<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight flex flex-wrap items-center gap-2">
            <span>Detail Antrian:</span>
            <span class="bg-[#3c8dbc] text-white px-3 py-1 rounded font-bold tracking-widest">
                {{ str_pad($antrian->nomor_antrian, 3, '0', STR_PAD_LEFT) }}
            </span>
            <span class="bg-gray-200 text-gray-700 text-sm px-2 py-1 rounded">
                {{ optional($antrian->sesi)->nama_sesi }}
            </span>
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 grid grid-cols-1 md:grid-cols-2 gap-6">
            <!-- Kolom Pertama: Informasi Pengunjung -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Informasi Pengunjung</h3>
                <div class="space-y-3 sm:space-y-2 text-sm text-gray-600">
                    <div class="flex items-start">
                        <div class="w-2/5 sm:w-1/3 font-bold text-gray-800">Nama</div>
                        <div class="w-3/5 sm:w-2/3 break-words">: {{ $antrian->nama }}</div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-2/5 sm:w-1/3 font-bold text-gray-800">NIK</div>
                        <div class="w-3/5 sm:w-2/3 break-words">: {{ $antrian->nik }}</div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-2/5 sm:w-1/3 font-bold text-gray-800">Gender</div>
                        <div class="w-3/5 sm:w-2/3 break-words">:
                            {{ $antrian->jenis_kelamin == 'L' ? 'Laki-Laki' : 'Perempuan' }}</div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-2/5 sm:w-1/3 font-bold text-gray-800">No HP / WA</div>
                        <div class="w-3/5 sm:w-2/3 break-words">: {{ $antrian->no_tlp }}</div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-2/5 sm:w-1/3 font-bold text-gray-800">Alamat</div>
                        <div class="w-3/5 sm:w-2/3 break-words">: {{ $antrian->alamat }}</div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-2/5 sm:w-1/3 font-bold text-gray-800">Hubungan</div>
                        <div class="w-3/5 sm:w-2/3 break-words">: {{ $antrian->hubungan }}</div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-2/5 sm:w-1/3 font-bold text-gray-800">Tgl Kunjungan</div>
                        <div class="w-3/5 sm:w-2/3 break-words">:
                            {{ \Carbon\Carbon::parse($antrian->tanggal_kunjungan)->format('d M Y') }}</div>
                    </div>
                    <div class="flex items-start">
                        <div class="w-2/5 sm:w-1/3 font-bold text-gray-800">Sesi</div>
                        <div class="w-3/5 sm:w-2/3 break-words">: {{ optional($antrian->sesi)->nama_sesi }}</div>
                    </div>
                </div>

                <div class="mt-4 border-t pt-4">
                    <p class="font-bold text-gray-800 mb-2">Foto Identitas (KTP,KK,SIM,DLL):</p>
                    @if ($antrian->foto_identitas)
                        <img src="{{ asset('storage/' . str_replace('public/', '', $antrian->foto_identitas)) }}"
                            class="w-full max-w-sm rounded border shadow-sm" alt="Foto Identitas">
                    @else
                        <div class="bg-gray-100 p-4 text-center text-gray-500 rounded">Tidak ada lampiran foto
                            identitas.</div>
                    @endif
                </div>
            </div>

            <!-- Kolom Kedua: Form Verifikasi -->
            <div class="bg-white shadow-sm sm:rounded-lg p-6">
                <h3 class="text-lg font-bold mb-4 border-b pb-2">Verifikasi Kunjungan</h3>

                @if ($antrian->kunjungan)
                    <div class="mb-6 bg-gray-50 border border-gray-200 p-4 rounded text-sm">
                        <p class="mb-1"><strong>Status Keputusan:</strong>
                            <span
                                class="px-2 py-1 uppercase font-bold text-xs rounded text-white
                                            {{ $antrian->kunjungan->status_verifikasi == 'disetujui' ? 'bg-green-600' : 'bg-red-600' }}">
                                {{ $antrian->kunjungan->status_verifikasi }}
                            </span>
                        </p>
                        <p class="mb-1"><strong>Tujuan Warga Binaan:</strong>
                            @if ($antrian->kunjungan->wargaBinaan)
                                {{ $antrian->kunjungan->wargaBinaan->nama }}
                            @else
                                <span
                                    class="text-blue-600 font-bold underline decoration-dotted">{{ $antrian->kunjungan->nama_warga_binaan_manual }}</span>
                                <span class="ml-1 text-[10px] bg-blue-100 text-blue-700 px-1 rounded uppercase">Input
                                    Manual</span>
                            @endif
                        </p>
                        <p><strong>Catatan:</strong> {{ $antrian->kunjungan->catatan ?: '-' }}</p>
                    </div>
                @endif

                @if (!in_array($antrian->status, ['selesai', 'ditolak']))
                    <form action="{{ route('admin.antrian.verifikasi', $antrian) }}" method="POST" class="space-y-4"
                        x-data="{ syncToDb: false }">
                        @csrf

                        @if (!$antrian->kunjungan->warga_binaan_id)
                            <div class="bg-blue-50 border border-blue-200 p-3 rounded-sm mb-4">
                                <div class="flex items-center mb-2">
                                    <input type="checkbox" name="sync_to_db" id="sync_to_db" x-model="syncToDb"
                                        class="rounded border-gray-300 text-[#3c8dbc] focus:ring-0 mr-2">
                                    <label for="sync_to_db" class="text-sm font-bold text-blue-800 cursor-pointer">
                                        <i class="fa-solid fa-cloud-arrow-up mr-1 text-blue-500"></i> Daftarkan ke
                                        Database Warga Binaan?
                                    </label>
                                </div>
                                <p class="text-[10px] text-blue-600 leading-relaxed pl-6">
                                    <i class="fa-solid fa-circle-info mr-1"></i> Centang ini jika ingin nama
                                    <strong>"{{ $antrian->kunjungan->nama_warga_binaan_manual }}"</strong> otomatis
                                    masuk ke master data tetap.
                                </p>
                            </div>
                        @endif

                        <div x-show="!syncToDb">
                            <label class="block text-gray-700 font-bold mb-1 text-sm">Warga Binaan yang dituju <span
                                    class="text-red-500" x-show="!syncToDb">*</span></label>
                            <select name="warga_binaan_id" class="w-full border-gray-300 rounded shadow-sm text-sm"
                                :required="!syncToDb">
                                <option value="">-- Pilih --</option>
                                @foreach ($wargaBinaans as $wb)
                                    <option value="{{ $wb->id }}">{{ $wb->nama }} (Reg:
                                        {{ $wb->no_registrasi }} / Blok {{ $wb->blok }})</option>
                                @endforeach
                            </select>
                            <p class="text-[10px] text-gray-500 mt-1 italic" x-show="!syncToDb">Pilih dari daftar jika
                                orang ini sebenarnya sudah terdaftar.</p>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-1 text-sm">Keputusan <span
                                    class="text-red-500">*</span></label>
                            <select name="status_verifikasi" class="w-full border-gray-300 rounded shadow-sm text-sm"
                                required>
                                <option value="">-- Pilih --</option>
                                <option value="disetujui">SETUJU (Izinkan Berkunjung)</option>
                                <option value="ditolak">TOLAK (Larangan/Syarat tidak penuhi)</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-gray-700 font-bold mb-1 text-sm">Catatan (Pesan Penolakan /
                                Lainnya)</label>
                            <textarea name="catatan" class="w-full border-gray-300 rounded shadow-sm text-sm" rows="3"
                                placeholder="Tulis alasan penolakan jika ditolak..."></textarea>
                        </div>
                        <button type="submit"
                            class="w-full bg-indigo-600 text-white font-bold py-2 rounded hover:bg-indigo-700 shadow flex justify-center items-center">
                            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Simpan Keputusan Verifikasi
                        </button>
                        <p class="text-xs text-gray-500 mt-2 text-center">Menyimpan keputusan akan mengubah status
                            antrian secara otomatis.</p>

                    </form>
                @endif
                <div class="mt-6 pt-4 border-t">
                    <a href="{{ route('admin.antrian.index') }}" class="text-sm text-indigo-600 hover:underline">&larr;
                        Kembali ke daftar antrian</a>
                </div>
            </div>
        </div>
</x-app-layout>
