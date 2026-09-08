<?php

namespace App\Http\Controllers\Petugas;

use App\Enums\StatusPeminjaman;
use App\Http\Controllers\Controller;
use App\Models\Peminjaman;
use App\Services\LoanApprovalService;
use DomainException;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Gate;
use Illuminate\View\View;

class PeminjamanController extends Controller
{
    /**
     * Display the pending loan queue.
     */
    public function index(): View
    {
        $peminjaman = Peminjaman::query()
            ->with(['user', 'ruangan', 'detailPeminjaman.fasilitas'])
            ->where('status', StatusPeminjaman::Menunggu)
            ->orderBy('tanggal')
            ->orderBy('jam_mulai')
            ->orderBy('created_at')
            ->get();

        return view('petugas.peminjaman.index', compact('peminjaman'));
    }

    /**
     * Display a loan for staff review.
     */
    public function show(Peminjaman $peminjaman): View
    {
        Gate::authorize('view', $peminjaman);

        $peminjaman->load(['user', 'ruangan', 'detailPeminjaman.fasilitas']);

        return view('petugas.peminjaman.show', compact('peminjaman'));
    }

    /**
     * Approve a pending loan.
     */
    public function approve(Peminjaman $peminjaman, LoanApprovalService $approval): RedirectResponse
    {
        Gate::authorize('approve', $peminjaman);

        try {
            $approval->approve($peminjaman);
        } catch (DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('petugas.peminjaman.show', $peminjaman)
            ->with('success', 'Pengajuan peminjaman disetujui.');
    }

    /**
     * Reject a pending loan.
     */
    public function reject(Peminjaman $peminjaman, LoanApprovalService $approval): RedirectResponse
    {
        Gate::authorize('reject', $peminjaman);

        try {
            $approval->reject($peminjaman);
        } catch (DomainException $exception) {
            return back()->with('error', $exception->getMessage());
        }

        return redirect()
            ->route('petugas.peminjaman.show', $peminjaman)
            ->with('success', 'Pengajuan peminjaman ditolak.');
    }
}
