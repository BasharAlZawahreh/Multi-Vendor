<?php

namespace App\Http\Controllers\Home;

use App\Events\OrderCreated;
use App\Exceptions\InvalidOrderException;
use App\Facades\Cart;
use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Repositories\Cart\CartRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Symfony\Component\Intl\Countries;

class CheckoutController extends Controller
{
    public function create(CartRepository $cart)
    {
        if ($cart->get()->count() == 0) {
            throw new InvalidOrderException('Cart Is Empty!');
        }

        return view('front.checkout', [
            'cart'=>$cart,
            'countries'=>Countries::getNames(),
        ]);
    }

    public function store(Request $request, CartRepository $cart)
    {
        $request->validate([
            'addr.billing.first_name' => 'required',
            'addr.billing.last_name' => 'required',
            'addr.billing.email' => 'required',
            'addr.billing.phone_number' => 'required',
            'addr.billing.city' => 'required',
            'addr.shipping.first_name' => 'required',
            'addr.shipping.last_name' => 'required',
            'addr.shipping.email' => 'required',
            'addr.shipping.phone_number' => 'required',
            'addr.shipping.city' => 'required',
        ]);

        $items = $cart->get()->groupBy('product.store_id')->all();

        // Database transaction is to make sure that all the data is saved in the database or none of them is saved
        DB::beginTransaction();
        try {
            foreach ($items as $store_id => $cart_items) {

                $order = Order::create([
                    'user_id' => auth()->id(),
                    'store_id' => $store_id,
                ]);

                foreach ($cart_items as $item) {
                    OrderItem::create([
                        'order_id' => $order->id,
                        'product_id' => $item->product_id,
                        'product_name' => $item->product->name,
                        'product_price' => $item->product->price,
                        'quantity' => $item->quantity,
                        'total' => $item->product->price * $item->quantity,
                    ]);
                }

                foreach ($request->post('addr') as $type => $address) {
                    $address['type'] = $type;
                    $order->addresses()->create($address);
                }

                event(new OrderCreated($order));

                DB::commit();
            }


        } catch (\Throwable $th) {
            DB::rollBack();
            throw $th;
        }


        return redirect()->route('orders.payment.create', $order->id);
    }
}

// 98638250
