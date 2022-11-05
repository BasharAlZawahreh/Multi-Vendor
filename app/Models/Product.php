<?php

namespace App\Models;

use App\Models\Scopes\StoreScope;
use App\Observers\ProdcutObserver;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $hidden = [ // hide these fields from the API
        'created_at',
        'updated_at',
        'deleted_at',
        'image',
    ];

    protected $appends=[ // add these fields to the API
        'image_url'
    ];

    //global scope
    protected static function booted()
    {
        static::addGlobalScope('store', new StoreScope());

        static::observe(ProdcutObserver::class);

        // static::creating(function ($product) {
        //     $product->slug = \Str::slug($product->name);
        // });
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

    public function scopeFilter(Builder $builder, array $filters = [])
    {
        //using array_merge to gurantee the default values are set if the user does not provide any
        $options = array_merge([
            'store_id' => null,
            'category_id' => null,
            'tag_id' => null,
            'status' => 'active',
        ], $filters);

        $builder->when($options['status'], function ($query, $status) {
            if ($status == 'active') {
                $query->active();
            }
        });

        $builder->when($options['store_id'],function($builder, $store_id){
            $builder->where('store_id',$store_id);
        });

        $builder->when($options['category_id'],function($builder, $category_id){
            $builder->where('category_id',$category_id);
        });

        $builder->when($options['tag_id'],function($builder, $tag_id){

            $builder->whereExists(function($query) use ($tag_id){
                $query->select(1)
                    ->from('product_tag')
                    ->whereRaw('product_tag.product_id = products.id')
                    ->where('product_tag.tag_id', $tag_id);
            });

            //same as above
            //$builder->whereRaw('Exists (SELECT product_id FROM product_tag WHERE tag_id = ?)', [$tag_id]);

            //defferint way to do the same thing
            //$builder->whereRaw('id IN (SELECT product_id FROM product_tag WHERE tag_id = ?)', [$tag_id]);

            //defferint way to do the same thing
            /*$builder->whereHas('tags',function($builder) use ($tag_id){
                $builder->whereIn('tag_id',$tag_id);
            });*/
        });

    }
}
