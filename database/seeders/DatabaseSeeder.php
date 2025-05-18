<?php

namespace Database\Seeders;

use App\Models\Movie;
use App\Models\Genre;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $genres = Genre::factory()->count(10)->create();

        // 映画データを~件生成
        Movie::factory(20)->create()->each(function ($movie) use ($genres) {
            // 各映画にランダムなジャンルを割り当てる
            $movie->update(['genre_id' => $genres->random()->id]);
        });

        // 座席データを挿入するシーダーを呼び出す
        $this->call([
            GenreSeeder::class,
            SheetTableSeeder::class,
    ]);
    }
}
