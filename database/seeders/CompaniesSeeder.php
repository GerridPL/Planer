<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory;

class CompaniesSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
        DB::table('companies')->insert([
            'name'=> 'W&G Software Sp. J.',
            'tax_number' => '1234567890',
            'city' => 'Opatówek',
            'postcode' => '62-860',
            'sub_exp_date' => '2021-06-01',
            'email' => 'firma@wg.pl',
            'phone' => '660355033',
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
        DB::table('companies')->insert([
            'name'=> 'W&G Software Sp. z o.o.',
            'tax_number' => '1234567899',
            'city' => 'Opatówek',
            'postcode' => '62-860',
            'sub_exp_date' => '2022-04-20',
            'email' => 'firma@wg.pl',
            'phone' => '660355033',
            'created_at' => $faker->dateTimeBetween(
                '-1 days',
                '+1 days'
            )
        ]);
    }
}
