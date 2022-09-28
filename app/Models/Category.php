<?php

namespace App\Models;

use App\Rules\filterRule;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    use HasFactory;
    protected  $guarded = [];

    public static function rules($id=0)
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
