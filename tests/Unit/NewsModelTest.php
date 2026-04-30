<?php

use Illuminate\Foundation\Testing\RefreshDatabase;
use App\Models\News;
use App\Models\Category;
use App\Models\Admin;
use App\Models\Language;

uses(Tests\TestCase::class, RefreshDatabase::class);

// ============================================================================
// scopeActiveEntries
// ============================================================================

test('scopeActiveEntries hanya mengembalikan berita dengan status=1 dan is_approved=1', function () {
    $admin = Admin::factory()->create();
    $category = Category::factory()->create();

    // Berita aktif & approved
    News::factory()->create([
        'status' => 1,
        'is_approved' => 1,
        'auther_id' => $admin->id,
        'category_id' => $category->id,
    ]);

    // Berita tidak aktif
    News::factory()->create([
        'status' => 0,
        'is_approved' => 1,
        'auther_id' => $admin->id,
        'category_id' => $category->id,
    ]);

    // Berita pending (belum approved)
    News::factory()->create([
        'status' => 1,
        'is_approved' => 0,
        'auther_id' => $admin->id,
        'category_id' => $category->id,
    ]);

    $activeNews = News::activeEntries()->get();

    expect($activeNews)->toHaveCount(1);
    expect($activeNews->first()->status)->toBe(1);
    expect($activeNews->first()->is_approved)->toBe(1);
});

// ============================================================================
// scopeWithLocalize
// ============================================================================

test('scopeWithLocalize memfilter berita berdasarkan bahasa session', function () {
    Language::factory()->create(['lang' => 'en', 'default' => 1]);
    session(['language' => 'en']);

    $admin = Admin::factory()->create();
    $category = Category::factory()->create(['language' => 'en']);

    // Berita bahasa Inggris
    News::factory()->create([
        'language' => 'en',
        'auther_id' => $admin->id,
        'category_id' => $category->id,
    ]);

    // Berita bahasa Indonesia
    News::factory()->create([
        'language' => 'id',
        'auther_id' => $admin->id,
        'category_id' => $category->id,
    ]);

    $localizedNews = News::withLocalize()->get();

    expect($localizedNews)->toHaveCount(1);
    expect($localizedNews->first()->language)->toBe('en');
});

// ============================================================================
// Relasi Model News
// ============================================================================

test('News memiliki relasi belongsTo ke Category', function () {
    $news = News::factory()->create();

    expect($news->category)->toBeInstanceOf(Category::class);
});

test('News memiliki relasi belongsTo ke Admin (auther)', function () {
    $news = News::factory()->create();

    expect($news->auther)->toBeInstanceOf(Admin::class);
});

test('News memiliki relasi belongsToMany ke Tag', function () {
    $news = News::factory()->create();
    $tag = \App\Models\Tag::factory()->create();

    $news->tags()->attach($tag->id);

    expect($news->tags)->toHaveCount(1);
    expect($news->tags->first()->name)->toBe($tag->name);
});
