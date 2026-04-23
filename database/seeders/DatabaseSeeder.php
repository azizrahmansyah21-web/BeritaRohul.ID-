<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Str;
use Carbon\Carbon;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $now = Carbon::now();

        // Nonaktifkan foreign key checks sementara jika melakukan truncate/fresh seed
        Schema::disableForeignKeyConstraints();

        // ==========================================
        // 1. PENGATURAN DASAR & BAHASA
        // ==========================================
        DB::table('languages')->updateOrInsert(['slug' => 'id'], [
            'name' => 'Indonesia',
            'lang' => 'id',
            'default' => 1,
            'status' => 1,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        DB::table('settings')->insert([
            ['key' => 'site_seo_title', 'value' => 'Portal Berita Rohul Terkini BeritaRohul.id', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'site_seo_description', 'value' => 'Portal berita terkini, terpercaya, dan tercepat di Rokan Hulu.', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'site_seo_keywords', 'value' => 'berita rohul, rokan hulu, portal berita, riau', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'site_logo', 'value' => 'logo-beritarohul.png', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'site_favicon', 'value' => 'favicon-beritarohul.png', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'site_name', 'value' => 'BeritaRohul.id', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'site_color', 'value' => '#007bff', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // ==========================================
        // 2. ROLES, PERMISSIONS & USERS
        // ==========================================
        $roleAdminId = DB::table('roles')->insertGetId(['name' => 'Super Admin', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now]);
        $roleEditorId = DB::table('roles')->insertGetId(['name' => 'Editor', 'guard_name' => 'web', 'created_at' => $now, 'updated_at' => $now]);

        $adminId = DB::table('admins')->insertGetId([
            'name' => 'Administrator',
            'email' => 'admin@beritarohul.id',
            'image' => 'default-admin.png',
            'password' => Hash::make('password123'),
            'status' => 1,
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        $userId = DB::table('users')->insertGetId([
            'name' => 'Pembaca Rohul',
            'email' => 'pembaca@gmail.com',
            'password' => Hash::make('password123'),
            'email_verified_at' => $now,
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // Assign Role to Admin (Spatie format)
        DB::table('model_has_roles')->insert([
            'role_id' => $roleAdminId,
            'model_type' => 'App\Models\Admin', // Sesuaikan dengan namespace model Admin Anda
            'model_id' => $adminId
        ]);

        // ==========================================
        // 3. KATEGORI & TAGS
        // ==========================================
        $categories = ['Pemerintahan', 'Hukum & Kriminal', 'Pendidikan', 'Ekonomi', 'Olahraga'];
        $categoryIds = [];
        foreach ($categories as $category) {
            $categoryIds[] = DB::table('categories')->insertGetId([
                'language' => 'id',
                'name' => $category,
                'slug' => Str::slug($category),
                'show_at_nav' => 1,
                'status' => 1,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        $tags = ['Rohul Terkini', 'Pasir Pengaraian', 'Pemkab Rohul', 'Viral'];
        $tagIds = [];
        foreach ($tags as $tag) {
            $tagIds[] = DB::table('tags')->insertGetId([
                'language' => 'id',
                'name' => $tag,
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }

        // ==========================================
        // 4. BERITA, KOMENTAR & RELASI TAG
        // ==========================================
        $newsTitles = [
            'Bupati Rohul Resmikan Pembangunan Infrastruktur Baru',
            'Harga Kebutuhan Pokok di Pasar Pasir Pengaraian Stabil',
            'Prestasi Siswa Rohul di Ajang Olimpiade Sains Nasional',
            'Kondisi Cuaca Ekstrem, Warga Bantaran Sungai Diimbau Waspada',
            'Turnamen Sepakbola Antar Kecamatan Resmi Digelar'
        ];

        foreach ($newsTitles as $index => $title) {
            $newsId = DB::table('news')->insertGetId([
                'language' => 'id',
                'category_id' => $categoryIds[array_rand($categoryIds)],
                'auther_id' => $adminId, // Typo auther_id mengikuti struktur DB
                'image' => 'sample-news-' . ($index + 1) . '.jpg',
                'title' => $title,
                'slug' => Str::slug($title),
                'content' => '<p>Detail lengkap mengenai berita <strong>' . $title . '</strong>. Ini adalah konten simulasi yang dibuat untuk keperluan development.</p>',
                'meta_title' => $title,
                'meta_description' => Str::limit($title, 150),
                'is_breaking_news' => rand(0, 1),
                'show_at_slider' => rand(0, 1),
                'show_at_popular' => rand(0, 1),
                'is_approved' => 1,
                'status' => 1,
                'views' => rand(50, 5000),
                'created_at' => clone $now->subDays(rand(0, 10)),
                'updated_at' => clone $now->subDays(rand(0, 10)),
            ]);

            // Relasi Tag
            DB::table('news_tags')->insert([
                ['news_id' => $newsId, 'tag_id' => $tagIds[array_rand($tagIds)], 'created_at' => $now, 'updated_at' => $now]
            ]);

            // Komentar Dummy
            if (rand(0, 1)) {
                DB::table('comments')->insert([
                    'news_id' => $newsId,
                    'user_id' => $userId,
                    'comment' => 'Informasi yang sangat bermanfaat untuk masyarakat Rohul!',
                    'created_at' => clone $now,
                    'updated_at' => clone $now,
                ]);
            }
        }

        // ==========================================
        // 5. TAMPILAN HALAMAN DEPAN (HOME SECTION)
        // ==========================================
        DB::table('home_section_settings')->insert([
            'language' => 'id',
            'category_section_one' => $categoryIds[0],
            'category_section_two' => $categoryIds[1],
            'category_section_three' => $categoryIds[2],
            'category_section_four' => $categoryIds[3],
            'created_at' => $now,
            'updated_at' => $now,
        ]);

        // ==========================================
        // 6. IKLAN (ADS)
        // ==========================================
        DB::table('ads')->updateOrInsert(['id' => 1], [
            'home_top_bar_ad' => 'ad-top.jpg', 'home_top_bar_ad_status' => 1, 'home_top_bar_ad_url' => 'https://example.com',
            'home_middle_ad' => 'ad-mid.jpg', 'home_middle_ad_status' => 1, 'home_middle_ad_url' => 'https://example.com',
            'view_page_ad' => 'ad-view.jpg', 'view_page_ad_status' => 1, 'view_page_ad_url' => 'https://example.com',
            'news_page_ad' => 'ad-news.jpg', 'news_page_ad_status' => 1, 'news_page_ad_url' => 'https://example.com',
            'side_bar_ad' => 'ad-side.jpg', 'side_bar_ad_status' => 1, 'side_bar_ad_url' => 'https://example.com',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        // ==========================================
        // 7. KONTAK, ABOUT & FOOTER INFO
        // ==========================================
        DB::table('abouts')->insert([
            'language' => 'id',
            'content' => '<p>BeritaRohul.id adalah portal berita terdepan yang menyajikan informasi aktual dan faktual seputar Rokan Hulu dan sekitarnya.</p>',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        DB::table('contacts')->insert([
            'language' => 'id',
            'address' => 'Jl. Tuanku Tambusai, Pasir Pengaraian, Rokan Hulu, Riau',
            'phone' => '+62 812-3456-7890',
            'email' => 'redaksi@beritarohul.id',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        DB::table('footer_infos')->insert([
            'language' => 'id',
            'logo' => 'logo-footer.png',
            'description' => 'Menyajikan berita tercepat dan akurat dari Rokan Hulu untuk dunia.',
            'copyright' => '© 2026 BeritaRohul.id - All Rights Reserved.',
            'created_at' => $now, 'updated_at' => $now,
        ]);

        // Footer Titles
        DB::table('footer_titles')->insert([
            ['language' => 'id', 'key' => 'grid_one_title', 'value' => 'Kategori Utama', 'created_at' => $now, 'updated_at' => $now],
            ['language' => 'id', 'key' => 'grid_two_title', 'value' => 'Tautan Berguna', 'created_at' => $now, 'updated_at' => $now],
            ['language' => 'id', 'key' => 'grid_three_title', 'value' => 'Kebijakan', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // Footer Grids (Menu-menu di Footer)
        DB::table('footer_grid_ones')->insert([
            ['language' => 'id', 'name' => 'Pemerintahan', 'url' => '/kategori/pemerintahan', 'status' => 1, 'created_at' => $now, 'updated_at' => $now]
        ]);
        DB::table('footer_grid_twos')->insert([
            ['language' => 'id', 'name' => 'Tentang Kami', 'url' => '/about', 'status' => 1, 'created_at' => $now, 'updated_at' => $now]
        ]);
        DB::table('footer_grid_threes')->insert([
            ['language' => 'id', 'name' => 'Privacy Policy', 'url' => '/privacy', 'status' => 1, 'created_at' => $now, 'updated_at' => $now]
        ]);

        // ==========================================
        // 8. MEDIA SOSIAL & SUBSCRIBERS
        // ==========================================
        DB::table('social_links')->insert([
            ['icon' => 'fab fa-facebook', 'url' => 'https://facebook.com/beritarohul', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
            ['icon' => 'fab fa-instagram', 'url' => 'https://instagram.com/beritarohul.id', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('social_counts')->insert([
            ['language' => 'id', 'icon' => 'fab fa-facebook', 'fan_count' => '10K', 'fan_type' => 'Fans', 'button_text' => 'Like', 'color' => '#3b5998', 'url' => 'https://facebook.com', 'status' => 1, 'created_at' => $now, 'updated_at' => $now],
        ]);

        DB::table('subscribers')->insert([
            ['email' => 'subscriber1@gmail.com', 'created_at' => $now, 'updated_at' => $now],
            ['email' => 'subscriber2@yahoo.com', 'created_at' => $now, 'updated_at' => $now],
        ]);

        // ==========================================
        // 9. INBOX / RECEIVED MAILS
        // ==========================================
        DB::table('recived_mails')->insert([
            ['email' => 'pengiklan@agency.com', 'subject' => 'Pertanyaan Kerjasama Iklan', 'message' => 'Halo, saya ingin menanyakan rate card untuk slot banner di home.', 'seen' => 0, 'replied' => 0, 'created_at' => $now, 'updated_at' => $now]
        ]);

        Schema::enableForeignKeyConstraints();
    }
}