<?php

use App\Models\Admin;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use Illuminate\Http\UploadedFile;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

beforeEach(function () {
    app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

    Permission::firstOrCreate(['name' => 'news index', 'guard_name' => 'admin']);
    Permission::firstOrCreate(['name' => 'news create', 'guard_name' => 'admin']);
    Permission::firstOrCreate(['name' => 'news update', 'guard_name' => 'admin']);
    Permission::firstOrCreate(['name' => 'news delete', 'guard_name' => 'admin']);
    Permission::firstOrCreate(['name' => 'news all-access', 'guard_name' => 'admin']);
});

function createSuperAdmin(): Admin
{
    $admin = Admin::factory()->create();
    $role = Role::firstOrCreate(['name' => 'Super Admin', 'guard_name' => 'admin']);
    $role->givePermissionTo(Permission::where('guard_name', 'admin')->get());
    $admin->assignRole($role);
    return $admin;
}

function createEditorAdmin(): Admin
{
    $admin = Admin::factory()->create();
    $role = Role::firstOrCreate(['name' => 'Editor', 'guard_name' => 'admin']);
    $role->givePermissionTo(['news index', 'news create', 'news update']);
    $admin->assignRole($role);
    return $admin;
}

test('[Create] Super Admin bisa membuat berita baru', function () {
    $admin = createSuperAdmin();
    $language = Language::factory()->create();
    $category = Category::factory()->create(['language' => $language->lang]);

    $response = $this->actingAs($admin, 'admin')
        ->post('/admin/news', [
            'language' => $language->lang,
            'category' => $category->id,
            'image' => UploadedFile::fake()->create('berita.jpg', 100, 'image/jpeg'),
            'title' => 'Berita Test Unit Pertama',
            'content1' => '<p>Ini adalah konten berita testing</p>',
            'meta_title' => 'Meta Title Test',
            'meta_description' => 'Meta Description Test',
            'tags' => 'Laravel,Testing,PHP',
            'is_breaking_news' => 0,
            'show_at_slider' => 0,
            'show_at_popular' => 0,
            'status' => 1,
        ]);

    $response->assertRedirect(route('admin.news.index'));

    $this->assertDatabaseHas('news', [
        'title' => 'Berita Test Unit Pertama',
        'slug' => 'berita-test-unit-pertama',
        'auther_id' => $admin->id,
    ]);
});

test('[Create] Berita Super Admin otomatis is_approved=1', function () {
    $admin = createSuperAdmin();
    $language = Language::factory()->create();
    $category = Category::factory()->create(['language' => $language->lang]);

    $this->actingAs($admin, 'admin')
        ->post('/admin/news', [
            'language' => $language->lang,
            'category' => $category->id,
            'image' => UploadedFile::fake()->create('berita.jpg', 100, 'image/jpeg'),
            'title' => 'Berita Langsung Approved',
            'content1' => '<p>Konten</p>',
            'tags' => 'Tag1',
            'status' => 1,
        ]);

    $this->assertDatabaseHas('news', [
        'title' => 'Berita Langsung Approved',
        'is_approved' => 1,
    ]);
});

test('[Create] Berita Editor (non-Super Admin) otomatis is_approved=0', function () {
    $admin = createEditorAdmin();
    $language = Language::factory()->create();
    $category = Category::factory()->create(['language' => $language->lang]);

    $this->actingAs($admin, 'admin')
        ->post('/admin/news', [
            'language' => $language->lang,
            'category' => $category->id,
            'image' => UploadedFile::fake()->create('berita.jpg', 100, 'image/jpeg'),
            'title' => 'Berita Editor Pending',
            'content1' => '<p>Konten</p>',
            'tags' => 'Tag1',
            'status' => 1,
        ]);

    $this->assertDatabaseHas('news', [
        'title' => 'Berita Editor Pending',
        'is_approved' => 0,
    ]);
});

test('[Delete] Super Admin bisa menghapus berita', function () {
    $admin = createSuperAdmin();
    $news = News::factory()->create(['auther_id' => $admin->id]);

    $response = $this->actingAs($admin, 'admin')
        ->delete('/admin/news/' . $news->id);

    $response->assertStatus(200);
    $this->assertDatabaseMissing('news', ['id' => $news->id]);
});

test('[Copy] Super Admin bisa menduplikat berita', function () {
    $admin = createSuperAdmin();
    $news = News::factory()->create(['auther_id' => $admin->id]);

    $response = $this->actingAs($admin, 'admin')
        ->get('/admin/news-copy/' . $news->id);

    $response->assertRedirect();
    expect(News::count())->toBe(2);
});

test('[Index] Halaman daftar berita bisa diakses', function () {
    $admin = createSuperAdmin();

    $response = $this->actingAs($admin, 'admin')
        ->get('/admin/news');

    $response->assertStatus(200);
});
