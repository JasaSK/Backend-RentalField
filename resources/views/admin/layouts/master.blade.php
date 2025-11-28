<!DOCTYPE html>
<html lang="id">
@include('admin.layouts.head')

<body class="bg-gray-100 font-sans antialiased">

    <div class="flex min-h-screen">

        <!-- Sidebar -->
        <aside class="fixed top-0 left-0 h-screen w-60 bg-white text-gray-800 flex flex-col border-r border-gray-300">
            <div class="p-6 border-b border-gray-300 flex items-center justify-center">
                <span class="text-2xl font-bold text-[#13810A]">
                    EZFutsal
                </span>
            </div>

            <nav class="flex-1 p-6 space-y-3 overflow-y-auto">
                <a href="{{ route('admin.dashboard') }}"
                    class="block px-4 py-2 rounded-lg transition flex items-center justify-center
                    {{ Route::is('admin.dashboard') ? 'bg-[#13810A] text-white' : 'hover:bg-[#13810A] hover:text-white text-gray-800' }}">
                    Dashboard
                </a>

                <a href="{{route('admin.order')}}"
                    class="block px-4 py-2 rounded-lg transition flex items-center justify-center
                    {{ Route::is('admin.order') ? 'bg-[#13810A] text-white' : 'hover:bg-[#13810A] hover:text-white text-gray-800' }}">
                    Pemesanan
                </a>

                <a href="{{ route('admin.banner') }}"
                    class="block px-4 py-2 rounded-lg transition flex items-center justify-center
                    {{ Route::is('admin.banner') ? 'bg-[#13810A] text-white' : 'hover:bg-[#13810A] hover:text-white text-gray-800' }}">
                    Banner
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
                <a href="{{ route('admin.gallery-categories') }}"
                    class="block px-4 py-2 rounded-lg transition flex items-center justify-center
                    {{ Route::is('admin.gallery-categories') ? 'bg-[#13810A] text-white' : 'hover:bg-[#13810A] hover:text-white text-gray-800' }}">
                    Kategori Galeri
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
            </nav>


            <div class="p-4 border-t border-gray-300 text-center text-sm text-gray-500">
                &copy; 2025 EZFutsal
            </div>
        </aside>

        <!-- konten utama -->
        <div class="ml-60 flex-1 flex flex-col h-screen overflow-y-auto">

            <!-- Navbar -->
            <nav class="bg-[#13810A] text-white py-4 px-8 flex justify-end items-center shadow-md sticky top-0 z-40">
                <button id="userBtn" class="relative">
                    <div class="w-12 h-12 bg-gray-400 rounded-full flex items-center justify-center hover:ring-2 hover:ring-white transition overflow-hidden">
                        <img id="profilePic" src="https://cdn-icons-png.flaticon.com/512/847/847969.png" alt="User" class="w-12 h-12 object-cover">
                    </div>
                </button>

                <!-- card profile -->
                @include('admin.layouts.usercard')
            </nav>

            <!-- konten dinamis -->
            <div class="p-8 flex-1">
                @yield('content')
            </div>

        </div>
    </div>
    <!-- Script -->
    @include('admin.layouts.script')
</body>

</html>