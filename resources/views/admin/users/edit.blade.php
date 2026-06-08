<x-app-layout>
    <x-slot name="header">
        <div class="flex items-center">
            <i class="fa-solid fa-user-edit mr-2 text-[#f39c12]"></i>
            {{ __('Edit Data Admin') }}
        </div>
    </x-slot>

    <div class="py-6">
        <div class="max-w-3xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow border-t-[3px] border-t-[#f39c12] rounded-sm">
                <div class="p-6">
                    <form method="POST" action="{{ route('admin.users.update', $user) }}">
                        @csrf
                        @method('PATCH')

                        <!-- Name -->
                        <div class="mb-5">
                            <label for="name" class="block text-xs font-bold text-gray-700 uppercase mb-2 tracking-wide">Nama Lengkap</label>
                            <input id="name" type="text" name="name" value="{{ old('name', $user->name) }}" required autofocus
                                class="w-full rounded-sm border-gray-300 shadow-sm focus:border-[#3c8dbc] focus:ring-0 text-sm">
                            @error('name') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Email Address -->
                        <div class="mb-5">
                            <label for="email" class="block text-xs font-bold text-gray-700 uppercase mb-2 tracking-wide">Alamat Email</label>
                            <input id="email" type="email" name="email" value="{{ old('email', $user->email) }}" required
                                class="w-full rounded-sm border-gray-300 shadow-sm focus:border-[#3c8dbc] focus:ring-0 text-sm">
                            @error('email') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <!-- Role -->
                        <div class="mb-5">
                            <label for="role" class="block text-xs font-bold text-gray-700 uppercase mb-2 tracking-wide">Role / Jabatan</label>
                            <select id="role" name="role" required
                                class="w-full rounded-sm border-gray-300 shadow-sm focus:border-[#3c8dbc] focus:ring-0 text-sm">
                                <option value="admin" {{ old('role', $user->role) == 'admin' ? 'selected' : '' }}>Admin (Full Access)</option>
                                <option value="operator" {{ old('role', $user->role) == 'operator' ? 'selected' : '' }}>Operator (Petugas)</option>
                                <option value="pimpinan" {{ old('role', $user->role) == 'pimpinan' ? 'selected' : '' }}>Pimpinan (View Only)</option>
                            </select>
                            @error('role') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                        </div>

                        <div class="bg-gray-50 p-4 border rounded-sm mb-8">
                            <h4 class="text-sm font-bold text-gray-700 mb-2 uppercase tracking-tight flex items-center">
                                <i class="fa-solid fa-lock mr-2 text-gray-400"></i> Ganti Password
                            </h4>
                            <p class="text-[11px] text-gray-500 mb-4 italic">Kosongkan jika tidak ingin mengubah password.</p>
                            
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-5">
                                <!-- Password -->
                                <div>
                                    <label for="password" class="block text-xs font-bold text-gray-700 uppercase mb-2 tracking-wide">Password Baru</label>
                                    <input id="password" type="password" name="password" autocomplete="new-password"
                                        class="w-full rounded-sm border-gray-300 shadow-sm focus:border-[#3c8dbc] focus:ring-0 text-sm">
                                    @error('password') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                                </div>

                                <!-- Confirm Password -->
                                <div>
                                    <label for="password_confirmation" class="block text-xs font-bold text-gray-700 uppercase mb-2 tracking-wide">Konfirmasi Password Baru</label>
                                    <input id="password_confirmation" type="password" name="password_confirmation"
                                        class="w-full rounded-sm border-gray-300 shadow-sm focus:border-[#3c8dbc] focus:ring-0 text-sm">
                                </div>
                            </div>
                        </div>

                        <div class="flex items-center justify-end gap-3 pt-4 border-t border-gray-100">
                            <a href="{{ route('admin.users.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-sm hover:bg-gray-200 font-bold text-xs uppercase tracking-wide transition-colors">
                                BATAL
                            </a>
                            <button type="submit" class="bg-[#f39c12] text-white px-6 py-2 rounded-sm hover:bg-[#e08e0b] font-bold text-xs uppercase tracking-wide shadow-md transition-colors">
                                UPDATE ADMIN
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
