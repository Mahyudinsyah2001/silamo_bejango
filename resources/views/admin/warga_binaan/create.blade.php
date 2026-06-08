<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Tambah Warga Binaan') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-4xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow border-t-[3px] border-t-[#00a65a] sm:rounded-sm p-6">
                
                <form action="{{ route('admin.warga-binaan.store') }}" method="POST" class="space-y-4">
                    @csrf
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        <!-- Kolom Kiri -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-1 border-b pb-1 text-sm text-[#00a65a]">Informasi Utama</label>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-1 text-sm">Nama Lengkap <span class="text-red-500">*</span></label>
                                <input type="text" name="nama" class="w-full border-gray-300 rounded shadow-sm text-sm focus:ring-0 focus:border-[#00a65a]" required value="{{ old('nama') }}">
                                @error('nama') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-1 text-sm">Nomor Registrasi</label>
                                <input type="text" name="no_registrasi" class="w-full border-gray-300 rounded shadow-sm text-sm focus:ring-0 focus:border-[#00a65a]" value="{{ old('no_registrasi') }}" placeholder="Biarkan kosong untuk auto-generate">
                                @error('no_registrasi') <span class="text-red-500 text-xs mt-1">{{ $message }}</span> @enderror
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-gray-700 font-bold mb-1 text-sm">Blok</label>
                                    <input type="text" name="blok" class="w-full border-gray-300 rounded shadow-sm text-sm focus:ring-0 focus:border-[#00a65a]" value="{{ old('blok') }}">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-bold mb-1 text-sm">Lokasi Sel</label>
                                    <input type="text" name="lokasi_sel" class="w-full border-gray-300 rounded shadow-sm text-sm focus:ring-0 focus:border-[#00a65a]" value="{{ old('lokasi_sel') }}">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-gray-700 font-bold mb-1 text-sm">Tgl Masuk UPT</label>
                                    <input type="date" name="tgl_msk_upt" class="w-full border-gray-300 rounded shadow-sm text-sm focus:ring-0 focus:border-[#00a65a]" value="{{ old('tgl_msk_upt') }}">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-bold mb-1 text-sm">Tgl Ekspirasi</label>
                                    <input type="date" name="tgl_ekspirasi" class="w-full border-gray-300 rounded shadow-sm text-sm focus:ring-0 focus:border-[#00a65a]" value="{{ old('tgl_ekspirasi') }}">
                                </div>
                            </div>
                        </div>

                        <!-- Kolom Kanan -->
                        <div class="space-y-4">
                            <div>
                                <label class="block text-gray-700 font-bold mb-1 border-b pb-1 text-sm text-[#00c0ef]">Data Alias & Nama Kecil</label>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-gray-700 font-bold mb-1 text-sm">Nm Alias 1</label>
                                    <input type="text" name="nm_alias_1" class="w-full border-gray-300 rounded shadow-sm text-sm focus:ring-0 focus:border-[#00c0ef]" value="{{ old('nm_alias_1') }}">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-bold mb-1 text-sm">Nm Kecil 1</label>
                                    <input type="text" name="nm_kecil_1" class="w-full border-gray-300 rounded shadow-sm text-sm focus:ring-0 focus:border-[#00c0ef]" value="{{ old('nm_kecil_1') }}">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-gray-700 font-bold mb-1 text-sm">Nm Alias 2</label>
                                    <input type="text" name="nm_alias_2" class="w-full border-gray-300 rounded shadow-sm text-sm focus:ring-0 focus:border-[#00c0ef]" value="{{ old('nm_alias_2') }}">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-bold mb-1 text-sm">Nm Kecil 2</label>
                                    <input type="text" name="nm_kecil_2" class="w-full border-gray-300 rounded shadow-sm text-sm focus:ring-0 focus:border-[#00c0ef]" value="{{ old('nm_kecil_2') }}">
                                </div>
                            </div>
                            <div class="grid grid-cols-2 gap-2">
                                <div>
                                    <label class="block text-gray-700 font-bold mb-1 text-sm">Nm Alias 3</label>
                                    <input type="text" name="nm_alias_3" class="w-full border-gray-300 rounded shadow-sm text-sm focus:ring-0 focus:border-[#00c0ef]" value="{{ old('nm_alias_3') }}">
                                </div>
                                <div>
                                    <label class="block text-gray-700 font-bold mb-1 text-sm">Nm Kecil 3</label>
                                    <input type="text" name="nm_kecil_3" class="w-full border-gray-300 rounded shadow-sm text-sm focus:ring-0 focus:border-[#00c0ef]" value="{{ old('nm_kecil_3') }}">
                                </div>
                            </div>
                            <div>
                                <label class="block text-gray-700 font-bold mb-1 text-sm">Keterangan Tambahan</label>
                                <textarea name="keterangan" class="w-full border-gray-300 rounded shadow-sm text-sm focus:ring-0 focus:border-[#00c0ef]" rows="1">{{ old('keterangan') }}</textarea>
                            </div>
                        </div>
                    </div>

                    <div class="flex justify-end space-x-2 pt-6 mt-6 border-t border-gray-100">
                        <a href="{{ route('admin.warga-binaan.index') }}" class="bg-gray-200 text-gray-700 px-5 py-2 rounded-sm text-sm font-bold shadow-sm hover:bg-gray-300 transition-colors">BATAL</a>
                        <button type="submit" class="bg-[#00a65a] text-white px-5 py-2 rounded-sm text-sm font-bold shadow-sm hover:bg-[#008d4c] transition-colors"><i class="fa-solid fa-save mr-2"></i> SIMPAN BARU</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</x-app-layout>
