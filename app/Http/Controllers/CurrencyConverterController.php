<?php

namespace App\Http\Controllers;

use App\Services\CurrencyConverter;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Session;

class CurrencyConverterController extends Controller
{
    public function index()
    {
        $api_key = config('services.currency_converter.api_key');
        $currencies = (new CurrencyConverter($api_key))->allCurrencies();

        return $currencies;
    }

    public function store(Request $request)
    {
        $request->validate([
            'currency_code'=>'required|size:3|string'
        ]);

        $currency_code = $request->input('currency_code');
        Session::put('currency_code',$currency_code);

        $baseCurrency = config('app.currency');
        $api_key = config('services.currency_converter.api_key');
        $cacheKey = "currency_rate_$baseCurrency"."_$currency_code";

        $rate = Cache::get($cacheKey, 0);
        if (!$rate) {
            $converter = app('currency.converter');
            $rate = $converter->convert($baseCurrency, $currency_code);

            Cache::put($cacheKey, $rate, now()->addMinutes(60));
        }

        return redirect()->back();
    }
}
