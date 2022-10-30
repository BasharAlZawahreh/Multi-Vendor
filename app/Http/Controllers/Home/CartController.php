<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $cart;
    function __construct(CartRepository $cartRepository) //injected CartRepository because its in the service container
    {
        $this->cart = $cartRepository;
    }

    public function index() //injected CartRepository because its in the service container
    {
        return view('front.cart', [
            'cart' => $this->cart
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $this->cart->add(Product::find($request->product_id), $request->quantity);
        return redirect()->route('cart.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'quantity' => 'required|integer|min:1',
        ]);

        if ($this->cart->get()->find($id)->product->quantity < $request->quantity) {
            return response()->json([
                'message' => 'The quantity you entered is not available',
            ], 422);
        }

        $this->cart->update($id, $request->quantity);
        return response()->json([
            'success' => true,
            'message' => 'Cart updated successfully'
        ]);
    }

    public function destroy($id)
    {
        $this->cart->delete($id);
        return redirect()->route('cart.index');
    }
}
