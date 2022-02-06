<?php

namespace Database\Seeders;

use Faker\Factory;
use App\Models\User;
use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class UsersSeeder extends Seeder
{
    public function run()
    {
        $faker = Factory::create();
            $user = User::create([
                'email'=> 'superadmin@gerrid.pl',
                'password'=> bcrypt('123456789'),
                'company'=> null,
                'created_at' => $faker->dateTimeBetween(
                    '-1 days',
                    '+1 days'
                )
            ]);
            $role = Role::findByName(config('permission.roles.super_admin'));
            if(isset($role)) {
                $user->assignRole($role);
            }

            $user = User::create([
                'email'=> 'admin1@gerrid.pl',
                'password'=> bcrypt('123456789'),
                'company'=> 1,
                'created_at' => $faker->dateTimeBetween(
                    '-1 days',
                    '+1 days'
                )
            ]);
            $role = Role::findByName(config('permission.roles.admin'));
            if(isset($role)) {
                $user->assignRole($role);
            }

            $user = User::create([
                'email'=> 'admin2@gerrid.pl',
                'password'=> bcrypt('123456789'),
                'company'=> 2,
                'created_at' => $faker->dateTimeBetween(
                    '-1 days',
                    '+1 days'
                )
            ]);
            $role = Role::findByName(config('permission.roles.admin'));
            if(isset($role)) {
                $user->assignRole($role);
            }

            $user = User::create([
                'email'=> 'user1@gerrid.pl',
                'password'=> bcrypt('123456789'),
                'company'=> 1,
                'created_at' => $faker->dateTimeBetween(
                    '-1 days',
                    '+1 days'
                )
            ]);
            $role = Role::findByName(config('permission.roles.user'));
            if(isset($role)) {
                $user->assignRole($role);
            }

            $user = User::create([
                'email'=> 'user2@gerrid.pl',
                'password'=> bcrypt('123456789'),
                'company'=> 2,
                'created_at' => $faker->dateTimeBetween(
                    '-1 days',
                    '+1 days'
                )
            ]);
            $role = Role::findByName(config('permission.roles.user'));
            if(isset($role)) {
                $user->assignRole($role);
            }

            $user = User::create([
                'email'=> 'manager1@gerrid.pl',
                'password'=> bcrypt('123456789'),
                'company'=> 1,
                'created_at' => $faker->dateTimeBetween(
                    '-1 days',
                    '+1 days'
                )
            ]);
            $role = Role::findByName(config('permission.roles.manager'));
            if(isset($role)) {
                $user->assignRole($role);
            }

            $user = User::create([
                'email'=> 'manager2@gerrid.pl',
                'password'=> bcrypt('123456789'),
                'company'=> 2,
                'created_at' => $faker->dateTimeBetween(
                    '-1 days',
                    '+1 days'
                )
            ]);
            $role = Role::findByName(config('permission.roles.manager'));
            if(isset($role)) {
                $user->assignRole($role);
            }

            $user = User::create([
                'email'=> 'implementation_specialist1@gerrid.pl',
                'password'=> bcrypt('123456789'),
                'company'=> 1,
                'created_at' => $faker->dateTimeBetween(
                    '-1 days',
                    '+1 days'
                )
            ]);
            $role = Role::findByName(config('permission.roles.implementation_specialist'));
            if(isset($role)) {
                $user->assignRole($role);
            }

            $user = User::create([
                'email'=> 'implementation_specialist2@gerrid.pl',
                'password'=> bcrypt('123456789'),
                'company'=> 2,
                'created_at' => $faker->dateTimeBetween(
                    '-1 days',
                    '+1 days'
                )
            ]);
            $role = Role::findByName(config('permission.roles.implementation_specialist'));
            if(isset($role)) {
                $user->assignRole($role);
            }
    }
}
