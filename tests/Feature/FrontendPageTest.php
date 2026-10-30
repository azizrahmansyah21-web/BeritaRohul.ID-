<?php

use App\Models\About;
use App\Models\Ad;
use App\Models\Contact;
use App\Models\Language;
use App\Models\News;
use App\Models\Setting;
use Illuminate\Support\Facades\View;

beforeEach(function () {
    Language::factory()->create(['lang' => 'en', 'default' => 1]);
    session(['language' => 'en']);

    // Seed settings yang dibutuhkan oleh blade views
    $settingsData = [
        'site_name' => 'BeritaRohul Test',
        'site_logo' => 'uploads/logo.png',
        'site_favicon' => 'uploads/favicon.png',
        'site_seo_title' => 'BeritaRohul Test',
        'site_seo_description' => 'Portal Berita Test',
        'site_seo_keywords' => 'berita,test',
        'site_color' => '#267538',
    ];

    foreach ($settingsData as $key => $value) {
        Setting::create(['key' => $key, 'value' => $value]);
    }

    // Share settings ke semua views (meniru AppServiceProvider)
    $settings = Setting::pluck('value', 'key')->toArray();
    View::share('settings', $settings);
});

function createAdRecord()
{
    return Ad::create([
        'home_top_bar_ad' => '', 'home_top_bar_ad_url' => '', 'home_top_bar_ad_status' => 0,
        'home_middle_ad' => '', 'home_middle_ad_url' => '', 'home_middle_ad_status' => 0,
        'news_page_ad' => '', 'news_page_ad_url' => '', 'news_page_ad_status' => 0,
        'view_page_ad' => '', 'view_page_ad_url' => '', 'view_page_ad_status' => 0,
        'side_bar_ad' => '', 'side_bar_ad_url' => '', 'side_bar_ad_status' => 0,
    ]);
}

test('Halaman Beranda (/) mengembalikan status 200', function () {
    createAdRecord();
    $response = $this->get('/');
    $response->assertStatus(200);
});

test('Halaman About mengembalikan status 200', function () {
    About::create(['content' => 'About us content', 'language' => 'en']);
    $response = $this->get('/about');
    $response->assertStatus(200);
});

test('Halaman Contact mengembalikan status 200', function () {
    Contact::create(['address' => 'Jl. Test', 'phone' => '08123', 'email' => 'test@test.com', 'language' => 'en']);
    $response = $this->get('/contact');
    $response->assertStatus(200);
});

test('Detail berita valid mengembalikan status 200', function () {
    createAdRecord();
    $news = News::factory()->create([
        'language' => 'en', 'status' => 1, 'is_approved' => 1,
        'slug' => 'berita-valid-test',
    ]);
    $response = $this->get('/news-details/berita-valid-test');
    $response->assertStatus(200);
});

test('Detail berita slug tidak ada mengembalikan 404 (Bug #3 fix)', function () {
    $response = $this->get('/news-details/slug-yang-tidak-ada-sama-sekali');
    $response->assertStatus(404);
});

test('Halaman daftar berita (/news) mengembalikan status 200', function () {
    createAdRecord();
    $response = $this->get('/news');
    $response->assertStatus(200);
});
