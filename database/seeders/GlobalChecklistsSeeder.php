<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class GlobalChecklistsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        DB::table('global_checklists')->insert([
            'name'=> 'Wystawienie Faktury',
            'author' => 2,
            'company' => 1,
            'checklist_category'=> 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_checklists')->insert([
            'name' => 'Wystawienie zamówienia zakupowego',
            'author' => 3,
            'company' => 2,
            'checklist_category' => 2,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('global_checklists')->insert([
            'name' => 'Zamówienie zakupowe',
            'author' => 2,
            'company' => 1,
            'checklist_category' => 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
    }
}
