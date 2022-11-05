<?php

namespace App\Observers;

class ProdcutObserver
{
    public function creating($product)
    {
       $product->slug = \Str::slug($product->name);
    }
}
