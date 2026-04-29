<?php

namespace Database\Seeders;

use App\Models\Admin;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class RoleUserSeeder extends Seeder
{
    public function run(): void
    {
        Admin::updateOrCreate(
            ['email' => 'editor@beritarohul.id'],
            [
                'name' => 'Editor',
                'image' => 'frontend/assets/images/icon.jpeg',
                'password' => Hash::make('editor123'),
                'status' => 1,
            ]
        );

        Admin::updateOrCreate(
            ['email' => 'penulis@beritarohul.id'],
            [
                'name' => 'Penulis',
                'image' => 'frontend/assets/images/icon.jpeg',
                'password' => Hash::make('penulis123'),
                'status' => 1,
            ]
        );
    }
}