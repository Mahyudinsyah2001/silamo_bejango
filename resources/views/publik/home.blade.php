@extends('layouts.public')

@section('content')
    <div class="hero-section">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-lg-7" data-aos="fade-right">
                    <span
                        class="badge bg-warning text-dark mb-3 px-3 py-2 fw-bold text-uppercase tracking-wider rounded-pill">Layanan
                        Terpadu</span>
                    <h1 class="hero-title" style="letter-spacing: -2px;">Sistem Layanan Monitoring  Kunjungan Online
                    </h1>
                    <p class="hero-subtitle">Daftar kunjungan dari rumah, hindari antrian panjang. Lebih Cepat, Lebih
                        Praktis, dan Bebas Pungli.</p>
                    <div class="d-flex flex-wrap gap-3">
                        <a href="{{ route('antrian.create') }}" class="btn btn-primary btn-lg px-4 shadow-lg"><i
                                class="fa-solid fa-ticket me-2"></i> Ambil Antrian</a>
                        <a href="{{ route('antrian.cek') }}" class="btn btn-outline-warning btn-lg px-4 shadow-sm"><i
                                class="fa-solid fa-magnifying-glass me-2"></i> Cek Status</a>
                        <a href="{{ route('informasi') }}" class="btn btn-outline-light btn-lg px-4 shadow-sm"><i
                                class="fa-solid fa-circle-info me-2"></i> Informasi Jadwal</a>
                        <a href="{{ route('informasi_sidang.download') }}" class="btn btn-info btn-lg px-4 shadow-sm text-white"><i
                                class="fa-solid fa-gavel me-2"></i> Informasi Sidang</a>
                    </div>
                </div>
                <div class="col-lg-5 d-none d-lg-block text-center" data-aos="fade-left" data-aos-delay="200">
                    <img src="{{ asset('img/logo_silamo_bejango.png') }}" alt="Logo SILAMO BEJANGO" class="img-fluid drop-shadow"
                        style="filter: drop-shadow(0 50px 50px rgba(0,0,0,0.15)); max-width: 150%;">
                </div>
            </div>
        </div>
    </div>

    <div class="container py-5 mt-5">
        <div class="text-center mb-5" data-aos="fade-up">
            <h2 class="fw-bold text-primary">Cara Mengambil Antrian</h2>
            <p class="text-muted">Ikuti langkah mudah berikut untuk mengunjungi keluarga/kerabat binaan.</p>
        </div>
        <div class="row g-4">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-card p-5 text-center h-100">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex align-items-center justify-content-center mb-4 transition-transform hover-scale"
                        style="width: 80px; height: 80px;">
                        <i class="fa-solid fa-file-pen fa-2xl"></i>
                    </div>
                    <h4 class="fw-bold text-primary">1. Isi Formulir</h4>
                    <p class="text-muted">Lengkapi data diri, upload foto KTP asli, dan pilih nama warga binaan.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-card p-5 text-center h-100 border-primary" style="border-width: 2px;">
                    <div class="bg-warning bg-opacity-25 text-warning rounded-circle d-inline-flex align-items-center justify-content-center mb-4 transition-transform"
                        style="width: 80px; height: 80px;">
                        <i class="fa-solid fa-qrcode fa-2xl"></i>
                    </div>
                    <h4 class="fw-bold text-primary">2. Dapat QR Code</h4>
                    <p class="text-muted">Sistem akan segera men-generate kode tiket dan QR Code secara spesifik.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="glass-card p-5 text-center h-100">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex align-items-center justify-content-center mb-4 transition-transform"
                        style="width: 80px; height: 80px;">
                        <i class="fa-solid fa-building-circle-check fa-2xl"></i>
                    </div>
                    <h4 class="fw-bold text-primary">3. Datang & Scan</h4>
                    <p class="text-muted">Tunjukkan QR code ke petugas verifikasi pada waktu sesi yang telah dipilih.</p>
                </div>
            </div>
        </div>
    </div>
@endsection