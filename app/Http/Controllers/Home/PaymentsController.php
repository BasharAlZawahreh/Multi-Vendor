<?php

namespace App\Http\Controllers\Home;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Pyament;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function create(Order $order)
    {
        return view('front.payment', [
            'order' => $order,
        ]);
    }

    public function createStripePaymentIntent(Order $order)
    {
        $amount = $order->items->sum(function ($item) {
            return $item->price * $item->quantity;
        });
        // Set your secret key. Remember to switch to your live secret key in production.
        // See your keys here: https://dashboard.stripe.com/apikeys
        $stripe = new \Stripe\StripeClient(config('services.stripe.key'));

        $paymentIntent = $stripe->paymentIntents->create(
            ['amount' => $amount, 'currency' => 'usd', 'payment_method_types' => ['card']]
        );

        try {

            $payment = new Pyament();
            $payment->forceFill([
                'order_id' => $order->id,
                'amount' => $paymentIntent->amount,
                'currency' => $paymentIntent->currency,
                'status' => 'pending',
                'method'=>'stripe',
                'transaction_id' => $paymentIntent->id,
                'transaction_data' => json_encode($paymentIntent),
            ]);

            $payment->save();
        } catch (\Illuminate\Database\QueryException $th) {
            echo $th->getMessage();
            return;
        }

        return [
            'clientSecret' => $paymentIntent->client_secret
        ];
    }

    public function success(Request $request, Order $order)
    {
        $stripe = new \Stripe\StripeClient(config('services.stripe.key'));

        $paymentIntent = $stripe->paymentIntents->retrieve(
            $request->query('payment_intent'),
            []
        );

        if ($paymentIntent->status === 'succeeded') {
            try {

                $payment = Pyament::where('order_id', $order->id)->first();
                $payment->forceFill([
                    'status' => 'completed',
                    'transaction_data' => json_encode($paymentIntent),
                ])->save();

            } catch (\Illuminate\Database\QueryException $th) {
                echo $th->getMessage();
                return;
            }
            event('payment.created', $payment->id);

            return redirect()->route('home.index', [
                'status' => 'Payment-Succeeded'
            ]);
        }
    }
}
