<!DOCTYPE html>
<html>

<head>
    <title>Laporan Antrian</title>
    <style>
        body {
            font-family: sans-serif;
            font-size: 12px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #000;
            padding: 5px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .text-center {
            text-align: center;
        }

        .title {
            font-size: 16px;
            font-weight: bold;
            margin-bottom: 5px;
        }
    </style>
</head>

<body>
    <div style="position: relative;">
        @php
            $logoPath = public_path('img/2-logo1 (2).png');
            $logoData = '';
            if (file_exists($logoPath)) {
                $logoData = base64_encode(file_get_contents($logoPath));
            }
        @endphp
        @if ($logoData)
            <img src="data:image/png;base64,{{ $logoData }}" style="height: 80px; position: absolute; left: 0; top: 0;">
        @endif
        <div class="text-center">
            <div class="title">LAPORAN ANTRIAN KUNJUNGAN LAPAS SUMBAWA</div>
            <div style="font-size: 14px; color: #555;">KEMENTERIAN HUKUM DAN HAK ASASI MANUSIA REPUBLIK INDONESIA</div>
            <div style="font-size: 14px; color: #555; margin-bottom: 10px;">KANTOR WILAYAH NUSA TENGGARA BARAT</div>
            <div style="border-bottom: 2px solid #000; margin-bottom: 15px; padding-bottom: 5px;">
                Periode: {{ \Carbon\Carbon::parse($request->dari_tanggal)->format('d M Y') }} s/d
                {{ \Carbon\Carbon::parse($request->sampai_tanggal)->format('d M Y') }}
            </div>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th>No</th>
                <th>Nama Pengunjung</th>
                <th>L/P</th>
                <th>NIK</th>
                <th>Tgl Kunjungan</th>
                <th>Sesi</th>
                <th>Nama WBP/Tahanan</th>
                <th>Status WBP/Tahanan</th>
            </tr>
        </thead>
        <tbody>
            @forelse($antrians as $index => $antrian)
                @php
                    $wbp = $antrian->kunjungan && $antrian->kunjungan->wargaBinaan
                        ? $antrian->kunjungan->wargaBinaan
                        : null;
                    $namaWbp = $wbp ? $wbp->nama
                        : ($antrian->kunjungan && $antrian->kunjungan->nama_warga_binaan_manual
                            ? $antrian->kunjungan->nama_warga_binaan_manual
                            : '-');
                    $statusWbp = $wbp
                        ? (str_starts_with(strtoupper($wbp->no_registrasi), 'BI') ? 'Narapidana' : 'Tahanan')
                        : '-';
                @endphp
                <tr>
                    <td class="text-center">{{ $index + 1 }}</td>
                    <td>{{ $antrian->nama }}<br>HP: {{ $antrian->no_tlp }}</td>
                    <td class="text-center">{{ $antrian->jenis_kelamin }}</td>
                    <td>{{ $antrian->nik }}</td>
                    <td>{{ \Carbon\Carbon::parse($antrian->tanggal_kunjungan)->format('d-m-Y') }}</td>
                    <td>{{ $antrian->sesi ? $antrian->sesi->nama_sesi : '-' }}</td>
                    <td>{{ $namaWbp }}</td>
                    <td>{{ $statusWbp }}</td>
                </tr>
            @empty
                <tr>
                    <td colspan="8" class="text-center">Tidak ada data kunjungan pada periode ini.</td>
                </tr>
            @endforelse
        </tbody>
    </table>
</body>

</html>
