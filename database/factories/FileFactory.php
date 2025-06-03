<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\File>
 */
class FileFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'driver' => array_rand(['public', 'local', 'other']),
            'folder' => (string) $this->faker->uuid(),
            'file_name' => $this->faker->uuid().'.zip',
            'file_original_name' => $this->faker->numerify('#########').'.zip',
        ];
    }
}
