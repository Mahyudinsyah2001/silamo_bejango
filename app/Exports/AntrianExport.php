<?php
namespace App\Exports;

use App\Models\Antrian;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class AntrianExport implements FromCollection, WithHeadings, WithMapping
{
    protected $dari_tanggal;
    protected $sampai_tanggal;

    public function __construct($dari_tanggal, $sampai_tanggal)
    {
        $this->dari_tanggal = $dari_tanggal;
        $this->sampai_tanggal = $sampai_tanggal;
    }

    public function collection()
    {
        return Antrian::with(['sesi', 'kunjungan.wargaBinaan'])
            ->whereDate('tanggal_kunjungan', '>=', $this->dari_tanggal)
            ->whereDate('tanggal_kunjungan', '<=', $this->sampai_tanggal)
            ->get();
    }

    public function headings(): array
    {
        return [
            'ID',
            'Kode Antrian',
            'Nama Pengunjung',
            'L/P',
            'NIK',
            'No HP',
            'Tanggal Kunjungan',
            'Sesi',
            'Status',
            'Warga Binaan Dituju',
            'Catatan Verifikasi'
        ];
    }
    
    public function map($antrian): array
    {
        return [
            $antrian->id,
            $antrian->kode_antrian,
            $antrian->nama,
            $antrian->jenis_kelamin,
            $antrian->nik,
            $antrian->no_tlp,
            $antrian->tanggal_kunjungan,
            $antrian->sesi ? $antrian->sesi->nama_sesi : '',
            strtoupper($antrian->status),
            $antrian->kunjungan && $antrian->kunjungan->wargaBinaan ? $antrian->kunjungan->wargaBinaan->nama : '-',
            $antrian->kunjungan ? $antrian->kunjungan->catatan : '-',
        ];
    }
}
