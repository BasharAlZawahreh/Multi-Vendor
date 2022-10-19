<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    //global scope
    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());
    }

    //local scope
    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }

    //accessor
    public function getImageUrlAttribute($value)
    {
        if (!$this->image) {
            return asset("assets/images/products/product-1.jpg");
        }

        if (\Str::startsWith($this->image, ['http://', 'https://'])) {
            return $this->image;
        }

        return asset("storaage/{$this->image}");
    }

    public function getSalePercentAttribute()
    {
        if ($this->compare_price > 0) {
            return round(100- ($this->price/$this->compare_price * 100),1);
        }
        return 0;
    }

    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'No Category',
        ]);
    }

    public function store()
    {
        return $this->belongsTo(Store::class)->withDefault([
            'name' => 'No Store',
        ]);
    }

    public function tags()
    {
        return $this->belongsToMany(
            Tag::class, // related model
            'product_tag', // pivot table
            'product_id', // foreign key on pivot table
            'tag_id', // related key on pivot table
            'id',   // local key
            'id'    // related key
        );
    }

    public function wishlists()
    {
        return $this->belongsToMany(User::class, 'user_wishlist', 'product_id', 'user_id', 'id', 'id');
    }
}
