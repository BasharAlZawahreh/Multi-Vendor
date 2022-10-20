<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $repo;

    public function __construct(CartModelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(CartRepository $cart)//injected CartRepository because its in the service container
   {
        $items = $cart->get();
        return view('home.cart.index', compact('items'));
    }

    public function store(Request $request,CartRepository $cart)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->add(Product::find($request->product_id), $request->quantity);
        return redirect()->route('home.cart.index');
    }

    public function update(Request $request, CartRepository $cart)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $cart->update(Product::find($request->product_id), $request->quantity);
        return redirect()->route('home.cart.index');

    }

    public function destroy(CartRepository $cart,$id)
    {
        $cart->delete($id);
        return redirect()->route('home.cart.index');
    }
}
