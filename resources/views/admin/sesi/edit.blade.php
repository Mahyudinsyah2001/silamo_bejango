<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Edit Sesi') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                
                <form action="{{ route('admin.sesi.update', $sesi) }}" method="POST" class="space-y-4">
                    @csrf @method('PUT')
                    <div>
                        <label class="block text-gray-700 font-bold mb-1">Nama Sesi <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_sesi" class="w-full border-gray-300 rounded shadow-sm" required value="{{ old('nama_sesi', $sesi->nama_sesi) }}">
                        @error('nama_sesi') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-1">Jam Mulai <span class="text-red-500">*</span></label>
                        <input type="time" name="jam_mulai" class="w-full border-gray-300 rounded shadow-sm" required value="{{ old('jam_mulai', \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i')) }}">
                        @error('jam_mulai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-1">Jam Selesai <span class="text-red-500">*</span></label>
                        <input type="time" name="jam_selesai" class="w-full border-gray-300 rounded shadow-sm" required value="{{ old('jam_selesai', \Carbon\Carbon::parse($sesi->jam_selesai)->format('H:i')) }}">
                        @error('jam_selesai') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div>
                        <label class="block text-gray-700 font-bold mb-1">Kuota per Hari <span class="text-red-500">*</span></label>
                        <input type="number" name="kuota" class="w-full border-gray-300 rounded shadow-sm" required value="{{ old('kuota', $sesi->kuota) }}" min="1">
                        @error('kuota') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    <div class="flex justify-end space-x-2 pt-4">
                        <a href="{{ route('admin.sesi.index') }}" class="bg-gray-300 text-gray-700 px-4 py-2 rounded">Batal</a>
                        <button type="submit" class="bg-indigo-600 text-white px-4 py-2 rounded">Update Sesi</button>
                    </div>
                </form>
                
            </div>
        </div>
    </div>
</x-app-layout>
