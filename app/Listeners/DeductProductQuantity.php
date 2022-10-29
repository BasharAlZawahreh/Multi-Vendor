<?php

namespace App\Listeners;

use App\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeductProductQuantity
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle()
    {
        $carts= Cart::get();
        foreach ($carts as $item) {
            $item->product->decrement('quantity', $item->quantity);
        }
    }
}
