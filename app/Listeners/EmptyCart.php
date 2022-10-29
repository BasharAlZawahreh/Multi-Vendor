<?php

namespace App\Listeners;

use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use App\Facades\Cart;

class EmptyCart
{


    public function __construct()
    {

    }

    public function handle()
    {
        Cart::clear();
    }
}
