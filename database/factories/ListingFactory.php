<?php

namespace Database\Factories;

use Faker\Generator as Faker;
use Illuminate\Database\Eloquent\Factories\Factory;
use App\Models\{
    Listing,
    Bed,
    Bath
};

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Listing>
 */
class ListingFactory extends Factory
{
    protected $model = Listing::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => $this->faker->sentence,
            'description' => $this->faker->paragraph,
            'price' => $this->faker->numberBetween(1000, 1000000),
            'bedroom' => Bed::inRandomOrder()->value('id'),
            'bathroom' => Bath::inRandomOrder()->value('id'),
            'type' => $this->faker->randomElement(['Apartment', 'House', 'Villa']),
            'publish_status' => $this->faker->randomElement(['published', 'draft']),
            'created_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
            'updated_at' => $this->faker->dateTimeBetween('-1 year', 'now'),
        ];
    }

    public function configure()
    {
        return $this->count(50); // Create 50 instances
    }
}
