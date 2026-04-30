<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Category;
use App\Models\News;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminCategoryTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $admin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permission and role
        Permission::create(['name' => 'category index', 'guard_name' => 'admin']);
        Permission::create(['name' => 'category create', 'guard_name' => 'admin']);
        Permission::create(['name' => 'category update', 'guard_name' => 'admin']);
        Permission::create(['name' => 'category delete', 'guard_name' => 'admin']);

        $role = Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);
        $role->givePermissionTo(Permission::all());

        // Create Admin user
        $this->admin = Admin::factory()->create([
            'email' => 'admin@beritarohul.id'
        ]);
        $this->admin->assignRole('Super Admin');
    }

    public function test_admin_can_view_category_index()
    {
        $response = $this->actingAs($this->admin, 'admin')->get(route('admin.category.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_create_category()
    {
        $response = $this->actingAs($this->admin, 'admin')->post(route('admin.category.store'), [
            'language' => 'id',
            'name' => 'Teknologi',
            'show_at_nav' => 1,
            'status' => 1,
        ]);

        $response->assertRedirect(route('admin.category.index'));
        $this->assertDatabaseHas('categories', [
            'name' => 'Teknologi',
            'slug' => 'teknologi'
        ]);
    }

    public function test_admin_can_update_category()
    {
        $category = Category::create([
            'language' => 'id',
            'name' => 'Lama',
            'slug' => 'lama',
            'show_at_nav' => 1,
            'status' => 1,
        ]);

        $response = $this->actingAs($this->admin, 'admin')->put(route('admin.category.update', $category->id), [
            'language' => 'en',
            'name' => 'Baru',
            'show_at_nav' => 0,
            'status' => 0,
        ]);

        $response->assertRedirect(route('admin.category.index'));
        $this->assertDatabaseHas('categories', [
            'id' => $category->id,
            'name' => 'Baru',
            'slug' => 'baru'
        ]);
    }

    public function test_admin_can_delete_empty_category()
    {
        $category = Category::create([
            'language' => 'id',
            'name' => 'Kosong',
            'slug' => 'kosong',
            'show_at_nav' => 1,
            'status' => 1,
        ]);

        $response = $this->actingAs($this->admin, 'admin')->delete(route('admin.category.destroy', $category->id));
        
        $response->assertStatus(200);
        $response->assertJson(['status' => 'success']);
        $this->assertDatabaseMissing('categories', ['id' => $category->id]);
    }

    public function test_admin_cannot_delete_category_with_news()
    {
        $category = Category::create([
            'language' => 'id',
            'name' => 'Berita',
            'slug' => 'berita',
            'show_at_nav' => 1,
            'status' => 1,
        ]);

        News::create([
            'language' => 'id',
            'category_id' => $category->id,
            'auther_id' => $this->admin->id,
            'image' => 'test.jpg',
            'title' => 'Test News',
            'slug' => 'test-news',
            'content' => 'Content',
            'meta_title' => 'Meta',
            'meta_description' => 'Desc',
            'is_breaking_news' => 0,
            'show_at_slider' => 0,
            'show_at_popular' => 0,
            'is_approved' => 1,
            'status' => 1,
            'views' => 0
        ]);

        $response = $this->actingAs($this->admin, 'admin')->delete(route('admin.category.destroy', $category->id));
        
        $response->assertStatus(200);
        $response->assertJson(['status' => 'error']);
        $this->assertDatabaseHas('categories', ['id' => $category->id]);
    }
}
