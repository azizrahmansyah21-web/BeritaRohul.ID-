<?php

namespace Database\Factories;

use App\Models\Language;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Language>
 */
class LanguageFactory extends Factory
{
    protected $model = Language::class;

    public function definition(): array
    {
        return [
            'name' => 'English',
            'lang' => 'en',
            'slug' => 'english',
            'default' => 1,
            'status' => 1,
        ];
    }

    /** State: Bahasa Indonesia */
    public function indonesian(): static
    {
        return $this->state(fn (array $attributes) => [
            'name' => 'Bahasa Indonesia',
            'lang' => 'id',
            'slug' => 'bahasa-indonesia',
            'default' => 0,
        ]);
    }
}
