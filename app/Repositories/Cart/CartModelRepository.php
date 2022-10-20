<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;

class CartModelRepository implements CartRepository
{

    public function get(): Collection
    {
        return Cart::with('product')
            ->where('cookie_id', '=', $this->getCookieId())
            ->get();
    }

    public function add(Product $product, int $quantity = 1): void
    {

        Cart::where('cookie_id', '=', $this->getCookieId())
            ->create([
                'user_id' => auth()->id(),
                'cookie_id' => $this->getCookieId(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
    }

    public function update(Product $product, int $quantity = 1): void
    {
        Cart::where('cookie_id', '=', $this->getCookieId())
            ->where('product_id', $product->id)->update([
                'quantity' => $quantity,
            ]);
    }

    public function delete($id): void
    {
        Cart::where('cookie_id', '=', $this->getCookieId())->where('id', $id)->delete();
    }

    public function clear(): void
    {
        Cart::where('cookie_id', '=', $this->getCookieId())->truncate();
    }

    public function total(): float
    {
        return  Cart::where('cookie_id', '=', $this->getCookieId())
            ->join('products', 'products.id', '=', 'carts.product_id')
            ->selectRaw('SUM(products.price * carts.quantity) as total')
            ->value('total') ?? 0;
    }


    protected function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = \Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 60 * 24 * 30);
        }

        return $cookie_id;
    }
}
