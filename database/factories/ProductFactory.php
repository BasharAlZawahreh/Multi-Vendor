<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Store;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Product>
 */
class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name' => $this->faker->productName,
            'slug' =>$this->faker->slug(),
            'store_id' => Store::inRandomOrder()->first()->id,
            'category_id' => Category::inRandomOrder()->first()->id,
            'description' => $this->faker->text,
            'image' => $this->faker->imageUrl(),
            'price' => $this->faker->randomFloat(1,1,49),
            'compare_price' => $this->faker->randomFloat(1,50,99),
            'quantity' => $this->faker->randomNumber(),
            'rating' => $this->faker->randomFloat(1,0,1),
            'featured' => $this->faker->boolean,
            'status' => $this->faker->randomElement(['active', 'draft', 'archived'])
        ];
    }
}
