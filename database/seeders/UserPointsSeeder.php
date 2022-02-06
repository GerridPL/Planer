<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class UserPointsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        DB::table('user_points')->insert([
            'index' => 1,
            'description'=> 'Otwórz formularz wystawiania faktury',
            'user_checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 2,
            'description'=> 'Wybierz kontrahenta',
            'user_checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 3,
            'description'=> 'Wybierz płatnika',
            'user_checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 4,
            'description'=> 'Wybierz towar',
            'user_checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 4,
            'subIndex' => 1,
            'description'=> 'Wybierz zielony plus',
            'user_checklist'=> 1,
            'company'=> 1,
            'user_point'=> 4,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 4,
            'subIndex' => 2,
            'description'=> 'Zaznacz interesujące towary',
            'user_checklist'=> 1,
            'company'=> 1,
            'user_point'=> 4,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 4,
            'subIndex' => 3,
            'description'=> 'Zatwierdź wybrane towary',
            'user_checklist'=> 1,
            'company'=> 1,
            'user_point'=> 4,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 5,
            'description'=> 'Wpisz cene',
            'user_checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 6,
            'description'=> 'Wybierz ilość',
            'user_checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 7,
            'description'=> 'Zatwierdź fakturę',
            'user_checklist'=> 1,
            'company'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 1,
            'description'=> 'Otwórz formularz wystawiania zamówienia zakupowego',
            'user_checklist'=> 2,
            'company'=> 2,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 2,
            'description'=> 'Wybierz kontrahenta',
            'user_checklist'=> 2,
            'company'=> 2,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 3,
            'description'=> 'Wybierz towar jaki chcesz zamówić',
            'user_checklist'=> 2,
            'company'=> 2,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 4,
            'description'=> 'Wybierz ilość jaką chcesz zamówić danego towaru',
            'user_checklist'=> 2,
            'company'=> 2,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_points')->insert([
            'index' => 5,
            'description'=> 'Zatwierdź zamówienie zakupowe',
            'user_checklist'=> 2,
            'company'=> 2,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
    }
}
