<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <i class="fa-regular fa-clock mr-2 text-[#f39c12]"></i>
            {{ __('Manajemen Sesi') }}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow border-t-[3px] border-t-[#00c0ef] rounded-sm p-6">
                
                @if(session('success'))
                    <div class="mb-4 bg-[#dff0d8] border border-[#d6e9c6] text-[#3c763d] px-4 py-3 rounded relative text-sm">
                        <i class="fa-solid fa-check mr-1"></i> {{ session('success') }}
                    </div>
                @endif
                
                <div class="flex justify-between mb-6">
                    <h3 class="text-lg font-bold text-[#333] hidden sm:block">Daftar Sesi Kunjungan</h3>
                    <a href="{{ route('admin.sesi.create') }}" class="bg-[#00c0ef] border-[#00acd6] text-white px-4 py-2 rounded-sm hover:bg-[#00acd6] font-bold text-sm shadow-sm ring-1 ring-[#00acd6]">
                        <i class="fa-solid fa-plus mr-1"></i> TAMBAH SESI
                    </a>
                </div>

                <div class="overflow-x-auto">
                    <table class="min-w-full text-left text-sm border border-[#f4f4f4]">
                        <thead class="bg-[#f9f9f9] border-b border-[#f4f4f4]">
                            <tr>
                                <th class="px-4 py-3 font-bold text-[#333]">NAMA SESI</th>
                                <th class="px-4 py-3 font-bold text-[#333]">JAM MULAI</th>
                                <th class="px-4 py-3 font-bold text-[#333]">JAM SELESAI</th>
                                <th class="px-4 py-3 font-bold text-[#333]">KUOTA / HARI</th>
                                <th class="px-4 py-3 font-bold text-[#333]">AKSI</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-[#f4f4f4] text-[#555]">
                            @foreach($sesis as $sesi)
                            <tr class="hover:bg-[#f5f5f5]">
                                <td class="px-4 py-3 font-bold text-[#3c8dbc]">{{ $sesi->nama_sesi }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($sesi->jam_mulai)->format('H:i') }}</td>
                                <td class="px-4 py-3">{{ \Carbon\Carbon::parse($sesi->jam_selesai)->format('H:i') }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 bg-yellow-100 text-yellow-800 rounded border border-yellow-200 font-bold text-xs">{{ $sesi->kuota }}</span>
                                </td>
                                <td class="px-4 py-3 flex space-x-2">
                                    <a href="{{ route('admin.sesi.edit', $sesi) }}" class="bg-[#f39c12] border-[#e08e0b] text-white px-2 py-1 rounded-sm text-xs hover:bg-[#e08e0b] shadow-sm">
                                        <i class="fa-solid fa-pen-to-square"></i>
                                    </a>
                                    <form action="{{ route('admin.sesi.destroy', $sesi) }}" method="POST" onsubmit="return confirm('Hapus sesi ini?')">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="bg-[#dd4b39] border-[#d73925] text-white px-2 py-1 rounded-sm text-xs hover:bg-[#d73925] shadow-sm">
                                            <i class="fa-solid fa-trash"></i>
                                        </button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                            @if($sesis->isEmpty())
                            <tr>
                                <td colspan="5" class="px-4 py-8 text-center text-[#777] italic">Belum ada data sesi kunjungan.</td>
                            </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
                <div class="mt-4">
                    {{ $sesis->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
