<?php

// ============================================================================
// Test Pembuatan Slug dari Judul Berita
// ============================================================================

test('slug dihasilkan dengan benar dari judul biasa', function () {
    $slug = \Str::slug('Berita Hari Ini');
    expect($slug)->toBe('berita-hari-ini');
});

test('slug menangani karakter spesial', function () {
    $slug = \Str::slug('Berita: Update & Terkini!');
    expect($slug)->toBe('berita-update-terkini');
});

test('slug menangani spasi ganda', function () {
    $slug = \Str::slug('Berita   Dengan   Spasi   Ganda');
    expect($slug)->toBe('berita-dengan-spasi-ganda');
});

test('slug mengubah huruf besar ke kecil', function () {
    $slug = \Str::slug('BERITA PENTING HARI INI');
    expect($slug)->toBe('berita-penting-hari-ini');
});

test('slug menangani karakter unicode/Indonesia', function () {
    $slug = \Str::slug('Berita Terbaru Dari Rohul 2025');
    expect($slug)->toBe('berita-terbaru-dari-rohul-2025');
});

test('slug menangani tanda hubung yang sudah ada', function () {
    $slug = \Str::slug('Berita-Terbaru Hari Ini');
    expect($slug)->toBe('berita-terbaru-hari-ini');
});

test('slug menghasilkan string kosong dari input kosong', function () {
    $slug = \Str::slug('');
    expect($slug)->toBe('');
});

test('slug menghapus angka leading/trailing spaces', function () {
    $slug = \Str::slug('  Berita Terkini  ');
    expect($slug)->toBe('berita-terkini');
});
