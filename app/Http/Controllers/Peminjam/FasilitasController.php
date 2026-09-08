<?php

namespace App\Http\Controllers\Peminjam;

use App\Http\Controllers\Controller;
use App\Models\Fasilitas;
use Illuminate\View\View;

class FasilitasController extends Controller
{
    /**
     * Display the facility catalog.
     */
    public function index(): View
    {
        $fasilitas = Fasilitas::query()
            ->orderBy('nama_fasilitas')
            ->get();

        return view('peminjam.fasilitas.index', compact('fasilitas'));
    }
}
