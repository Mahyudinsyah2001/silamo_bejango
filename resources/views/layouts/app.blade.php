<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-[#ecf0f5]">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'SILAMO BEJANGO') }}</title>
    <link href="https://fonts.googleapis.com/css2?family=Source+Sans+Pro:wght@300;400;600;700&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <!-- Favicon -->
    <link rel="icon" type="image/png" href="{{ asset('img/logo_silamo_bejango.png') }}">
    <style>
        body {
            font-family: 'Source Sans Pro', sans-serif;
        }
        /* Dark Mode Overrides */
        html.dark-mode, html.dark-mode body, html.dark-mode .bg-\[\#ecf0f5\] {
            background-color: #1a2226 !important;
        }
        html.dark-mode .text-\[\#333\], html.dark-mode .text-gray-800, html.dark-mode .text-gray-900 {
            color: #d1d5db !important;
        }
        html.dark-mode .text-\[\#777\], html.dark-mode .text-gray-600, html.dark-mode .text-gray-500 {
            color: #9ca3af !important;
        }
        html.dark-mode .bg-white {
            background-color: #222d32 !important;
            border-color: #374850 !important;
            color: #d1d5db !important;
        }
        html.dark-mode .border-gray-200, html.dark-mode .border-gray-300, html.dark-mode .border-b {
            border-color: #374850 !important;
        }
        html.dark-mode .bg-gray-50, html.dark-mode .bg-gray-100, html.dark-mode .hover\:bg-gray-50:hover, html.dark-mode .hover\:bg-gray-100:hover {
            background-color: #2c3b41 !important;
        }
        html.dark-mode input, html.dark-mode select, html.dark-mode textarea {
            background-color: #374850 !important;
            color: #d1d5db !important;
            border-color: #1a2226 !important;
        }
        html.dark-mode input::placeholder, html.dark-mode textarea::placeholder {
            color: #9ca3af !important;
        }
        html.dark-mode .shadow-sm, html.dark-mode .shadow, html.dark-mode .shadow-md {
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.5), 0 2px 4px -1px rgba(0, 0, 0, 0.3) !important;
        }
    </style>
    <script>
        // Apply dark mode immediately to prevent flash of light content
        if (localStorage.getItem('darkMode') === 'yes') {
            document.documentElement.classList.add('dark-mode');
        }
    </script>
</head>

<body class="font-sans antialiased h-full overflow-hidden text-[#333]" x-data="{ sidebarOpen: window.innerWidth > 768 }">
    <div class="flex h-screen bg-[#ecf0f5]">
        <!-- Mobile Sidebar Backdrop -->
        <div x-show="sidebarOpen && window.innerWidth < 768" @click="sidebarOpen = false"
            class="fixed inset-0 bg-black/50 z-[90] md:hidden transition-opacity duration-300"
            x-transition:enter="opacity-0" x-transition:enter-end="opacity-100" x-transition:leave="opacity-100"
            x-transition:leave-end="opacity-0">
        </div>

        <!-- Sidebar -->
        @include('layouts.navigation')

        <!-- Main Content Container -->
        <div class="flex-1 flex flex-col transition-all duration-300 relative w-full overflow-visible">

            <!-- Navbar (Header) -->
            <header
                class="relative bg-[#f39c12] text-white flex items-center justify-between h-[50px] shadow-sm transition-colors"
                style="z-index: 9999 !important;">
                <div class="flex items-center h-full">
                    <button @click="sidebarOpen = !sidebarOpen"
                        class="text-white hover:bg-[#e08e0b] px-4 h-full flex items-center justify-center transition-colors focus:outline-none">
                        <i class="fa-solid fa-bars fa-lg"></i>
                    </button>
                </div>

                <div class="flex items-center h-full">
                    <!-- Dark Mode Toggle Button -->
                    <button onclick="toggleDarkMode()" id="darkModeBtn"
                        class="text-white hover:bg-[#e08e0b] px-4 h-[50px] flex items-center justify-center transition-colors focus:outline-none">
                        <i class="fa-solid fa-moon text-lg" id="darkModeIcon"></i>
                    </button>

                    <div class="relative px-2" x-data="{ open: false }" @click.outside="open = false">
                        <button @click="open = !open"
                            class="flex items-center hover:bg-[#e08e0b] px-3 h-[50px] transition duration-200">
                            <div
                                class="w-7 h-7 rounded-full bg-white text-[#f39c12] flex items-center justify-center font-bold mr-2 text-xs shadow-sm">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span class="text-sm font-semibold hidden sm:inline">{{ Auth::user()->name }}</span>
                            <svg class="ml-1 w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <div x-show="open" x-transition:enter="transition ease-out duration-150"
                            x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                            x-transition:leave="transition ease-in duration-75"
                            x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                            class="absolute right-0 top-full w-72 rounded-b shadow-xl border-none pointer-events-auto"
                            style="display: none; z-index: 1000000 !important;">
                            <!-- Header Dropdown (Kembali ke Desain Awal) -->
                            <div class="bg-[#f39c12] text-white text-center px-4 py-5 rounded-t-sm shadow-inner">
                                <div
                                    class="w-20 h-20 rounded-full bg-white text-[#f39c12] flex items-center justify-center font-bold text-4xl mx-auto mb-3 shadow-md border-4 border-white/20">
                                    {{ substr(Auth::user()->name, 0, 1) }}
                                </div>
                                <p class="font-bold text-lg leading-tight uppercase tracking-tight">
                                    {{ Auth::user()->name }}</p>
                                <small
                                    class="text-[10px] text-white/80 uppercase mt-1 tracking-[2px] font-semibold">{{ Auth::user()->role }}
                                    - Member</small>
                            </div>
                            <!-- Menu Items -->
                            <div
                                class="bg-[#f9f9f9] border-t border-gray-200 flex justify-between items-center px-4 py-3 rounded-b">
                                <a href="{{ route('profile.edit') }}"
                                    class="text-[11px] bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-sm hover:bg-gray-100 transition-all font-bold shadow-sm uppercase tracking-wide whitespace-nowrap">
                                    Profile
                                </a>
                                <form method="POST" action="{{ route('logout') }}" class="m-0">
                                    @csrf
                                    <button type="submit"
                                        class="text-[11px] bg-white border border-gray-300 text-gray-700 px-4 py-2 rounded-sm hover:bg-gray-100 transition-all font-bold shadow-sm uppercase tracking-wide whitespace-nowrap">
                                        Sign Out
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>
            </header>

            <!-- Breadcrumbs & Title Area -->
            @if (isset($header))
                <div class="px-4 pt-4 pb-2 flex flex-col sm:flex-row justify-between items-center bg-transparent mt-2">
                    <h1 class="text-2xl font-normal text-[#333] flex items-center m-0">
                        {{ $header }}
                    </h1>
                    <ol class="flex text-sm text-[#777] mt-2 sm:mt-0 font-medium bg-transparent rounded p-0 m-0">
                        <li class="flex items-center"><a href="#" class="hover:text-blue-600"><i
                                    class="fa-solid fa-gauge-high mr-1"></i> Home</a></li>
                        <li class="mx-2">></li>
                        <li class="text-[#777]">Dashboard</li>
                    </ol>
                </div>
            @endif

            <!-- Page Content -->
            <main class="relative flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-6 text-[#333] pb-20 custom-scrollbar"
                style="z-index: 1 !important;">
                <div x-data="{ pageAnim: false }" x-init="setTimeout(() => pageAnim = true, 50)" x-show="pageAnim" 
                     x-transition:enter="transition-all ease-out duration-700" 
                     x-transition:enter-start="opacity-0 translate-y-4" 
                     x-transition:enter-end="opacity-100 translate-y-0"
                     class="w-full">
                    {{ $slot }}
                </div>
            </main>
        </div>
    </div>



    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Apply global responsive wrappers to all tables in admin to prevent overflow on mobile.
            const tables = document.querySelectorAll('main table');
            tables.forEach(table => {
                const parentClass = table.parentElement.className;
                if (!parentClass.includes('overflow-x-auto') && !table.closest('.table-responsive')) {
                    const wrapper = document.createElement('div');
                    wrapper.className = 'w-full overflow-x-auto block border-0 mb-4 rounded-sm';
                    table.parentNode.insertBefore(wrapper, table);
                    wrapper.appendChild(table);
                }
            });
        });

        // Dark Mode Logic
        function toggleDarkMode() {
            document.documentElement.classList.toggle('dark-mode');
            const isDark = document.documentElement.classList.contains('dark-mode');
            localStorage.setItem('darkMode', isDark ? 'yes' : 'no');
            updateDarkModeIcon(isDark);
        }

        function updateDarkModeIcon(isDark) {
            const icon = document.getElementById('darkModeIcon');
            if (icon) {
                if (isDark) {
                    icon.classList.remove('fa-moon');
                    icon.classList.add('fa-sun');
                } else {
                    icon.classList.remove('fa-sun');
                    icon.classList.add('fa-moon');
                }
            }
        }

        // Initialize icon on load
        document.addEventListener('DOMContentLoaded', function() {
            const isDark = document.documentElement.classList.contains('dark-mode');
            updateDarkModeIcon(isDark);
        });
    </script>
</body>

</html>
