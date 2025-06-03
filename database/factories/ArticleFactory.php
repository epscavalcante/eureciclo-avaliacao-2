<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Article>
 */
class ArticleFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'file_id' => 1,
            'identificacao' => $this->faker->numerify('#############'),
            'data' => $this->faker->date(),
            'ementa' => $this->faker->words(5, true),
            'titulo' => $this->faker->sentence(),
            'subtitulo' => $this->faker->sentence(10),
            'texto' => $this->faker->text(rand(400, 900)),
        ];
    }
}
