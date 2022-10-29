<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\Pivot;

class OrderItem extends Pivot
{
    use HasFactory;
    protected $guarded = []; // <-- This is the default value, so you can remove this line
    protected $table = 'order_items'; // <-- This is NOT the default for pivot, so we're including it
    public $incrementing = true; // <-- This is NOT the default for pivot, so we're including it
    public $timestamps = false; // <-- This is NOT the default for pivot, so we're including it

    public function product()
    {
        return $this->belongsTo(Product::class)->withDefault([
            'name' =>$this->product_name,
        ]);
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

}

