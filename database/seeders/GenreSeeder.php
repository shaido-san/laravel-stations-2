<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Genre;
use Faker\Factory as Faker;

class GenreSeeder extends Seeder
{
    public function run(): void
    {
        $faker = Faker::create();

        for ($i = 0; $i < 20; $i++) {
            Genre::firstOrCreate([
                'name' => $faker->unique()->word,
            ]);
        }
    }
}