<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\Sesi;
use App\Models\WargaBinaan;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Str;

class AntrianPublikController extends Controller
{
    public function create()
    {
        $sesis = Sesi::all();
        $allWB = WargaBinaan::orderBy('nama')->get();

        // Pisah berdasarkan prefix No. Registrasi
        // Warga Binaan (Narapidana) = awalan 'BI'
        // Tahanan = selain 'BI' (misal: A, AIII, dst.)
        $narapidanas = $allWB->filter(fn($wb) => str_starts_with(strtoupper($wb->no_registrasi), 'BI'));
        $tahaans     = $allWB->filter(fn($wb) => !str_starts_with(strtoupper($wb->no_registrasi), 'BI'));

        // Cek jam operasional: 08:00 - 15:00 WITA
        $jamSekarang = \Carbon\Carbon::now();
        $jamBuka     = \Carbon\Carbon::today()->setTime(8, 0, 0);
        $jamTutup    = \Carbon\Carbon::today()->setTime(15, 0, 0);
        $isJamOperasional = $jamSekarang->between($jamBuka, $jamTutup);

        // Jika di luar jam operasional, tanggal minimum = besok
        if ($isJamOperasional) {
            $minDate = \Carbon\Carbon::today()->format('Y-m-d');
        } else {
            $minDate = \Carbon\Carbon::tomorrow()->format('Y-m-d');
        }

        return view('publik.antrian.create', compact('sesis', 'narapidanas', 'tahaans', 'minDate', 'isJamOperasional'));
    }

    public function store(Request $request)
    {
        // Cek jam operasional: 08:00 - 15:00 WITA
        $jamSekarang = \Carbon\Carbon::now();
        $jamBuka     = \Carbon\Carbon::today()->setTime(8, 0, 0);
        $jamTutup    = \Carbon\Carbon::today()->setTime(15, 0, 0);
        $isJamOperasional = $jamSekarang->between($jamBuka, $jamTutup);

        // Jika di luar jam operasional dan user memilih tanggal hari ini → tolak
        if (!$isJamOperasional && $request->tanggal_kunjungan === \Carbon\Carbon::today()->format('Y-m-d')) {
            return back()
                ->with('error', 'Jam operasional pendaftaran antrian sudah selesai (08.00 – 15.00 WITA). Silakan ambil nomor antrian untuk hari berikutnya.')
                ->withInput();
        }

        // Tentukan aturan validasi tanggal secara dinamis
        $tanggalRule = $isJamOperasional ? 'after_or_equal:today' : 'after:today';

        $request->validate([
            'nama' => 'required|string|max:255',
            'jenis_kelamin' => 'required|in:L,P',
            'nik' => 'required|digits:16',
            'foto_identitas' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'alamat' => 'required|string',
            'no_tlp' => 'required|string|max:20',
            'hubungan' => 'required|string',
            'tanggal_kunjungan' => 'required|date|' . $tanggalRule,
            'sesi_id' => 'required|exists:sesis,id',
            'warga_binaan_id' => 'required_without:nama_warga_binaan_manual|nullable|exists:warga_binaans,id',
            'nama_warga_binaan_manual' => 'required_without:warga_binaan_id|nullable|string|max:255',
        ]);

        $sesi = Sesi::findOrFail($request->sesi_id);

        $today = $request->tanggal_kunjungan;

        // Cek batasan kunjungan 1x seminggu untuk warga binaan yang sama
        $startOfWeek = \Carbon\Carbon::parse($today)->startOfWeek()->format('Y-m-d');
        $endOfWeek = \Carbon\Carbon::parse($today)->endOfWeek()->format('Y-m-d');

        $hasVisit = false;
        if ($request->filled('warga_binaan_id')) {
            $hasVisit = \App\Models\Kunjungan::where('warga_binaan_id', $request->warga_binaan_id)
                ->whereHas('antrian', function ($query) use ($startOfWeek, $endOfWeek) {
                    $query->whereBetween('tanggal_kunjungan', [$startOfWeek, $endOfWeek])
                          ->whereNotIn('status', ['batal', 'ditolak']);
                })->exists();
        } elseif ($request->filled('nama_warga_binaan_manual')) {
            $hasVisit = \App\Models\Kunjungan::where('nama_warga_binaan_manual', $request->nama_warga_binaan_manual)
                ->whereHas('antrian', function ($query) use ($startOfWeek, $endOfWeek) {
                    $query->whereBetween('tanggal_kunjungan', [$startOfWeek, $endOfWeek])
                          ->whereNotIn('status', ['batal', 'ditolak']);
                })->exists();
        }

        if ($hasVisit) {
            return back()->with('error', 'Mohon maaf, Warga Binaan tersebut sudah memiliki jadwal kunjungan pada minggu ini. Batas kunjungan hanya 1 kali seminggu.')->withInput();
        }

        $countDay = Antrian::whereDate('tanggal_kunjungan', $today)
                           ->where('sesi_id', $sesi->id)
                           ->whereNotIn('status', ['ditolak', 'batal'])
                           ->count();

        if ($countDay >= $sesi->kuota) {
            return back()->with('error', 'Mohon maaf, kuota untuk sesi tersebut sudah penuh. Silakan pilih hari atau sesi kunjungan lainnya.')->withInput();
        }

        // Hitung nomor urut KHUSUS untuk sesi ini pada tanggal ini (mulai dari 1)
        $lastAntrian = Antrian::whereDate('tanggal_kunjungan', $request->tanggal_kunjungan)
                             ->where('sesi_id', $request->sesi_id)
                             ->orderBy('nomor_antrian', 'desc')
                             ->first();

        $nextNumber   = $lastAntrian ? ($lastAntrian->nomor_antrian + 1) : 1;
        $nomorDisplay = str_pad($nextNumber, 3, '0', STR_PAD_LEFT);

        // kode_antrian dibuat unik: YYYYMMDD-{sesi_id}-{nomor} agar tidak tabrakan antar sesi
        $tanggalStr  = \Carbon\Carbon::parse($request->tanggal_kunjungan)->format('Ymd');
        $kodeAntrian = $tanggalStr . '-' . $request->sesi_id . '-' . $nomorDisplay;

        $path = $request->file('foto_identitas')->store('public/identitas');

        $antrian = Antrian::create([
            'kode_antrian'    => $kodeAntrian,
            'nomor_antrian'   => $nextNumber,
            'nama'            => $request->nama,
            'jenis_kelamin'   => $request->jenis_kelamin,
            'nik'             => $request->nik,
            'foto_identitas'  => $path,
            'alamat'          => $request->alamat,
            'no_tlp'          => $request->no_tlp,
            'hubungan'        => $request->hubungan,
            'tanggal_kunjungan' => $request->tanggal_kunjungan,
            'sesi_id'         => $request->sesi_id,
            'status'          => 'menunggu',
        ]);

        $antrian->kunjungan()->create([
            'warga_binaan_id'          => $request->warga_binaan_id,
            'nama_warga_binaan_manual' => $request->nama_warga_binaan_manual,
            'status_verifikasi'        => 'pending',
        ]);

        return redirect()->route('antrian.sukses', $antrian->kode_antrian)
                         ->with('success', 'Nomor Antrian berhasil diambil!');
    }

    public function show(Antrian $antrian)
    {
        return view('publik.antrian.show', compact('antrian'));
    }

    public function cekStatus()
    {
        return view('publik.antrian.cek');
    }

    public function cariAntrian(Request $request)
    {
        $request->validate(['nik' => 'required|digits:16']);

        $antrian = Antrian::where('nik', $request->nik)
                          ->latest()
                          ->first();

        if (!$antrian) {
            return back()->with('error', 'NIK tidak ditemukan atau Anda belum pernah mengambil antrian.')->withInput();
        }

        return redirect()->route('antrian.sukses', $antrian->kode_antrian);
    }

    public function cetak(Antrian $antrian)
    {
        $pdf = Pdf::loadView('publik.antrian.cetak', compact('antrian'));
        return $pdf->download('Karcis-Antrian-Lapas-'.$antrian->kode_antrian.'.pdf');
    }
}
