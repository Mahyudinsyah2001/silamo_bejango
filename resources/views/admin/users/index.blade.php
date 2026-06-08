<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <i class="fa-solid fa-users-gear mr-2 text-[#f39c12]"></i>
            {{ __('Manajemen Admin') }}
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

                @if(session('error'))
                    <div class="mb-4 bg-[#f2dede] border border-[#ebccd1] text-[#a94442] px-4 py-3 rounded relative text-sm">
                        <i class="fa-solid fa-triangle-exclamation mr-1"></i> {{ session('error') }}
                    </div>
                @endif
                
                <div class="flex justify-between items-center mb-6">
                    <h3 class="text-lg font-bold text-gray-700 uppercase tracking-tight">Daftar Akun Admin</h3>
                    <a href="{{ route('admin.users.create') }}" 
                       class="bg-[#00a65a] text-white px-4 py-2 rounded-sm hover:bg-[#008d4c] font-bold text-xs uppercase tracking-wide shadow-sm flex items-center transition-colors">
                        <i class="fa-solid fa-user-plus mr-2"></i> TAMBAH ADMIN
                    </a>
                </div>

                <div class="overflow-x-auto border border-gray-100 rounded-sm">
                    <table class="min-w-full text-left text-sm">
                        <thead class="bg-gray-50 border-b-2 border-gray-200">
                            <tr>
                                <th class="px-4 py-4 font-bold text-gray-700 uppercase tracking-tight">Identitas</th>
                                <th class="px-4 py-4 font-bold text-gray-700 uppercase tracking-tight w-[180px]">Email</th>
                                <th class="px-4 py-4 font-bold text-gray-700 uppercase tracking-tight w-[120px]">Role</th>
                                <th class="px-4 py-4 font-bold text-gray-700 uppercase tracking-tight w-[180px]">Dibuat Pada</th>
                                <th class="px-4 py-4 font-bold text-gray-700 uppercase tracking-tight text-center w-[120px]">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100 bg-white text-gray-600 font-medium">
                            @foreach($users as $user)
                            <tr class="hover:bg-gray-50/50 transition-colors">
                                <td class="px-4 py-3">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 rounded-full bg-gray-100 border border-gray-200 flex items-center justify-center mr-3 text-[#f39c12] font-bold">
                                            {{ substr($user->name, 0, 1) }}
                                        </div>
                                        <div>
                                            <span class="block text-gray-800 font-bold">{{ $user->name }}</span>
                                            @if($user->id === auth()->id())
                                                <span class="text-[10px] bg-blue-100 text-blue-600 px-1 rounded font-bold uppercase">Saya</span>
                                            @endif
                                        </div>
                                    </div>
                                </td>
                                <td class="px-4 py-3 text-gray-500">{{ $user->email }}</td>
                                <td class="px-4 py-3">
                                    <span class="px-2 py-0.5 bg-gray-100 border border-gray-200 rounded text-[10px] text-gray-500 font-bold uppercase tracking-tighter">{{ $user->role ?? 'Admin' }}</span>
                                </td>
                                <td class="px-4 py-3 text-gray-400 text-xs italic">{{ $user->created_at->format('d/m/Y H:i') }}</td>
                                <td class="px-4 py-3">
                                    <div class="flex justify-center items-center gap-1.5">
                                        <a href="{{ route('admin.users.edit', $user) }}" class="w-8 h-8 flex items-center justify-center bg-[#f39c12] text-white rounded-sm hover:bg-[#e08e0b] shadow-sm transition-all" title="Edit">
                                            <i class="fa-solid fa-edit text-xs"></i>
                                        </a>
                                        @if($user->id !== auth()->id())
                                        <form action="{{ route('admin.users.destroy', $user) }}" method="POST" onsubmit="return confirm('Hapus akun admin ini?')" class="inline">
                                            @csrf @method('DELETE')
                                            <button type="submit" class="w-8 h-8 flex items-center justify-center bg-[#dd4b39] text-white rounded-sm hover:bg-[#d73925] shadow-sm transition-all" title="Hapus">
                                                <i class="fa-solid fa-trash text-xs"></i>
                                            </button>
                                        </form>
                                        @else
                                        <button class="w-8 h-8 flex items-center justify-center bg-gray-200 text-gray-400 rounded-sm cursor-not-allowed" title="Tidak bisa hapus sendiri">
                                            <i class="fa-solid fa-trash text-xs"></i>
                                        </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>

                <div class="mt-6 pt-4 border-t border-gray-100">
                    {{ $users->links() }}
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
