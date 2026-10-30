<?php

use App\Models\Admin;
use App\Models\User;

// ============================================================================
// 🛡️ Pengujian Autentikasi Admin
// ============================================================================

test('[Guest] tidak bisa akses /admin/dashboard dan di-redirect ke login', function () {
    $response = $this->get('/admin/dashboard');

    $response->assertRedirect('/admin/login');
});

test('[Guest] tidak bisa akses /admin/news dan di-redirect ke login', function () {
    $response = $this->get('/admin/news');

    $response->assertRedirect('/admin/login');
});

test('[Guest] tidak bisa akses /admin/category dan di-redirect ke login', function () {
    $response = $this->get('/admin/category');

    $response->assertRedirect('/admin/login');
});

test('[User Biasa] tidak bisa akses admin panel', function () {
    $user = User::factory()->create();

    $response = $this->actingAs($user, 'web')
        ->get('/admin/dashboard');

    // User biasa bukan admin, jadi harus di-redirect ke admin login
    $response->assertRedirect('/admin/login');
});

test('[Admin Login] berhasil login dengan kredensial yang benar', function () {
    $admin = Admin::factory()->create([
        'email' => 'admin@beritarohul.id',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post('/admin/login', [
        'email' => 'admin@beritarohul.id',
        'password' => 'password123',
    ]);

    $response->assertRedirect('/admin/dashboard');
    $this->assertAuthenticatedAs($admin, 'admin');
});

test('[Admin Login] gagal login dengan password salah', function () {
    Admin::factory()->create([
        'email' => 'admin@beritarohul.id',
        'password' => bcrypt('password123'),
    ]);

    $response = $this->post('/admin/login', [
        'email' => 'admin@beritarohul.id',
        'password' => 'password_salah',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest('admin');
});

test('[Admin Login] gagal login dengan email yang tidak terdaftar', function () {
    $response = $this->post('/admin/login', [
        'email' => 'tidak.ada@beritarohul.id',
        'password' => 'password123',
    ]);

    $response->assertSessionHasErrors('email');
    $this->assertGuest('admin');
});

test('[Admin Logout] berhasil logout', function () {
    $admin = Admin::factory()->create();

    $response = $this->actingAs($admin, 'admin')
        ->post('/admin/logout');

    $response->assertRedirect('/admin/login');
    $this->assertGuest('admin');
});
