<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolePermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // 1. Reset cache Spatie (Sangat penting agar tidak error saat seed ulang)
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // 2. Daftar Hak Akses (Permissions) untuk Portal Berita
        $permissions = [
            'news view',
            'news create',
            'news edit',
            'news delete',
            'category manage',
            'comment manage',
            'setting manage',
            'role manage',
            'user manage'
        ];

        // 3. Masukkan permissions ke database
        foreach ($permissions as $permission) {
            // Gunakan firstOrCreate agar tidak error duplikat jika seeder dijalankan 2x
            Permission::firstOrCreate(['name' => $permission, 'guard_name' => 'admin']);
        }

        // 4. Buat Role 'Writer' (Penulis) dan beri akses khusus berita saja
        $roleWriter = Role::firstOrCreate(['name' => 'writer', 'guard_name' => 'admin']);
        $roleWriter->syncPermissions(['news view', 'news create', 'news edit']);

        // 5. Buat Role 'Super Admin' dan beri SEMUA akses
        $roleAdmin = Role::firstOrCreate(['name' => 'super admin', 'guard_name' => 'admin']);
        $roleAdmin->syncPermissions(Permission::all());

        // (Opsional) 6. Pasang role Super Admin ke User pertama di database Anda
        $adminUser = \App\Models\User::first();
        if ($adminUser) {
            $adminUser->assignRole('super admin');
        }
    }
}