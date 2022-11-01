<?php
namespace App\Facades;

use App\Providers\CartServiceProvider;
use App\Repositories\Cart\CartRepository;
use Illuminate\Support\Facades\Facade;

class Cart extends Facade
{
    // public static function __callStatic($name, $arguments)
    // {
    //     $cart = app(CartServiceProvider::class);
    //     return $cart->$name(...$arguments);
    // }

    protected static function getFacadeAccessor()
    {
        return 'cart';
    }
}
