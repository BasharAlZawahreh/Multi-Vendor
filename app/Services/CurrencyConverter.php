<?php

namespace App\Services;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;

class CurrencyConverter
{
    protected $base_url;
    protected $headers;
    public function __construct(private $apiKey)
    {
        $this->base_url = 'https://api.apilayer.com/currency_data';
        $this->headers = [
            'apikey' => $this->apiKey,
            'Accept' => 'application/json',
            'Content-Type' => 'application/json',
        ];
    }

    public function allCurrencies()
    {
        $currencies = collect(DB::select('select code from currencies'));


        if ($currencies->count() == 0) {
            $result = Http::baseUrl($this->base_url)
                ->withHeaders($this->headers)
                ->get('/list');

            foreach (($result->json())['currencies'] as $code => $name) {
                DB::insert('insert into currencies (code, name) values (?, ?)', [$code, $name]);
            }

            return $result;
        }

        return $currencies;
    }


    /**
     * Method: GET Currency
     * base_url: https://api.apilayer.com/currency_data
     * endpoint: /convert
     * curl --request GET 'https://api.apilayer.com/currency_data/convert?base=USD&symbols=EUR,GBP,JPY&*amount=5&date=2018-01-01' \
     * header 'apikey: YOUR API KEY'
     */
    public function convert(string $from, string $to, float $amount = 1): float
    {
        $response = Http::baseUrl($this->base_url)
            ->withHeaders($this->headers)
            ->get('/convert', [
                'from' => $from,
                "to" => $to,
                "amount" => $amount,
                "date" => now()
            ]);

       return $response->json()['result'];
    }
}
