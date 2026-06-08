@extends('layouts.public')

@section('content')
<div class="container py-5 mt-4">
    <div class="row justify-content-center">
        <div class="col-lg-5" data-aos="fade-up">
            
            <div class="text-center mb-5">
                <i class="fa-solid fa-magnifying-glass-chart fa-3x text-primary mb-3"></i>
                <h2 class="fw-bold">Cek Status Antrian</h2>
                <p class="text-muted">Masukkan NIK Anda untuk melihat nomor antrian terbaru.</p>
            </div>

            @if(session('error'))
            <div class="alert alert-danger shadow-sm border-0 mb-4 rounded-4" data-aos="fade-in">
                <div class="d-flex align-items-center">
                    <i class="fa-solid fa-circle-xmark fa-xl me-3 text-danger"></i>
                    <div>{{ session('error') }}</div>
                </div>
            </div>
            @endif

            <div class="glass-card p-4 p-md-5">
                <form action="{{ route('antrian.cari') }}" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label class="form-label fw-bold text-secondary small">NOMOR INDUK KEPENDUDUKAN (NIK)</label>
                        <div class="input-group input-group-lg">
                            <span class="input-group-text bg-light border-end-0 text-muted"><i class="fa-solid fa-id-card"></i></span>
                            <input type="text" name="nik" class="form-control bg-light border-start-0 @error('nik') is-invalid @enderror" placeholder="16 Digit NIK" required maxlength="16" value="{{ old('nik') }}" autofocus>
                        </div>
                        @error('nik')<small class="text-danger mt-1 d-block">{{ $message }}</small>@enderror
                    </div>

                    <div class="d-grid mb-3">
                        <button type="submit" class="btn btn-primary btn-lg fw-bold shadow-sm py-3">
                            <i class="fa-solid fa-search me-2"></i> CARI TIKET ANTRIAN
                        </button>
                    </div>

                    <div class="text-center">
                        <a href="{{ route('home') }}" class="text-decoration-none text-muted small fw-bold">
                            <i class="fa-solid fa-arrow-left me-1"></i> Kembali ke Beranda
                        </a>
                    </div>
                </form>
            </div>

            <div class="mt-5 p-4 bg-primary bg-opacity-10 rounded-4 border border-primary-subtle shadow-sm" data-aos="fade-up" data-aos-delay="200">
                <h6 class="fw-bold mb-2 text-primary"><i class="fa-solid fa-lightbulb me-2"></i> Tips Cepat</h6>
                <p class="text-sm text-muted mb-0">Pastikan NIK yang Anda masukkan sama dengan NIK yang didaftarkan saat mengambil antrian. Jika sudah ditemukan, Anda dapat mengunduh kembali karcis dalam format PDF.</p>
            </div>

        </div>
    </div>
</div>
@endsection
