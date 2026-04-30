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

        // 2. Daftar Hak Akses (Permissions) berdasarkan Controller di sistem
        $permissions = [
            // Kategori
            ['name' => 'category index', 'group_name' => 'Category'],
            ['name' => 'category create', 'group_name' => 'Category'],
            ['name' => 'category update', 'group_name' => 'Category'],
            ['name' => 'category delete', 'group_name' => 'Category'],
            
            // Berita
            ['name' => 'news index', 'group_name' => 'News'],
            ['name' => 'news create', 'group_name' => 'News'],
            ['name' => 'news update', 'group_name' => 'News'],
            ['name' => 'news delete', 'group_name' => 'News'],
            ['name' => 'news all-access', 'group_name' => 'News'],

            // Pages
            ['name' => 'about index', 'group_name' => 'Pages'],
            ['name' => 'about update', 'group_name' => 'Pages'],
            ['name' => 'contact index', 'group_name' => 'Pages'],
            ['name' => 'contact update', 'group_name' => 'Pages'],

            // Pesan Kontak
            ['name' => 'contact message index', 'group_name' => 'Contact Message'],
            ['name' => 'contact message update', 'group_name' => 'Contact Message'],

            // Pengaturan
            ['name' => 'setting index', 'group_name' => 'Setting'],
            ['name' => 'setting update', 'group_name' => 'Setting'],

            // Manajemen Role
            ['name' => 'access management index', 'group_name' => 'Access Management'],
            ['name' => 'access management create', 'group_name' => 'Access Management'],
            ['name' => 'access management update', 'group_name' => 'Access Management'],
            ['name' => 'access management delete', 'group_name' => 'Access Management'],

            // Bahasa
            ['name' => 'language index', 'group_name' => 'Language'],
            ['name' => 'language create', 'group_name' => 'Language'],
            ['name' => 'language update', 'group_name' => 'Language'],
            ['name' => 'language delete', 'group_name' => 'Language'],

            // Subscribers
            ['name' => 'subscribers index', 'group_name' => 'Subscribers'],
            ['name' => 'subscribers update', 'group_name' => 'Subscribers'],
            ['name' => 'subscribers delete', 'group_name' => 'Subscribers'],

            // Iklan
            ['name' => 'advertisement index', 'group_name' => 'Advertisement'],
            ['name' => 'advertisement update', 'group_name' => 'Advertisement'],

            // Home Section
            ['name' => 'home section index', 'group_name' => 'Home Section'],
            ['name' => 'home section update', 'group_name' => 'Home Section'],

            // Social
            ['name' => 'social count index', 'group_name' => 'Social'],
            ['name' => 'social count create', 'group_name' => 'Social'],
            ['name' => 'social count update', 'group_name' => 'Social'],
            ['name' => 'social count delete', 'group_name' => 'Social'],
            ['name' => 'social link index', 'group_name' => 'Social'],
            ['name' => 'social link create', 'group_name' => 'Social'],
            ['name' => 'social link update', 'group_name' => 'Social'],
            ['name' => 'social link delete', 'group_name' => 'Social'],

            // Footer
            ['name' => 'footer index', 'group_name' => 'Footer'],
            ['name' => 'footer create', 'group_name' => 'Footer'],
            ['name' => 'footer update', 'group_name' => 'Footer'],
            ['name' => 'footer delete', 'group_name' => 'Footer'],
        ];

        // 3. Masukkan permissions ke database
        foreach ($permissions as $permission) {
            Permission::firstOrCreate([
                'name' => $permission['name'], 
                'guard_name' => 'admin'
            ], [
                'group_name' => $permission['group_name']
            ]);
        }

        // 4. Buat Role 'Penulis'
        $rolePenulis = Role::firstOrCreate(['name' => 'Penulis', 'guard_name' => 'admin']);
        // Penulis hanya bisa manajemen berita (index, create, update)
        $rolePenulis->syncPermissions(['news index', 'news create', 'news update']);

        // 5. Buat Role 'Editor'
        $roleEditor = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'admin']);
        // Editor bisa mengatur berita dan kategori secara penuh
        $roleEditor->syncPermissions([
            'news index', 'news create', 'news update', 'news delete', 'news all-access',
            'category index', 'category create', 'category update', 'category delete'
        ]);

        // 6. Buat Role 'Super Admin'
        $roleAdmin = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'admin']);
        // Super Admin dapat semua izin
        $roleAdmin->syncPermissions(Permission::all());

        // 7. Berikan peran Super Admin ke user pertama
        $adminUser = \App\Models\Admin::first();
        if ($adminUser) {
            $adminUser->assignRole('Super Admin');
        }
    }
}