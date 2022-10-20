<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;

class HomeController extends Controller
{
    public function index()
    {

        $products = Product::active()
            ->with('category')
            ->latest()
            ->take(8)
            ->get();

        return view('front.home', [
            'products' => $products
        ]);
    }

    public function addToWishlist(Product $product)
    {
        auth()->user()->wishlist()->syncWithoutDetaching($product->id);

        return back();
    }
}
