<aside :class="sidebarOpen ? 'w-[230px] translate-x-0' : '-translate-x-full md:translate-x-0 md:w-[64px] lg:w-[230px]'"
    class="fixed md:relative inset-y-0 left-0 flex flex-col bg-[#222d32] text-white transition-all duration-300 ease-in-out flex-shrink-0 min-h-screen shadow-2xl md:shadow-none"
    style="z-index: 10000 !important;">

    <!-- Branding -->
    <div class="flex items-center justify-center h-[60px] bg-[#e08e0b] shadow-sm px-4">
        <a href="{{ route('admin.dashboard') }}"
            class="flex items-center space-x-2 text-white font-bold text-lg overflow-hidden" x-show="sidebarOpen">
            <img src="{{ asset('img/logo_silamo_bejango.png') }}" alt="Logo" class="h-[55px] w-auto">
            <b class="font-extrabold tracking-wide whitespace-nowrap">SILAMO BEJANGO</b>
        </a>
    </div>

    <!-- User Panel -->
    <div class="flex items-center py-4 px-3 border-transparent" x-show="sidebarOpen">
        <div
            class="w-10 h-10 rounded-full bg-[#f39c12] flex items-center justify-center font-bold text-white text-lg shrink-0">
            {{ substr(Auth::user()->name, 0, 1) }}
        </div>
        <div class="ml-3 overflow-hidden text-left pl-1">
            <p class="text-sm font-semibold text-white whitespace-nowrap overflow-hidden text-ellipsis m-0">
                {{ Auth::user()->name }}</p>
            <p class="text-[11px] text-[#4ae387] mt-1 flex items-center m-0">
                <i class="fa-solid fa-circle text-[8px] mr-1 shadow-sm"></i> Online
            </p>
        </div>
    </div>

    <!-- Search Form -->
    <div class="px-3 pb-3" x-show="sidebarOpen">
        <div class="flex">
            <input type="text" placeholder="Search..."
                class="w-full bg-[#374850] text-[#fff] placeholder-[#999] border-none rounded-l-sm px-3 py-2 text-sm focus:ring-0 focus:bg-white focus:text-[#666] transition-colors focus:placeholder-[#999]">
            <button
                class="bg-[#374850] text-[#999] rounded-r-sm px-3 hover:text-white transition-colors border-none group">
                <i class="fa-solid fa-magnifying-glass"></i>
            </button>
        </div>
    </div>

    <!-- Navigation Area -->
    <div class="flex-1 overflow-y-auto custom-scrollbar" x-show="sidebarOpen">
        <p class="px-4 py-3 text-[12px] font-semibold text-[#4b646f] bg-[#1a2226] uppercase m-0 tracking-wider">MAIN
            NAVIGATION</p>
        <nav class="space-y-0">
            <a href="{{ route('admin.dashboard') }}"
                class="flex items-center px-4 py-3 text-sm transition-colors {{ request()->routeIs('admin.dashboard') ? 'bg-[#1e282c] border-l-[3px] border-[#f39c12] text-white' : 'text-[#b8c7ce] hover:text-white hover:bg-[#1e282c] border-l-[3px] border-transparent' }}">
                <i
                    class="fa-solid fa-gauge-high w-6 text-left text-lg {{ request()->routeIs('admin.dashboard') ? 'text-[#f39c12]' : '' }}"></i>
                <span class="ml-2 font-medium">Dashboard</span>
            </a>

            <a href="{{ route('admin.antrian.index') }}"
                class="flex items-center px-4 py-3 text-sm transition-colors {{ request()->routeIs('admin.antrian.*') ? 'bg-[#1e282c] border-l-[3px] border-[#f39c12] text-white' : 'text-[#b8c7ce] hover:text-white hover:bg-[#1e282c] border-l-[3px] border-transparent' }}">
                <i
                    class="fa-solid fa-list-check w-6 text-left text-lg {{ request()->routeIs('admin.antrian.*') ? 'text-[#f39c12]' : '' }}"></i>
                <span class="ml-2 font-medium">Data Antrian</span>
            </a>

            <a href="{{ route('admin.warga-binaan.index') }}"
                class="flex items-center px-4 py-3 text-sm transition-colors {{ request()->routeIs('admin.warga-binaan.*') ? 'bg-[#1e282c] border-l-[3px] border-[#f39c12] text-white' : 'text-[#b8c7ce] hover:text-white hover:bg-[#1e282c] border-l-[3px] border-transparent' }}">
                <i
                    class="fa-solid fa-users w-6 text-left text-lg {{ request()->routeIs('admin.warga-binaan.*') ? 'text-[#f39c12]' : '' }}"></i>
                <span class="ml-2 font-medium">Warga Binaan</span>
            </a>

            <a href="{{ route('admin.sesi.index') }}"
                class="flex items-center px-4 py-3 text-sm transition-colors {{ request()->routeIs('admin.sesi.*') ? 'bg-[#1e282c] border-l-[3px] border-[#f39c12] text-white' : 'text-[#b8c7ce] hover:text-white hover:bg-[#1e282c] border-l-[3px] border-transparent' }}">
                <i
                    class="fa-regular fa-calendar-days w-6 text-left text-lg {{ request()->routeIs('admin.sesi.*') ? 'text-[#f39c12]' : '' }}"></i>
                <span class="ml-2 font-medium">Pengaturan Sesi</span>
            </a>

            <a href="{{ route('admin.users.index') }}"
                class="flex items-center px-4 py-3 text-sm transition-colors {{ request()->routeIs('admin.users.*') ? 'bg-[#1e282c] border-l-[3px] border-[#f39c12] text-white' : 'text-[#b8c7ce] hover:text-white hover:bg-[#1e282c] border-l-[3px] border-transparent' }}">
                <i
                    class="fa-solid fa-users-gear w-6 text-left text-lg {{ request()->routeIs('admin.users.*') ? 'text-[#f39c12]' : '' }}"></i>
                <span class="ml-2 font-medium">Manajemen Admin</span>
            </a>

            <a href="{{ route('admin.laporan.index') }}"
                class="flex items-center px-4 py-3 text-sm transition-colors {{ request()->routeIs('admin.laporan.*') ? 'bg-[#1e282c] border-l-[3px] border-[#f39c12] text-white' : 'text-[#b8c7ce] hover:text-white hover:bg-[#1e282c] border-l-[3px] border-transparent' }}">
                <i
                    class="fa-solid fa-file-pdf w-6 text-left text-lg {{ request()->routeIs('admin.laporan.*') ? 'text-[#f39c12]' : '' }}"></i>
                <span class="ml-2 font-medium">Laporan</span>
            </a>

            <a href="{{ route('admin.informasi-sidang.index') }}"
                class="flex items-center px-4 py-3 text-sm transition-colors {{ request()->routeIs('admin.informasi-sidang.*') ? 'bg-[#1e282c] border-l-[3px] border-[#f39c12] text-white' : 'text-[#b8c7ce] hover:text-white hover:bg-[#1e282c] border-l-[3px] border-transparent' }}">
                <i
                    class="fa-solid fa-gavel w-6 text-left text-lg {{ request()->routeIs('admin.informasi-sidang.*') ? 'text-[#f39c12]' : '' }}"></i>
                <span class="ml-2 font-medium">Informasi Sidang</span>
            </a>

            <p
                class="px-4 py-3 text-[12px] font-semibold text-[#4b646f] bg-[#1a2226] uppercase mt-0 mb-0 tracking-wider">
                LABELS</p>
            <a href="{{ route('admin.antrian.display') }}" target="_blank"
                class="flex items-center px-4 py-3 text-sm text-[#b8c7ce] hover:text-white hover:bg-[#1e282c] transition-colors border-l-[3px] border-transparent">
                <i class="fa-regular fa-circle text-green-500 w-6 text-left text-sm"></i>
                <span class="ml-2">Display TV</span>
            </a>
            <a href="{{ route('home') }}" target="_blank"
                class="flex items-center px-4 py-3 text-sm text-[#b8c7ce] hover:text-white hover:bg-[#1e282c] transition-colors border-l-[3px] border-transparent">
                <i class="fa-regular fa-circle text-[#00c0ef] w-6 text-left text-sm"></i>
                <span class="ml-2">Web Publik</span>
            </a>
            <form method="POST" action="{{ route('logout') }}" class="block w-full m-0">
                @csrf
                <a href="{{ route('logout') }}" onclick="event.preventDefault(); this.closest('form').submit();"
                    class="flex items-center px-4 py-3 text-sm text-[#b8c7ce] hover:text-white hover:bg-[#1e282c] w-full transition-colors border-l-[3px] border-transparent">
                    <i class="fa-regular fa-circle text-[#dd4b39] w-6 text-left text-sm"></i>
                    <span class="ml-2">Logout</span>
                </a>
            </form>
        </nav>
    </div>
</aside>
