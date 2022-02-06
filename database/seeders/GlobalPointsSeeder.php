<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class GlobalPointsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        DB::table('global_points')->insert([
            'index' => 1,
            'description'=> 'Otwórz formularz wystawiania faktury',
            'checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 2,
            'description'=> 'Wybierz kontrahenta',
            'checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 3,
            'description'=> 'Wybierz płatnika',
            'checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 4,
            'description'=> 'Wybierz towar',
            'checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 4,
            'subIndex' => 1,
            'description'=> 'Wybierz zielony plus',
            'checklist'=> 1,
            'company'=> 1,
            'point'=> 4,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 4,
            'subIndex' => 2,
            'description'=> 'Zaznacz interesujące towary',
            'checklist'=> 1,
            'company'=> 1,
            'point'=> 4,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 4,
            'subIndex' => 3,
            'description'=> 'Zatwierdź wybrane towary',
            'checklist'=> 1,
            'company'=> 1,
            'point'=> 4,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 5,
            'description'=> 'Wpisz cene',
            'checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 6,
            'description'=> 'Wybierz ilość',
            'checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 7,
            'description'=> 'Zatwierdź fakturę',
            'checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 1,
            'description'=> 'Otwórz formularz wystawiania zamówienia zakupowego',
            'checklist'=> 2,
            'company'=> 2,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 2,
            'description'=> 'Wybierz kontrahenta',
            'checklist'=> 2,
            'company'=> 2,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 3,
            'description'=> 'Wybierz towar jaki chcesz zamówić',
            'checklist'=> 2,
            'company'=> 2,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 4,
            'description'=> 'Wybierz ilość jaką chcesz zamówić danego towaru',
            'checklist'=> 2,
            'company'=> 2,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 5,
            'description'=> 'Zatwierdź zamówienie zakupowe',
            'checklist'=> 2,
            'company'=> 2,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 1,
            'description'=> 'test1',
            'checklist'=> 3,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_points')->insert([
            'index' => 2,
            'description'=> 'test2',
            'checklist'=> 3,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
    }
}
