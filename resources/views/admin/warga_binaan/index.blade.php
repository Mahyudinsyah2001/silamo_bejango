<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <i class="fa-solid fa-users-rectangle mr-2 text-[#f39c12]"></i>
            {{ __('Data Warga Binaan') }}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow border-t-[3px] border-t-[#00a65a] rounded-sm p-6">
                
                @if(session('success'))
                    <div class="mb-4 bg-[#dff0d8] border border-[#d6e9c6] text-[#3c763d] px-4 py-3 rounded relative text-sm">
                        <i class="fa-solid fa-check mr-1"></i> {{ session('success') }}
                    </div>
                @endif
                @if(session('error'))
                    <div class="mb-4 bg-[#f2dede] border border-[#ebccd1] text-[#a94442] px-4 py-3 rounded relative text-sm">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ session('error') }}
                    </div>
                @endif
                
                <div class="flex flex-col lg:flex-row justify-between items-center mb-6 gap-4" x-data="{ openImport: false }">
                    <!-- Sisi Kiri: Pencarian Standar AdminLTE -->
                    <form method="GET" action="{{ route('admin.warga-binaan.index') }}" class="flex items-center gap-0 w-full lg:w-auto">
                        <div class="relative flex-1 lg:flex-none">
                            <span class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none text-gray-400">
                                <i class="fa-solid fa-search text-xs"></i>
                            </span>
                            <input type="text" name="search" value="{{ request('search') }}" 
                                placeholder="Cari Nama / No. Reg..." 
                                class="rounded-l-sm border-gray-300 pl-9 py-2 text-sm focus:ring-0 focus:border-[#3c8dbc] w-full lg:w-64">
                        </div>
                        <button type="submit" class="bg-[#3c8dbc] border border-[#3c8dbc] text-white px-4 py-2 rounded-r-sm text-sm hover:bg-[#367fa9] font-bold shadow-sm transition-colors">
                            CARI
                        </button>
                    </form>

                    <!-- Sisi Kanan: Action Buttons -->
                    <div class="w-full lg:w-auto overflow-x-auto pb-2 custom-scrollbar mt-3 lg:mt-0">
                        <div class="flex flex-nowrap md:flex-wrap items-center gap-2 justify-start lg:justify-end w-max lg:w-auto min-w-full">
                        <a href="{{ route('admin.warga-binaan.create') }}" 
                           class="bg-[#00a65a] text-white px-3 py-2 rounded-sm hover:bg-[#008d4c] font-bold text-xs uppercase tracking-wide shadow-sm flex items-center transition-colors whitespace-nowrap">
                            <i class="fa-solid fa-plus-circle mr-1.5"></i> TAMBAH
                        </a>
                        <button @click="openImport = true" 
                           class="bg-[#00c0ef] text-white px-3 py-2 rounded-sm hover:bg-[#00acd6] font-bold text-xs uppercase tracking-wide shadow-sm flex items-center transition-colors whitespace-nowrap">
                            <i class="fa-solid fa-file-excel mr-1.5"></i> IMPORT
                        </button>
                        <a href="{{ route('admin.warga-binaan.template') }}" 
                           class="bg-[#f4f4f4] border border-gray-300 text-gray-700 px-3 py-2 rounded-sm hover:bg-gray-200 font-bold text-xs uppercase tracking-wide shadow-sm flex items-center transition-colors whitespace-nowrap">
                            <i class="fa-solid fa-download mr-1.5 text-gray-500"></i> TEMPLATE
                        </a>
                        <form action="{{ route('admin.warga-binaan.destroy-all') }}" method="POST" onsubmit="return confirm('PERINGATAN: Apakah Anda yakin ingin menghapus SELURUH data Warga Binaan?\n\nSemua riwayat dan data terkait mungkin akan terhapus dan tidak dapat dikembalikan.')" class="m-0 p-0 flex">
                            @csrf @method('DELETE')
                            <button type="submit" 
                               class="bg-[#dd4b39] border border-[#d33724] text-white px-3 py-2 rounded-sm hover:bg-[#d73925] font-bold text-xs uppercase tracking-wide shadow-sm flex items-center transition-colors whitespace-nowrap">
                                <i class="fa-solid fa-trash-can mr-1.5"></i> KOSONGKAN
                            </button>
                        </form>
                        </div>
                    </div>

                    <!-- Modal Import CSV (Pusat & Rapi) -->
                    <div x-show="openImport" 
                         class="fixed inset-0 z-[10000] flex items-center justify-center p-4 overflow-y-auto" 
                         x-transition:enter="transition ease-out duration-300"
                         x-transition:enter-start="opacity-0"
                         x-transition:enter-end="opacity-100"
                         x-cloak>
                        
                        <!-- Backdrop -->
                        <div class="fixed inset-0 bg-gray-900 opacity-60 transition-opacity" @click="openImport = false"></div>

                        <!-- Modal Content -->
                        <div class="relative bg-white rounded-md text-left overflow-hidden shadow-2xl transform transition-all sm:max-w-lg sm:w-full border-t-[5px] border-[#00c0ef] z-10"
                             x-transition:enter="transition ease-out duration-300"
                             x-transition:enter-start="opacity-0 scale-95"
                             x-transition:enter-end="opacity-100 scale-100">
                             
                            <form action="{{ route('admin.warga-binaan.import') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                <div class="p-8">
                                    <div class="flex items-center mb-4">
                                        <div class="w-10 h-10 bg-blue-50 rounded-full flex items-center justify-center mr-3">
                                            <i class="fa-solid fa-file-csv text-xl text-[#00c0ef]"></i>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-900 tracking-tight">Import Data Massal</h3>
                                    </div>
                                    
                                    <p class="text-sm text-gray-500 mb-6 italic bg-gray-50 p-4 border-l-4 border-blue-200 rounded-r-md">
                                        Pastikan kolom CSV berurutan lengkap sesuai template bawaan. Gunakan template yang tersedia jika ragu.
                                    </p>
                                    
                                    <div class="mb-4">
                                        <label class="block text-xs font-bold text-gray-700 uppercase mb-2">Pilih File Excel / CSV</label>
                                        <input type="file" name="csv_file" accept=".csv, application/vnd.openxmlformats-officedocument.spreadsheetml.sheet, application/vnd.ms-excel" required 
                                            class="block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-xs file:font-bold file:bg-[#00c0ef]/10 file:text-[#00c0ef] hover:file:bg-[#00c0ef]/20 border border-gray-200 p-2 rounded-md">
                                    </div>
                                </div>
                                
                                <div class="bg-gray-50 px-8 py-4 flex flex-row-reverse gap-3 border-t">
                                    <button type="submit" class="bg-[#00c0ef] text-white px-6 py-2.5 rounded-md text-sm font-bold shadow-md hover:bg-[#00acd6] transition-all">
                                        MULAI UNGGAH
                                    </button>
                                    <button type="button" @click="openImport = false" class="bg-white border border-gray-300 text-gray-600 px-6 py-2.5 rounded-md text-sm font-bold hover:bg-gray-50 transition-all">
                                        BATAL
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto border border-gray-100 rounded-sm">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-4 py-4 font-bold text-gray-700 uppercase tracking-tight w-[180px]">No. Registrasi</th>
                                <th class="px-4 py-4 font-bold text-gray-700 uppercase tracking-tight">Nama Lengkap</th>
                                <th class="px-4 py-4 font-bold text-gray-700 uppercase tracking-tight w-[160px]">Blok</th>
                                <th class="px-4 py-4 font-bold text-gray-700 uppercase tracking-tight w-[160px]">Lokasi Sel</th>
                                <th class="px-4 py-4 font-bold text-gray-700 uppercase tracking-tight text-center w-[120px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white text-gray-600 font-medium">
                            @foreach($wargaBinaans as $wb)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-4 py-3 font-bold text-[#3c8dbc]">{{ $wb->no_registrasi }}</td>
                                <td class="px-4 py-3 text-gray-800">{{ $wb->nama }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 bg-gray-100 border border-gray-200 rounded text-[10px] text-gray-500 font-bold uppercase tracking-tighter">{{ $wb->blok }}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-600 font-medium">{{ $wb->lokasi_sel ?? '-' }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center items-center gap-1.5">
                                        <a href="{{ route('admin.warga-binaan.edit', $wb) }}" class="w-8 h-8 flex items-center justify-center bg-[#f39c12] text-white rounded-sm hover:bg-[#e08e0b] shadow-sm transition-all" title="Edit">
                                            <i class="fa-solid fa-edit text-xs"></i>
                                        </a>
                                        <form action="{{ route('admin.warga-binaan.destroy', $wb) }}" method="POST" onsubmit="return confirm('Hapus data warga binaan ini?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-[#dd4b39] text-white rounded-sm hover:bg-[#d73925] shadow-sm transition-all" title="Hapus">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                            @if($wargaBinaans->isEmpty())
                            <tr>
                                <td colspan="5" class="px-6 py-12 text-center text-gray-400 italic bg-gray-50/30">Belum ada data warga binaan.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    {{ $wargaBinaans->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
