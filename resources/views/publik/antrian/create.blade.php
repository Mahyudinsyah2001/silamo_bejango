@extends('layouts.public')

@section('content')
    <style>
        :root {
            --step-active: var(--primary);
            --step-pending: #dee2e6;
        }

        .registration-container {
            max-width: 900px;
            margin: auto;
        }

        /* Step Indicator Styling */
        .step-progress {
            display: flex;
            justify-content: space-between;
            position: relative;
            margin-bottom: 40px;
        }

        .step-progress::before {
            content: '';
            position: absolute;
            top: 18px;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--step-pending);
            z-index: 0;
        }

        .step-progress-bar {
            position: absolute;
            top: 18px;
            left: 0;
            height: 3px;
            background: var(--step-active);
            z-index: 1;
            transition: width 0.4s ease;
            width: 0%;
        }

        .step-dot {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fff;
            border: 3px solid var(--step-pending);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 2;
            position: relative;
            transition: all 0.3s ease;
            color: #94a3b8;
            font-weight: 800;
        }

        .step-dot.active {
            border-color: var(--step-active);
            background: var(--step-active);
            color: #fff;
            box-shadow: 0 0 15px rgba(30, 58, 138, 0.3);
        }

        .step-dot.completed {
            border-color: var(--step-active);
            background: #fff;
            color: var(--step-active);
        }

        .step-label {
            position: absolute;
            top: 45px;
            width: 100px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 0.65rem;
            font-weight: 700;
            color: #64748b;
            text-transform: uppercase;
            white-space: nowrap;
        }

        @media (max-width: 576px) {
            .step-label {
                display: none;
            }
        }

        .step-dot.active+.step-label {
            color: var(--step-active);
        }

        /* Form Step Content */
        .form-step {
            display: none;
        }

        .form-step.active {
            display: block;
            animation: slideIn 0.4s ease forwards;
        }

        @keyframes slideIn {
            from {
                opacity: 0;
                transform: translateY(15px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        /* Interactive Session Cards */
        .session-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(150px, 1fr));
            gap: 10px;
        }

        .session-card {
            border: 2px solid #f1f5f9;
            border-radius: 12px;
            padding: 15px;
            cursor: pointer;
            transition: all 0.3s;
            position: relative;
            overflow: hidden;
        }

        @media (max-width: 576px) {
            .session-card {
                padding: 10px;
            }
        }

        .session-card:hover {
            border-color: var(--primary);
            background: #f8fafc;
        }

        .session-card.selected {
            border-color: var(--primary);
            background: #eff6ff;
            box-shadow: 0 4px 12px rgba(30, 58, 138, 0.1);
        }

        .session-card.selected::after {
            content: '\f058';
            font-family: 'Font Awesome 6 Free';
            font-weight: 900;
            position: absolute;
            top: 10px;
            right: 10px;
            color: var(--primary);
        }

        .session-time {
            font-size: 1rem;
            font-weight: 800;
            color: #1e293b;
            margin-bottom: 5px;
        }

        @media (max-width: 576px) {
            .session-time {
                font-size: 0.85rem;
            }
        }

        .session-name {
            font-size: 0.75rem;
            font-weight: 600;
            color: #64748b;
            margin-bottom: 10px;
        }

        .session-meta {
            font-size: 0.65rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 20px;
            display: inline-block;
        }

        .meta-available {
            background: #dcfce7;
            color: #166534;
        }

        /* ID Card Preview */
        #ktp-preview-container {
            border: 2px dashed #cbd5e1;
            border-radius: 12px;
            overflow: hidden;
            display: none;
            margin-top: 15px;
            position: relative;
        }

        #ktp-preview {
            width: 100%;
            height: 200px;
            object-fit: contain;
            background: #000;
        }

        .remove-preview {
            position: absolute;
            top: 10px;
            right: 10px;
            background: #ef4444;
            color: white;
            border: none;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            cursor: pointer;
            box-shadow: 0 2px 8px rgba(0, 0, 0, 0.2);
        }

        .form-control,
        .form-select {
            padding: 10px;
            font-size: 0.9rem;
            border-color: #e2e8f0;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 4px rgba(30, 58, 138, 0.08);
        }

        .section-header {
            margin-bottom: 25px;
            border-bottom: 1px solid #f1f5f9;
            padding-bottom: 10px;
        }

        .section-tag {
            display: inline-block;
            padding: 4px 10px;
            background: #eff6ff;
            color: #1e40af;
            border-radius: 6px;
            font-size: 0.65rem;
            font-weight: 800;
            text-transform: uppercase;
            margin-bottom: 10px;
        }

        @media (max-width: 768px) {
            h1.fw-extrabold {
                font-size: 1.8rem !important;
            }
        }
    </style>

    <div class="container py-5 mt-4">
        <!-- ERROR HANDLING -->
        @if (session('error'))
            <div class="alert alert-danger shadow-sm border-0 mb-4 text-center">
                <i class="fa-solid fa-circle-exclamation fa-2xl mb-2 d-block"></i>
                <strong>{{ session('error') }}</strong>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger shadow-sm border-0 mb-4">
                <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="registration-container">
            <!-- Header -->
            <div class="text-center mb-5" data-aos="fade-down">
                <span class="badge bg-primary-subtle text-primary px-3 py-2 rounded-pill mb-3 fw-bold">LAYANAN TERPADU</span>
                <h1 class="fw-extrabold text-primary" style="font-weight: 900; letter-spacing: -1px;">Registrasi Kunjungan
                    Online</h1>
                <p class="text-muted">Proses pendaftaran cepat, transparan, dan tanpa perlu mengantri panjang.</p>
            </div>

            <!-- Step Indicator -->
            <div class="step-progress px-md-5 mb-5" data-aos="fade-up">
                <div class="step-progress-bar" id="progressBar"></div>
                <div class="step-dot active" id="dot1">1 <span class="step-label">Identitas</span></div>
                <div class="step-dot" id="dot2">2 <span class="step-label">Relasi</span></div>
                <div class="step-dot" id="dot3">3 <span class="step-label">Jadwal</span></div>
                <div class="step-dot" id="dot4"><i class="fa-solid fa-check"></i> <span
                        class="step-label">Selesai</span></div>
            </div>

            <form action="{{ route('antrian.store') }}" method="POST" enctype="multipart/form-data" id="multiStepForm"
                class="bg-white rounded-4 shadow-lg p-4 p-md-5 border border-white">
                @csrf

                <!-- STEP 1: IDENTITAS -->
                <div class="form-step active" id="step1">
                    <div class="section-header">
                        <span class="section-tag">Tahap 1 dari 3</span>
                        <h3 class="fw-bold text-dark">Lengkapi Identitas Diri</h3>
                        <p class="text-muted small">Pastikan data sesuai dengan kartu identitas KTP/SIM/KK yang berlaku.</p>
                    </div>

                    <div class="row g-3">
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-secondary">No. Identitas (16 Digit)</label>
                            <input type="text" name="nik" class="form-control" placeholder="5204..." required
                                maxlength="16" value="{{ old('nik') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-secondary">Nama Lengkap (Sesuai KTP)</label>
                            <input type="text" name="nama" class="form-control" placeholder="Nama Lengkap" required
                                value="{{ old('nama') }}">
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-secondary">Jenis Kelamin</label>
                            <select name="jenis_kelamin" class="form-select" required>
                                <option value="" disabled selected>Pilih...</option>
                                <option value="L">Laki-Laki</option>
                                <option value="P">Perempuan</option>
                            </select>
                        </div>
                        <div class="col-md-6 mb-3">
                            <label class="form-label fw-bold small text-secondary">Nomor WhatsApp Aktif</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0 text-muted">+62</span>
                                <input type="text" name="no_tlp" class="form-control border-start-0"
                                    placeholder="82340..." required value="{{ old('no_tlp') }}">
                            </div>
                        </div>
                        <div class="col-12 mb-3">
                            <label class="form-label fw-bold small text-secondary">Alamat Domisili Sekarang</label>
                            <textarea name="alamat" class="form-control" rows="3" placeholder="Jl. Contoh No. 123..." required>{{ old('alamat') }}</textarea>
                        </div>
                        <div class="col-12 mb-4">
                            <label class="form-label fw-bold small text-secondary">Unggah Foto KTP Asli</label>
                            <div class="bg-light p-4 rounded-3 text-center border-2 border-dashed border-secondary-subtle">
                                <i class="fa-solid fa-cloud-arrow-up fa-2x text-primary-emphasis mb-2"></i>
                                <h6 class="fw-bold mb-1">Klik untuk pilih foto KTP</h6>
                                <p class="text-xs text-muted">Format JPG/PNG, Maks. 2MB. Pastikan foto tidak blur.</p>
                                <input type="file" name="foto_identitas" id="ktp_input" class="d-none" accept="image/*"
                                    required>
                                <button type="button" class="btn btn-primary btn-sm mt-2 px-4"
                                    onclick="document.getElementById('ktp_input').click()">Pilih File</button>
                            </div>
                            <div id="ktp-preview-container">
                                <button type="button" class="remove-preview" onclick="resetKtp()"><i
                                        class="fa-solid fa-xmark"></i></button>
                                <img id="ktp-preview" src="">
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-end mt-4">
                        <button type="button" class="btn btn-primary btn-lg px-5 fw-bold"
                            onclick="nextStep(2)">Lanjutkan <i class="fa-solid fa-arrow-right ms-2"></i></button>
                    </div>
                </div>

                <!-- STEP 2: RELASI -->
                <div class="form-step" id="step2">
                    <div class="section-header">
                        <span class="section-tag">Tahap 2 dari 3</span>
                        <h3 class="fw-bold text-dark">Siapa yang ingin Anda temui?</h3>
                        <p class="text-muted small">Pilih nama warga binaan / Tahanan dan jelaskan hubungan kekerabatan Anda.</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold small text-secondary">Warga Binaan / Tahanan</label>

                            {{-- PILIHAN TIPE --}}
                            <div class="d-flex flex-column flex-md-row gap-3 mb-3" id="tipe-wb-group">
                                <div class="flex-fill">
                                    <input type="radio" class="btn-check" name="tipe_wb" id="tipe_narapidana"
                                        value="narapidana" checked>
                                    <label class="btn btn-outline-primary w-100 py-3 fw-bold d-flex align-items-center justify-content-center gap-2"
                                        for="tipe_narapidana">
                                        <i class="fa-solid fa-user-lock fa-lg"></i>
                                        <span>Warga Binaan<br><small class="fw-normal opacity-75">(Narapidana)</small></span>
                                    </label>
                                </div>
                                <div class="flex-fill">
                                    <input type="radio" class="btn-check" name="tipe_wb" id="tipe_tahanan"
                                        value="tahanan">
                                    <label class="btn btn-outline-warning w-100 py-3 fw-bold d-flex align-items-center justify-content-center gap-2"
                                        for="tipe_tahanan">
                                        <i class="fa-solid fa-handcuffs fa-lg"></i>
                                        <span>Tahanan<br><small class="fw-normal opacity-75">(Dalam Proses Hukum)</small></span>
                                    </label>
                                </div>
                            </div>

                            {{-- DROPDOWN NARAPIDANA --}}
                            <div id="container-select-wb">
                                <select name="warga_binaan_id"
                                    class="form-select @error('warga_binaan_id') is-invalid @enderror" required
                                    id="select-wb">
                                    <option value="" disabled selected>-- Cari Warga Binaan (Narapidana) --</option>
                                    @foreach ($narapidanas as $wb)
                                        <option value="{{ $wb->id }}">{{ $wb->nama }} (No. Reg:
                                            {{ $wb->no_registrasi }})</option>
                                    @endforeach
                                </select>
                                <div class="mt-2 text-xs text-muted px-2"><i class="fa-solid fa-circle-info me-1"></i>
                                    Gunakan kotak pencarian di atas jika list terlalu panjang.</div>
                            </div>

                            {{-- DROPDOWN TAHANAN --}}
                            <div id="container-select-tahanan" style="display: none;">
                                <select name="warga_binaan_id"
                                    class="form-select @error('warga_binaan_id') is-invalid @enderror"
                                    id="select-tahanan" disabled>
                                    <option value="" disabled selected>-- Cari Tahanan --</option>
                                    @foreach ($tahaans as $wb)
                                        <option value="{{ $wb->id }}">{{ $wb->nama }} (No. Reg:
                                            {{ $wb->no_registrasi }})</option>
                                    @endforeach
                                </select>
                                <div class="mt-2 text-xs text-muted px-2"><i class="fa-solid fa-circle-info me-1"></i>
                                    Gunakan kotak pencarian di atas jika list terlalu panjang.</div>
                            </div>

                            {{-- INPUT MANUAL --}}
                            <div id="container-manual-wb" style="display: none;">
                                <div class="input-group input-group-lg shadow-sm border rounded-3 overflow-hidden">
                                    <span class="input-group-text bg-white border-0"><i
                                            class="fa-solid fa-user-edit text-[#605ca8]"></i></span>
                                    <input type="text" name="nama_warga_binaan_manual" id="input-manual-wb"
                                        class="form-control border-0 ps-0 text-sm"
                                        placeholder="Tulis Nama Warga Binaan / Tahanan...">
                                </div>
                                <div class="mt-2 text-[10px] text-danger px-2 font-bold"><i
                                        class="fa-solid fa-triangle-exclamation me-1"></i> Pastikan ejaan nama benar untuk
                                    memudahkan verifikasi petugas.</div>
                            </div>

                            {{-- Toggle Manual --}}
                            <div class="mt-3 bg-gray-50 p-2 rounded border border-dashed border-gray-300">
                                <div class="form-check form-switch">
                                    <input class="form-check-input" type="checkbox" role="switch" id="toggleManual">
                                    <label class="form-check-label text-xs font-bold text-gray-700" for="toggleManual">
                                        Tidak menemukan nama di daftar? Input manual
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-12 mb-3">
                            <label class="form-label fw-bold small text-secondary">Apa hubungan Anda dengan WB/Tahanan?</label>
                            <div class="row g-2">
                                @foreach (['Istri/Suami', 'Orang Tua', 'Anak Kandung', 'Saudara Kandung', 'Penasehat Hukum', 'Teman/Lainnya'] as $rel)
                                    <div class="col-md-4">
                                        <input type="radio" class="btn-check" name="hubungan"
                                            id="hub_{{ $loop->index }}" value="{{ $rel }}" required>
                                        <label class="btn btn-outline-secondary w-100 text-start py-3"
                                            for="hub_{{ $loop->index }}">
                                            <i class="fa-solid fa-check-circle me-2 opacity-25"></i> {{ $rel }}
                                        </label>
                                    </div>
                                @endforeach
                            </div>
                            
                            <!-- Catatan tambahan untuk Teman/Lainnya -->
                            <div class="alert bg-warning bg-opacity-10 border border-warning-subtle text-dark small mt-3 mb-0" id="catatan-teman" style="display: none;">
                                <div class="d-flex">
                                    <i class="fa-solid fa-triangle-exclamation text-warning mt-1 me-2"></i>
                                    <div>
                                        <strong>Catatan Penting:</strong> Bagi pengunjung di luar keluarga inti (Teman atau lainnya), mohon untuk terlebih dahulu menghubungi/konfirmasi keluarga inti karena akses kunjungan hanya diberikan 1 kali dalam seminggu sesuai jadwal yang sudah ada di menu informasi.
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5 border-top pt-4">
                        <button type="button" class="btn btn-link link-secondary fw-bold text-decoration-none"
                            onclick="prevStep(1)"><i class="fa-solid fa-arrow-left me-2"></i> Sebelumnya</button>
                        <button type="button" class="btn btn-primary btn-lg px-5 fw-bold"
                            onclick="nextStep(3)">Lanjutkan <i class="fa-solid fa-arrow-right ms-2"></i></button>
                    </div>
                </div>

                <!-- STEP 3: JADWAL -->
                <div class="form-step" id="step3">
                    <div class="section-header">
                        <span class="section-tag">Tahap Akhir</span>
                        <h3 class="fw-bold text-dark">Tentukan Jadwal Kunjungan</h3>
                        <p class="text-muted small">Pilih tanggal dan sesi jam kunjungan yang masih memiliki kuota.</p>
                    </div>

                    <div class="row g-4">
                        <div class="col-md-12 mb-4">
                            @if(!$isJamOperasional)
                                <div class="alert alert-warning mb-3 border-0 shadow-sm">
                                    <i class="fa-solid fa-clock me-2"></i> <strong>Informasi:</strong> Jam operasional pendaftaran antrian untuk hari ini telah selesai (08.00 - 15.00 WITA). Silakan pilih tanggal kunjungan untuk hari berikutnya.
                                </div>
                            @endif
                            <label class="form-label fw-bold small text-secondary">Pilih Tanggal Kedatangan</label>
                            <div class="input-group input-group-lg">
                                <span class="input-group-text bg-white border-end-0"><i
                                        class="fa-solid fa-calendar-alt text-primary"></i></span>
                                <input type="date" name="tanggal_kunjungan" class="form-control border-start-0 ps-0"
                                    required value="{{ $minDate }}" min="{{ $minDate }}">
                            </div>
                        </div>

                        <div class="col-md-12">
                            <label class="form-label fw-bold small text-secondary mb-3">Pilih Sesi Jam Kunjungan</label>
                            <div class="session-grid">
                                @foreach ($sesis as $sesi)
                                    <div class="session-card" onclick="selectSession(this, '{{ $sesi->id }}')">
                                        <div class="session-time">
                                            {{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }} -
                                            {{ \Carbon\Carbon::parse($sesi->jam_selesai)->format('H:i') }} WIB</div>
                                        <div class="session-name">{{ $sesi->nama_sesi }}</div>
                                        <div class="session-meta meta-available">
                                            <i class="fa-solid fa-users me-1"></i> Kuota: {{ $sesi->kuota }} Seat
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                            <input type="hidden" name="sesi_id" id="selected_sesi_id" required>
                        </div>
                    </div>

                    <div class="alert bg-primary bg-opacity-10 border border-primary-subtle text-dark rounded-4 mt-5 p-4">
                        <div class="d-flex align-items-center">
                            <i class="fa-solid fa-circle-check fa-2x text-primary me-4"></i>
                            <div>
                                <h6 class="fw-bold mb-1">Konfirmasi Registrasi</h6>
                                <p class="text-sm mb-0">Dengan menekan tombol di bawah, Anda menyatakan data yang diisi
                                    adalah benar dan bersedia mematuhi tata tertib Lapas Sumbawa.</p>
                            </div>
                        </div>
                    </div>

                    <div class="d-flex justify-content-between mt-5 border-top pt-4">
                        <button type="button" class="btn btn-link link-secondary fw-bold text-decoration-none"
                            onclick="prevStep(2)"><i class="fa-solid fa-arrow-left me-2"></i> Sebelumnya</button>
                        <button type="submit" class="btn btn-success btn-lg px-5 fw-bold shadow">
                            <i class="fa-solid fa-qrcode me-2"></i> SELESAI & CETAK ANTRIAN
                        </button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    @push('scripts')
        <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

        <script>
            let currentStep = 1;
            const totalSteps = 3;

            $(document).ready(function() {
                // Init Select2 untuk Narapidana
                $('#select-wb').select2({
                    placeholder: "-- Cari Warga Binaan (Narapidana) --",
                    allowClear: true,
                    width: '100%'
                });

                // Init Select2 untuk Tahanan
                $('#select-tahanan').select2({
                    placeholder: "-- Cari Tahanan --",
                    allowClear: true,
                    width: '100%'
                });

                // Logika Toggle Tipe (Narapidana / Tahanan)
                $('input[name="tipe_wb"]').on('change', function () {
                    const tipe = $(this).val();
                    if ($('#toggleManual').is(':checked')) return; // Jika manual aktif, abaikan

                    if (tipe === 'narapidana') {
                        // Tampilkan Narapidana
                        $('#container-select-wb').show();
                        $('#select-wb').prop('required', true).prop('disabled', false);

                        // Sembunyikan Tahanan
                        $('#container-select-tahanan').hide();
                        $('#select-tahanan').val(null).trigger('change');
                        $('#select-tahanan').prop('required', false).prop('disabled', true);
                    } else {
                        // Tampilkan Tahanan
                        $('#container-select-tahanan').show();
                        $('#select-tahanan').prop('required', true).prop('disabled', false);

                        // Sembunyikan Narapidana
                        $('#container-select-wb').hide();
                        $('#select-wb').val(null).trigger('change');
                        $('#select-wb').prop('required', false).prop('disabled', true);
                    }
                });

                // Logika Toggle Manual Input
                $('#toggleManual').on('change', function () {
                    const isManual = $(this).is(':checked');
                    const tipe = $('input[name="tipe_wb"]:checked').val();

                    if (isManual) {
                        // Sembunyikan semua dropdown
                        $('#container-select-wb').hide();
                        $('#container-select-tahanan').hide();
                        $('#container-manual-wb').show();

                        $('#select-wb').prop('required', false).prop('disabled', true);
                        $('#select-tahanan').prop('required', false).prop('disabled', true);
                        $('#input-manual-wb').prop('required', true).focus();
                    } else {
                        // Kembali ke dropdown sesuai tipe yang dipilih
                        $('#container-manual-wb').hide();
                        $('#input-manual-wb').prop('required', false).val('');

                        if (tipe === 'narapidana') {
                            $('#container-select-wb').show();
                            $('#select-wb').prop('required', true).prop('disabled', false);
                            $('#container-select-tahanan').hide();
                            $('#select-tahanan').prop('required', false).prop('disabled', true);
                        } else {
                            $('#container-select-tahanan').show();
                            $('#select-tahanan').prop('required', true).prop('disabled', false);
                            $('#container-select-wb').hide();
                            $('#select-wb').prop('required', false).prop('disabled', true);
                        }
                    }
                });

                // Logika Catatan Teman/Lainnya
                $('input[name="hubungan"]').on('change', function() {
                    if ($(this).val() === 'Teman/Lainnya') {
                        $('#catatan-teman').slideDown();
                    } else {
                        $('#catatan-teman').slideUp();
                    }
                });
            });

            function updateProgress() {
                const percent = ((currentStep - 1) / (totalSteps - 1)) * 100;
                document.getElementById('progressBar').style.width = percent + '%';

                for (let i = 1; i <= totalSteps; i++) {
                    const dot = document.getElementById('dot' + i);
                    if (i < currentStep) {
                        dot.className = 'step-dot completed';
                        dot.innerHTML = '<i class="fa-solid fa-check"></i>';
                    } else if (i === currentStep) {
                        dot.className = 'step-dot active';
                        dot.innerText = i;
                    } else {
                        dot.className = 'step-dot';
                        dot.innerText = i;
                    }
                }
            }

            function nextStep(step) {
                // Simple Validation before moving next
                if (!validateStep(currentStep)) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Data Belum Lengkap',
                        text: 'Harap lengkapi semua isian yang tersedia sebelum melanjutkan.',
                        confirmButtonColor: '#f39c12'
                    });
                    return;
                }

                document.getElementById('step' + currentStep).classList.remove('active');
                currentStep = step;
                document.getElementById('step' + currentStep).classList.add('active');
                updateProgress();
                window.scrollTo(0, 0);
            }

            function prevStep(step) {
                document.getElementById('step' + currentStep).classList.remove('active');
                currentStep = step;
                document.getElementById('step' + currentStep).classList.add('active');
                updateProgress();
                window.scrollTo(0, 0);
            }

            function validateStep(step) {
                const currentStepEl = document.getElementById('step' + step);
                const inputs = currentStepEl.querySelectorAll('input[required], select[required], textarea[required]');
                let valid = true;

                inputs.forEach(input => {
                    if (!input.value) valid = false;
                });

                // Special check for identity photo
                if (step === 1 && !document.getElementById('ktp_input').files.length) valid = false;

                return valid;
            }

            // ID Card Preview Logic
            const ktpInput = document.getElementById('ktp_input');
            const ktpPreview = document.getElementById('ktp-preview');
            const ktpContainer = document.getElementById('ktp-preview-container');

            ktpInput.addEventListener('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        ktpPreview.src = e.target.result;
                        ktpContainer.style.display = 'block';
                    }
                    reader.readAsDataURL(file);
                }
            });

            function resetKtp() {
                ktpInput.value = "";
                ktpContainer.style.display = 'none';
                ktpPreview.src = "";
            }

            // Session Selection Logic
            function selectSession(element, id) {
                document.querySelectorAll('.session-card').forEach(card => card.classList.remove('selected'));
                element.classList.add('selected');
                document.getElementById('selected_sesi_id').value = id;
            }
        </script>
    @endpush
@endsection
