<?php

use App\Blog;
use Carbon\Carbon;
use Faker\Factory as Faker;
use Illuminate\Database\Seeder;

class BlogSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();

        Blog::truncate();

        foreach (range(1, 20) as $key => $each) {
            $title = $faker->sentence;
            Blog::create([
                'title' => $title,
                'slug' => str_slug($title),
                'excerpt' => $faker->sentence,
                'content' => $faker->paragraph,
                'published_at' => Carbon::now(),
            ]);
        }
    }
}
