<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $guarded = [];

    //Events (observers) >>> here or in the observer class (app/Observers/CartObserver.php)
    protected static function booted()
    {

        static::observe(CartObserver::class);

        // static::creating(function ($cart) {
        //     $cart->id = \Str::uuid();
        // });
    }

    public function user()
    {
        return $this->belongsTo(User::class)->withDefault([
            'name' => 'Guest',
        ]);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    


}


