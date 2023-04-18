<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Validation\Rules\Unique;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\JalurMasuk>
 */
class JalurMasukFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama' => fake()->unique()->randomElement(['Registrasi Utama', 'Putra/putri Guru', 'On The Spot', 'SBMPTN', 'Tes']),
            'status' => fake()->randomElement(['aktif', 'tidak aktif'])
        ];
    }
}
