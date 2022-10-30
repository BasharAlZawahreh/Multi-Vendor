<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;
    protected $guarded = [];

    protected static function booted()
    {
        static::creating(function (Order $order) {
            $order->number = Order::getNextOrderNumber();
        });
    }

    protected static function getNextOrderNumber()
    {
        $year = now()->year;
        $lastOrder = Order::whereYear('created_at', $year)->max('number');
        if ($lastOrder) {
            return $lastOrder + 1;
        }
        return $year . "0001";
    }

    public function products()
    {
        return $this
            ->belongsToMany(Product::class, 'order_items', 'order_id', 'product_id', 'id', 'id')
            ->using(OrderItem::class)//because we have a custom pivot model
            ->as('order_item') // to make an alias for the pivot table, so we call it like $order->order_item->quantity rather than $order->pivot->quantity
            ->withPivot(['product_name', 'options', 'quantity', 'price']);
    }

    public function store()
    {
        return $this->belongsTo(Store::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest',
        ]);
    }

    public function addresses()
    {
        return $this->hasMany(OrderAddress::class);
    }

    public function billingAddress()
    {
        return $this->hasOne(OrderAddress::class)->where('type', 'billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(OrderAddress::class)->where('type', 'shipping');
    }

}
