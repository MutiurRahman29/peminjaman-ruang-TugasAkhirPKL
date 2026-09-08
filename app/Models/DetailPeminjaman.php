<?php

namespace App\Models;

use Database\Factories\DetailPeminjamanFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class DetailPeminjaman extends Model
{
    /** @use HasFactory<DetailPeminjamanFactory> */
    use HasFactory;

    /** @var string */
    protected $table = 'detail_peminjaman';

    /** @var string */
    protected $primaryKey = 'id_detail';

    /** @var list<string> */
    protected $fillable = [
        'id_peminjaman',
        'id_fasilitas',
        'jumlah',
    ];

    /**
     * Get the loan for this detail.
     *
     * @return BelongsTo<Peminjaman, $this>
     */
    public function peminjaman(): BelongsTo
    {
        return $this->belongsTo(Peminjaman::class, 'id_peminjaman', 'id_peminjaman');
    }

    /**
     * Get the facility for this detail.
     *
     * @return BelongsTo<Fasilitas, $this>
     */
    public function fasilitas(): BelongsTo
    {
        return $this->belongsTo(Fasilitas::class, 'id_fasilitas', 'id_fasilitas');
    }
}
