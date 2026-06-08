<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <i class="fa-solid fa-ticket-simple mr-2 text-[#f39c12]"></i>
            {{ __('Manajemen Antrian') }}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow border-t-[3px] border-t-[#3c8dbc] rounded-sm p-6">
                
                @if(session('success'))
                    <div class="mb-4 bg-[#dff0d8] border border-[#d6e9c6] text-[#3c763d] px-4 py-3 rounded relative text-sm">
                        <i class="fa-solid fa-check mr-1"></i> {{ session('success') }}
                    </div>
                @endif
                
                <div class="flex flex-col md:flex-row justify-between mb-6 gap-4">
                    <div class="w-full overflow-x-auto pb-2 custom-scrollbar">
                        <form method="GET" action="{{ route('admin.antrian.index') }}" class="flex flex-nowrap md:flex-wrap gap-2 items-center w-max lg:w-auto">
                            <div class="relative flex items-center">
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 flex items-center pl-3 pointer-events-none">
                                        <i class="fa-solid fa-barcode text-gray-400"></i>
                                    </div>
                                    <input type="text" name="kode_antrian" id="scannerInput" value="{{ request('kode_antrian') }}" placeholder="Scan Barcode Karcis..." class="rounded-sm border-[#3c8dbc] pl-9 pr-3 py-2 text-sm focus:border-[#367fa9] focus:ring-0 bg-[#f0f8ff] w-52 shadow-sm font-semibold text-[#3c8dbc]" autofocus autocomplete="off">
                                </div>
                                <button type="button" onclick="startCamera()" class="ml-2 bg-gray-100 border border-gray-300 text-gray-700 px-3 py-2 rounded-sm text-sm hover:bg-gray-200 shadow-sm" title="Scan pakai Kamera Laptop/HP">
                                    <i class="fa-solid fa-camera"></i>
                                </button>
                            </div>
                            <input type="date" name="tanggal" value="{{ request('tanggal') }}" onchange="this.form.submit()" class="rounded-sm border-gray-300 px-3 py-2 text-sm focus:border-[#3c8dbc] focus:ring-0 shrink-0">
                            <select name="status" class="rounded-sm border-gray-300 px-3 py-2 text-sm focus:border-[#3c8dbc] focus:ring-0 shrink-0">
                                <option value="">Semua Status</option>
                                <option value="menunggu" {{ request('status') == 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                                <option value="dipanggil" {{ request('status') == 'dipanggil' ? 'selected' : '' }}>Dipanggil</option>
                                <option value="selesai" {{ request('status') == 'selesai' ? 'selected' : '' }}>Selesai</option>
                                <option value="ditolak" {{ request('status') == 'ditolak' ? 'selected' : '' }}>Ditolak</option>
                            </select>
                            <button type="submit" class="bg-[#3c8dbc] border-[#367fa9] text-white px-4 py-2 rounded-sm text-sm hover:bg-[#367fa9] font-bold shadow-sm shrink-0">
                                <i class="fa-solid fa-filter mr-1"></i> FILTER
                            </button>
                            
                            <div class="flex gap-1 ml-2 border-l pl-3 border-gray-200 shrink-0">
                                <a href="{{ route('admin.antrian.index', ['tanggal' => date('Y-m-d')]) }}" class="px-3 py-1.5 text-xs bg-white border border-gray-300 text-gray-700 rounded-sm hover:bg-gray-100 {{ request('tanggal') == date('Y-m-d') ? 'ring-1 ring-[#3c8dbc] bg-blue-50 border-[#3c8dbc]' : '' }}">
                                    <i class="fa-solid fa-calendar-day mr-1 text-[#00c0ef]"></i> Hari Ini
                                </a>
                                <a href="{{ route('admin.antrian.index', ['tanggal' => date('Y-m-d', strtotime('-1 day'))]) }}" class="px-3 py-1.5 text-xs bg-white border border-gray-300 text-gray-700 rounded-sm hover:bg-gray-100 {{ request('tanggal') == date('Y-m-d', strtotime('-1 day')) ? 'ring-1 ring-[#3c8dbc] bg-blue-50 border-[#3c8dbc]' : '' }}">
                                    <i class="fa-solid fa-calendar-minus mr-1 text-[#f39c12]"></i> Kemarin
                                </a>
                                <a href="{{ route('admin.antrian.index') }}" class="px-3 py-1.5 text-xs bg-white border border-gray-300 text-gray-700 rounded-sm hover:bg-gray-100 {{ !request('tanggal') ? 'ring-1 ring-[#3c8dbc] bg-blue-50 border-[#3c8dbc]' : '' }}">
                                    <i class="fa-solid fa-list mr-1 text-gray-500"></i> Semua
                                </a>
                            </div>
                        </form>
                    </div>
                    <a href="{{ route('admin.antrian.display') }}" target="_blank" class="bg-[#00a65a] border-[#008d4c] text-white px-4 py-2 rounded-sm hover:bg-[#008d4c] font-bold text-sm text-center shadow-sm whitespace-nowrap h-fit">
                        <i class="fa-solid fa-desktop mr-1"></i> BUKA DISPLAY TV
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm border border-[#f4f4f4]">
                        <thead class="bg-[#f9f9f9] border-b border-[#f4f4f4]">
                            <tr>
                                <th class="px-4 py-3 font-bold text-[#333]">KODE</th>
                                <th class="px-4 py-3 font-bold text-[#333]">NAMA PENGUNJUNG</th>
                                <th class="px-4 py-3 font-bold text-[#333]">WB / TAHANAN</th>
                                <th class="px-4 py-3 font-bold text-[#333]">TANGGAL</th>
                                <th class="px-4 py-3 font-bold text-[#333]">SESI</th>
                                <th class="px-4 py-3 font-bold text-[#333]">STATUS</th>
                                <th class="px-4 py-3 font-bold text-[#333]">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f4f4f4] text-[#555]">
                            @foreach($antrians as $antrian)
                            <tr class="hover:bg-[#f5f5f5] antrian-row" data-id="{{ $antrian->id }}" data-status="{{ $antrian->status }}">
                                <td class="px-4 py-3">
                                    <span class="font-bold text-[#3c8dbc] text-base">{{ str_pad($antrian->nomor_antrian, 3, '0', STR_PAD_LEFT) }}</span>
                                </td>
                                <td class="px-4 py-3">{{ $antrian->nama }}</td>
                                @if($antrian->kunjungan && $antrian->kunjungan->wargaBinaan)
                                    @php
                                        $noReg = $antrian->kunjungan->wargaBinaan->no_registrasi;
                                        $isNapi = str_starts_with(strtoupper($noReg), 'BI');
                                    @endphp
                                    <td class="py-3 pl-3 pr-4 {{ $isNapi ? 'border-l-[3px] border-l-blue-500' : 'border-l-[3px] border-l-orange-500' }}">
                                        <span class="font-semibold text-gray-800 block leading-snug">{{ $antrian->kunjungan->wargaBinaan->nama }}</span>
                                        <span class="text-[10px] font-bold {{ $isNapi ? 'text-blue-600' : 'text-orange-600' }}">
                                            <i class="fa-solid {{ $isNapi ? 'fa-user-lock' : 'fa-handcuffs' }} mr-0.5"></i>
                                            {{ $isNapi ? 'Warga Binaan' : 'Tahanan' }}
                                        </span>
                                    </td>
                                @elseif($antrian->kunjungan && $antrian->kunjungan->nama_warga_binaan_manual)
                                    <td class="py-3 pl-3 pr-4 border-l-[3px] border-l-gray-400">
                                        <span class="italic text-blue-600 block leading-snug">{{ $antrian->kunjungan->nama_warga_binaan_manual }}</span>
                                        <span class="text-[10px] font-bold text-gray-500">
                                            <i class="fa-solid fa-pen-to-square mr-0.5"></i> Input Manual
                                        </span>
                                    </td>
                                @else
                                    <td class="px-4 py-3"><span class="text-gray-400">-</span></td>
                                @endif
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($antrian->tanggal_kunjungan)->format('d/m/y') }}</td>
                                <td class="px-4 py-3"><span class="text-xs px-2 py-0.5 bg-gray-100 rounded border">{{ optional($antrian->sesi)->nama_sesi }}</span></td>
                                <td class="px-4 py-3 status-cell">
                                    <span class="px-2 py-0.5 rounded text-[10px] text-white font-bold status-badge
                                        {{ $antrian->status == 'menunggu' ? 'bg-[#f39c12]' : '' }}
                                        {{ $antrian->status == 'dipanggil' ? 'bg-[#00c0ef]' : '' }}
                                        {{ $antrian->status == 'selesai' ? 'bg-[#00a65a]' : '' }}
                                        {{ $antrian->status == 'ditolak' ? 'bg-[#dd4b39]' : '' }}">
                                        {{ strtoupper($antrian->status) }}
                                    </span>
                                </td>
                                <td class="px-4 py-3 flex space-x-2 action-cell">
                                    @if($antrian->status == 'menunggu')
                                    <form action="{{ route('admin.antrian.update-status', $antrian) }}" method="POST" class="panggil-form" onsubmit="return confirm('Tandai sebagai dipanggil?')">
                                        @csrf
                                        @method('PATCH')
                                        <input type="hidden" name="status" value="dipanggil">
                                        <button class="bg-[#00c0ef] border-[#00acd6] text-white px-2 py-1 rounded-sm text-xs hover:bg-[#00acd6] shadow-sm">
                                            <i class="fa-solid fa-bullhorn mr-1"></i> PANGGIL
                                        </button>
                                    </form>
                                    @endif
                                    <a href="{{ route('admin.antrian.show', $antrian) }}" class="bg-[#222d32] border-[#1a2226] text-white px-2 py-1 rounded-sm text-xs hover:bg-[#1a2226] shadow-sm">
                                        <i class="fa-solid fa-eye mr-1"></i> DETAIL
                                    </a>
                                    <form action="{{ route('admin.antrian.destroy', $antrian) }}" method="POST" onsubmit="return confirm('Hapus data antrian ini?')" class="inline">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="bg-[#dd4b39] border-[#d73925] text-white px-2 py-1 rounded-sm text-xs hover:bg-[#d73925] shadow-sm">
                                            <i class="fa-solid fa-trash mr-1"></i> HAPUS
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($antrians->isEmpty())
                                <tr>
                                    <td colspan="7" class="px-4 py-8 text-center text-[#777] italic">Tidak ada data antrian untuk filter ini.</td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $antrians->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>

<!-- Modal Kamera Scanner -->
<div id="cameraModal" class="custom-modal-overlay" style="display: none;">
    <div class="custom-modal-content">
        <div class="custom-modal-header">
            <h3 class="custom-modal-title">
                <i class="fa-solid fa-camera" style="color: #3c8dbc; margin-right: 8px;"></i> Scan Karcis
            </h3>
            <button type="button" onclick="stopCamera()" class="custom-modal-close">
                <i class="fa-solid fa-xmark"></i>
            </button>
        </div>
        <div id="qr-reader"></div>
        <p style="text-align: center; font-size: 12px; color: #6b7280; margin-top: 15px; margin-bottom: 0;">
            <i class="fa-solid fa-circle-info" style="margin-right: 4px;"></i> Arahkan kamera ke QR Code karcis pengunjung.
        </p>
    </div>
</div>

<style>
    /* JAMINAN MODAL BERADA PALING ATAS */
    .custom-modal-overlay {
        position: fixed;
        top: 0;
        left: 0;
        width: 100vw;
        height: 100vh;
        background: rgba(17, 24, 39, 0.85); /* Dark bg */
        z-index: 999999 !important; /* Paksa paling atas */
        display: flex;
        align-items: center;
        justify-content: center;
        backdrop-filter: blur(4px);
    }
    
    .custom-modal-content {
        background: #ffffff;
        padding: 24px;
        border-radius: 12px;
        width: 90%;
        max-width: 400px;
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.25);
        animation: modalFadeIn 0.3s ease-out;
    }

    @keyframes modalFadeIn {
        from { opacity: 0; transform: translateY(-20px); }
        to { opacity: 1; transform: translateY(0); }
    }

    .custom-modal-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 16px;
        border-bottom: 1px solid #f3f4f6;
        padding-bottom: 12px;
    }

    .custom-modal-title {
        font-size: 18px;
        font-weight: bold;
        color: #1f2937;
        margin: 0;
    }

    .custom-modal-close {
        background: transparent;
        border: none;
        color: #9ca3af;
        cursor: pointer;
        font-size: 20px;
        padding: 4px;
        transition: color 0.2s;
    }
    .custom-modal-close:hover {
        color: #ef4444;
    }

    /* Styling khusus untuk merapikan bawaan html5-qrcode */
    #qr-reader {
        border: 2px dashed #cbd5e1 !important;
        border-radius: 8px !important;
        width: 100% !important;
        background: #f8fafc;
        overflow: hidden;
    }
    
    /* Tombol 'Request Camera Permissions' */
    #qr-reader button {
        background-color: #3c8dbc !important;
        color: white !important;
        border: none !important;
        padding: 10px 20px !important;
        border-radius: 6px !important;
        font-weight: bold !important;
        font-size: 14px !important;
        margin: 15px auto !important;
        display: block !important;
        cursor: pointer !important;
        box-shadow: 0 4px 6px -1px rgba(60, 141, 188, 0.2) !important;
        transition: background-color 0.2s;
    }
    #qr-reader button:hover {
        background-color: #367fa9 !important;
    }
    
    /* Pilihan Kamera (Select) */
    #qr-reader select {
        padding: 8px !important;
        border-radius: 6px !important;
        border: 1px solid #cbd5e1 !important;
        margin-bottom: 15px !important;
        width: 90% !important;
        font-size: 14px !important;
        background: white !important;
        display: block !important;
        margin-left: auto !important;
        margin-right: auto !important;
    }
    
    /* Sembunyikan elemen sampah dari library */
    #qr-reader a {
        display: none !important; /* Sembunyikan link 'Powered by' */
    }
    #qr-reader__dashboard_section_csr span {
        display: none !important; /* Sembunyikan tulisan 'Or drop an image...' */
    }
    #qr-reader__dashboard_section_swaplink {
        display: none !important; /* Sembunyikan teks fallback */
    }
</style>

<!-- html5-qrcode Library -->
<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

<script>
    // Logika Kamera Scanner
    let html5QrcodeScanner = null;

    function startCamera() {
        document.getElementById('cameraModal').style.display = 'flex';
        
        if (!html5QrcodeScanner) {
            html5QrcodeScanner = new Html5QrcodeScanner(
                "qr-reader", 
                { 
                    fps: 10, 
                    qrbox: {width: 250, height: 250}, 
                    aspectRatio: 1.0,
                    supportedScanTypes: [Html5QrcodeScanType.SCAN_TYPE_CAMERA] // Hanya kamera, sembunyikan file upload
                }
            );
        }
        
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    }

    function stopCamera() {
        document.getElementById('cameraModal').style.display = 'none';
        if (html5QrcodeScanner) {
            html5QrcodeScanner.clear().catch(error => {
                console.error("Failed to clear html5QrcodeScanner. ", error);
            });
        }
    }

    function onScanSuccess(decodedText, decodedResult) {
        // Hentikan kamera
        stopCamera();
        
        // Masukkan hasil ke input text
        const scannerInput = document.getElementById('scannerInput');
        scannerInput.value = decodedText;
        
        // Submit form otomatis
        scannerInput.closest('form').submit();
    }

    function onScanFailure(error) {
        // Abaikan error saat scanning berlangsung (frame per frame)
    }

    // Autofocus ulang ke input scanner jika admin menekan sembarang tombol huruf/angka
    // sehingga mempermudah jika scanner digunakan tanpa harus mengklik kolom dulu.
    document.addEventListener('keydown', function(e) {
        const activeElement = document.activeElement;
        const modal = document.getElementById('cameraModal');
        const isTyping = activeElement.tagName === 'INPUT' || 
                         activeElement.tagName === 'TEXTAREA' || 
                         activeElement.tagName === 'SELECT';
        const isModalOpen = modal && modal.style.display !== 'none';

        if (e.key === 'Enter') {
            if (!isTyping && !isModalOpen) {
                // Cari form "PANGGIL" pertama di halaman (antrian berstatus menunggu)
                const firstPanggilForm = document.querySelector('form input[name="status"][value="dipanggil"]')?.closest('form');
                if (firstPanggilForm) {
                    e.preventDefault();
                    // Klik tombol PANGGIL (akan memicu onsubmit confirm)
                    firstPanggilForm.querySelector('button')?.click();
                }
            }
        } else if (e.key.length === 1 && !e.ctrlKey && !e.altKey && !e.metaKey) {
            // Jangan auto focus jika yang ditekan adalah tombol fungsi, ctrl, alt, dsb
            const scannerInput = document.getElementById('scannerInput');
            
            // Cek apakah admin sedang mengetik di input lain dan modal kamera tidak terbuka
            if (!isTyping && !isModalOpen) {
                scannerInput.focus();
            }
        }
    });

    // Polling untuk memperbarui status antrian secara real-time tanpa refresh halaman
    function pollQueueStatuses() {
        const rows = document.querySelectorAll('tr.antrian-row');
        if (rows.length === 0) return;

        const ids = Array.from(rows).map(row => row.getAttribute('data-id')).join(',');
        
        fetch("{{ route('admin.antrian.statuses') }}?ids=" + ids)
            .then(response => response.json())
            .then(statuses => {
                rows.forEach(row => {
                    const id = row.getAttribute('data-id');
                    const currentStatus = row.getAttribute('data-status');
                    const newStatus = statuses[id];

                    if (newStatus && newStatus !== currentStatus) {
                        // Update status attribute
                        row.setAttribute('data-status', newStatus);

                        // Update status badge
                        const badge = row.querySelector('.status-badge');
                        if (badge) {
                            badge.innerText = newStatus.toUpperCase();
                            // Reset class
                            badge.className = 'px-2 py-0.5 rounded text-[10px] text-white font-bold status-badge';
                            // Add appropriate background color class
                            if (newStatus === 'menunggu') badge.classList.add('bg-[#f39c12]');
                            else if (newStatus === 'dipanggil') badge.classList.add('bg-[#00c0ef]');
                            else if (newStatus === 'selesai') badge.classList.add('bg-[#00a65a]');
                            else if (newStatus === 'ditolak') badge.classList.add('bg-[#dd4b39]');
                        }

                        // Hapus form "PANGGIL" jika status bukan lagi "menunggu"
                        if (newStatus !== 'menunggu') {
                            const panggilForm = row.querySelector('.panggil-form');
                            if (panggilForm) {
                                panggilForm.remove();
                            }
                        }
                    }
                });
            })
            .catch(error => console.error('Error polling queue statuses:', error));
    }

    // Jalankan polling setiap 3 detik
    setInterval(pollQueueStatuses, 3000);
</script>
