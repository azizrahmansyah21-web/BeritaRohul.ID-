<?php

use App\Models\Subscriber;

test('Subscribe berhasil dengan email valid', function () {
    $response = $this->post('/subscribe-newsletter', [
        'email' => 'pembaca@example.com',
    ]);
    $response->assertStatus(200);
    $response->assertJson(['status' => 'success']);
    $this->assertDatabaseHas('subscribers', ['email' => 'pembaca@example.com']);
});

test('Subscribe gagal dengan email duplikat', function () {
    Subscriber::factory()->create(['email' => 'sudah.ada@example.com']);
    $response = $this->post('/subscribe-newsletter', [
        'email' => 'sudah.ada@example.com',
    ]);
    $response->assertSessionHasErrors('email');
});

test('Subscribe gagal tanpa email', function () {
    $response = $this->post('/subscribe-newsletter', ['email' => '']);
    $response->assertSessionHasErrors('email');
});

test('Subscribe gagal dengan format email tidak valid', function () {
    $response = $this->post('/subscribe-newsletter', ['email' => 'bukan-email']);
    $response->assertSessionHasErrors('email');
});
