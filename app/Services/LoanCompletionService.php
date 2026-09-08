<?php

namespace App\Services;

use App\Enums\StatusPeminjaman;
use App\Models\Peminjaman;
use Carbon\CarbonImmutable;
use DomainException;
use Illuminate\Support\Facades\DB;

class LoanCompletionService
{
    /**
     * Mark an approved loan as completed after its scheduled end time.
     *
     * @throws DomainException
     */
    public function complete(Peminjaman $peminjaman): void
    {
        DB::transaction(function () use ($peminjaman): void {
            $peminjaman = Peminjaman::query()
                ->lockForUpdate()
                ->findOrFail($peminjaman->id_peminjaman);

            if ($peminjaman->status !== StatusPeminjaman::Disetujui) {
                throw new DomainException('Peminjaman ini tidak dapat diselesaikan.');
            }

            $jadwalSelesai = CarbonImmutable::parse(
                $peminjaman->tanggal->toDateString().' '.$peminjaman->jam_selesai,
                config('app.timezone'),
            );

            if ($jadwalSelesai->isFuture()) {
                throw new DomainException('Peminjaman belum dapat diselesaikan sebelum jadwal berakhir.');
            }

            $peminjaman->update(['status' => StatusPeminjaman::Selesai]);
        });
    }
}
