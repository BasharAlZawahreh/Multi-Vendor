<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\OrderCreatedNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderCreatedNotification
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  object  $event
     * @return void
     */
    public function handle(OrderCreated $event)
    {
        $order= $event->order;
        $users = User::where('store_id','=',$order->store_id);

        $users->first()->notify(new OrderCreatedNotification($order)); // send to the first user (if the store has only one owner)

        /*
        //if the store has more than one owner:
        Notification::send($users->get(), new OrderCreatedNotification($order));

        //also we can do it like this
        foreach ($users->get() as $user) {
            $user->notify(new OrderCreatedNotification($order));
        }
        */
    }
}
