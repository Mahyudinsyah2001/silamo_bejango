<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\AntrianExport;

class LaporanController extends Controller
{
    public function index(Request $request)
    {
        return view('admin.laporan.index');
    }

    public function exportPdf(Request $request)
    {
        $request->validate([
            'dari_tanggal' => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal'
        ]);

        $antrians = Antrian::with(['sesi', 'kunjungan.wargaBinaan'])
                    ->whereDate('tanggal_kunjungan', '>=', $request->dari_tanggal)
                    ->whereDate('tanggal_kunjungan', '<=', $request->sampai_tanggal)
                    ->get();

        $pdf = Pdf::loadView('admin.laporan.pdf', compact('antrians', 'request'));
        // Load view setup for landscape size 
        $pdf->setPaper('a4', 'landscape');
        
        return $pdf->download('laporan-antrian.pdf');
    }

    public function exportExcel(Request $request)
    {
        $request->validate([
            'dari_tanggal' => 'required|date',
            'sampai_tanggal' => 'required|date|after_or_equal:dari_tanggal'
        ]);
        
        return Excel::download(new AntrianExport($request->dari_tanggal, $request->sampai_tanggal), 'laporan-antrian.xlsx');
    }
}
