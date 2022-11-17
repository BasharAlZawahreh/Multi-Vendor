<?php

namespace App\Providers;

use App\Services\CurrencyConverter;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Http\Resources\Json\ResourceResponse;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('currency.converter', function (){
            return new CurrencyConverter(config('services.currency_converter.api_key'));
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
       Validator::extend('filter', function ($attribute, $value, $parameters, $validator) {
            return !in_array(strtolower($value), $parameters);
        }, 'This value is prohipited.');

        JsonResource::withoutWrapping(); // remove data from response
        // Paginator::useBootstrapFour();
    }
}
