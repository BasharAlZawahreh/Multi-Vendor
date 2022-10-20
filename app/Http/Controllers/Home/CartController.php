<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cookie;

class CartController extends Controller
{
    protected $cart;
    function __construct(CartRepository $cartRepository) //injected CartRepository because its in the service container
    {
        $this->cart = $cartRepository;
    }

    public function index(CartRepository $cart) //injected CartRepository because its in the service container
    {
        return view('front.cart', [
            'cart' => $cart
        ]);
    }

    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->add(Product::find($request->product_id), $request->quantity);
        return redirect()->route('cart.index');
    }

    public function update(Request $request, CartRepository $cart)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->update(Product::find($request->product_id), $request->quantity);
        return redirect()->route('cart.index');
    }

    public function destroy(CartRepository $cart, $id)
    {
        $cart->delete($id);
        return redirect()->route('cart.index');
    }
}
