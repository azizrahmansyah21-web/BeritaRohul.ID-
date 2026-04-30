<?php

namespace Tests\Feature;

use App\Models\Admin;
use App\Models\Setting;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Tests\TestCase;

class AdminSettingTest extends TestCase
{
    use RefreshDatabase;

    protected Admin $superAdmin;

    protected function setUp(): void
    {
        parent::setUp();
        
        // Setup cache
        app()[\Spatie\Permission\PermissionRegistrar::class]->forgetCachedPermissions();

        // Create permission and role
        Permission::create(['name' => 'setting index', 'guard_name' => 'admin']);
        Permission::create(['name' => 'setting update', 'guard_name' => 'admin']);

        $roleSA = Role::create(['name' => 'Super Admin', 'guard_name' => 'admin']);
        $roleSA->givePermissionTo(Permission::all());

        // Create Admin user
        $this->superAdmin = Admin::factory()->create([
            'email' => 'admin@beritarohul.id'
        ]);
        $this->superAdmin->assignRole('Super Admin');
    }

    public function test_super_admin_can_view_settings()
    {
        $response = $this->actingAs($this->superAdmin, 'admin')->get(route('admin.setting.index'));
        $response->assertStatus(200);
    }

    public function test_super_admin_can_update_general_settings()
    {
        Setting::create(['key' => 'site_name', 'value' => 'Old Name']);

        $response = $this->actingAs($this->superAdmin, 'admin')->put(route('admin.general-setting.update'), [
            'site_name' => 'New Berita Rohul',
            // Mock empty logo/favicon since we are just testing setting text value here
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('settings', [
            'key' => 'site_name',
            'value' => 'New Berita Rohul'
        ]);
    }

    public function test_super_admin_can_update_seo_settings()
    {
        Setting::create(['key' => 'site_seo_title', 'value' => 'Old SEO']);
        Setting::create(['key' => 'site_seo_description', 'value' => 'Old Desc']);
        Setting::create(['key' => 'site_seo_keywords', 'value' => 'old, key']);

        $response = $this->actingAs($this->superAdmin, 'admin')->put(route('admin.seo-setting.update'), [
            'site_seo_title' => 'New SEO Title',
            'site_seo_description' => 'New Description',
            'site_seo_keywords' => 'new, keyword'
        ]);

        $response->assertRedirect();
        $this->assertDatabaseHas('settings', [
            'key' => 'site_seo_title',
            'value' => 'New SEO Title'
        ]);
    }
}
