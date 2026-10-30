<?php

use App\Models\Comment;
use App\Models\News;
use App\Models\User;
use App\Models\Language;

// ============================================================================
// 💬 Pengujian Komentar
// ============================================================================

beforeEach(function () {
    Language::factory()->create(['lang' => 'en', 'default' => 1]);
    session(['language' => 'en']);
});

test('[Proteksi] Guest tidak bisa mengirim komentar — redirect ke login', function () {
    $news = News::factory()->create(['language' => 'en']);

    $response = $this->post('/news-comment', [
        'news_id' => $news->id,
        'comment' => 'Komentar dari guest',
    ]);

    // Guest harus di-redirect ke login
    $response->assertRedirect('/login');
});

test('[User Login] bisa mengirim komentar', function () {
    $user = User::factory()->create();
    $news = News::factory()->create(['language' => 'en']);

    $response = $this->actingAs($user)
        ->post('/news-comment', [
            'news_id' => $news->id,
            'comment' => 'Ini komentar saya',
        ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('comments', [
        'news_id' => $news->id,
        'user_id' => $user->id,
        'comment' => 'Ini komentar saya',
    ]);
});

test('[User Login] bisa membalas komentar (reply)', function () {
    $user = User::factory()->create();
    $news = News::factory()->create(['language' => 'en']);
    $parentComment = Comment::factory()->create([
        'news_id' => $news->id,
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)
        ->post('/news-comment-replay', [
            'news_id' => $news->id,
            'parent_id' => $parentComment->id,
            'replay' => 'Ini balasan komentar',
        ]);

    $response->assertRedirect();

    $this->assertDatabaseHas('comments', [
        'news_id' => $news->id,
        'parent_id' => $parentComment->id,
        'comment' => 'Ini balasan komentar',
    ]);
});

test('[Otorisasi] User hanya bisa hapus komentar miliknya sendiri', function () {
    $user = User::factory()->create();
    $news = News::factory()->create(['language' => 'en']);
    $comment = Comment::factory()->create([
        'news_id' => $news->id,
        'user_id' => $user->id,
    ]);

    $response = $this->actingAs($user)
        ->delete('/news-comment-destroy', [
            'id' => $comment->id,
        ]);

    $response->assertStatus(200);
    $response->assertJson(['status' => 'success']);

    $this->assertDatabaseMissing('comments', ['id' => $comment->id]);
});

test('[Otorisasi] User TIDAK bisa hapus komentar orang lain', function () {
    $userA = User::factory()->create();
    $userB = User::factory()->create();
    $news = News::factory()->create(['language' => 'en']);

    // Komentar milik User B
    $comment = Comment::factory()->create([
        'news_id' => $news->id,
        'user_id' => $userB->id,
    ]);

    // User A coba hapus komentar User B
    $response = $this->actingAs($userA)
        ->delete('/news-comment-destroy', [
            'id' => $comment->id,
        ]);

    $response->assertStatus(200);
    $response->assertJson(['status' => 'error']);

    // Komentar harus masih ada
    $this->assertDatabaseHas('comments', ['id' => $comment->id]);
});

test('[Validasi] Komentar kosong ditolak', function () {
    $user = User::factory()->create();
    $news = News::factory()->create(['language' => 'en']);

    $response = $this->actingAs($user)
        ->post('/news-comment', [
            'news_id' => $news->id,
            'comment' => '',
        ]);

    $response->assertSessionHasErrors('comment');
});
