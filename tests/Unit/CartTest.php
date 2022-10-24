<?php

namespace Tests\Unit;

use App\Facades\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\Store;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;


class CartTest extends TestCase
{
    use RefreshDatabase;

    /**@test */
    public function test_update_cart_quantity()
    {
        $store = Store::factory()->create();
        $category =  Category::factory()->create();
        $product = Product::factory()->create([
            'store_id' => $store->id,
            'category_id' => $category->id,
        ]);

        Cart::add($product, 1);
        $cart = Cart::get()->first();

        $this->put("/cart/$cart->id", [
            'quantity' => 3
        ])->assertStatus(200);
    }
}
