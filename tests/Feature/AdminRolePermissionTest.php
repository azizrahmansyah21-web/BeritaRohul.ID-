<?php

use App\Models\Admin;
use App\Models\Language;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// ============================================================================
// 🛡️ Pengujian Hak Akses Role & Permission
// ============================================================================

beforeEach(function () {
    // Reset cached roles and permissions
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
});

test('[Super Admin] bisa akses halaman dashboard', function () {
    $admin = Admin::factory()->create();
    $role = Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);
    $admin->assignRole($role);

    $response = $this->actingAs($admin, 'admin')
        ->get('/admin/dashboard');

    $response->assertStatus(200);
});

test('[Admin dengan permission news create] bisa akses halaman buat berita', function () {
    $admin = Admin::factory()->create();
    $role = Role::create(['name' => 'Editor', 'guard_name' => 'admin']);
    $permission = Permission::create(['name' => 'news create', 'guard_name' => 'admin']);
    // Tambah permission index juga agar bisa akses menu
    $permissionIndex = Permission::create(['name' => 'news index', 'guard_name' => 'admin']);
    $role->givePermissionTo([$permission, $permissionIndex]);
    $admin->assignRole($role);

    $response = $this->actingAs($admin, 'admin')
        ->get('/admin/news/create');

    $response->assertStatus(200);
});

test('[Admin tanpa permission setting] tidak bisa akses halaman pengaturan', function () {
    $admin = Admin::factory()->create();
    $role = Role::create(['name' => 'Jurnalis', 'guard_name' => 'admin']);
    // Berikan hanya permission news, BUKAN setting
    $permissionNews = Permission::create(['name' => 'news create', 'guard_name' => 'admin']);
    Permission::create(['name' => 'setting index', 'guard_name' => 'admin']);
    $role->givePermissionTo($permissionNews);
    $admin->assignRole($role);

    $response = $this->actingAs($admin, 'admin')
        ->get('/admin/setting');

    // Harus 403 Forbidden karena tidak punya permission
    $response->assertStatus(403);
});

test('[Super Admin] bisa akses halaman pengaturan', function () {
    $admin = Admin::factory()->create();
    $role = Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);
    Permission::create(['name' => 'setting index', 'guard_name' => 'admin']);
    $admin->assignRole($role);

    $response = $this->actingAs($admin, 'admin')
        ->get('/admin/setting');

    $response->assertStatus(200);
});

test('[Admin tanpa permission news delete] tidak bisa menghapus berita', function () {
    $admin = Admin::factory()->create();
    $role = Role::create(['name' => 'Jurnalis', 'guard_name' => 'admin']);
    Permission::create(['name' => 'news delete', 'guard_name' => 'admin']);
    $admin->assignRole($role);

    $news = \App\Models\News::factory()->create(['auther_id' => $admin->id]);

    $response = $this->actingAs($admin, 'admin')
        ->delete('/admin/news/' . $news->id);

    $response->assertStatus(403);
});
