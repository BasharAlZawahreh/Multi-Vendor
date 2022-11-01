<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCreatedNotification extends Notification
{
    use Queueable;

    protected $order;
    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Order $order)
    {
        $this->order = $order;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable) // $notifiable is the user (passed automatically)
    {
        return ['mail'];

        $channels = ['database'];
        if($notifiable->notifications_preferences['order_created']['sms'] ?? false) {
            $channels[] = 'vonage';
        }
        if($notifiable->notifications_preferences['order_created']['email'] ?? false) {
            $channels[] = 'mail';
        }
        if ($notifiable->notifications_preferences['order_created']['brodcast'] ?? false) {
            $channels[] = 'broadcast';
        }

        return  $channels;

        // return ['mail', 'database', 'broadcast']; // send to mail, database and broadcast
    }


    public function toMail($notifiable) //to(channel)
    {
        $address = $this->order->billingAddress()->first();

        return (new MailMessage)
                    ->subject('Order #'. $this->order->number . 'Created')
                    ->greeting('Hello ' . $notifiable->name)
                    ->line("A new order has been created, number: {$this->order->number}, created by: {$address->name}, from {$address->countryName}")
                    ->action('View Order', url('/dashboard'))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
