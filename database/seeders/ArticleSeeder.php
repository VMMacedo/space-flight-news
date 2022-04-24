<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ArticleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        for ($i=1; $i < 51; $i++) { 
            DB::table('articles')->insert([
                'title' => $faker->words(3, true),
                'url' => $faker->url(),
                'imageUrl' => $faker->imageUrl(640, 480, 'animals', true),
                'newsSite' => $faker->word(),
                'summary' => $faker->paragraph(),
                'publishedAt' => $faker->date('Y-m-d H:i:s'),
                'updatedAt' => $faker->date('Y-m-d H:i:s'),
                'featured' => $faker->boolean(),
                'events_id' => $faker->numberBetween(1, 50),
                'launches_id' => $faker->numberBetween(1, 50),
                'created_at' => $faker->date('Y-m-d H:i:s'),
                'updated_at' => $faker->date('Y-m-d H:i:s'),

            ]);
        }
    }
}
