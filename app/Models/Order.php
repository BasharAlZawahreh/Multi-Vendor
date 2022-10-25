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
            ->using(OrderItem::class) //because we have a custom pivot model
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
        return $this->hasMany(Address::class);

        // return $this->morphMany(Address::class, 'addressable');
    }

    public function billingAddress()
    {
        return $this->hasOne(Address::class)->where('type', 'billing');
    }

    public function shippingAddress()
    {
        return $this->hasOne(Address::class)->where('type', 'shipping');
    }

    /*
    // This is the default implementation of the above two methods
    public function getShippingAddressAttribute()
    {
        return $this->addresses()->where('type', 'shipping')->first();
    }

    public function getBillingAddressAttribute()
    {
        return $this->addresses()->where('type', 'billing')->first();
    }
    */
}
