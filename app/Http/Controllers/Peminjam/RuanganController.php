<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Ruangan;
use Illuminate\View\View;

class RuanganController extends Controller
{
    /**
     * Display the room catalog.
     */
    public function index(): View
    {
        $ruangan = Ruangan::query()
            ->orderBy('nama_ruangan')
            ->get();

        return view('peminjam.ruangan.index', compact('ruangan'));
    }
}
