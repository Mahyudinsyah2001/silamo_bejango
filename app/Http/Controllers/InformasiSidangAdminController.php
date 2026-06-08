<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\InformasiSidang;
use Illuminate\Support\Facades\Storage;

class InformasiSidangAdminController extends Controller
{
    public function index()
    {
        // Ambil data terbaru (karena kita menyarankan 1 file terbaru saja)
        $informasi = InformasiSidang::latest()->first();
        return view('admin.informasi_sidang.index', compact('informasi'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'file_sidang' => 'required|mimes:pdf,doc,docx,xls,xlsx|max:10240',
        ]);

        // Hapus file yang lama jika ada (agar selalu 1 file saja)
        $oldFile = InformasiSidang::latest()->first();
        if ($oldFile) {
            Storage::delete($oldFile->file_path);
            $oldFile->delete();
        }

        $file = $request->file('file_sidang');
        $originalName = $file->getClientOriginalName();
        $path = $file->store('public/informasi_sidang');

        InformasiSidang::create([
            'file_path' => $path,
            'original_name' => $originalName,
        ]);

        return back()->with('success', 'File Informasi Sidang berhasil diunggah!');
    }

    public function destroy(InformasiSidang $informasi_sidang)
    {
        Storage::delete($informasi_sidang->file_path);
        $informasi_sidang->delete();

        return back()->with('success', 'File Informasi Sidang berhasil dihapus!');
    }
}
