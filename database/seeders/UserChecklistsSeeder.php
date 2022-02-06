<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class UserChecklistsSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        DB::table('user_checklists')->insert([
            'user'=> 4,
            'name'=> 'Wystawienie Faktury',
            'checklist_category'=> 1,
            'allocated_by'=> 2,
            'global_checklist'=>1,
            'company' => 1,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('user_checklists')->insert([
            'user'=> 5,
            'name'=> 'Wystawienie zamówienia zakupowego',
            'checklist_category'=> 2,
            'allocated_by'=> 3,
            'global_checklist'=> 2,
            'company' => 2,
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
    }
}
