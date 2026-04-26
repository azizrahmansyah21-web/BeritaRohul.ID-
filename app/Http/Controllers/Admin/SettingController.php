<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminGeneralSettingUpdateRequest;
use App\Http\Requests\AdminSeoSettingUpdateRequest;
use App\Models\Setting;
use App\Traits\FileUploadTrait;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\View\View;
use Spatie\Permission\Middleware\PermissionMiddleware;

class SettingController extends Controller implements HasMiddleware
{
    use FileUploadTrait;

    public static function middleware(): array
    {
        return [
            new Middleware(
                PermissionMiddleware::using('setting index,admin'),
                only: [
                    'index',
                    'crudIndex',
                    'crudCreate',
                    'crudEdit',
                ]
            ),

            new Middleware(
                PermissionMiddleware::using('setting update,admin'),
                only: [
                    'updateGeneralSetting',
                    'updateSeoSetting',
                    'updateAppearanceSetting',
                    'updateMicrosoftApiSetting',
                    'crudStore',
                    'crudUpdate',
                    'crudDestroy',
                ]
            ),
        ];
    }

    public function index(): View
    {
        return view('admin.setting.index');
    }

    public function updateGeneralSetting(AdminGeneralSettingUpdateRequest $request): RedirectResponse
    {
        $logoPath = $this->handleFileUpload($request, 'site_logo');
        $faviconPath = $this->handleFileUpload($request, 'site_favicon');

        $this->updateSetting('site_name', $request->site_name);

        if (!empty($logoPath)) {
            $this->updateSetting('site_logo', $logoPath);
        }

        if (!empty($faviconPath)) {
            $this->updateSetting('site_favicon', $faviconPath);
        }

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->back();
    }

    public function updateSeoSetting(AdminSeoSettingUpdateRequest $request): RedirectResponse
    {
        $this->updateSetting('site_seo_title', $request->site_seo_title);
        $this->updateSetting('site_seo_description', $request->site_seo_description);
        $this->updateSetting('site_seo_keywords', $request->site_seo_keywords);

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->back();
    }

    public function updateAppearanceSetting(Request $request): RedirectResponse
    {
        $request->validate([
            'site_color' => ['required', 'max:200'],
        ]);

        $this->updateSetting('site_color', $request->site_color);

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->back();
    }

    public function updateMicrosoftApiSetting(Request $request): RedirectResponse
    {
        $request->validate([
            'site_microsoft_api_host' => ['required'],
            'site_microsoft_api_key' => ['required'],
        ]);

        $this->updateSetting('site_microsoft_api_host', $request->site_microsoft_api_host);
        $this->updateSetting('site_microsoft_api_key', $request->site_microsoft_api_key);

        toast(__('admin.Updated Successfully!'), 'success');

        return redirect()->back();
    }

    /**
     * CRUD Settings
     */
public function crudIndex(): View
{
    $settingItems = Setting::query()
        ->orderByDesc('id')
        ->paginate(10);

    return view('admin.setting.crud-index', compact('settingItems'));
}

    public function crudCreate(): View
    {
        return view('admin.setting.crud-create');
    }

    public function crudStore(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:settings,key'],
            'value' => ['nullable', 'string'],
        ]);

        Setting::create($validated);

        toast('Setting berhasil ditambahkan!', 'success');

        return redirect()->route('admin.settings-crud.index');
    }

    public function crudEdit(int|string $id): View
    {
        $setting = Setting::findOrFail($id);

        return view('admin.setting.crud-edit', compact('setting'));
    }

    public function crudUpdate(Request $request, int|string $id): RedirectResponse
    {
        $setting = Setting::findOrFail($id);

        $validated = $request->validate([
            'key' => ['required', 'string', 'max:255', 'unique:settings,key,' . $setting->id],
            'value' => ['nullable', 'string'],
        ]);

        $setting->update($validated);

        toast('Setting berhasil diperbarui!', 'success');

        return redirect()->route('admin.settings-crud.index');
    }

    public function crudDestroy(int|string $id): RedirectResponse
    {
        $setting = Setting::findOrFail($id);
        $setting->delete();

        toast('Setting berhasil dihapus!', 'success');

        return redirect()->route('admin.settings-crud.index');
    }

    /**
     * Helper untuk update setting berdasarkan key.
     */
    private function updateSetting(string $key, mixed $value): void
    {
        Setting::updateOrCreate(
            ['key' => $key],
            ['value' => $value]
        );
    }
}