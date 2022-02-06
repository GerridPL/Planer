<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class PermissionsSeeder extends Seeder
{
    public function run()
    {
        app()[PermissionRegistrar::class]->forgetCachedPermissions();

        // Zarządzanie firmami (wszystkimi)
        Permission::create(['name' => 'companies']);

        // Zarządzanie użytkownikami (wszystkimi)
        Permission::create(['name' => 'users']);

        // Zarządzanie firmą (jedną)
        Permission::create(['name' => 'company']);

        // Zarządzanie kategoriami
        Permission::create(['name' => 'category']);

        // Zarządzanie użytkownikami firmy
        Permission::create(['name' => 'company_users']);

        // Zarządzanie globalnymi listami kontrolnymi
        Permission::create(['name' => 'manage_global_checklists']);

        // Przeglądanie i przydzielanie list kontrolnych do użytkowników (bez zarządzania)
        Permission::create(['name' => 'global_checklists']);

        // Generowanie raportu
        Permission::create(['name' => 'report']);

        // Realizacja checklisty
        Permission::create(['name' => 'user_checklist']);

        // SUPER_ADMIN
        $userRole = Role::findByName(config('permission.roles.super_admin'));
        $userRole->givePermissionTo('companies');
        $userRole->givePermissionTo('users');

        // ADMIN
        $userRole = Role::findByName(config('permission.roles.admin'));
        $userRole->givePermissionTo('category');
        $userRole->givePermissionTo('company');
        $userRole->givePermissionTo('company_users');
        $userRole->givePermissionTo('user_checklist');
        $userRole->givePermissionTo('report');
        $userRole->givePermissionTo('global_checklists');
        $userRole->givePermissionTo('manage_global_checklists');

        // MANAGER
        $userRole = Role::findByName(config('permission.roles.manager'));
        $userRole->givePermissionTo('category');
        $userRole->givePermissionTo('user_checklist');
        $userRole->givePermissionTo('report');
        $userRole->givePermissionTo('global_checklists');
        $userRole->givePermissionTo('manage_global_checklists');

        // IMPLEMENTATION_SPECIALIST
        $userRole = Role::findByName(config('permission.roles.implementation_specialist'));
        $userRole->givePermissionTo('user_checklist');
        $userRole->givePermissionTo('report');
        $userRole->givePermissionTo('global_checklists');

        // USER
        $userRole = Role::findByName(config('permission.roles.user'));
        $userRole->givePermissionTo('user_checklist');
        $userRole->givePermissionTo('report');
    }
}
