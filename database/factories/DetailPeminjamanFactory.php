<?php

namespace Database\Factories;

use App\Models\DetailPeminjaman;
use App\Models\Fasilitas;
use App\Models\Peminjaman;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<DetailPeminjaman>
 */
class DetailPeminjamanFactory extends Factory
{
    protected $model = DetailPeminjaman::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'id_peminjaman' => Peminjaman::factory(),
            'id_fasilitas' => Fasilitas::factory(),
            'jumlah' => 1,
        ];
    }
}
