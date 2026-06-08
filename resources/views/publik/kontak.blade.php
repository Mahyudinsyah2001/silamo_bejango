@extends('layouts.public')

@section('content')
    <div class="container py-5 mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-8 text-center mb-5" data-aos="fade-down">
                <h1 class="fw-bold text-primary">Hubungi Kami</h1>
                <p class="text-muted">Untuk informasi lebih lanjut mengenai layanan kami.</p>
            </div>
        </div>

        <div class="row justify-content-center g-4 mb-5">
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="100">
                <div class="glass-card p-4 text-center h-100">
                    <div class="bg-primary bg-opacity-10 text-primary rounded-circle d-inline-flex justify-content-center align-items-center mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-location-dot fa-xl"></i>
                    </div>
                    <h5 class="fw-bold text-primary">Alamat Lapas</h5>
                    <p class="text-muted text-sm">Jl. Lintas Sumbawa - Bima Km. 5, Sumbawa Besar, Nusa Tenggara Barat.</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="200">
                <div class="glass-card p-4 text-center h-100">
                    <div class="bg-secondary bg-opacity-10 text-secondary rounded-circle d-inline-flex justify-content-center align-items-center mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-phone fa-xl"></i>
                    </div>
                    <h5 class="fw-bold text-primary">Telepon</h5>
                    <p class="text-muted text-sm">0851-3731-5977<br>Layanan Jam Kerja Pkl. 08:00 - 15:00</p>
                </div>
            </div>
            <div class="col-md-4" data-aos="fade-up" data-aos-delay="300">
                <div class="glass-card p-4 text-center h-100">
                    <div class="bg-success bg-opacity-10 text-success rounded-circle d-inline-flex justify-content-center align-items-center mb-3"
                        style="width: 60px; height: 60px;">
                        <i class="fa-solid fa-envelope fa-xl"></i>
                    </div>
                    <h5 class="fw-bold text-primary">Email & Sosial Media</h5>
                    <p class="text-muted text-sm">lapassumbawabesar@kemenkumham.com<br>IG: @lapassumbawabesar</p>
                </div>
            </div>
        </div>

        <div class="row justify-content-center" data-aos="fade-up" data-aos-delay="400">
            <div class="col-lg-10">
                <div class="glass-card p-2 shadow-sm rounded-4 overflow-hidden">
                    <iframe src="https://maps.google.com/maps?q=-8.5337971,117.456909&z=17&output=embed" width="100%"
                        height="450" style="border:0;" allowfullscreen="" loading="lazy"
                        referrerpolicy="no-referrer-when-downgrade"></iframe>
                </div>
            </div>
        </div>
    </div>
@endsection