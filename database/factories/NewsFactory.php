<?php

namespace Database\Factories;

use App\Models\Admin;
use App\Models\Category;
use App\Models\News;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\News>
 */
class NewsFactory extends Factory
{
    protected $model = News::class;

    public function definition(): array
    {
        $title = fake()->unique()->sentence();

        return [
            'language' => 'en',
            'category_id' => Category::factory(),
            'auther_id' => Admin::factory(),
            'image' => 'uploads/news/default.jpg',
            'title' => $title,
            'slug' => \Str::slug($title),
            'content' => fake()->paragraphs(3, true),
            'meta_title' => fake()->sentence(),
            'meta_description' => fake()->sentence(),
            'is_breaking_news' => 0,
            'show_at_slider' => 0,
            'show_at_popular' => 0,
            'is_approved' => 1,
            'status' => 1,
            'views' => 0,
        ];
    }

    /** State: berita pending (belum disetujui) */
    public function pending(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_approved' => 0,
        ]);
    }

    /** State: berita inactive */
    public function inactive(): static
    {
        return $this->state(fn (array $attributes) => [
            'status' => 0,
        ]);
    }

    /** State: berita breaking news */
    public function breakingNews(): static
    {
        return $this->state(fn (array $attributes) => [
            'is_breaking_news' => 1,
        ]);
    }
}
