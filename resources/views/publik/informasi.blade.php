@extends('layouts.public')

@section('content')
    <div class="container py-5 mt-4">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                <div class="text-center mb-5" data-aos="fade-down">
                    <h1 class="fw-bold text-primary">Informasi & Jadwal Kunjungan</h1>
                    <p class="text-muted">Pahami syarat dan ketentuan sebelum melakukan pendaftaran kunjungan.</p>
                </div>

                <div class="row g-4 mb-5">
                    <div class="col-md-6" data-aos="fade-right">
                        <div class="glass-card p-4 h-100">
                            <h4 class="fw-bold text-primary border-bottom pb-2 mb-3">Ketentuan Pakaian</h4>
                            <div class="row g-2">
                                <div class="col-sm-6">
                                    <div class="p-3 border rounded shadow-sm bg-white h-100">
                                        <h6 class="fw-bold text-dark mb-2 border-bottom pb-2"><i
                                                class="fa-solid fa-person-dress text-danger me-2"
                                                style="font-size: 1.2rem;"></i>Wanita</h6>
                                        <ul class="text-muted list-unstyled small mb-0">
                                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Celana
                                                panjang / Rok panjang</li>
                                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Baju rapi
                                                dan sopan</li>
                                            <li class="mb-2"><i class="fa-solid fa-xmark text-danger me-2"></i>Tanpa topi &
                                                kacamata hitam</li>
                                            <li class="mb-0"><i class="fa-solid fa-xmark text-danger me-2"></i>Tidak memakai
                                                jaket</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 border rounded shadow-sm bg-white h-100">
                                        <h6 class="fw-bold text-dark mb-2 border-bottom pb-2"><i
                                                class="fa-solid fa-person text-primary me-2"
                                                style="font-size: 1.2rem;"></i>Pria</h6>
                                        <ul class="text-muted list-unstyled small mb-0">
                                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Celana
                                                panjang (kain/jeans)</li>
                                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Baju polo /
                                                kaos / kemeja</li>
                                            <li class="mb-2"><i class="fa-solid fa-xmark text-danger me-2"></i>Tanpa penutup
                                                kepala & kacamata hitam</li>
                                            <li class="mb-0"><i class="fa-solid fa-xmark text-danger me-2"></i>Tidak memakai
                                                jaket</li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-6" data-aos="fade-left">
                        <div class="glass-card p-4 h-100 bg-primary text-white" style="border:none;">
                            <h4 class="fw-bold border-bottom border-light pb-2 mb-3">Barang Terlarang</h4>
                            <p class="mb-3 text-white-50"><i class="fa-solid fa-triangle-exclamation text-warning me-2"></i>
                                Sanksi tegas diberlakukan apabila membawa:</p>
                            <ul class="list-unstyled mb-4">
                                <li class="mb-2"><i
                                        class="fa-solid fa-ban text-danger bg-white rounded-circle p-1 me-2"></i> Narkotika
                                    & Obat Terlarang</li>
                                <li class="mb-2"><i
                                        class="fa-solid fa-ban text-danger bg-white rounded-circle p-1 me-2"></i> Handphone
                                    / Kamera</li>
                                <li class="mb-2"><i
                                        class="fa-solid fa-ban text-danger bg-white rounded-circle p-1 me-2"></i> Senjata
                                    Tajam / Api</li>
                                <li class="mb-2"><i
                                        class="fa-solid fa-ban text-danger bg-white rounded-circle p-1 me-2"></i> Minuman
                                    Keras</li>
                            </ul>

                            <h5 class="fw-bold border-bottom border-light pb-2 mb-3 mt-2">Makanan, Minuman & Obat</h5>
                            <div class="row g-2 text-dark">
                                <div class="col-sm-6">
                                    <div class="p-3 border rounded shadow-sm bg-white h-100">
                                        <h6 class="fw-bold text-success mb-2 border-bottom pb-2"><i
                                                class="fa-solid fa-check-circle me-1"></i>Bisa Dibawa</h6>
                                        <ul class="text-muted list-unstyled small mb-0">
                                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Obat
                                                berstandar BPOM</li>
                                            <li class="mb-2"><i class="fa-solid fa-check text-success me-2"></i>Makanan
                                                rumahan</li>
                                            <li class="mb-0"><i class="fa-solid fa-check text-success me-2"></i>Buah
                                                terpotong</li>
                                        </ul>
                                    </div>
                                </div>
                                <div class="col-sm-6">
                                    <div class="p-3 border rounded shadow-sm bg-white h-100">
                                        <h6 class="fw-bold text-danger mb-2 border-bottom pb-2"><i
                                                class="fa-solid fa-xmark-circle me-1"></i>Tidak Bisa Dibawa</h6>
                                        <ul class="text-muted list-unstyled small mb-0">
                                            <li class="mb-2"><i class="fa-solid fa-xmark text-danger me-2"></i>Minuman
                                                beralkohol</li>
                                            <li class="mb-2"><i class="fa-solid fa-xmark text-danger me-2"></i>Kemasan
                                                minimarket</li>
                                            <li class="mb-2"><i class="fa-solid fa-xmark text-danger me-2"></i>Kacang kulit
                                                / rebus</li>
                                            <li class="mb-2"><i class="fa-solid fa-xmark text-danger me-2"></i>Bahan mentah
                                            </li>
                                            <li class="mb-0"><i class="fa-solid fa-xmark text-danger me-2"></i>Obat herbal
                                            </li>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-4 mb-5" data-aos="fade-up">
                    <h4 class="fw-bold text-primary text-center mb-4">Jadwal Hari Pelayanan</h4>
                    <div class="row text-center g-3">
                        <div class="col-md-4">
                            <div class="p-3 border rounded shadow-sm bg-white h-100">
                                <i class="fa-solid fa-users text-primary fs-3 mb-3"></i>
                                <h5 class="fw-bold text-dark mb-2">Kunjungan Narapidana</h5>
                                <p class="mb-0 text-muted">Senin, Selasa, Kamis</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded shadow-sm bg-white h-100">
                                <i class="fa-solid fa-user-lock text-primary fs-3 mb-3"></i>
                                <h5 class="fw-bold text-dark mb-2">Kunjungan Tahanan</h5>
                                <p class="mb-0 text-muted">Rabu</p>
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="p-3 border rounded shadow-sm bg-white h-100">
                                <i class="fa-solid fa-box-open text-primary fs-3 mb-3"></i>
                                <h5 class="fw-bold text-dark mb-2">Titipan Barang</h5>
                                <p class="mb-0 text-muted">Senin - Jum'at</p>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="glass-card p-4" data-aos="fade-up">
                    <h4 class="fw-bold text-primary text-center mb-4">Jadwal Sesi Kunjungan</h4>
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover text-center align-middle">
                            <thead class="table-primary text-primary">
                                <tr>
                                    <th>Nama Sesi</th>
                                    <th>Jam Mulai</th>
                                    <th>Jam Selesai</th>
                                    <th>Kuota Harian</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($sesis as $sesi)
                                    <tr>
                                        <td class="fw-bold text-secondary">{{ $sesi->nama_sesi }}</td>
                                        <td>{{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }} WITA</td>
                                        <td>{{ \Carbon\Carbon::parse($sesi->jam_selesai)->format('H:i') }} WITA</td>
                                        <td><span class="badge bg-success px-3 py-2">{{ $sesi->kuota }} Pengunjung</span></td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="4" class="text-muted">Belum ada pengaturan sesi.</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection