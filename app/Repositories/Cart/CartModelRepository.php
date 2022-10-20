<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;

class CartModelRepository implements CartRepository
{
    public function get(): Collection
    {
        return Cart::where('cookie_id', $this->getCookieId())->get();
    }

    public function add(Product $product, int $quantity = 1): void
    {
        Cart::where('cookie_id', $this->getCookieId())
            ->create([
                'user_id' => auth()->id(),
                'cookie_id' => \Str::uuid(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);
    }

    public function update(Product $product, int $quantity = 1): void
    {
        Cart::where('cookie_id', $this->getCookieId())
            ->where('product_id', $product->id)->update([
                'quantity' => $quantity,
            ]);
    }

    public function delete($id): void
    {
        Cart::where('cookie_id',$this->getCookieId())->where('id', $id)->delete();
    }

    public function clear(): void
    {
        Cart::where('cookie_id',$this->getCookieId())->truncate();
    }

    public function total(): float
    {
        return Cart::where('cookie_id',$this->getCookieId())->join('products')
            ->selectRow('SUM(products.price * carts.quantity) as total')
            ->value('total');
    }


    protected function getCookieId()
    {
        $cookie_id = Cookie::get('cookie_id');
        if (!$cookie_id) {
            $cookie_id = \Str::uuid();
            Cookie::queue('cookie_id', $cookie_id, Carbon::now()->addDays(30));
        }
    }
}
