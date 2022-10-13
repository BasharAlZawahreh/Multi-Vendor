<?php

namespace App\Models;

use App\Rules\filterRule;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Category extends Model
{
    use HasFactory, SoftDeletes;
    protected  $guarded = [];

    public function products()
    {
        return $this->hasMany(Product::class, 'category_id', 'id');
    }

    public function parento()
    {
        return $this->belongsTo(Category::class, 'parent_id', 'id')->withDefault([
            'name' => 'No Parent',
        ]);
    }

    public function children()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id');
    }

    public function scopeFilter(Builder $builder, array $filters)
    {
        $builder->when($filters['name'] ?? false, function ($query, $name) {
            $query->where('categories.name', 'like', '%' . $name . '%');
        });

        $builder->when($filters['status'] ?? false, function ($query, $status) {
            $query->where('status', $status);
        });
    }

    public function parent()
    {
        return $this->belongsTo(Category::class, 'parent_id');
    }

    public static function rules($id = 0)
    {

        return [
            'name' => "required|string|max:255|unique:categories,name,$id",
            'parent_id' => 'nullable|exists:categories,id',
            'description' => 'nullable|string',
            'status' => 'required|in:active,inactive',
            'image' => 'nullable|image',
            'filter:laravel,php'
            // function ($attribute, $value, $fail) {
            //     if (strtolower($value) == 'laravel') {
            //         $fail('The ' . $attribute . ' field is invalid.');
            //     }
            // }

            // new filterRule(['laravel','php']),
        ];
    }

    public static function messages()
    {
        return [
            'name.required' => 'Category name is required',
            'name.unique' => 'Category name must be unique',
            'name.max' => 'Category name must be less than 255 characters',
            'parent_id.exists' => 'Parent category must be exists',
            'status.required' => 'Category status is required',
            'status.in' => 'Category status must be active or inactive',
            'image.image' => 'Category image must be image file'
        ];
    }
}
