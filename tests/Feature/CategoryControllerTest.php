<?php

namespace Tests\Feature;

use App\Models\Category;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class CategoryControllerTest extends TestCase
{
    public function test_the_category_index_page_is_rendered_property()
    {
        $user = User::create([
            'email'=> 'test1@firma.pl',
            'password'=> bcrypt('test'),
            'company'=> 1
        ]);
        $role = Role::findByName(config('permission.roles.admin'));
        $user->assignRole($role);

        $this->actingAs($user);

        $response = $this->get('/categories');
        $response->assertStatus(200);

        $user->forceDelete();
    }

    public function test_the_category_index_page_int_render_with_user_role()
    {
        $user = User::create([
            'email'=> 'test1@firma.pl',
            'password'=> bcrypt('test'),
            'company'=> 1
        ]);
        $role = Role::findByName(config('permission.roles.user'));
        $user->assignRole($role);

        $this->actingAs($user);

        $response = $this->get('/categories');
        $response->assertStatus(403);
        $user->forceDelete();
    }

    public function test_the_category_index_page_int_render_with_implementation_specialist_role()
    {
        $user = User::create([
            'email'=> 'test1@firma.pl',
            'password'=> bcrypt('test'),
            'company'=> 1
        ]);
        $role = Role::findByName(config('permission.roles.implementation_specialist'));
        $user->assignRole($role);
        $this->actingAs($user);

        $response = $this->get('/categories');
        $response->assertStatus(403);
        $user->forceDelete();
    }

    public function test_the_category_create_page_is_rendered_property()
    {
        $user = User::create([
            'email'=> 'test1@firma.pl',
            'password'=> bcrypt('test'),
            'company'=> 1
        ]);
        $role = Role::findByName(config('permission.roles.admin'));
        $user->assignRole($role);

        $this->actingAs($user);

        $response = $this->get('/categories/create');
        $response->assertStatus(200);
        $user->forceDelete();
    }

    public function test_the_category_create_new_category_property()
    {
        $user = User::create([
            'email'=> 'test1@firma.pl',
            'password'=> bcrypt('test'),
            'company'=> 1
        ]);
        $role = Role::findByName(config('permission.roles.manager'));
        $user->assignRole($role);

        $this->actingAs($user);

        $response = $this->post('/categories', [
            'name' => 'Testowa kategoria',
            'company' => 1
        ]);

        $category = Category::where('name', 'Testowa kategoria')
            ->first();

        $response->assertStatus(302);

        $this->assertEquals('Testowa kategoria', $category->name);
        $this->assertEquals('1', $category->company);

        $user->forceDelete();
        $category->forceDelete();
    }
}
