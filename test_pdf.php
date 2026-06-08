<?php
require __DIR__.'/vendor/autoload.php';
$app = require_once __DIR__.'/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    $sesi = new App\Models\Sesi();
    $sesi->nama_sesi = 'Sesi Pagi';
    $sesi->jam_mulai = '09:00:00';

    $wargaBinaan = new App\Models\WargaBinaan();
    $wargaBinaan->nama = 'Budi Santoso';

    $kunjungan = new App\Models\Kunjungan();
    $kunjungan->setRelation('wargaBinaan', $wargaBinaan);
    
    $antrian = new App\Models\Antrian();
    $antrian->kode_antrian = '20260414-1-001';
    $antrian->nomor_antrian = 1;
    $antrian->tanggal_kunjungan = '2026-04-14';
    $antrian->nama = 'Pengunjung Test';
    $antrian->setRelation('sesi', $sesi);
    $antrian->setRelation('kunjungan', $kunjungan);

    $pdf = Barryvdh\DomPDF\Facade\Pdf::loadView('publik.antrian.cetak', compact('antrian'));
    $pdf->save(__DIR__ . '/test.pdf');
    echo "SUCCESS\n";

} catch (\Throwable $e) {
    echo "ERROR: " . $e->getMessage() . "\n";
    echo $e->getTraceAsString();
}
