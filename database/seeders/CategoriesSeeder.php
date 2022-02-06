<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class CategoriesSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        DB::table('categories')->insert([
            'name'=> 'Faktury',
            'description' => 'Kategoria zawierająca faktury',
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('categories')->insert([
            'name'=> 'Zamówienia Zakupowe',
            'description' => 'Kategoria zawierająca zamówienia zakupowe',
            'company'=> 2,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
    }
}
