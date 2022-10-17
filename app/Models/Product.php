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
}
