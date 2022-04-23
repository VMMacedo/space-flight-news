<?php

namespace Database\Seeders;

use DB;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EventSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = \Faker\Factory::create('pt_BR');

        for ($i=0; $i < 50; $i++) { 
            DB::table('events')->insert([
                'provider' => $faker->paragraph(),
                'created_at' => $faker->date('Y-m-d H:i:s'),
                'updated_at' => $faker->date('Y-m-d H:i:s')
            ]);
        }
       
    }
}
