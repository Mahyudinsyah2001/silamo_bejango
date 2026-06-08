<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Menambah kolom nomor_antrian untuk menyimpan nomor urut per sesi per hari.
     * kode_antrian tetap unik tapi formatnya diubah menjadi YYYYMMDD-{sesi_id}-{nomor}
     */
    public function up(): void
    {
        Schema::table('antrians', function (Blueprint $table) {
            // Nomor urut tampilan per sesi per tanggal (1, 2, 3, ...)
            $table->unsignedInteger('nomor_antrian')->default(0)->after('kode_antrian');
        });

        // Isi nomor_antrian untuk data lama berdasarkan urutan kode_antrian existing
        DB::statement('UPDATE antrians SET nomor_antrian = CAST(kode_antrian AS UNSIGNED)');

        // Ubah kode_antrian lama ke format baru: YYYYMMDD-sesi_id-nomor
        $antrians = DB::table('antrians')->orderBy('id')->get();
        foreach ($antrians as $antrian) {
            $tanggal = date('Ymd', strtotime($antrian->tanggal_kunjungan));
            $nomor   = str_pad($antrian->nomor_antrian, 3, '0', STR_PAD_LEFT);
            $newKode = $tanggal . '-' . $antrian->sesi_id . '-' . $nomor;
            DB::table('antrians')->where('id', $antrian->id)->update(['kode_antrian' => $newKode]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Drop kolom jika ada
        if (Schema::hasColumn('antrians', 'nomor_antrian')) {
            Schema::table('antrians', function (Blueprint $table) {
                $table->dropColumn('nomor_antrian');
            });
        }

        // Kembalikan kode_antrian ke format lama (nomor 3 digit) jika kolom masih ada
        if (Schema::hasColumn('antrians', 'kode_antrian')) {
            $antrians = DB::table('antrians')->orderBy('id')->get();
            foreach ($antrians as $antrian) {
                // Hindari error jika property tidak ada
                $nomor = property_exists($antrian, 'nomor_antrian') ? str_pad($antrian->nomor_antrian, 3, '0', STR_PAD_LEFT) : '000';
                DB::table('antrians')->where('id', $antrian->id)->update(['kode_antrian' => $nomor]);
            }
        }
    }
};
