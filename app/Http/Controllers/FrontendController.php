<?php
namespace App\Http\Controllers;

use App\Models\Sesi;
use App\Models\InformasiSidang;
use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;

class FrontendController extends Controller
{
    public function index()
    {
        return view('publik.home');
    }

    public function informasi()
    {
        $sesis = Sesi::all();
        return view('publik.informasi', compact('sesis'));
    }

    public function kontak()
    {
        return view('publik.kontak');
    }

    public function downloadSidang()
    {
        $informasi = InformasiSidang::latest()->first();
        if (!$informasi || !Storage::exists($informasi->file_path)) {
            return back()->with('error', 'Informasi Sidang saat ini belum tersedia.');
        }

        return Storage::download($informasi->file_path, $informasi->original_name);
    }
}
