<?php

namespace App\Models;

use App\Enums\KondisiFasilitas;
use Database\Factories\FasilitasFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Fasilitas extends Model
{
    /** @use HasFactory<FasilitasFactory> */
    use HasFactory;

    /** @var string */
    protected $table = 'fasilitas';

    /** @var string */
    protected $primaryKey = 'id_fasilitas';

    /** @var list<string> */
    protected $fillable = [
        'nama_fasilitas',
        'jumlah',
        'kondisi',
        'keterangan',
    ];

    /**
     * Get the loan details that use the facility.
     *
     * @return HasMany<DetailPeminjaman, $this>
     */
    public function detailPeminjaman(): HasMany
    {
        return $this->hasMany(DetailPeminjaman::class, 'id_fasilitas', 'id_fasilitas');
    }

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'kondisi' => KondisiFasilitas::class,
        ];
    }
}
