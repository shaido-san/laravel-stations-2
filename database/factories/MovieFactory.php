<?php

namespace Database\Factories;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Database\Eloquent\Factories\Factory;

class MovieFactory extends Factory
{
    protected $model = Movie::class;
    public function definition()
    {
        return [
            'title' => $this->faker->unique()->sentence(3),
            'image_url' => $this->faker->imageUrl(),
            'published_year' => $this->faker->year,
            'description' => $this->faker->realText(20),
            'is_showing' => $this->faker->boolean,
            'genre_id' => optional(Genre::inRandomOrder()->first())->id ?? Genre::factory(),
        ];
    }
}
