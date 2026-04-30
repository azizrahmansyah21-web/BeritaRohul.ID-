<?php

use App\Models\Language;

beforeEach(function () {
    Language::factory()->create(['lang' => 'en', 'default' => 1]);
});

test('Bahasa bisa diubah via endpoint /language', function () {
    $response = $this->get('/language?language_code=id');
    $response->assertStatus(200);
    $response->assertJson(['status' => 'success']);
});

test('Session bahasa berubah setelah request', function () {
    $this->get('/language?language_code=id');
    expect(session('language'))->toBe('id');
});

test('Session bahasa berubah kembali ke en', function () {
    $this->get('/language?language_code=id');
    expect(session('language'))->toBe('id');

    $this->get('/language?language_code=en');
    expect(session('language'))->toBe('en');
});
