<?php

use App\Models\Ad;
use App\Models\Language;

it('returns a successful response', function () {
    Language::factory()->create(['lang' => 'en', 'default' => 1]);
    session(['language' => 'en']);

    Ad::create([
        'home_top_bar_ad' => '', 'home_top_bar_ad_url' => '', 'home_top_bar_ad_status' => 0,
        'home_middle_ad' => '', 'home_middle_ad_url' => '', 'home_middle_ad_status' => 0,
        'news_page_ad' => '', 'news_page_ad_url' => '', 'news_page_ad_status' => 0,
        'view_page_ad' => '', 'view_page_ad_url' => '', 'view_page_ad_status' => 0,
        'side_bar_ad' => '', 'side_bar_ad_url' => '', 'side_bar_ad_status' => 0,
    ]);

    $response = $this->get('/');

    $response->assertStatus(200);
});
