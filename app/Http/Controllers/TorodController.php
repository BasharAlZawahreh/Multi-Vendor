<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreTorodRequest;
use App\Http\Requests\UpdateTorodRequest;
use App\Jobs\GetAllDistrictsJob;
use App\Models\Torod;
use App\Models\TorodCities;
use Illuminate\Support\Facades\Http;

class TorodController extends Controller
{
    protected $base_uri;
    public function __construct()
    {
        $this->base_uri = 'https://demo.stage.torod.co';
    }

    public function index()
    {
        $cities = TorodCities::select('name_en', 'value')->distinct()->get();
        return view('welcome', compact('cities'));
    }

    public function getDistricts()
    {
        try {
            $getTokenResponse = Http::asForm()->post($this->base_uri . '/en/api/token', [
                'client_id' => 'Nj5jmtQvlm7u9hq69lDp0DbZwRwKmK0z',
                'client_secret' => 'gOUuKfoSWxiJTIbSbrJkwyuamiFq2EL0'
            ]);

            $token = json_decode($getTokenResponse->body())->data->bearer_token;

            $getRegionsResponse = Http::withHeaders(
                [
                    'Authorization' => 'Bearer ' . $token,
                    'Accept' => 'application/json',
                ]
            )->get($this->base_uri . '/en/api/get-all/regions?country_id=1');

            $regions = json_decode($getRegionsResponse->body())->data;

            foreach ($regions as $region) {
                $getCitiesResponse = Http::withHeaders(
                    [
                        'Authorization' => 'Bearer ' . $token,
                        'Accept' => 'application/json',
                    ]
                )->get($this->base_uri . '/en/api/get-all/cities?region_id=' . $region->region_id);

                $cities = json_decode($getCitiesResponse->body())->data;
                foreach ($cities as $city) {
                    $getDistrictsPerCityResponse = Http::withHeaders(
                        [
                            'Authorization' => 'Bearer ' . $token,
                            'Accept' => 'application/json',
                        ]
                    )->get($this->base_uri . '/en/api/get-all/districts?cities_id=' . $city->cities_id);

                    $districtsPerCity = json_decode($getDistrictsPerCityResponse->body())->data ?? '';
                    if ($districtsPerCity) {
                        foreach ($districtsPerCity as $districtPerCity) {
                           $regionName= $city->city_name == $region->region_name ? $region->region_name:'';
                            TorodCities::create([
                                'value' => "$districtPerCity->name_en, $city->city_name, $regionName, Saudi Arabia",
                                'name_en' => "$districtPerCity->name_en, $city->city_name",
                                'name_ar' => "$districtPerCity->name_ar, $city->city_name_ar",
                            ]);
                        }
                    }
                }
            }
        } catch (\Exception $th) {
            return response()->json([
                'message' => 'Error while getting districts',
                'error' => $th->getMessage()
            ], 500);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\StoreTorodRequest  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTorodRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Torod  $torod
     * @return \Illuminate\Http\Response
     */
    public function show(Torod $torod)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Torod  $torod
     * @return \Illuminate\Http\Response
     */
    public function edit(Torod $torod)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\UpdateTorodRequest  $request
     * @param  \App\Models\Torod  $torod
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTorodRequest $request, Torod $torod)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Torod  $torod
     * @return \Illuminate\Http\Response
     */
    public function destroy(Torod $torod)
    {
        //
    }
}
