<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Store>
 */
class StoreFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {

        return [
            'name' => $this->faker->name(),
            'slug' =>$this->faker->slug(),
            'description' => $this->faker->text(),
            'logo' => $this->faker->imageUrl(300, 300),
            'status' => $this->faker->randomElement(['active', 'inactive']),
            'email' => $this->faker->unique()->email(),
            'address' => $this->faker->address(),
            'phone' => $this->faker->phoneNumber(),
            'cover' => $this->faker->imageUrl(300, 300),
        ];
    }
}
