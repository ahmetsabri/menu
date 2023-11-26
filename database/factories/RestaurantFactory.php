<?php

namespace Database\Factories;

use App\Models\Category;
use App\Models\Restaurant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Restaurant>
 */
class RestaurantFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $name = fake()->company;

        return [
            'name' => $name,
            'slug' => str()->slug($name),
            'status' => 'active'
        ];
    }

    public function configure()
    {
        return $this->afterCreating(function (Restaurant $restaurant) {
            $restaurant->categories()->createMany((Category::factory()->count(random_int(1,7))->make(['restaurant_id'=>$restaurant->id])->toArray()));
        });
    }
}
