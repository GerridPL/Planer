<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RolesSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        $super_admin = Role::create(['name' => config('permission.roles.super_admin')]);
        $admin = Role::create(['name' => config('permission.roles.admin')]);
        $manager = Role::create(['name' => config('permission.roles.manager')]);
        $implementation_specialist = Role::create(['name' => config('permission.roles.implementation_specialist')]);
        $user = Role::create(['name' => config('permission.roles.user')]);
    }
}
