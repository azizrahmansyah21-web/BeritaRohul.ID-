<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

// ============================================================================
// 📰 Pengujian Alur Persetujuan (Approval Workflow)
// ============================================================================

beforeEach(function () {
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    // Buat bahasa default
    Language::factory()->create(['lang' => 'en', 'default' => 1]);
    session(['language' => 'en']);
});

test('Berita PENDING (is_approved=0) tidak tampil di query activeEntries', function () {
    $pendingNews = News::factory()->pending()->create(['language' => 'en']);

    $activeNews = News::activeEntries()->get();

    expect($activeNews)->toHaveCount(0);
    expect($activeNews->pluck('id'))->not->toContain($pendingNews->id);
});

test('Berita APPROVED (is_approved=1) tampil di query activeEntries', function () {
    $approvedNews = News::factory()->create([
        'language' => 'en',
        'status' => 1,
        'is_approved' => 1,
    ]);

    $activeNews = News::activeEntries()->get();

    expect($activeNews)->toHaveCount(1);
    expect($activeNews->first()->id)->toBe($approvedNews->id);
});

test('Berita INACTIVE (status=0) meskipun approved tidak tampil', function () {
    News::factory()->create([
        'language' => 'en',
        'status' => 0,
        'is_approved' => 1,
    ]);

    $activeNews = News::activeEntries()->get();

    expect($activeNews)->toHaveCount(0);
});

test('Admin bisa approve berita pending', function () {
    Permission::firstOrCreate(['name' => 'news all-access', 'guard_name' => 'admin']);
    $admin = Admin::factory()->create();
    $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'admin']);
    $role->givePermissionTo(Permission::where('guard_name', 'admin')->get());
    $admin->assignRole($role);

    $news = News::factory()->pending()->create();

    $response = $this->actingAs($admin, 'admin')
        ->put('/admin/approve-news', [
            'id' => $news->id,
            'is_approve' => 1,
        ]);

    $response->assertStatus(200);

    $news->refresh();
    expect($news->is_approved)->toBe(1);
});

test('Campuran berita pending dan approved — hanya approved yang muncul', function () {
    // 3 approved
    News::factory()->count(3)->create([
        'language' => 'en',
        'status' => 1,
        'is_approved' => 1,
    ]);

    // 2 pending
    News::factory()->count(2)->pending()->create([
        'language' => 'en',
        'status' => 1,
    ]);

    $activeNews = News::activeEntries()->get();

    expect($activeNews)->toHaveCount(3);
});
