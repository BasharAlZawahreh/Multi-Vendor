<?php

namespace App\Http\Controllers\Home;

use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CheckoutController extends Controller
{
    public function create()
    {
        if (Cart::get()->count() == 0) {
            redirect()->back();
        }
        
        return view('front.checkout', [
            'cart' => Cart::get(),
        ]);
    }

    public function store(Request $request, CartRepository $cart)
    {
        // $request->validate([
        //     'billing_address' => 'required',
        //     'shipping_address' => 'required',
        //     'payment_method' => 'required',
        // ]);

        $items = $cart->get()->groupBy('product.store_id')->all();

        // Database transaction is to make sure that all the data is saved in the database or none of them is saved
        DB::beginTransaction();
        try {
            foreach ($items as $store_id => $cart_items) {
                $order = Order::create([
                    'user_id' => auth()->id(),
                    'store_id' => 1,
                    'status' => 'pending',
                ]);

                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'price' => $item->product->price,
                        'quantity' => $item->quantity,
                    ]);
                }

                foreach ($request['address'] as $type => $address) {
                    'billing' === $type ?
                        $order->billingAddress()->create($address) :
                        $order->shippingAddress()->create($address);
                }
            }

            $cart->clear();
            DB::commit();
        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }
    }
}
