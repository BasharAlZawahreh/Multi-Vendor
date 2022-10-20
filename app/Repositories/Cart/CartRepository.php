<?php

namespace App\Repositories\Cart;

use Illuminate\Support\Collection;

interface CartRepository
{
    public function get(): Collection;
    public function add($product, int $quantity = 1): void;
    public function remove($product): void;
    public function clear(): void;

}
