<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use App\Models\TorodCities;
use Illuminate\Support\Facades\Http;

class GetAllDistrictsJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    protected $base_uri;
    public function __construct()
    {
        $this->base_uri = 'https://demo.stage.torod.co';
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $getTokenResponse = Http::asForm()->post($this->base_uri.'/en/api/token', [
            'client_id' => 'Nj5jmtQvlm7u9hq69lDp0DbZwRwKmK0z',
            'client_secret' => 'gOUuKfoSWxiJTIbSbrJkwyuamiFq2EL0'
        ]);

        $token = json_decode($getTokenResponse->body())->data->bearer_token;

        $getRegionsResponse = Http::withHeaders(
            [
                'Authorization' => 'Bearer ' . $token,
                'Accept' => 'application/json',
            ]
        )->get($this->base_uri.'/en/api/get-all/regions?country_id=1');

        $regions = json_decode($getRegionsResponse->body())->data;

        foreach ($regions as $region) {
            $getCitiesResponse = Http::withHeaders(
                [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ]
            )->get($this->base_uri.'/en/api/get-all/cities?region_id=' . $region->region_id);

            $cities = json_decode($getCitiesResponse->body())->data;
            foreach ($cities as $city) {
                $getDistrictsPerCityResponse = Http::withHeaders(
                    [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ]
                )->get($this->base_uri.'/en/api/get-all/districts?cities_id=' . $city->cities_id);

                $districtsPerCity = json_decode($getDistrictsPerCityResponse->body())->data ?? '';
                if ($districtsPerCity) {
                    foreach ($districtsPerCity as $districtPerCity) {
                        TorodCities::create([
                            'value' => "$districtPerCity->name_en, $city->city_name, $region->region_name, Saudi Arabia",
                            'name_en' => "$districtPerCity->name_en, $city->city_name",
                            'name_ar' => "$districtPerCity->name_ar, $city->city_name_ar",
                        ]);
                    }
                }
            }
        }
    }
}
