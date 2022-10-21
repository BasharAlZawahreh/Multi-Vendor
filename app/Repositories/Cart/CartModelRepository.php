<?php

namespace App\Repositories\Cart;

use App\Models\Cart;
use App\Models\Product;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cookie;

class CartModelRepository implements CartRepository
{
    protected $items;
    public function __construct()
    {
        $this->items = collect([]);
    }

    public function get(): Collection
    {
        if ($this->items->isEmpty()) {
            $this->items = Cart::with('product')->get();
        }

        return $this->items;
    }

    public function add(Product $product, int $quantity = 1): void
    {

        $cart = Cart::where('product_id', '=', $product->id)
            ->first();

        if ($cart) {
            $cart->increment('quantity', $quantity);
        } else {
            $item = Cart::create([
                'user_id' => auth()->id(),
                'product_id' => $product->id,
                'quantity' => $quantity,
            ]);

            $this->get()->push($item);
        }
    }

    public function update($id, int $quantity = 1): void
    {
        Cart::find($id)->update([
            'quantity' => $quantity,
        ]);
    }

    public function delete($id): void
    {
        Cart::find('id')->delete();
    }

    public function clear(): void
    {
        Cart::truncate();
    }

    public function total(): float
    {
        return  $this->get()->sum(function ($item) {
            return $item->quantity * $item->product->price;
        });
    }
}
