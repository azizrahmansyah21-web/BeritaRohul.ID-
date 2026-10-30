<?php

use App\Models\Admin;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;

beforeEach(function () {
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();
});

test('Upload gambar via Summernote endpoint berhasil', function () {
    $admin = Admin::factory()->create();
    $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'admin']);
    $admin->assignRole($role);

    // Gunakan create() bukan image() karena GD tidak tersedia
    $file = UploadedFile::fake()->create('test-image.jpg', 100, 'image/jpeg');

    $response = $this->actingAs($admin, 'admin')
        ->post('/admin/news/upload-image', [
            'file' => $file,
        ]);

    $response->assertStatus(200);
    $response->assertJsonStructure(['url']);
});

test('Upload gambar gagal tanpa file', function () {
    $admin = Admin::factory()->create();
    $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'admin']);
    $admin->assignRole($role);

    $response = $this->actingAs($admin, 'admin')
        ->post('/admin/news/upload-image', []);

    $response->assertStatus(400);
    $response->assertJson(['error' => 'File tidak ditemukan atau terkorupsi saat diunggah.']);
});
