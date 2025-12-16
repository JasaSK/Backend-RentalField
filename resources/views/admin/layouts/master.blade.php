<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

      

    <!-- Load Tailwind CSS and other styles -->
    @include('admin.layouts.head')

</head>

<body class="bg-gradient-to-br from-gray-50 to-gray-100 font-sans antialiased preload">
    <!-- Enhanced Loader -->
    <div id="page-loader" class="fixed inset-0 z-[9999] flex items-center justify-center">
        <div class="text-center">
            <!-- Enhanced Animated Logo -->
            <div class="logo-container mx-auto mb-8">
                <div class="logo-ring logo-ring-outer"></div>
                <div class="logo-ring logo-ring-middle"></div>
                <div class="logo-ring logo-ring-inner"></div>
                <div class="logo-core">
                    <span class="logo-text">EZ</span>
                </div>
            </div>

            <!-- Loading Text -->
            <div class="loading-text mb-4" id="loader-text">
                Memuat Dashboard
                <div class="loading-dots inline-flex ml-2">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            </div>

            <!-- Loading Progress -->
            <div class="loading-progress">
                <div id="loading-bar" class="loading-progress-bar"></div>
            </div>

            <!-- Loading Stats -->
            <div class="mt-6">
                <div class="flex justify-between text-xs text-gray-500 mb-1">
                    <span>System</span>
                    <span id="progress-percentage">0%</span>
                    <span>UI</span>
                </div>
                <div class="text-sm text-gray-600 loading-subtext mt-4">
                    <span id="loading-phase">Initializing...</span>
                </div>
            </div>
        </div>
    </div>

    <div class="flex min-h-screen">
        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed top-0 left-0 h-screen w-64 bg-gradient-to-b from-white to-gray-50 text-gray-800 flex flex-col border-r border-gray-200 shadow-xl
                   transform -translate-x-full lg:translate-x-0 transition-transform duration-300 ease-in-out z-40">
            <!-- Sidebar Header -->
            <div class="p-6 border-b border-gray-200 flex items-center justify-center">
                <div class="flex items-center gap-3">
                    <div
                        class="w-10 h-10 rounded-xl bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center shadow-lg">
                        <span class="text-white font-bold text-xl">EZ</span>
                    </div>
                    <div>
                        <span
                            class="text-2xl font-bold bg-gradient-to-r from-emerald-600 to-green-600 bg-clip-text text-transparent">EZFutsal</span>
                        <p class="text-xs text-gray-500 mt-1">Admin Panel</p>
                    </div>
                </div>
            </div>

            <!-- Navigation Menu -->
            <nav class="flex-1 p-4 space-y-2 overflow-y-auto">
                <!-- Dashboard -->
                <a href="{{ route('admin.dashboard') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                    {{ Route::is('admin.dashboard')
                        ? 'bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-lg'
                        : 'hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-700 hover:shadow-md text-gray-700' }}">
                    <div
                        class="p-2 rounded-lg {{ Route::is('admin.dashboard') ? 'bg-white/20' : 'bg-emerald-100 group-hover:bg-emerald-200' }}">
                        <svg class="w-5 h-5 {{ Route::is('admin.dashboard') ? 'text-white' : 'text-emerald-600 group-hover:text-emerald-700' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                            </path>
                        </svg>
                    </div>
                    <span class="font-medium">Dashboard</span>
                </a>

                <!-- Verify Ticket -->
                <a href="{{ route('admin.verify.ticket') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                    {{ Route::is('admin.verify.ticket')
                        ? 'bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-lg'
                        : 'hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-700 hover:shadow-md text-gray-700' }}">
                    <div
                        class="p-2 rounded-lg {{ Route::is('admin.verify.ticket') ? 'bg-white/20' : 'bg-emerald-100 group-hover:bg-emerald-200' }}">
                        <svg class="w-5 h-5 {{ Route::is('admin.verify.ticket') ? 'text-white' : 'text-emerald-600 group-hover:text-emerald-700' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Verify Ticket</span>
                </a>

                <!-- Banner -->
                <a href="{{ route('admin.banner') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                    {{ Route::is('admin.banner')
                        ? 'bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-lg'
                        : 'hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-700 hover:shadow-md text-gray-700' }}">
                    <div
                        class="p-2 rounded-lg {{ Route::is('admin.banner') ? 'bg-white/20' : 'bg-emerald-100 group-hover:bg-emerald-200' }}">
                        <svg class="w-5 h-5 {{ Route::is('admin.banner') ? 'text-white' : 'text-emerald-600 group-hover:text-emerald-700' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <span class="font-medium">Banner</span>
                </a>

                <!-- Kategori Gallery -->
                <a href="{{ route('admin.gallery-categories') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                    {{ Route::is('admin.gallery-categories')
                        ? 'bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-lg'
                        : 'hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-700 hover:shadow-md text-gray-700' }}">
                    <div
                        class="p-2 rounded-lg {{ Route::is('admin.gallery-categories') ? 'bg-white/20' : 'bg-emerald-100 group-hover:bg-emerald-200' }}">
                        <svg class="w-5 h-5 {{ Route::is('admin.gallery-categories') ? 'text-white' : 'text-emerald-600 group-hover:text-emerald-700' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <span class="font-medium">Kategori Gallery</span>
                </a>

                <!-- Gallery -->
                <a href="{{ route('admin.gallery') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                    {{ Route::is('admin.gallery')
                        ? 'bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-lg'
                        : 'hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-700 hover:shadow-md text-gray-700' }}">
                    <div
                        class="p-2 rounded-lg {{ Route::is('admin.gallery') ? 'bg-white/20' : 'bg-emerald-100 group-hover:bg-emerald-200' }}">
                        <svg class="w-5 h-5 {{ Route::is('admin.gallery') ? 'text-white' : 'text-emerald-600 group-hover:text-emerald-700' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                            </path>
                        </svg>
                    </div>
                    <span class="font-medium">Gallery</span>
                </a>

                <!-- Kategori Lapangan -->
                <a href="{{ route('admin.field-categories') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                    {{ Route::is('admin.field-categories')
                        ? 'bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-lg'
                        : 'hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-700 hover:shadow-md text-gray-700' }}">
                    <div
                        class="p-2 rounded-lg {{ Route::is('admin.field-categories') ? 'bg-white/20' : 'bg-emerald-100 group-hover:bg-emerald-200' }}">
                        <svg class="w-5 h-5 {{ Route::is('admin.field-categories') ? 'text-white' : 'text-emerald-600 group-hover:text-emerald-700' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10">
                            </path>
                        </svg>
                    </div>
                    <span class="font-medium">Kategori Lapangan</span>
                </a>

                <!-- Lapangan -->
                <a href="{{ route('admin.fields') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                    {{ Route::is('admin.fields')
                        ? 'bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-lg'
                        : 'hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-700 hover:shadow-md text-gray-700' }}">
                    <div
                        class="p-2 rounded-lg {{ Route::is('admin.fields') ? 'bg-white/20' : 'bg-emerald-100 group-hover:bg-emerald-200' }}">
                        <svg class="w-5 h-5 {{ Route::is('admin.fields') ? 'text-white' : 'text-emerald-600 group-hover:text-emerald-700' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                            </path>
                        </svg>
                    </div>
                    <span class="font-medium">Lapangan</span>
                </a>

                <!-- Refund -->
                <a href="{{ route('admin.refund') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                    {{ Route::is('admin.refund')
                        ? 'bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-lg'
                        : 'hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-700 hover:shadow-md text-gray-700' }}">
                    <div
                        class="p-2 rounded-lg {{ Route::is('admin.refund') ? 'bg-white/20' : 'bg-emerald-100 group-hover:bg-emerald-200' }}">
                        <svg class="w-5 h-5 {{ Route::is('admin.refund') ? 'text-white' : 'text-emerald-600 group-hover:text-emerald-700' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                            </path>
                        </svg>
                    </div>
                    <span class="font-medium">Refund</span>
                </a>

                <!-- Maintenance -->
                <a href="{{ route('admin.maintenance') }}"
                    class="group flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200
                    {{ Route::is('admin.maintenance')
                        ? 'bg-gradient-to-r from-emerald-500 to-green-600 text-white shadow-lg'
                        : 'hover:bg-gradient-to-r hover:from-emerald-50 hover:to-green-50 hover:text-emerald-700 hover:shadow-md text-gray-700' }}">
                    <div
                        class="p-2 rounded-lg {{ Route::is('admin.maintenance') ? 'bg-white/20' : 'bg-emerald-100 group-hover:bg-emerald-200' }}">
                        <svg class="w-5 h-5 {{ Route::is('admin.maintenance') ? 'text-white' : 'text-emerald-600 group-hover:text-emerald-700' }}"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                            </path>
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                        </svg>
                    </div>
                    <span class="font-medium">Maintenance</span>
                </a>

                <!-- Logout -->
                <form action="{{ route('logout') }}" method="POST" class="block logout mt-8">
                    @csrf
                    <button type="submit"
                        class="group w-full flex items-center gap-3 px-4 py-3 rounded-xl transition-all duration-200 hover:bg-gradient-to-r hover:from-red-50 hover:to-rose-50 hover:text-red-700 hover:shadow-md text-gray-700">
                        <div class="p-2 rounded-lg bg-red-100 group-hover:bg-red-200">
                            <svg class="w-5 h-5 text-red-600 group-hover:text-red-700" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1">
                                </path>
                            </svg>
                        </div>
                        <span class="font-medium">Logout</span>
                    </button>
                </form>
            </nav>

            <!-- Sidebar Footer -->
            <div
                class="p-4 border-t border-gray-200 text-center text-sm text-gray-500 bg-gradient-to-r from-gray-50 to-white">
                <p>&copy; 2025 EZFutsal</p>
                <p class="text-xs mt-1">Admin Panel v1.0</p>
            </div>
        </aside>

        <!-- Overlay -->
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30 lg:hidden"></div>

        <!-- Main Content -->
        <div class="lg:ml-64 flex-1 flex flex-col h-screen overflow-y-auto">

            <!-- Navbar -->
            <nav
                class="bg-gradient-to-r from-emerald-600 to-green-600 text-white py-4 px-6 flex justify-between items-center shadow-xl sticky top-0 z-50">
                <!-- Left Nav (Hamburger + Logo Mobile) -->
                <div class="flex items-center gap-3 lg:hidden">
                    <!-- Hamburger - Tambahkan z-index tinggi -->
                    <button id="hamburger"
                        class="text-white focus:outline-none focus:ring-2 focus:ring-white/30 rounded-lg p-2 relative z-60">
                        <!-- Hamburger Icon -->
                        <svg id="icon-hamburger" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 block"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>

                        <!-- Close Icon -->
                        <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 hidden"
                            fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Logo / Text -->
                    <div class="flex items-center gap-2 z-50">
                        <div class="w-8 h-8 rounded-lg bg-white/20 flex items-center justify-center">
                            <span class="text-white font-bold text-sm">EZ</span>
                        </div>
                        <span class="text-xl font-bold text-white">EZFutsal</span>
                    </div>
                </div>

                <!-- Right Section: User Profile -->
                <div class="ml-auto flex items-center gap-4">
                    {{-- <!-- Notifications (optional) -->
                    <button class="relative p-2 hover:bg-white/10 rounded-lg transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>
                        <span class="absolute top-1 right-1 w-2 h-2 bg-red-500 rounded-full"></span>
                    </button> --}}

                    <!-- User Profile -->
                    <div class="flex items-center gap-3 group relative cursor-pointer" id="user-menu">
                        <div class="text-right hidden lg:block">
                            <p class="font-semibold text-white">{{ Auth::user()->name }}</p>
                            <p class="text-sm text-white/80">{{ Auth::user()->role }}</p>
                        </div>
                        <div class="relative">
                            <div
                                class="w-12 h-12 bg-gradient-to-br from-emerald-500 to-green-400 rounded-full flex items-center justify-center shadow-lg border-2 border-white/30 group-hover:scale-105 transition-transform duration-200">
                                <span
                                    class="text-white font-bold text-xl">{{ strtoupper(substr(Auth::user()->name, 0, 1)) }}</span>
                            </div>
                            <div
                                class="absolute -bottom-1 -right-1 w-4 h-4 bg-emerald-400 rounded-full border-2 border-white">
                            </div>
                        </div>
                    </div>
                </div>
            </nav>


            <!-- Dynamic Content -->
            <main class="p-6 flex-1">
                @yield('content')
            </main>

            <!-- Footer -->
            <footer class="bg-gradient-to-r from-gray-50 to-white border-t border-gray-200 py-4 px-6">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <div class="text-gray-600 text-sm">
                        <p>© 2025 EZFutsal - Sistem Booking Lapangan Olahraga</p>
                        <p class="text-xs mt-1">Last updated: {{ now()->format('d M Y H:i') }}</p>
                    </div>
                    <div class="flex items-center gap-4 mt-2 md:mt-0">
                        <span class="text-xs text-gray-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                            </svg>
                            Response Time: <span class="font-medium text-emerald-600">Fast</span>
                        </span>
                        <span class="text-xs text-gray-500 flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Uptime: <span class="font-medium text-emerald-600">99.9%</span>
                        </span>
                    </div>
                </div>
            </footer>
        </div>
    </div>

    @include('admin.layouts.script')

    <!-- Enhanced Loader Script -->
    <script>
      
    </script>
</body>

</html>
