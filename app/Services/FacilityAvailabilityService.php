<?php

namespace App\Services;

use App\Enums\StatusPeminjaman;
use App\Models\DetailPeminjaman;
use App\Models\Fasilitas;
use Illuminate\Support\Facades\DB;

class FacilityAvailabilityService
{
    /**
     * Get the remaining stock for facilities during a requested time range.
     *
     * @param  array<int, int>  $fasilitasIds
     * @return array<int, int>
     */
    public function availableQuantities(
        array $fasilitasIds,
        string $tanggal,
        string $jamMulai,
        string $jamSelesai,
        ?int $exceptPeminjamanId = null,
    ): array {
        if ($fasilitasIds === []) {
            return [];
        }

        $stokTotal = Fasilitas::query()
            ->whereIn('id_fasilitas', $fasilitasIds)
            ->pluck('jumlah', 'id_fasilitas');

        $stokTerpakai = DetailPeminjaman::query()
            ->select('detail_peminjaman.id_fasilitas', DB::raw('SUM(detail_peminjaman.jumlah) as jumlah_terpakai'))
            ->join('peminjaman', 'peminjaman.id_peminjaman', '=', 'detail_peminjaman.id_peminjaman')
            ->whereIn('detail_peminjaman.id_fasilitas', $fasilitasIds)
            ->where('peminjaman.status', StatusPeminjaman::Disetujui)
            ->where('peminjaman.tanggal', $tanggal)
            ->when(
                $exceptPeminjamanId,
                fn ($query) => $query->where('peminjaman.id_peminjaman', '!=', $exceptPeminjamanId),
            )
            ->where('peminjaman.jam_mulai', '<', $jamSelesai)
            ->where('peminjaman.jam_selesai', '>', $jamMulai)
            ->groupBy('detail_peminjaman.id_fasilitas')
            ->pluck('jumlah_terpakai', 'detail_peminjaman.id_fasilitas');

        return $stokTotal
            ->mapWithKeys(fn ($jumlah, $id): array => [(int) $id => max(0, (int) $jumlah - (int) ($stokTerpakai[$id] ?? 0))])
            ->all();
    }
}
