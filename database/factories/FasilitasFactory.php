<?php

namespace Database\Factories;

use App\Enums\KondisiFasilitas;
use App\Models\Fasilitas;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Fasilitas>
 */
class FasilitasFactory extends Factory
{
    protected $model = Fasilitas::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_fasilitas' => 'Fasilitas '.fake()->unique()->bothify('??-##'),
            'jumlah' => fake()->numberBetween(1, 20),
            'kondisi' => KondisiFasilitas::Baik,
            'keterangan' => fake()->optional()->sentence(),
        ];
    }
}
