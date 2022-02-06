<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call(CompaniesSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(PermissionsSeeder::class);
        $this->call(UsersSeeder::class);
        $this->call(CategoriesSeeder::class);
        $this->call(GlobalChecklistsSeeder::class);
        $this->call(GlobalPointsSeeder::class);
        $this->call(UserChecklistsSeeder::class);
        $this->call(UserPointsSeeder::class);
    }
}
