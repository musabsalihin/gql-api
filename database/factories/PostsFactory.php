<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Model>
 */
class PostsFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $main_title = fake()->text(20);
        $title = [
            'default' => $main_title,
            'bm' => '',
            'en' => $main_title,
            'cn' => '',
        ];;
        return [
            'post_title' => $title,
            'post_description' => fake()->text(400),
            'post_status' => rand(0,1)?'publish':'draft',
            'post_publish_date' => fake()->dateTimeBetween('now', '+3 months')->format('Y-m-d'),
        ];
    }
}
