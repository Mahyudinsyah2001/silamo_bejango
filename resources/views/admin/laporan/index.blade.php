<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <i class="fa-solid fa-file-invoice mr-2 text-[#f39c12]"></i>
            {{ __('Cetak Laporan Antrian & Kunjungan') }}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow border-t-[3px] border-t-[#f39c12] rounded-sm p-8">
                
                @if ($errors->any())
                    <div class="mb-6 bg-[#f2dede] border border-[#ebccd1] text-[#a94442] px-4 py-3 rounded-sm relative text-sm">
                        <ul class="list-disc pl-5">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif

                <div class="flex items-start mb-8 text-[#555]">
                    <div class="bg-[#f3f4f6] p-4 rounded-sm mr-4">
                        <i class="fa-solid fa-circle-info text-[#3c8dbc] text-xl"></i>
                    </div>
                    <div>
                        <h4 class="font-bold text-lg mb-1">Filter Laporan</h4>
                        <p class="text-sm">Silakan pilih rentang tanggal kunjungan yang ingin Anda rekap. Laporan dapat diekspor ke format PDF untuk dicetak atau Excel untuk pengolahan data lebih lanjut.</p>
                    </div>
                </div>
                
                <form action="{{ route('admin.laporan.export-pdf') }}" method="POST" id="formLaporan" class="space-y-6">
                    @csrf
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-8 mb-4">
                        <div class="relative">
                            <label class="block text-gray-700 font-bold mb-2 uppercase text-xs tracking-wider">
                                <i class="fa-regular fa-calendar-check mr-1"></i> Dari Tanggal
                            </label>
                            <input type="date" name="dari_tanggal" class="w-full border-gray-300 rounded-sm shadow-sm focus:border-[#3c8dbc] focus:ring-0 text-sm" required value="{{ old('dari_tanggal', date('Y-m-d')) }}">
                        </div>
                        <div class="relative">
                            <label class="block text-gray-700 font-bold mb-2 uppercase text-xs tracking-wider">
                                <i class="fa-regular fa-calendar-xmark mr-1"></i> Sampai Tanggal
                            </label>
                            <input type="date" name="sampai_tanggal" class="w-full border-gray-300 rounded-sm shadow-sm focus:border-[#3c8dbc] focus:ring-0 text-sm" required value="{{ old('sampai_tanggal', date('Y-m-d')) }}">
                        </div>
                    </div>
                    
                    <div class="flex flex-col sm:flex-row gap-4 pt-6 border-t border-gray-100">
                        <button type="submit" onclick="document.getElementById('formLaporan').action='{{ route('admin.laporan.export-pdf') }}'" class="bg-[#dd4b39] border-[#d73925] text-white px-6 py-3 rounded-sm hover:bg-[#d73925] flex items-center justify-center font-bold text-sm shadow-sm transition-colors flex-1 uppercase">
                            <i class="fa-solid fa-file-pdf mr-2 text-lg"></i>
                            Download PDF
                        </button>
                        
                        <button type="submit" onclick="document.getElementById('formLaporan').action='{{ route('admin.laporan.export-excel') }}'" class="bg-[#00a65a] border-[#008d4c] text-white px-6 py-3 rounded-sm hover:bg-[#008d4c] flex items-center justify-center font-bold text-sm shadow-sm transition-colors flex-1 uppercase">
                            <i class="fa-solid fa-file-excel mr-2 text-lg"></i>
                            Download EXCEL
                        </button>
                    </div>
                </form>
            </div>

            <div class="mt-8 grid grid-cols-1 md:grid-cols-2 gap-4">
                <div class="bg-white p-4 shadow-sm border-l-4 border-l-[#3c8dbc] text-sm">
                    <p class="font-bold text-[#3c8dbc] mb-1">Tips Laporan PDF</p>
                    <p class="text-gray-600">Gunakan format PDF untuk lampiran fisik atau arsip yang tidak bisa diubah.</p>
                </div>
                <div class="bg-white p-4 shadow-sm border-l-4 border-l-[#00a65a] text-sm">
                    <p class="font-bold text-[#00a65a] mb-1">Tips Laporan Excel</p>
                    <p class="text-gray-600">Gunakan format Excel jika Anda ingin melakukan filter data atau menghitung total pengunjung di aplikasi spreadsheet.</p>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
