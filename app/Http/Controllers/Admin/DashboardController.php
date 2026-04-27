<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Language;
use App\Models\News;
use App\Models\SocialLink;
use App\Models\Subscriber;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use App\Models\Admin;

class DashboardController extends Controller
{
    public function index() : View
    {
        $publishedNews = News::where(['status' => 1, 'is_approved' => 1])->count();
        $pendingNews = News::where(['status' => 1, 'is_approved' => 0])->count();
        $Categories = Category::count();
        $languages = Language::count();
        $roles = Role::count();
        $permissions = Permission::count();
        $socials = SocialLink::count();
        $subscribers = Subscriber::count();

        $recentNews = News::with('category')->latest()->take(5)->get();
        $topAuthors = Admin::withCount('news')
            ->orderBy('news_count', 'desc')
            ->take(5)
            ->get();

        $adSettings = \App\Models\Ad::first();
        $activeAds = 0;
        $inactiveAds = 0;

        if ($adSettings) {
            $statuses = [
                $adSettings->home_top_bar_ad_status,
                $adSettings->home_middle_ad_status,
                $adSettings->view_page_ad_status,
                $adSettings->news_page_ad_status,
                $adSettings->side_bar_ad_status,
            ];
        
            $activeAds = count(array_filter($statuses, function($status) {
                return $status == 1;
            }));

            $inactiveAds = 5 - $activeAds;
        }
        return view('admin.dashboard.index', compact(
            'publishedNews', 
            'pendingNews', 
            'Categories', 
            'languages', 
            'roles', 
            'permissions', 
            'socials', 
            'subscribers',
            'recentNews',
            'topAuthors',
            'activeAds',
            'inactiveAds'
        ));
    }
}