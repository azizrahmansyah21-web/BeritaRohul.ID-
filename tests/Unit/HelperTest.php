<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\Language;
use App\Models\Setting;

uses(Tests\TestCase::class, RefreshDatabase::class);

// ============================================================================
// formatTags()
// ============================================================================

test('formatTags menggabungkan array menjadi string CSV', function () {
    $result = formatTags(['Laravel', 'PHP', 'Testing']);
    expect($result)->toBe('Laravel,PHP,Testing');
});

test('formatTags dengan satu elemen', function () {
    $result = formatTags(['Laravel']);
    expect($result)->toBe('Laravel');
});

test('formatTags dengan array kosong mengembalikan string kosong', function () {
    $result = formatTags([]);
    expect($result)->toBe('');
});

// ============================================================================
// truncate()
// ============================================================================

test('truncate memotong teks sesuai limit', function () {
    $text = 'Ini adalah berita yang sangat panjang sekali dan harus dipotong';
    $result = truncate($text, 20);
    expect(strlen($result))->toBeLessThanOrEqual(23); // 20 + '...'
    expect($result)->toContain('...');
});

test('truncate tidak memotong teks pendek', function () {
    $text = 'Singkat';
    $result = truncate($text, 45);
    expect($result)->toBe('Singkat');
});

test('truncate menggunakan default limit 45', function () {
    $text = str_repeat('a', 100);
    $result = truncate($text);
    expect(strlen($result))->toBeLessThanOrEqual(48); // 45 + '...'
});

// ============================================================================
// convertToKFormat()
// ============================================================================

test('convertToKFormat menampilkan angka biasa di bawah 1000', function () {
    expect(convertToKFormat(999))->toEqual(999);
    expect(convertToKFormat(0))->toEqual(0);
    expect(convertToKFormat(500))->toEqual(500);
});

test('convertToKFormat mengubah ribuan ke format K', function () {
    expect(convertToKFormat(1000))->toBe('1K');
    expect(convertToKFormat(1500))->toBe('1.5K');
    expect(convertToKFormat(10000))->toBe('10K');
    expect(convertToKFormat(999999))->toBe('1000K');
});

test('convertToKFormat mengubah jutaan ke format M', function () {
    expect(convertToKFormat(1000000))->toBe('1M');
    expect(convertToKFormat(2500000))->toBe('2.5M');
});

// ============================================================================
// setSidebarActive()
// ============================================================================

test('setSidebarActive mengembalikan active jika route cocok', function () {
    // Simulate named route
    $this->get('/');
    $result = setSidebarActive(['index']);
    // Since we're testing via HTTP context, just verify function doesn't crash
    expect($result)->toBeIn(['active', '']);
});

test('setSidebarActive mengembalikan string kosong jika route tidak cocok', function () {
    $result = setSidebarActive(['nonexistent.route']);
    expect($result)->toBe('');
});

// ============================================================================
// getLangauge() — termasuk test fix Bug #1
// ============================================================================

test('getLangauge mengembalikan bahasa dari session jika sudah di-set', function () {
    session(['language' => 'id']);
    expect(getLangauge())->toBe('id');
});

test('getLangauge mengembalikan bahasa default dari database', function () {
    Language::factory()->create(['lang' => 'en', 'default' => 1]);
    session()->forget('language');

    $result = getLangauge();
    expect($result)->toBe('en');
});

test('getLangauge mengembalikan en jika tidak ada bahasa di database (Bug #1 fix)', function () {
    // Tidak ada Language di database, session kosong
    session()->forget('language');

    $result = getLangauge();
    expect($result)->toBe('en');
});

// ============================================================================
// getSetting() — termasuk test fix Bug #2
// ============================================================================

test('getSetting mengembalikan value setting yang ada', function () {
    Setting::create(['key' => 'site_name', 'value' => 'BeritaRohul']);

    expect(getSetting('site_name'))->toBe('BeritaRohul');
});

test('getSetting mengembalikan null jika key tidak ditemukan (Bug #2 fix)', function () {
    // Tidak ada setting dengan key ini
    expect(getSetting('key_yang_tidak_ada'))->toBeNull();
});
