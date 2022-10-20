<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Repositories\Cart\CartModelRepository;
use Illuminate\Http\Request;

class CartController extends Controller
{
    protected $repo;

    public function __construct(CartModelRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index()
    {
        $items = $this->repo->get();
        return view('home.cart.index', compact('items'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $this->repo->add(Product::find($request->product_id), $request->quantity);
        return redirect()->route('home.cart.index');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'required|integer|min:1',
        ]);

        $this->repo->update(Product::find($request->product_id), $request->quantity);
        return redirect()->route('home.cart.index');

    }

    public function destroy($id)
    {
        $this->repo->delete($id);
        return redirect()->route('home.cart.index');
    }
}
