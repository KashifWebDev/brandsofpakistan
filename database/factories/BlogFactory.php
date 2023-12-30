<?php

namespace Database\Factories;

use App\Models\BlogCategory;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\blog>
 */
class BlogFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $title = $this->faker->sentence(rand(4, 8));

        return [
            'category_id' => BlogCategory::all()->random()->id,
            'title' => $title,
            'slug' => Str::slug($title, '-'),
            'description' => $this->faker->sentence(5),
            'cover_image' => $this->faker->imageUrl(),
            'content' => $this->faker->text(),
            'status' => $this->faker->randomElements(['draft', 'publish']),
            'tags' => json_encode([
                $this->faker->randomElement(
                    [
                        "house",
                        "flat",
                        "apartment",
                        "room", "shop",
                        "lot", "garage"
                    ]
                )
            ]),
            'featured' => rand(0, 10) > 5
        ];
    }
}
