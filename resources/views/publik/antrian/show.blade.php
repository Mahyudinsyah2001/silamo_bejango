@extends('layouts.public')

@section('content')
    <div class="container py-5 mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-5">

                @if (session('success'))
                    <div class="alert alert-success shadow-sm border-0 mb-4 text-center" data-aos="fade-in">
                        <i class="fa-solid fa-circle-check fa-2xl mb-2 d-block icon-bounce" style="color: #10b981;"></i>
                        <strong>Pendaftaran Berhasil!</strong><br>
                        {{ session('success') }}
                    </div>
                @endif

                <div id="ticket-card" class="glass-card text-center overflow-hidden ticket-hover" data-aos="zoom-in"
                    style="border-top: 5px solid var(--secondary);">
                    <!-- Header Karcis -->
                    <div class="bg-primary text-white p-4 d-flex align-items-center justify-content-center">
                        <img src="{{ asset('img/2-logo.png') }}" alt="Logo" class="me-3"
                            style="height: 55px; width: auto; border-radius: 8px;">
                        <div class="text-start">
                            <h4 class="fw-bold mb-0">E-Karcis Kunjungan</h4>
                            <p class="mb-0 opacity-75 text-sm">Lapas Kelas IIA Sumbawa Besar</p>
                        </div>
                    </div>

                    <!-- Tanggal & Sesi -->
                    <div class="bg-light p-3 border-bottom d-flex justify-content-between align-items-center">
                        <div class="text-start">
                            <span class="d-block text-muted text-sm fw-bold">Tanggal</span>
                            <span
                                class="fw-bold text-dark">{{ \Carbon\Carbon::parse($antrian->tanggal_kunjungan)->format('d F Y') }}</span>
                        </div>
                        <div class="text-end">
                            <span class="d-block text-muted text-sm fw-bold">Sesi Terpilih</span>
                            <span class="fw-bold text-dark">{{ $antrian->sesi->nama_sesi }}
                                ({{ \Carbon\Carbon::parse($antrian->sesi->jam_mulai)->format('H:i') }})</span>
                        </div>
                    </div>

                    <!-- Nomor Antrian -->
                    <div class="p-5 pb-4 bg-white">
                        <p class="text-muted fw-bold mb-2">NOMOR ANTRIAN ANDA</p>
                        <h1 class="display-3 fw-bold text-primary tracking-wider mb-4">
                            {{ str_pad($antrian->nomor_antrian, 3, '0', STR_PAD_LEFT) }}
                        </h1>

                        <div class="d-inline-block p-3 bg-white border rounded-4 shadow-sm mb-4 qr-pulse">
                            {!! QrCode::size(200)->generate($antrian->kode_antrian) !!}
                        </div>

                        <p class="text-sm text-muted px-4">Tunjukkan QR Code ini kepada petugas pendaftaran saat Anda tiba
                            di Lapas. Harap simpan halaman ini atau unduh karcis.</p>
                    </div>

                    <!-- Pengunjung Info -->
                    <div class="bg-light p-4 text-start border-top">
                        <div class="row">
                            <div class="col-6 mb-3">
                                <span class="d-block text-muted text-sm">Nama Pengunjung</span>
                                <span class="fw-bold text-dark">{{ $antrian->nama }}</span>
                            </div>
                            <div class="col-6 mb-3">
                                @php
                                    $kunjungan = $antrian->kunjungan;
                                    $wbModel   = $kunjungan?->wargaBinaan;
                                    if ($wbModel) {
                                        $isNarapidana = str_starts_with(strtoupper($wbModel->no_registrasi), 'BI');
                                        $labelBertemu = $isNarapidana ? 'Bertemu Warga Binaan' : 'Bertemu Tahanan';
                                        $namaBertemu  = $wbModel->nama;
                                    } else {
                                        $labelBertemu = 'Bertemu WB / Tahanan';
                                        $namaBertemu  = $kunjungan?->nama_warga_binaan_manual ?? '-';
                                    }
                                @endphp
                                <span class="d-block text-muted text-sm">{{ $labelBertemu }}</span>
                                <span class="fw-bold text-dark">{{ $namaBertemu }}</span>
                            </div>
                        </div>

                    </div>

                    <!-- Alert Peringatan Keterlambatan (Inside Ticket) -->
                    <div class="text-start p-3 text-dark" style="border-top: 2px dashed #f59e0b; background-color: #fffbeb;">
                        <strong style="font-size: 0.9rem;"><i class="fa-solid fa-triangle-exclamation me-1 text-warning"></i> PERHATIAN PENTING:</strong>
                        <ul class="mb-0 ps-3 mt-1" style="font-size: 0.85rem;">
                            <li>Datang <strong>tepat waktu</strong> (minimal 30 menit sebelum sesi).</li>
                            <li>Wajib membawa/menunjukkan <strong>E-Karcis ini</strong> & KTP asli.</li>
                            <li class="text-danger">Keterlambatan dapat <strong>membatalkan</strong> antrian Anda.</li>
                        </ul>
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="mt-4 pt-2">
                    <div class="d-grid gap-2">
                        <div class="btn-group w-100 shadow-sm flex-wrap flex-md-nowrap">
                            <a href="{{ route('antrian.cetak', $antrian->kode_antrian) }}"
                                class="btn btn-primary py-2 fw-bold btn-hover-scale">
                                <i class="fa-solid fa-file-pdf me-1"></i> PDF
                            </a>
                            <button id="download-jpg" class="btn btn-warning py-2 fw-bold text-dark btn-hover-scale">
                                <i class="fa-solid fa-image me-1"></i> JPG
                            </button>
                            <button onclick="window.print()" class="btn btn-dark py-2 fw-bold btn-hover-scale">
                                <i class="fa-solid fa-print me-1"></i> Cetak
                            </button>
                        </div>
                        <a href="{{ route('home') }}" class="btn btn-outline-secondary mt-2 py-2 fw-bold btn-hover-scale">
                            <i class="fa-solid fa-house me-1"></i> Kembali ke Beranda
                        </a>
                    </div>
                </div>

            </div>
        </div>
    </div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/html2canvas@1.4.1/dist/html2canvas.min.js"></script>
        <script>
            document.getElementById('download-jpg').addEventListener('click', function () {
                const btn = this;
                const originalContent = btn.innerHTML;
                btn.innerHTML = '<i class="fa-solid fa-spinner fa-spin me-2"></i> Memproses...';
                btn.disabled = true;

                const ticketCard = document.getElementById('ticket-card');

                // Use html2canvas to capture the div
                html2canvas(ticketCard, {
                    scale: 2, // Higher resolution
                    useCORS: true,
                    backgroundColor: "#ffffff",
                    logging: false
                }).then(canvas => {
                    const link = document.createElement('a');
                    link.download =
                        'Karcis-Antrian-{{ str_pad($antrian->nomor_antrian, 3, '0', STR_PAD_LEFT) }}.jpg';
                    link.href = canvas.toDataURL('image/jpeg', 0.9);
                    link.click();

                    btn.innerHTML = originalContent;
                    btn.disabled = false;

                    Swal.fire({
                        icon: 'success',
                        title: 'Berhasil!',
                        text: 'Karcis berhasil disimpan sebagai gambar.',
                        toast: true,
                        position: 'top-end',
                        showConfirmButton: false,
                        timer: 3000
                    });
                }).catch(err => {
                    console.error(err);
                    btn.innerHTML = originalContent;
                    btn.disabled = false;
                    alert('Gagal mengambil gambar. Silakan coba lagi.');
                });
            });
        </script>

        <style>
            /* Animasi Kustom untuk Interaksi UI */
            .icon-bounce {
                animation: bounceIn 0.8s cubic-bezier(0.28, 0.84, 0.42, 1) 0.3s both;
            }
            @keyframes bounceIn {
                0% { transform: scale(0); opacity: 0; }
                50% { transform: scale(1.2); opacity: 1; }
                100% { transform: scale(1); opacity: 1; }
            }

            .qr-pulse {
                animation: softPulse 2.5s infinite;
                border: 2px solid transparent;
            }
            @keyframes softPulse {
                0% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0.4); border-color: rgba(13, 110, 253, 0.1); }
                70% { box-shadow: 0 0 0 15px rgba(13, 110, 253, 0); border-color: rgba(13, 110, 253, 0.5); }
                100% { box-shadow: 0 0 0 0 rgba(13, 110, 253, 0); border-color: rgba(13, 110, 253, 0.1); }
            }

            .ticket-hover {
                transition: transform 0.3s ease, box-shadow 0.3s ease;
            }
            .ticket-hover:hover {
                transform: translateY(-8px);
                box-shadow: 0 20px 40px rgba(0,0,0,0.12) !important;
            }

            .btn-hover-scale {
                transition: all 0.2s ease-in-out !important;
            }
            .btn-hover-scale:hover {
                transform: scale(1.05) translateY(-2px);
                z-index: 10;
                box-shadow: 0 8px 15px rgba(0,0,0,0.15);
            }
            .btn-hover-scale:active {
                transform: scale(0.95);
            }
        </style>

        <style>
            @media print {
                @page {
                    size: portrait;
                    margin: 10px;
                }

                body {
                    -webkit-print-color-adjust: exact !important;
                    print-color-adjust: exact !important;
                    background: #fff;
                }

                body * {
                    visibility: hidden;
                }

                #ticket-card {
                    visibility: visible;
                    position: absolute;
                    left: 50%;
                    top: 20px;
                    transform: translateX(-50%);
                    width: 100%;
                    max-width: 450px !important;
                    box-shadow: none !important;
                    border: 2px dashed #ccc !important;
                    border-top: 8px solid #0d6efd !important;
                    border-radius: 8px !important;
                    page-break-inside: avoid;
                    background-color: #fff !important;
                }

                #ticket-card * {
                    visibility: visible;
                }

                .alert,
                .btn-group,
                .btn,
                .navbar,
                .footer,
                #download-jpg {
                    display: none !important;
                }

                .bg-primary {
                    background-color: #0d6efd !important;
                    color: #fff !important;
                }

                .bg-light {
                    background-color: #f8f9fa !important;
                }

                .text-primary {
                    color: #0d6efd !important;
                }

                .border-bottom {
                    border-bottom: 2px dashed #ddd !important;
                }

                .border-top {
                    border-top: 2px dashed #ddd !important;
                }
            }
        </style>
    @endpush
@endsection