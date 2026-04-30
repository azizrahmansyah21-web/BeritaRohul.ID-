<?php

namespace Tests\Feature;

use App\Models\Admin;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminRoleUserTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permission and roles
        Permission::create(['name' => 'access management index', 'guard_name' => 'admin']);
        Permission::create(['name' => 'access management create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'access management update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'access management delete', 'guard_name' => 'admin']);

        $roleSA = Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);
        $roleSA->givePermissionTo(Permission::all());

        Role::create(['name' => 'Editor', 'guard_name' => 'admin']);

        // Create Admin user
        $this->superAdmin = Admin::factory()->create([
            'email' => 'admin@beritarohul.id'
        ]);
        $this->superAdmin->assignRole('Super Admin');
    }

    public function test_super_admin_can_view_role_users()
    {
        $response = $this->actingAs($this->superAdmin, 'admin')->get(route('admin.role-users.index'));
        $response->assertStatus(200);
    }

    public function test_super_admin_can_create_new_admin()
    {
        $response = $this->actingAs($this->superAdmin, 'admin')->post(route('admin.role-users.store'), [
            'name' => 'Editor Baru',
            'email' => 'editorbaru@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'role' => 'Editor'
        ]);

        $response->assertRedirect(route('admin.role-users.index'));
        $this->assertDatabaseHas('admins', [
            'email' => 'editorbaru@example.com'
        ]);
        
        $newAdmin = Admin::where('email', 'editorbaru@example.com')->first();
        $this->assertTrue($newAdmin->hasRole('Editor'));
    }

    public function test_super_admin_cannot_demote_themselves()
    {
        // Mencoba update Super Admin menjadi Editor
        $response = $this->actingAs($this->superAdmin, 'admin')->put(route('admin.role-users.update', $this->superAdmin->id), [
            'name' => 'Administrator',
            'email' => 'admin@beritarohul.id',
            'role' => 'Editor'
        ]);

        // Harus dikembalikan (redirect back) dengan error
        $response->assertRedirect();
        // Memastikan status Super Admin tidak hilang
        $this->assertTrue($this->superAdmin->fresh()->hasRole('Super Admin'));
        $this->assertFalse($this->superAdmin->fresh()->hasRole('Editor'));
    }

    public function test_super_admin_cannot_be_deleted()
    {
        $response = $this->actingAs($this->superAdmin, 'admin')->delete(route('admin.role-users.destroy', $this->superAdmin->id));
        
        $response->assertStatus(200);
        $response->assertJson(['status' => 'error', 'message' => __('admin.Can\'t Delete the Super User')]);
        $this->assertDatabaseHas('admins', ['id' => $this->superAdmin->id]);
    }
}
