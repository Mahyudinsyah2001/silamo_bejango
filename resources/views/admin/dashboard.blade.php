<x-app-layout>
    <x-slot name="header">
        Dashboard <small class="text-sm text-[#777] ml-1 font-light">Control panel</small>
    </x-slot>

    <!-- Small boxes (Stat box) -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <!-- Box 1: Aqua -->
        <div class="rounded-sm bg-[#00c0ef] text-white relative flex flex-col p-0 shadow-sm overflow-hidden group">
            <div class="p-4 relative z-10 w-3/4">
                <h3 class="text-4xl font-bold mb-1">{{ $totalAntrianHariIni ?? 0 }}</h3>
                <p class="text-white text-[15px] m-0">Total Semua Antrian</p>
            </div>
            <div class="absolute right-0 top-0 -mt-1 mr-3 z-0 text-black/10 group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-bag-shopping text-7xl"></i>
            </div>
            <a href="{{ route('admin.antrian.index') }}" class="text-center bg-black/10 py-1.5 text-white/90 text-sm hover:bg-black/20 hover:text-white mt-2 transition-colors z-10 block w-full">
                More info <i class="fa-solid fa-circle-arrow-right ml-1"></i>
            </a>
        </div>
        
        <!-- Box 2: Green -->
        <div class="rounded-sm bg-[#00a65a] text-white relative flex flex-col p-0 shadow-sm overflow-hidden group">
            <div class="p-4 relative z-10 w-3/4">
                <h3 class="text-4xl font-bold mb-1">{{ $totalDisetujui ?? 0 }}<sup class="text-xl" style="top: -10px;"></sup></h3>
                <p class="text-white text-[15px] m-0">Total Selesai / Dipanggil</p>
            </div>
            <div class="absolute right-0 top-0 mt-3 mr-3 z-0 text-black/10 group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-chart-simple text-7xl"></i>
            </div>
            <a href="{{ route('admin.antrian.index', ['status'=>'selesai']) }}" class="text-center bg-black/10 py-1.5 text-white/90 text-sm hover:bg-black/20 hover:text-white mt-2 transition-colors z-10 block w-full">
                More info <i class="fa-solid fa-circle-arrow-right ml-1"></i>
            </a>
        </div>

        <!-- Box 3: Yellow/Orange -->
        <div class="rounded-sm bg-[#f39c12] text-white relative flex flex-col p-0 shadow-sm overflow-hidden group">
            <div class="p-4 relative z-10 w-3/4">
                <h3 class="text-4xl font-bold mb-1">{{ $antrianMenunggu ?? 0 }}</h3>
                <p class="text-white text-[15px] m-0">Total Menunggu</p>
            </div>
            <div class="absolute right-0 top-0 mt-2 mr-4 z-0 text-black/10 group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-user-plus text-7xl"></i>
            </div>
            <a href="{{ route('admin.antrian.index', ['status'=>'menunggu']) }}" class="text-center bg-black/10 py-1.5 text-white/90 text-sm hover:bg-black/20 hover:text-white mt-2 transition-colors z-10 block w-full">
                More info <i class="fa-solid fa-circle-arrow-right ml-1"></i>
            </a>
        </div>

        <!-- Box 4: Red -->
        <div class="rounded-sm bg-[#dd4b39] text-white relative flex flex-col p-0 shadow-sm overflow-hidden group">
            @php
                $sisaKuotaAll = 0;
                if(isset($sesis)) {
                    foreach($sesis as $s) { $sisaKuotaAll += $s->sisa_kuota; }
                }
            @endphp
            <div class="p-4 relative z-10 w-3/4">
                <h3 class="text-4xl font-bold mb-1">{{ $sisaKuotaAll }}</h3>
                <p class="text-white text-[15px] m-0">Sisa Kuota Kunjungan</p>
            </div>
            <div class="absolute right-0 top-0 mt-2 mr-3 z-0 text-black/10 group-hover:scale-110 transition-transform duration-300">
                <i class="fa-solid fa-chart-pie text-7xl"></i>
            </div>
            <a href="{{ route('admin.sesi.index') }}" class="text-center bg-black/10 py-1.5 text-white/90 text-sm hover:bg-black/20 hover:text-white mt-2 transition-colors z-10 block w-full">
                More info <i class="fa-solid fa-circle-arrow-right ml-1"></i>
            </a>
        </div>
    </div>

    <!-- Main row -->
    <div class="flex flex-col lg:flex-row gap-4">
        <!-- Box: Status Sesi -->
        <div class="bg-white shadow border-t-[3px] border-t-[#00a65a] rounded-sm relative flex-1">
            <div class="px-4 py-3 border-b flex justify-between items-center text-[#333]">
                <h3 class="font-normal text-lg m-0"><i class="fa-solid fa-clock mr-2"></i> Status Kuota Sesi Hari Ini</h3>
                <div class="flex space-x-1">
                    <div class="px-2 bg-green-500 rounded-sm text-xs text-white">Aktif</div>
                    <div class="px-2 bg-blue-500 rounded-sm text-xs text-white">Sisa Kuota</div>
                </div>
            </div>
            <div class="p-4 max-h-[300px] overflow-y-auto">
                <div class="space-y-4">
                    @isset($sesis)
                    @foreach($sesis as $sesi)
                    <div class="flex items-start {{ !$loop->last ? 'border-b border-[#f4f4f4] pb-4' : '' }}">
                        <img src="https://ui-avatars.com/api/?name={{ urlencode($sesi->nama_sesi) }}&background=d2d6de&color=444" class="w-10 h-10 rounded-full" alt="Session Icon">
                        <div class="ml-3 flex-1">
                            <div class="flex justify-between items-center mb-1">
                                <span class="font-bold text-[#3c8dbc] text-sm">{{ $sesi->nama_sesi }}</span>
                                <span class="text-[11px] text-[#999]"><i class="fa-regular fa-clock"></i> {{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }}</span>
                            </div>
                            <!-- Attachment style box -->
                            <div class="text-sm bg-[#f4f4f4] border border-[#ddd] p-3 text-[#444] mt-1 relative w-fit min-w-[250px]">
                                <div class="font-bold mb-2">Status Kuota: <a href="{{ route('admin.sesi.index') }}" class="font-normal italic text-[#00c0ef]">Kelola Sesi</a></div>
                                <div class="bg-white border p-2 flex justify-between items-center gap-4">
                                    <span class="text-xs text-[#666]">Terpakai: <span class="font-bold">{{ $sesi->terpakai ?? 0 }}</span> dari {{ $sesi->kuota }}</span>
                                    @if(isset($sesi->sisa_kuota) && $sesi->sisa_kuota > 0)
                                        <span class="bg-[#00a65a] text-white px-2 py-1 text-xs rounded shadow-sm">Sisa: {{ $sesi->sisa_kuota }}</span>
                                    @else
                                        <span class="bg-[#dd4b39] text-white px-2 py-1 text-xs rounded shadow-sm">Penuh</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                    @endisset
                </div>
            </div>
            <div class="bg-gray-100 p-3 border-t text-center text-[#777] text-sm">
                <i>Data diupdate otomatis berdasarkan pendaftaran kunjungan untuk hari ini.</i>
            </div>
        </div>

        <!-- Box: Quick actions (To match 'Sales Graph' location) -->
        <div class="bg-gradient-to-b from-[#00b2dc] to-[#0092b7] text-white shadow border border-transparent rounded-sm relative flex-1 flex flex-col">
            <div class="px-4 py-3 border-b border-white/20 flex justify-between items-center">
                <h3 class="font-normal text-lg m-0"><i class="fa-solid fa-chart-line text-white/80 mr-2"></i> Statistik Antrian (7 Hari Terakhir)</h3>
                <div class="flex space-x-1">
                    <button class="text-white hover:text-gray-200"><i class="fa-solid fa-minus"></i></button>
                </div>
            </div>
            <div class="p-4 flex-1 flex flex-col justify-center items-center w-full relative h-[180px]">
                <!-- Real ChartJS Canvas -->
                <canvas id="antrianChart"></canvas>
            </div>
            <div class="bg-[#00a3cb] p-4 flex justify-between gap-4 text-center border-t border-white/20">
                <div class="flex-1">
                    <div class="inline-block relative">
                        <div class="w-14 h-14 rounded-full border-4 border-white/30 border-t-white bg-transparent mx-auto flex items-center justify-center font-bold text-sm">{{ $totalAntrianBulanIni ?? 0 }}</div>
                    </div>
                    <div class="text-[11px] font-semibold mt-2 text-white/90">Pendaftar Bulan Ini</div>
                </div>
                <div class="flex-1">
                    <a href="{{ route('admin.antrian.index', ['status'=>'selesai']) }}" class="block group">
                        <div class="w-14 h-14 rounded-full border-4 border-white/30 border-t-white bg-transparent mx-auto flex items-center justify-center text-white group-hover:scale-105 transition-transform"><span class="font-bold text-sm">{{ $totalSelesaiKeseluruhan ?? 0 }}</span></div>
                        <div class="text-[11px] font-semibold mt-2 text-white/90">Total Selesai</div>
                    </a>
                </div>
                <div class="flex-1">
                    <div class="w-14 h-14 rounded-full border-4 border-white/30 border-t-[#dd4b39] bg-transparent mx-auto flex items-center justify-center font-bold text-sm">{{ $totalDitolakKeseluruhan ?? 0 }}</div>
                    <div class="text-[11px] font-semibold mt-2 text-white/90">Total Ditolak</div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Script for ChartJS -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            var ctx = document.getElementById('antrianChart').getContext('2d');
            var antrianChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: @json($grafikTanggal ?? []),
                    datasets: [{
                        label: 'Jumlah Antrian',
                        data: @json($grafikData ?? []),
                        borderColor: 'rgba(255, 255, 255, 1)',
                        backgroundColor: 'rgba(255, 255, 255, 0.2)',
                        pointBackgroundColor: 'rgba(255, 255, 255, 1)',
                        borderWidth: 2,
                        tension: 0.3,
                        fill: true
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false,
                    plugins: {
                        legend: { display: false },
                        tooltip: { backgroundColor: 'rgba(0,0,0,0.7)', titleColor: '#fff', bodyColor: '#fff' }
                    },
                    scales: {
                        x: { 
                            grid: { display: false, drawBorder: false }, 
                            ticks: { color: 'rgba(255,255,255,0.8)' } 
                        },
                        y: { 
                            grid: { color: 'rgba(255,255,255,0.2)', tickColor: 'transparent' }, 
                            ticks: { color: 'rgba(255,255,255,0.8)', stepSize: 1, precision: 0 },
                            beginAtZero: true
                        }
                    }
                }
            });
        });
    </script>
</x-app-layout>
