<?php

namespace App\Http\Controllers\Peminjam;

use App\Enums\KondisiFasilitas;
use App\Enums\StatusPeminjaman;
use App\Enums\StatusRuangan;
use App\Http\Controllers\Controller;
use App\Http\Requests\Peminjam\StorePeminjamanRequest;
use App\Models\Fasilitas;
use App\Models\Peminjaman;
use App\Models\Ruangan;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    /**
     * Display the authenticated user's loan history.
     */
    public function index(Request $request): View
    {
        $peminjaman = $request->user()
            ->peminjaman()
            ->with(['ruangan', 'detailPeminjaman.fasilitas'])
            ->orderByDesc('tanggal')
            ->orderByDesc('jam_mulai')
            ->get();

        return view('peminjam.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Display the room loan request form.
     */
    public function create(): View
    {
        $ruangan = Ruangan::query()
            ->where('status', StatusRuangan::Tersedia)
            ->orderBy('nama_ruangan')
            ->get();

        $fasilitas = Fasilitas::query()
            ->where('kondisi', KondisiFasilitas::Baik)
            ->where('jumlah', '>', 0)
            ->orderBy('nama_fasilitas')
            ->get();

        return view('peminjam.peminjaman.create', compact('ruangan', 'fasilitas'));
    }

    /**
     * Store a new room loan request for the authenticated user.
     */
    public function store(StorePeminjamanRequest $request): RedirectResponse
    {
        $peminjaman = DB::transaction(function () use ($request) {
            $peminjaman = $request->user()
                ->peminjaman()
                ->create([
                    ...$request->safe()->only([
                        'id_ruangan',
                        'tanggal',
                        'jam_mulai',
                        'jam_selesai',
                        'keperluan',
                    ]),
                    'status' => StatusPeminjaman::Menunggu,
                ]);

            $peminjaman->detailPeminjaman()->createMany($request->selectedFasilitas());

            return $peminjaman;
        });

        return redirect()
            ->route('peminjam.peminjaman.show', $peminjaman)
            ->with('success', 'Pengajuan peminjaman berhasil dikirim.');
    }

    /**
     * Display a loan owned by the authenticated user.
     */
    public function show(Peminjaman $peminjaman): View
    {
        Gate::authorize('view', $peminjaman);

        $peminjaman->load(['ruangan', 'detailPeminjaman.fasilitas']);

        return view('peminjam.peminjaman.show', compact('peminjaman'));
    }
}
