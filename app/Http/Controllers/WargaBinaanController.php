<?php

namespace App\Http\Controllers;

use App\Models\WargaBinaan;
use Illuminate\Http\Request;

class WargaBinaanController extends Controller
{
    public function index(Request $request)
    {
        $query = WargaBinaan::query();
        if ($request->has('search')) {
            $query->where('nama', 'like', '%' . $request->search . '%')
                  ->orWhere('no_registrasi', 'like', '%' . $request->search . '%');
        }
        $wargaBinaans = $query->paginate(10);
        return view('admin.warga_binaan.index', compact('wargaBinaans'));
    }

    public function create()
    {
        return view('admin.warga_binaan.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_registrasi' => 'nullable|string|unique:warga_binaans,no_registrasi|max:255',
            'blok' => 'nullable|string|max:255',
            'keterangan' => 'nullable|string',
            'tgl_msk_upt' => 'nullable|date',
            'tgl_ekspirasi' => 'nullable|date',
            'nm_alias_1' => 'nullable|string|max:255',
            'nm_alias_2' => 'nullable|string|max:255',
            'nm_alias_3' => 'nullable|string|max:255',
            'nm_kecil_1' => 'nullable|string|max:255',
            'nm_kecil_2' => 'nullable|string|max:255',
            'nm_kecil_3' => 'nullable|string|max:255',
            'lokasi_sel' => 'nullable|string|max:255',
        ]);

        $data = $request->all();
        
        // Auto-generate No Registrasi jika kosong
        if (!$request->no_registrasi) {
            $data['no_registrasi'] = 'WBP-' . time() . '-' . rand(10, 99);
        }
        
        // Default blok jika kosong
        if (!$request->blok) {
            $data['blok'] = 'BELUM SET';
        }

        WargaBinaan::create($data);
        return redirect()->route('admin.warga-binaan.index')->with('success', 'Warga Binaan berhasil ditambahkan.');
    }

    public function edit(WargaBinaan $wargaBinaan)
    {
        return view('admin.warga_binaan.edit', compact('wargaBinaan'));
    }

    public function update(Request $request, WargaBinaan $wargaBinaan)
    {
        $request->validate([
            'nama' => 'required|string|max:255',
            'no_registrasi' => 'required|string|max:255|unique:warga_binaans,no_registrasi,' . $wargaBinaan->id,
            'blok' => 'required|string|max:255',
            'keterangan' => 'nullable|string',
            'tgl_msk_upt' => 'nullable|date',
            'tgl_ekspirasi' => 'nullable|date',
            'nm_alias_1' => 'nullable|string|max:255',
            'nm_alias_2' => 'nullable|string|max:255',
            'nm_alias_3' => 'nullable|string|max:255',
            'nm_kecil_1' => 'nullable|string|max:255',
            'nm_kecil_2' => 'nullable|string|max:255',
            'nm_kecil_3' => 'nullable|string|max:255',
            'lokasi_sel' => 'nullable|string|max:255',
        ]);

        $wargaBinaan->update($request->all());
        return redirect()->route('admin.warga-binaan.index')->with('success', 'Warga Binaan berhasil diupdate.');
    }

    public function destroy(WargaBinaan $wargaBinaan)
    {
        $wargaBinaan->delete();
        return redirect()->route('admin.warga-binaan.index')->with('success', 'Warga Binaan berhasil dihapus.');
    }

    public function destroyAll()
    {
        WargaBinaan::query()->delete();
        return redirect()->route('admin.warga-binaan.index')->with('success', 'Seluruh data Warga Binaan berhasil dikosongkan.');
    }

    public function downloadTemplate()
    {
        $headers = [
            'Content-Type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename="template_warga_binaan.csv"',
        ];

        $callback = function() {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Nama Lengkap', 'No. Registrasi', 'Tgl Msk UPT', 'Tgl Ekspirasi', 'Nm Alias 1', 'Nm Alias 2', 'Nm Alias 3', 'Nm Kecil 1', 'Nm Kecil 2', 'Nm Kecil 3', 'Blok', 'Lokasi Sel']);
            fputcsv($file, ['Contoh Nama', 'REG-12345', '2023-01-01', '2025-01-01', 'Alias1', '', '', 'Kecil1', '', '', 'Blok A', 'Kamar 1']);
            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }

    public function importCSV(Request $request)
    {
        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt,xlsx,xls'
        ]);

        try {
            $file = $request->file('csv_file');
            $extension = strtolower($file->getClientOriginalExtension());
            $readerType = null;
            
            if (in_array($extension, ['csv', 'txt'])) {
                $readerType = \Maatwebsite\Excel\Excel::CSV;
            } elseif ($extension === 'xls') {
                $readerType = \Maatwebsite\Excel\Excel::XLS;
            } elseif ($extension === 'xlsx') {
                $readerType = \Maatwebsite\Excel\Excel::XLSX;
            }

            if ($readerType) {
                \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\WargaBinaanImport, $file, null, $readerType);
            } else {
                \Maatwebsite\Excel\Facades\Excel::import(new \App\Imports\WargaBinaanImport, $file);
            }

            return redirect()->route('admin.warga-binaan.index')->with('success', 'Data Warga Binaan berhasil diimport!');
        } catch (\Exception $e) {
            return redirect()->route('admin.warga-binaan.index')->with('error', 'Gagal import: ' . $e->getMessage());
        }
    }
}
