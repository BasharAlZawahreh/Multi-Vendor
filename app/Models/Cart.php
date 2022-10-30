<?php

namespace App\Models;

use App\Observers\CartObserver;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cookie;

class Cart extends Model
{
    use HasFactory;

    public $incrementing = false;
    protected $guarded = [];
    protected $table='carts';
    protected $primaryKey = 'id';

    //Events (observers) >>> here or in the observer class (app/Observers/CartObserver.php)
    protected static function booted()
    {
        static::observe(CartObserver::class);

        static::addGlobalScope('cookie_id', function ($query)  {
            $query->where('cookie_id', '=',  Self::getCookieId());
        });

    }

    protected static function getCookieId()
    {
        $cookie_id = Cookie::get('cart_id');
        if (!$cookie_id) {
            $cookie_id = \Str::uuid();
            Cookie::queue('cart_id', $cookie_id, 60 * 24 * 30);
        }

        return $cookie_id;
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


