<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Facades\Cart;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class DeductProductQuantity
{
  
    public function __construct()
    {
        //
    }

    public function handle($event)
    {
        $order = $event->order;
        foreach ($order->products as $product) {
            $product->decrement('quantity', $product->order_item->quantity);
        }
    }
}
