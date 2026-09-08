<?php

namespace App\Services;

use App\Enums\StatusPeminjaman;
use App\Models\Peminjaman;

class RoomAvailabilityService
{
    /**
     * Determine whether an approved loan overlaps the requested time range.
     */
    public function hasConflict(
        int $idRuangan,
        string $tanggal,
        string $jamMulai,
        string $jamSelesai,
        ?int $exceptPeminjamanId = null,
    ): bool {
        return Peminjaman::query()
            ->where('id_ruangan', $idRuangan)
            ->where('tanggal', $tanggal)
            ->where('status', StatusPeminjaman::Disetujui)
            ->when(
                $exceptPeminjamanId,
                fn ($query) => $query->where('id_peminjaman', '!=', $exceptPeminjamanId),
            )
            ->where('jam_mulai', '<', $jamSelesai)
            ->where('jam_selesai', '>', $jamMulai)
            ->exists();
    }
}
