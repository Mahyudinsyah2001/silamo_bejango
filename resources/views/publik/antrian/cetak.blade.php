<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <title>Karcis Antrian - {{ $antrian->kode_antrian }}</title>
    <style>
        body {
            font-family: 'Helvetica', 'Arial', sans-serif;
            color: #333;
            margin: 0;
            padding: 20px;
        }

        .card {
            width: 100%;
            max-width: 400px;
            margin: 0 auto;
            border: 2px dashed #1e3a8a;
            padding: 20px;
            border-radius: 10px;
            text-align: center;
        }

        .header {
            border-bottom: 2px solid #1e3a8a;
            padding-bottom: 10px;
            margin-bottom: 20px;
        }

        .title {
            font-size: 20px;
            font-weight: bold;
            margin: 0;
            color: #1e3a8a;
        }

        .subtitle {
            font-size: 14px;
            margin: 5px 0 0;
            color: #555;
        }

        .antrian-label {
            font-size: 14px;
            margin-bottom: 5px;
            font-weight: bold;
        }

        .nomor {
            font-size: 45px;
            font-weight: bold;
            margin: 0 0 20px;
            color: #1e3a8a;
            letter-spacing: 2px;
        }

        .qr-code {
            margin-bottom: 20px;
            text-align: center;
            display: block;
        }

        .info-table {
            border-collapse: collapse;
            margin-top: 15px;
            width: 100%;
            text-align: left;
        }

        .info-table td {
            padding: 8px 5px;
            border-bottom: 1px dotted #ccc;
            font-size: 13px;
        }

        .info-table td:first-child {
            font-weight: bold;
            width: 120px;
        }

        .footer {
            margin-top: 20px;
            font-size: 12px;
            font-style: italic;
            color: #666;
            border-top: 2px solid #1e3a8a;
            padding-top: 10px;
        }
    </style>
</head>

<body>
    <div class="card">
        <div class="header">
            <div style="margin-bottom: 10px;">
                <img src="data:image/png;base64,{{ base64_encode(file_get_contents(public_path('img/2-logo.png'))) }}"
                    style="height: 60px; width: auto;">
            </div>
            <h1 class="title">KARCIS KUNJUNGAN</h1>
            <p class="subtitle">Lapas Kelas IIA Sumbawa Besar</p>
        </div>

        <div class="antrian-label">NOMOR ANTRIAN</div>
        <div class="nomor">{{ str_pad($antrian->nomor_antrian, 3, '0', STR_PAD_LEFT) }}</div>

        <div class="qr-code">
            <img src="data:image/svg+xml;base64,{{ base64_encode((string) QrCode::size(150)->generate($antrian->kode_antrian)) }}"
                width="150" height="150">
        </div>

        <table class="info-table">
            <tr>
                <td>Tanggal</td>
                <td>: {{ \Carbon\Carbon::parse($antrian->tanggal_kunjungan)->format('d F Y') }}</td>
            </tr>
            <tr>
                <td>Sesi Kunjungan</td>
                <td>: {{ $antrian->sesi->nama_sesi }}
                    ({{ \Carbon\Carbon::parse($antrian->sesi->jam_mulai)->format('H:i') }})</td>
            </tr>
            <tr>
                <td>Nama Pengunjung</td>
                <td>: {{ $antrian->nama }}</td>
            </tr>
            <tr>
                @php
                    $kunjunganCetak = $antrian->kunjungan;
                    $wbModelCetak   = $kunjunganCetak?->wargaBinaan;
                    if ($wbModelCetak) {
                        $isNarapidanaCetak = str_starts_with(strtoupper($wbModelCetak->no_registrasi), 'BI');
                        $labelCetak = $isNarapidanaCetak ? 'Warga Binaan' : 'Tahanan';
                        $namaCetak  = $wbModelCetak->nama;
                    } else {
                        $labelCetak = 'WB / Tahanan';
                        $namaCetak  = $kunjunganCetak?->nama_warga_binaan_manual ?? '-';
                    }
                @endphp
                <td>{{ $labelCetak }}</td>
                <td>: {{ $namaCetak }}</td>
            </tr>
        </table>

        <div class="footer" style="color: #b45309; background-color: #fef3c7; border: 1px dashed #f59e0b; padding: 12px; margin-top: 20px; border-radius: 5px; text-align: left; font-size: 11px;">
            <strong style="font-size: 12px;">PERHATIAN PENTING:</strong><br>
            1. Harap datang <strong>tepat waktu</strong> (minimal 30 menit sebelum sesi dimulai).<br>
            2. Wajib membawa dokumen identitas asli (KTP) dan menunjukkan <strong>Karcis Antrian ini</strong>.<br>
            3. Keterlambatan dapat mengakibatkan antrian Anda <strong>dibatalkan</strong> oleh sistem.
        </div>
    </div>
</body>

</html>