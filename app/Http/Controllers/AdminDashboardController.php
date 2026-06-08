<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\WargaBinaan;
use App\Models\Sesi;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class AdminDashboardController extends Controller
{
    public function index()
    {
        $today = Carbon::today();
        
        // Kotak Atas (Total Hari Ini, disinkronisasikan agar Sisa Kuota Kunjungan mencerminkan data aktual)
        $totalAntrianHariIni = Antrian::whereDate('tanggal_kunjungan', $today)->count();
        $totalDisetujui = Antrian::whereDate('tanggal_kunjungan', $today)->whereIn('status', ['selesai', 'dipanggil'])->count();
        $antrianMenunggu = Antrian::whereDate('tanggal_kunjungan', $today)->where('status', 'menunggu')->count();
                            
        $sesis = Sesi::all()->map(function ($sesi) use ($today) {
            $terpakai = Antrian::whereDate('tanggal_kunjungan', $today)
                               ->where('sesi_id', $sesi->id)
                               ->whereNotIn('status', ['ditolak', 'batal'])
                               ->count();
            $sesi->sisa_kuota = $sesi->kuota - $terpakai;
            $sesi->terpakai = $terpakai;
            return $sesi;
        });

        // Data Grafik (7 hari terakhir berdasarkan tanggal pendaftaran/created_at)
        $grafikTanggal = [];
        $grafikData = [];
        // Kita loop 7 hari dari 6 hari lalu sampai hari ini
        for ($i = 6; $i >= 0; $i--) {
            $date = Carbon::today()->subDays($i);
            $grafikTanggal[] = $date->format('d/m');
            $grafikData[] = Antrian::whereDate('created_at', $date)->count();
        }

        // Data Lingkaran Bawah (Pendaftar Bulan Ini berdasarkan created_at)
        $totalAntrianBulanIni = Antrian::whereMonth('created_at', Carbon::now()->month)
                                       ->whereYear('created_at', Carbon::now()->year)
                                       ->count();
        $totalSelesaiKeseluruhan = Antrian::where('status', 'selesai')->count();
        $totalDitolakKeseluruhan = Antrian::where('status', 'ditolak')->count();

        return view('admin.dashboard', compact(
            'totalAntrianHariIni', 
            'totalDisetujui', 
            'antrianMenunggu', 
            'sesis',
            'grafikTanggal',
            'grafikData',
            'totalAntrianBulanIni',
            'totalSelesaiKeseluruhan',
            'totalDitolakKeseluruhan'
        ));
    }
}
