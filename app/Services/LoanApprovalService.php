<?php

namespace App\Services;

use App\Enums\KondisiFasilitas;
use App\Enums\StatusPeminjaman;
use App\Enums\StatusRuangan;
use App\Models\Fasilitas;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use DomainException;
use Illuminate\Support\Facades\DB;

class LoanApprovalService
{
    public function __construct(
        private readonly RoomAvailabilityService $roomAvailability,
        private readonly FacilityAvailabilityService $facilityAvailability,
    ) {}

    /**
     * Approve a pending loan after locking the loan, room, and selected facilities.
     *
     * @throws DomainException
     */
    public function approve(Peminjaman $peminjaman): void
    {
        DB::transaction(function () use ($peminjaman): void {
            $peminjaman = Peminjaman::query()
                ->lockForUpdate()
                ->findOrFail($peminjaman->id_peminjaman);

            $this->ensurePending($peminjaman);

            $ruangan = Ruangan::query()
                ->lockForUpdate()
                ->findOrFail($peminjaman->id_ruangan);

            if ($ruangan->status !== StatusRuangan::Tersedia) {
                throw new DomainException('Ruangan tidak tersedia untuk disetujui.');
            }

            $fasilitasIds = $peminjaman->detailPeminjaman()
                ->orderBy('id_fasilitas')
                ->pluck('id_fasilitas')
                ->map(fn ($id): int => (int) $id)
                ->all();

            $fasilitas = Fasilitas::query()
                ->whereIn('id_fasilitas', $fasilitasIds)
                ->orderBy('id_fasilitas')
                ->lockForUpdate()
                ->get()
                ->keyBy('id_fasilitas');

            if ($this->roomAvailability->hasConflict(
                $peminjaman->id_ruangan,
                $peminjaman->tanggal->toDateString(),
                $peminjaman->jam_mulai,
                $peminjaman->jam_selesai,
                $peminjaman->id_peminjaman,
            )) {
                throw new DomainException('Jadwal ruangan sudah bentrok dengan peminjaman yang disetujui.');
            }

            foreach ($fasilitasIds as $idFasilitas) {
                $item = $fasilitas->get($idFasilitas);

                if (! $item instanceof Fasilitas || $item->kondisi !== KondisiFasilitas::Baik || $item->jumlah < 1) {
                    throw new DomainException('Fasilitas pada pengajuan tidak tersedia untuk disetujui.');
                }
            }

            $stokTersedia = $this->facilityAvailability->availableQuantities(
                $fasilitasIds,
                $peminjaman->tanggal->toDateString(),
                $peminjaman->jam_mulai,
                $peminjaman->jam_selesai,
                $peminjaman->id_peminjaman,
            );

            foreach ($peminjaman->detailPeminjaman as $detail) {
                $tersedia = $stokTersedia[$detail->id_fasilitas] ?? 0;

                if ($detail->jumlah > $tersedia) {
                    $namaFasilitas = $fasilitas->get($detail->id_fasilitas)?->nama_fasilitas ?? 'Fasilitas';

                    throw new DomainException("Stok {$namaFasilitas} pada jadwal tersebut hanya tersedia {$tersedia}.");
                }
            }

            $peminjaman->update(['status' => StatusPeminjaman::Disetujui]);
        });
    }

    /**
     * Reject a pending loan.
     *
     * @throws DomainException
     */
    public function reject(Peminjaman $peminjaman): void
    {
        DB::transaction(function () use ($peminjaman): void {
            $peminjaman = Peminjaman::query()
                ->lockForUpdate()
                ->findOrFail($peminjaman->id_peminjaman);

            $this->ensurePending($peminjaman);

            $peminjaman->update(['status' => StatusPeminjaman::Ditolak]);
        });
    }

    /**
     * @throws DomainException
     */
    private function ensurePending(Peminjaman $peminjaman): void
    {
        if ($peminjaman->status !== StatusPeminjaman::Menunggu) {
            throw new DomainException('Pengajuan ini tidak dapat diproses lagi.');
        }
    }
}
