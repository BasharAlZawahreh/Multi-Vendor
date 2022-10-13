<?php

namespace App\Models;

use Illuminate\Contracts\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];

    //global scope
    protected static function booted()
    {
        static::addGlobalScope('store', function (Builder $builder) {
            $user=auth()->user();
            if ($user->name == 'Admin') {
                 $builder;
            } else {
                 $builder->where('store_id', $user->store_id);
            }

        });
    }

    public function category()
    {
        return $this->belongsTo(Category::class) ?? null;
    }

    public function store()
    {
        return $this->belongsTo(Store::class) ?? null;
    }
}
