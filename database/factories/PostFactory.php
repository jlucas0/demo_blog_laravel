<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        //Generates a random html and removes <html>,<head> and <body> tags
        $text = fake()->randomHtml();
        $text = substr($text,strpos($text,'<body>')+6);
        $text = substr($text,0,strpos($text,"</body>"));

        
        return [
            'title' => fake()->sentence(),
            'slug' => fake()->unique()->slug(),
            'extract' => fake()->text(),
            'post' => $text,
        ];
    }
}
