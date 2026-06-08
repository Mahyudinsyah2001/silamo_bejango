<?php

namespace App\Http\Controllers;

use App\Models\Antrian;
use App\Models\WargaBinaan;
use App\Models\Kunjungan;
use Illuminate\Http\Request;

class AntrianAdminController extends Controller
{
    public function index(Request $request)
    {
        $query = Antrian::with('sesi')->orderBy('created_at', 'desc');
        
        if ($request->has('kode_antrian') && $request->kode_antrian != '') {
            $query->where('kode_antrian', 'like', '%' . $request->kode_antrian . '%');
        }
        
        if ($request->has('tanggal') && $request->tanggal != '') {
            $query->whereDate('tanggal_kunjungan', $request->tanggal);
        }
        
        if ($request->has('status') && $request->status != '') {
            $query->where('status', $request->status);
        }

        $antrians = $query->paginate(15);
        return view('admin.antrian.index', compact('antrians'));
    }

    public function show(Antrian $antrian)
    {
        $wargaBinaans = WargaBinaan::all();
        $antrian->load('kunjungan.wargaBinaan', 'sesi');
        return view('admin.antrian.show', compact('antrian', 'wargaBinaans'));
    }

    public function updateStatus(Request $request, Antrian $antrian)
    {
        $request->validate([
            'status' => 'required|in:menunggu,dipanggil,selesai,ditolak'
        ]);

        $antrian->update(['status' => $request->status]);
        
        return back()->with('success', 'Status antrian berhasil diubah.');
    }

    public function verifikasi(Request $request, Antrian $antrian)
    {
        $request->validate([
            'warga_binaan_id' => 'required_without:sync_to_db|nullable|exists:warga_binaans,id',
            'status_verifikasi' => 'required|in:disetujui,ditolak',
            'catatan' => 'nullable|string',
            'sync_to_db' => 'nullable'
        ]);

        $finalWbId = $request->warga_binaan_id;
        $kunjungan = Kunjungan::where('antrian_id', $antrian->id)->first();

        // Logika Sinkronisasi ke Database (Auto-Register)
        if ($request->has('sync_to_db') && $kunjungan && $kunjungan->nama_warga_binaan_manual) {
            $newWb = WargaBinaan::create([
                'nama' => $kunjungan->nama_warga_binaan_manual,
                'no_registrasi' => 'NEW-' . time(),
                'blok' => 'BELUM DITENTUKAN',
                'keterangan' => 'Daftar Otomatis via Verifikasi Antrian'
            ]);
            $finalWbId = $newWb->id;
        }

        $kunjungan->update([
            'warga_binaan_id' => $finalWbId,
            'status_verifikasi' => $request->status_verifikasi,
            'catatan' => $request->catatan,
        ]);

        $statusAntrian = $request->status_verifikasi == 'disetujui' ? 'selesai' : 'ditolak';
        $antrian->update(['status' => $statusAntrian]);

        $msg = 'Verifikasi kunjungan berhasil disimpan.';
        if ($request->has('sync_to_db')) {
            $msg .= ' Data WBP baru telah disinkronkan ke database.';
        }

        return redirect()->route('admin.antrian.index')->with('success', $msg);
    }

    public function display()
    {
        return view('admin.antrian.display');
    }

    public function getLatestDipanggil()
    {
        // Menghapus filter whereDate 'tanggal_kunjungan' hari ini agar data testing 
        // (atau antrian untuk tanggal lain) tetap muncul dan bersuara di Display TV 
        // ketika tombol 'Panggil' diklik.
        $antrian = Antrian::with('sesi')->where('status', 'dipanggil')
                            ->orderBy('updated_at', 'desc')->first();

        if (!$antrian) {
            return response()->json(null);
        }

        return response()->json([
            'id'              => $antrian->id,
            'kode_antrian'    => $antrian->kode_antrian,
            'nomor_display'   => str_pad($antrian->nomor_antrian, 3, '0', STR_PAD_LEFT),
            'nama'            => $antrian->nama,
            'nama_sesi'       => optional($antrian->sesi)->nama_sesi,
        ]);
    }

    public function panggilSelanjutnya()
    {
        $today = \Carbon\Carbon::today();
        
        // Cari antrian pertama hari ini yang berstatus menunggu
        $nextAntrian = Antrian::whereDate('tanggal_kunjungan', $today)
            ->where('status', 'menunggu')
            ->orderBy('sesi_id', 'asc')
            ->orderBy('nomor_antrian', 'asc')
            ->first();

        if (!$nextAntrian) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada antrian berikutnya untuk hari ini.'
            ]);
        }

        // Ubah status menjadi dipanggil
        $nextAntrian->update(['status' => 'dipanggil']);

        return response()->json([
            'success' => true,
            'kode_antrian' => $nextAntrian->kode_antrian,
            'nomor_display' => str_pad($nextAntrian->nomor_antrian, 3, '0', STR_PAD_LEFT),
            'nama' => $nextAntrian->nama,
            'nama_sesi' => optional($nextAntrian->sesi)->nama_sesi
        ]);
    }

    public function getStatuses(Request $request)
    {
        $ids = explode(',', $request->get('ids', ''));
        $statuses = Antrian::whereIn('id', $ids)->pluck('status', 'id');
        return response()->json($statuses);
    }

    public function destroy(Antrian $antrian)
    {
        // Data kunjungan akan ikut terhapus jika diatur cascade di database
        // Jika tidak, kita hapus manual
        if ($antrian->kunjungan) {
            $antrian->kunjungan->delete();
        }
        
        $antrian->delete();
        
        return redirect()->route('admin.antrian.index')->with('success', 'Data antrian berhasil dihapus.');
    }
}
