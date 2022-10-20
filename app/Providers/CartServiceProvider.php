<?php

namespace App\Providers;

use App\Repositories\Cart\CartRepository;
use Illuminate\Support\ServiceProvider;

class CartServiceProvider extends ServiceProvider
{
    //Register services in the service container.
    public function register()
    {
        $this->app->bind(CartRepository::class,function(){
            return new \App\Repositories\Cart\CartModelRepository();
        });
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
