<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Register>
 */
class RegisterFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'user_id' => $this->faker->numberBetween(2, 51),
            'nama' => $this->faker->name,
            'nama_ibu' => $this->faker->name('female'),
            'jk' => $this->faker->randomElement(['L', 'P']),
            'hp' => $this->faker->phoneNumber,
            'email' => $this->faker->unique()->safeEmail,
            'tempat_lahir' => $this->faker->city,
            'tanggal_lahir' => $this->faker->date,
            'alamat' => $this->faker->address,
            'kewarganegaraan' => 'Indonesia',
            'identitas_kewarganegaraan' => $this->faker->nik,
            'status_diterima' => 'diterima',
            'diterima_di' => $this->faker->numberBetween(1, 12),
            'jenjang_pendidikan_id' => 1,
            'sistem_kuliah_id' => 1,
            'jalur_masuk_id' => 1,
            'pilihan1' => $this->faker->numberBetween(1, 12),
            'pilihan2' => $this->faker->numberBetween(1, 12),
            'pilihan3' => $this->faker->numberBetween(1, 12),
            'nama_sekolah' => $this->faker->company,
            'jenis_sekolah' => $this->faker->randomElement(['SMA', 'SMK', 'MA']),
            'jurusan_sekolah' => $this->faker->word,
            'tahun_lulus' => $this->faker->year,
            'nisn' => $this->faker->unique()->numerify('##########'),
            'alamat_sekolah' => $this->faker->address,
        ];
    }
}
