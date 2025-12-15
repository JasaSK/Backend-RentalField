<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Admin</title>

    <!-- CSS STYLES HARUS DIMUAT PERTAMA -->
    <style>
        /* CRITICAL CSS - Load immediately */
        body.preload {
            opacity: 0;
            visibility: hidden;
        }

        #page-loader {
            position: fixed;
            inset: 0;
            z-index: 9999;
            display: flex;
            align-items: center;
            justify-content: center;
            background: white;
            opacity: 1;
            transition: opacity 0.5s ease;
        }

        /* Hide main content initially */
        .flex.min-h-screen {
            opacity: 0;
            transition: opacity 0.3s ease;
        }

        body.loaded .flex.min-h-screen {
            opacity: 1;
        }

        /* Font loading */
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        /* Basic loader styles */
        .text-center {
            text-align: center;
        }

        .mx-auto {
            margin-left: auto;
            margin-right: auto;
        }

        .mb-6 {
            margin-bottom: 1.5rem;
        }

        .w-24 {
            width: 6rem;
        }

        .h-24 {
            height: 6rem;
        }

        .relative {
            position: relative;
        }

        .absolute {
            position: absolute;
        }

        .inset-0 {
            top: 0;
            right: 0;
            bottom: 0;
            left: 0;
        }

        .inset-2 {
            top: 0.5rem;
            right: 0.5rem;
            bottom: 0.5rem;
            left: 0.5rem;
        }

        .inset-4 {
            top: 1rem;
            right: 1rem;
            bottom: 1rem;
            left: 1rem;
        }

        .rounded-full {
            border-radius: 9999px;
        }

        .border-4 {
            border-width: 4px;
        }

        .border-emerald-200 {
            border-color: #a7f3d0;
        }

        .border-emerald-300 {
            border-color: #6ee7b7;
        }

        .bg-gradient-to-br {
            background-image: linear-gradient(to bottom right, var(--tw-gradient-stops));
        }

        .from-emerald-500 {
            --tw-gradient-from: #10b981;
            --tw-gradient-stops: var(--tw-gradient-from), var(--tw-gradient-to, rgba(16, 185, 129, 0));
        }

        .to-green-600 {
            --tw-gradient-to: #059669;
        }

        .flex {
            display: flex;
        }

        .items-center {
            align-items: center;
        }

        .justify-center {
            justify-content: center;
        }

        .text-white {
            color: white;
        }

        .font-bold {
            font-weight: 700;
        }

        .text-2xl {
            font-size: 1.5rem;
            line-height: 2rem;
        }

        .text-lg {
            font-size: 1.125rem;
            line-height: 1.75rem;
        }

        .font-semibold {
            font-weight: 600;
        }

        .text-gray-800 {
            color: #1f2937;
        }

        .mb-3 {
            margin-bottom: 0.75rem;
        }

        .w-48 {
            width: 12rem;
        }

        .h-2 {
            height: 0.5rem;
        }

        .bg-gray-200 {
            background-color: #e5e7eb;
        }

        .overflow-hidden {
            overflow: hidden;
        }

        .h-full {
            height: 100%;
        }

        .bg-gradient-to-r {
            background-image: linear-gradient(to right, var(--tw-gradient-stops));
        }

        .w-0 {
            width: 0%;
        }

        .transition-all {
            transition-property: all;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }

        .duration-700 {
            transition-duration: 700ms;
        }

        .ease-out {
            transition-timing-function: cubic-bezier(0, 0, 0.2, 1);
        }

        .text-sm {
            font-size: 0.875rem;
            line-height: 1.25rem;
        }

        .text-gray-500 {
            color: #6b7280;
        }

        .mt-3 {
            margin-top: 0.75rem;
        }

        /* Tambahkan di bagian CSS Anda */
        #hamburger {
            position: relative;
            z-index: 9999 !important;
            cursor: pointer;
        }

        #icon-hamburger,
        #icon-close {
            pointer-events: none;
        }

        /* Pastikan overlay tidak menutupi hamburger */
        #overlay {
            z-index: 40;
        }

        /* Pastikan sidebar di bawah hamburger */
        #sidebar {
            z-index: 50;
        }

        /* Untuk layar kecil, pastikan hamburger selalu terlihat */
        @media (max-width: 1023px) {
            nav.sticky {
                position: sticky;
                z-index: 9999;
            }

            #hamburger {
                z-index: 10000 !important;
            }
        }
    </style>

    <!-- Load Tailwind CSS and other styles -->
    @include('admin.layouts.head')

    <!-- Additional styles -->
    <style>
        /* Additional styles after Tailwind loads */
        .animate-ping {
            animation: ping 1s cubic-bezier(0, 0, 0.2, 1) infinite;
        }

        @keyframes ping {

            75%,
            100% {
                transform: scale(2);
                opacity: 0;
            }
        }

        .animate-spin {
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            from {
                transform: rotate(0deg);
            }

            to {
                transform: rotate(360deg);
            }
        }

        /* Smooth transitions for loaded state */
        body.loaded {
            opacity: 1;
            visibility: visible;
        }

        /* Fade in animations */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
                transform: translateY(-10px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }
    </style>
</head>


<body class="bg-gradient-to-br from-gray-50 to-gray-100 font-sans antialiased preload">
    <!-- Loader - Fixed -->
    <div id="page-loader"
        class="fixed inset-0 z-[9999] flex items-center justify-center bg-white transition-opacity duration-500">
        <div class="text-center">
            <!-- Animated Logo Container -->
            <div class="w-24 h-24 mb-6 mx-auto relative">
                <!-- Outer ring animation -->
                <div class="absolute inset-0 rounded-full border-4 border-emerald-200 animate-ping"></div>
                <!-- Middle ring -->
                <div class="absolute inset-2 rounded-full border-4 border-emerald-300 animate-spin"></div>
                <!-- Inner logo -->
                <div
                    class="absolute inset-4 rounded-full bg-gradient-to-br from-emerald-500 to-green-600 flex items-center justify-center">
                    <span class="text-white font-bold text-2xl">EZ</span>
                </div>
            </div>

            <!-- Loading text -->
            <div>
                <p class="text-lg font-semibold text-gray-800 mb-3" id="loader-text">Memuat Dashboard</p>
                <div class="w-48 h-2 bg-gray-200 rounded-full overflow-hidden mx-auto">
                    <div id="loading-bar"
                        class="h-full bg-gradient-to-r from-emerald-500 to-green-600 w-0 transition-all duration-700 ease-out">
                    </div>
                </div>
                <p class="text-sm text-gray-500 mt-3">Mohon tunggu sebentar...</p>
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
                            fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
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

</body>

</html>
