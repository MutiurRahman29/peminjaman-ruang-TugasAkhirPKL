<?php

namespace Database\Factories;

use App\Enums\StatusRuangan;
use App\Models\Ruangan;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ruangan>
 */
class RuanganFactory extends Factory
{
    protected $model = Ruangan::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_ruangan' => 'Ruang '.fake()->unique()->bothify('??-##'),
            'kapasitas' => fake()->numberBetween(10, 100),
            'lokasi' => 'Gedung '.fake()->randomLetter().' Lantai '.fake()->numberBetween(1, 5),
            'status' => StatusRuangan::Tersedia,
        ];
    }
}
