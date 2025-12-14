<!DOCTYPE html>
<html lang="id">
@include('admin.layouts.head')

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside id="sidebar"
            class="fixed top-0 left-0 h-screen w-60 bg-white text-gray-800 flex flex-col border-r border-gray-300
                   transform -translate-x-full lg:translate-x-0 transition-transform duration-300 z-40">
            <div class="p-6 border-b border-gray-300 flex items-center justify-center">
                <span class="text-2xl font-bold text-[#13810A]">EZFutsal</span>
            </div>

            <nav class="flex-1 p-6 space-y-3 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-2 rounded-lg transition flex items-center justify-center
                    {{ Route::is('admin.dashboard') ? 'bg-[#13810A] text-white' : 'hover:bg-[#13810A] hover:text-white text-gray-800' }}">
                    Dashboard
                </a>

                <a href="{{ route('admin.verify.ticket') }}"
                    class="block px-4 py-2 rounded-lg transition flex items-center justify-center
                    {{ Route::is('admin.verify.ticket') ? 'bg-[#13810A] text-white' : 'hover:bg-[#13810A] hover:text-white text-gray-800' }}">
                    Verify Ticket
                </a>

                <a href="{{ route('admin.banner') }}"
                    class="block px-4 py-2 rounded-lg transition flex items-center justify-center
                    {{ Route::is('admin.banner') ? 'bg-[#13810A] text-white' : 'hover:bg-[#13810A] hover:text-white text-gray-800' }}">
                    Banner
                </a>

                <a href="{{ route('admin.gallery-categories') }}"
                    class="block px-4 py-2 rounded-lg transition flex items-center justify-center
                    {{ Route::is('admin.gallery-categories') ? 'bg-[#13810A] text-white' : 'hover:bg-[#13810A] hover:text-white text-gray-800' }}">
                    Kategori Gallery
                </a>

                <a href="{{ route('admin.gallery') }}"
                    class="block px-4 py-2 rounded-lg transition flex items-center justify-center
                    {{ Route::is('admin.gallery') ? 'bg-[#13810A] text-white' : 'hover:bg-[#13810A] hover:text-white text-gray-800' }}">
                    Gallery
                </a>

                <a href="{{ route('admin.field-categories') }}"
                    class="block px-4 py-2 rounded-lg transition flex items-center justify-center
                    {{ Route::is('admin.field-categories') ? 'bg-[#13810A] text-white' : 'hover:bg-[#13810A] hover:text-white text-gray-800' }}">
                    Kategori Lapangan
                </a>

                <a href="{{ route('admin.fields') }}"
                    class="block px-4 py-2 rounded-lg transition flex items-center justify-center
                    {{ Route::is('admin.fields') ? 'bg-[#13810A] text-white' : 'hover:bg-[#13810A] hover:text-white text-gray-800' }}">
                    Lapangan
                </a>

                <a href="{{ route('admin.refund') }}"
                    class="block px-4 py-2 rounded-lg transition flex items-center justify-center
                    {{ Route::is('admin.refund') ? 'bg-[#13810A] text-white' : 'hover:bg-[#13810A] hover:text-white text-gray-800' }}">
                    Refund
                </a>

                <a href="{{ route('admin.maintenance') }}"
                    class="block px-4 py-2 rounded-lg transition flex items-center justify-center
                    {{ Route::is('admin.maintenance') ? 'bg-[#13810A] text-white' : 'hover:bg-[#13810A] hover:text-white text-gray-800' }}">
                    Maintenance
                </a>

                <form action="{{ route('logout') }}" method="POST" class="block logout">
                    @csrf
                    <button type="submit"
                        class="w-full px-4 py-2 rounded-lg transition flex items-center justify-center hover:bg-[#13810A] hover:text-white text-gray-800">
                        Logout
                    </button>
                </form>
            </nav>

            <div class="p-4 border-t border-gray-300 text-center text-sm text-gray-500">
                &copy; 2025 EZFutsal
            </div>
        </aside>

        <!-- Overlay -->
        <div id="overlay" class="fixed inset-0 bg-black bg-opacity-50 hidden z-30 lg:hidden"></div>

        <!-- konten utama -->
        <div class="lg:ml-60 flex-1 flex flex-col h-screen overflow-y-auto">

            <!-- Navbar -->
            <nav
                class="bg-[#13810A] text-white py-4 px-8 flex justify-between items-center shadow-md sticky top-0 z-50">

                <!-- LEFT NAV (Hamburger + Logo Mobile) -->
                <div class="flex items-center gap-3 lg:hidden">
                    <!-- Hamburger -->
                    <button id="hamburger" class="text-white focus:outline-none">
                        <!-- Hamburger Icon -->
                        <svg id="icon-hamburger" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 block" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>

                        <!-- Close Icon -->
                        <svg id="icon-close" xmlns="http://www.w3.org/2000/svg" class="h-7 w-7 hidden" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>

                    <!-- Logo / Text -->
                    <span class="text-xl font-bold text-white">
                        EZFutsal
                    </span>
                </div>

                <!-- Profil -->
                <div class="ml-auto relative flex flex-col items-center flex-none cursor-default">
                    <div
                        class="w-16 aspect-square bg-green-600 rounded-full flex items-center justify-center shadow-lg border-2 border-white/20">
                        <span class="text-white font-bold text-2xl">{{ Auth::user()->name[0] }}</span>
                    </div>
                </div>
            </nav>
            <!-- konten dinamis -->
            <div class="p-8 flex-1">
                @yield('content')
            </div>

        </div>
    </div>
    @include('admin.layouts.script')
</body>

</html>
