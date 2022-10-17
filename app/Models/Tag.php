<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;
    public  $timestamps = false;
    protected $guarded = [];
    

    public function products()
    {
        return $this->belongsToMany(
            Product::class, // related model
            'product_tag', // pivot table
            'tag_id', // foreign key on pivot table
            'product_id', // related key on pivot table
            'id',   // local key
            'id'    // related key
        );
    }
}
