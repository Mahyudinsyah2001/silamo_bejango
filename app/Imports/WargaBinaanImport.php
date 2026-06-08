<?php

namespace App\Imports;

use App\Models\WargaBinaan;
use Maatwebsite\Excel\Concerns\ToModel;

class WargaBinaanImport implements ToModel, \Maatwebsite\Excel\Concerns\WithStartRow
{
    public function startRow(): int
    {
        return 2;
    }

    public function model(array $row)
    {
        $nama = trim($row[0] ?? '');
        if (empty($nama)) {
            return null;
        }

        $noReg = !empty($row[1]) ? trim($row[1]) : 'WBP-' . time() . '-' . rand(100, 999);
        
        if (WargaBinaan::where('no_registrasi', $noReg)->exists()) {
            return null;
        }

        $parseDate = function($val) {
            if (empty($val)) return null;
            if (is_numeric($val)) {
                try {
                    return \PhpOffice\PhpSpreadsheet\Shared\Date::excelToDateTimeObject($val)->format('Y-m-d');
                } catch (\Exception $e) {
                    return null;
                }
            }
            return date('Y-m-d', strtotime($val));
        };

        return new WargaBinaan([
            'nama' => $nama,
            'no_registrasi' => $noReg,
            'tgl_msk_upt' => $parseDate($row[2] ?? null),
            'tgl_ekspirasi' => $parseDate($row[3] ?? null),
            'nm_alias_1' => $row[4] ?? null,
            'nm_alias_2' => $row[5] ?? null,
            'nm_alias_3' => $row[6] ?? null,
            'nm_kecil_1' => $row[7] ?? null,
            'nm_kecil_2' => $row[8] ?? null,
            'nm_kecil_3' => $row[9] ?? null,
            'blok' => !empty($row[10]) ? $row[10] : 'BELUM SET',
            'lokasi_sel' => $row[11] ?? null,
            'keterangan' => '-'
        ]);
    }
}
