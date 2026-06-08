<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <i class="fa-solid fa-gavel mr-2 text-[#f39c12]"></i>
            {{ __('Informasi Sidang') }}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow border-t-[3px] border-t-[#f39c12] rounded-sm p-8">
                
                @if (session('success'))
                    <div class="mb-6 bg-[#dff0d8] border border-[#d6e9c6] text-[#3c763d] px-4 py-3 rounded-sm relative text-sm">
                        {{ session('success') }}
                    </div>
                @endif

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
                        <h4 class="font-bold text-lg mb-1">Upload Informasi Sidang</h4>
                        <p class="text-sm">Silakan pilih file (PDF, Word, atau Excel) untuk diunggah. File ini akan otomatis menggantikan file sebelumnya jika ada, dan bisa diunduh oleh pengunjung di halaman utama.</p>
                    </div>
                </div>

                <div class="mb-8">
                    @if($informasi)
                        <div class="p-4 bg-blue-50 border border-blue-100 rounded-sm mb-4">
                            <p class="text-sm text-blue-800 font-semibold mb-2">File Saat Ini:</p>
                            <div class="flex items-center justify-between">
                                <span class="text-gray-700 break-all font-medium"><i class="fa-solid fa-file mr-2 text-blue-500"></i> {{ $informasi->original_name }}</span>
                                <div class="flex gap-2 ml-4">
                                    <a href="{{ Storage::url($informasi->file_path) }}" target="_blank" class="text-xs bg-blue-500 hover:bg-blue-600 text-white px-3 py-2 rounded font-bold shadow-sm">Lihat</a>
                                    <form action="{{ route('admin.informasi-sidang.destroy', $informasi->id) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus file ini?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="text-xs bg-red-500 hover:bg-red-600 text-white px-3 py-2 rounded font-bold shadow-sm">Hapus</button>
                                    </form>
                                </div>
                            </div>
                            <p class="text-xs text-gray-500 mt-2">Diunggah pada: {{ $informasi->created_at->format('d M Y H:i') }}</p>
                        </div>
                    @else
                        <div class="p-4 bg-gray-50 border border-gray-200 rounded-sm mb-4 text-center">
                            <p class="text-sm text-gray-500">Belum ada file Informasi Sidang yang diunggah.</p>
                        </div>
                    @endif
                </div>
                
                <form action="{{ route('admin.informasi-sidang.store') }}" method="POST" enctype="multipart/form-data" class="space-y-6">
                    @csrf
                    <div>
                        <label class="block text-gray-700 font-bold mb-2 uppercase text-xs tracking-wider">
                            <i class="fa-solid fa-file-arrow-up mr-1"></i> Pilih File (PDF, DOC/DOCX, XLS/XLSX)
                        </label>
                        <input type="file" name="file_sidang" class="w-full border-gray-300 rounded-sm shadow-sm text-sm p-2 border bg-gray-50" required accept=".pdf,.doc,.docx,.xls,.xlsx">
                        <p class="text-xs text-gray-500 mt-1">Maksimal ukuran file: 10MB</p>
                    </div>
                    
                    <div class="pt-4 border-t border-gray-100">
                        <button type="submit" class="bg-[#00a65a] border-[#008d4c] text-white px-6 py-3 rounded-sm hover:bg-[#008d4c] flex items-center justify-center font-bold text-sm shadow-sm transition-colors uppercase w-full md:w-auto">
                            <i class="fa-solid fa-upload mr-2 text-lg"></i>
                            Upload File Baru
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</x-app-layout>
