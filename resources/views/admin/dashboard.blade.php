@extends('admin.layouts.master')

@section('content')
    <div class="p-6">
        <!-- Welcome Header -->
        <div class="mb-8">
            <div class="flex items-center justify-between mb-6">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">Selamat Datang, {{ Auth::user()->name }}! 👋</h1>
                    <p class="text-gray-600">Ini adalah dashboard manajemen untuk sistem booking lapangan olahraga</p>
                </div>
                <div class="flex items-center gap-3">
                    <div class="text-sm text-gray-600 bg-gray-50 px-4 py-2 rounded-lg">
                        <span class="font-medium">Tanggal:</span> {{ now()->translatedFormat('l, d F Y') }}
                    </div>
                    <div class="text-sm text-gray-600 bg-gray-50 px-4 py-2 rounded-lg">
                        <span class="font-medium">Waktu:</span> {{ now()->format('H:i') }}
                    </div>
                </div>
            </div>

            <!-- Quick Stats Row -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4 mb-8">
                <div class="bg-gradient-to-br from-emerald-500 to-green-600 rounded-xl p-5 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-90">Pendapatan Bulan Ini</p>
                            <p class="text-2xl font-bold mt-2">Rp {{ number_format($incomeThisMonth, 0, ',', '.') }}</p>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="flex items-center gap-2 mt-4 text-sm">
                        <span class="bg-white/20 px-2 py-1 rounded-full flex items-center gap-1">
                            @if ($percentageChange > 0)
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M5 10l7-7m0 0l7 7m-7-7v18"></path>
                                </svg>
                            @else
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 14l-7 7m0 0l-7-7m7 7V3"></path>
                                </svg>
                            @endif
                            {{ abs($percentageChange) }}%
                        </span>
                        <span>dari bulan lalu</span>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-blue-500 to-indigo-600 rounded-xl p-5 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-90">Booking Hari Ini</p>
                            <p class="text-2xl font-bold mt-2">{{ $bookingCount }}</p>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm opacity-90">
                        Dari total {{ $fieldCount }} lapangan
                    </div>
                </div>

                <div class="bg-gradient-to-br from-green-500 to-emerald-600 rounded-xl p-5 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-90">Lapangan Aktif</p>
                            <p class="text-2xl font-bold mt-2">{{ $fieldStatus }}</p>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm opacity-90">
                        Siap untuk booking
                    </div>
                </div>

                <div class="bg-gradient-to-br from-amber-500 to-orange-600 rounded-xl p-5 text-white shadow-lg">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm font-medium opacity-90">Maintenance</p>
                            <p class="text-2xl font-bold mt-2">{{ $maintenanceCount }}</p>
                        </div>
                        <div class="p-3 bg-white/20 rounded-xl">
                            <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                            </svg>
                        </div>
                    </div>
                    <div class="mt-4 text-sm opacity-90">
                        Perlu perbaikan
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Section -->
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
            <!-- Chart 1: Pemesanan -->
            <div class="bg-white border border-gray-200 shadow-xl rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Grafik Pemesanan</h3>
                        <p class="text-gray-600 text-sm mt-1">Perkembangan pemesanan dalam 7 hari terakhir</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 bg-blue-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Pemesanan</span>
                        </div>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="chartPesanan"></canvas>
                </div>
            </div>

            <!-- Chart 2: Pendapatan -->
            <div class="bg-white border border-gray-200 shadow-xl rounded-2xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Grafik Pendapatan</h3>
                        <p class="text-gray-600 text-sm mt-1">Pendapatan dalam 7 hari terakhir</p>
                    </div>
                    <div class="flex items-center gap-2">
                        <div class="flex items-center gap-1">
                            <div class="w-3 h-3 bg-emerald-500 rounded-full"></div>
                            <span class="text-sm text-gray-600">Pendapatan</span>
                        </div>
                    </div>
                </div>
                <div class="h-64">
                    <canvas id="chartPendapatan"></canvas>
                </div>
            </div>
        </div>

        <!-- Two Columns Section -->
        <div class="grid grid-cols-1 gap-6 mb-8">
            <!-- Recent Bookings -->
            <div class="bg-white border border-gray-200 shadow-xl rounded-2xl overflow-hidden">
                <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white px-6 py-5">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold text-gray-800">Booking Terbaru</h3>
                            <p class="text-gray-600 text-sm mt-1">{{ count($bookings) }} booking hari ini</p>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="border-b border-gray-200">
                                <th class="py-4 px-6 text-left">
                                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">No</span>
                                </th>
                                <th class="py-4 px-6 text-left">
                                    <span
                                        class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</span>
                                </th>
                                <th class="py-4 px-6 text-left">
                                    <span
                                        class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Lapangan</span>
                                </th>
                                <th class="py-4 px-6 text-left">
                                    <span
                                        class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</span>
                                </th>
                                <th class="py-4 px-6 text-left">
                                    <span
                                        class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100">
                            @forelse ($bookings as $index => $booking)
                                <tr class="hover:bg-gray-50 transition-colors duration-150">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-lg flex items-center justify-center">
                                                <span
                                                    class="text-sm font-semibold text-blue-700">{{ $index + 1 }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-full flex items-center justify-center">
                                                <span class="font-semibold text-blue-600 text-sm">
                                                    {{ strtoupper(substr($booking['user']['name'] ?? 'GU', 0, 2)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <span
                                                    class="font-medium text-gray-800 block">{{ $booking['user']['name'] ?? 'Guest' }}</span>
                                                <span
                                                    class="text-xs text-gray-500 mt-1">{{ $booking['user']['email'] ?? '' }}</span>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        <span
                                            class="font-medium text-gray-700">{{ $booking['field']['name'] ?? 'N/A' }}</span>
                                    </td>
                                    <td class="py-4 px-6">
                                        <div class="space-y-1">
                                            <div class="text-sm text-gray-700">
                                                {{ $booking['date'] ? \Carbon\Carbon::parse($booking['date'])->format('d M Y') : 'N/A' }}
                                            </div>
                                            <div class="text-xs text-gray-500">{{ $booking['start_time'] }} -
                                                {{ $booking['end_time'] }}</div>
                                        </div>
                                    </td>
                                    <td class="py-4 px-6">
                                        @php
                                            $statusConfig = [
                                                'pending' => [
                                                    'bg' => 'bg-yellow-100',
                                                    'text' => 'text-yellow-800',
                                                    'border' => 'border-yellow-200',
                                                ],
                                                'approved' => [
                                                    'bg' => 'bg-green-100',
                                                    'text' => 'text-green-800',
                                                    'border' => 'border-green-200',
                                                ],
                                                'refunded' => [
                                                    'bg' => 'bg-blue-100',
                                                    'text' => 'text-blue-800',
                                                    'border' => 'border-blue-200',
                                                ],
                                                'rejected' => [
                                                    'bg' => 'bg-red-100',
                                                    'text' => 'text-red-800',
                                                    'border' => 'border-red-200',
                                                ],
                                            ];
                                            $config = $statusConfig[$booking['status']] ?? $statusConfig['pending'];
                                        @endphp
                                        <div
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">
                                            <div
                                                class="w-2 h-2 rounded-full {{ str_replace('text-', 'bg-', $config['text']) }}">
                                            </div>
                                            <span class="text-sm font-medium capitalize">{{ $booking['status'] }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-500 mb-2">Belum ada booking</h3>
                                            <p class="text-gray-400 max-w-md text-center">
                                                Tidak ada booking untuk hari ini
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                    <div class="px-6 py-4 border-t border-gray-200 text-right">
                        <a href="{{ route('admin.booking') }}" class="text-sm font-medium text-blue-600 hover:underline">
                            Lihat semua booking →
                        </a>
                    </div>

                </div>
            </div>

            <!-- Customer Section -->
            <div class="bg-white border border-gray-200 shadow-xl rounded-2xl overflow-hidden">
                <div class="border-b border-gray-200 bg-gradient-to-r from-purple-50 to-white px-6 py-5">
                    <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="p-2 bg-purple-100 rounded-lg">
                                <svg class="w-6 h-6 text-purple-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </div>
                            <div>
                                <h3 class="text-xl font-bold text-gray-800">Daftar Customer</h3>
                                <p class="text-gray-600 text-sm mt-1">Total {{ count($user) }} customer terdaftar</p>
                            </div>
                        </div>
                        <div class="mt-3 sm:mt-0">
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                    </svg>
                                </div>
                                <input type="text" placeholder="Cari customer..." id="searchCustomer"
                                    class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-purple-500 focus:border-purple-500 w-full sm:w-64">
                            </div>
                        </div>
                    </div>
                </div>

                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="border-b border-gray-200">
                                <th class="py-4 px-6 text-left">
                                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">No</span>
                                </th>
                                <th class="py-4 px-6 text-left">
                                    <span
                                        class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</span>
                                </th>
                                <th class="py-4 px-6 text-left">
                                    <span
                                        class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Kontak</span>
                                </th>
                                <th class="py-4 px-6 text-left">
                                    <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Role</span>
                                </th>
                                <th class="py-4 px-6 text-left">
                                    <span
                                        class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</span>
                                </th>
                            </tr>
                        </thead>
                        <tbody class="divide-y divide-gray-100" id="customerTableBody">
                            @forelse ($user as $index => $customer)
                                <tr class="hover:bg-gray-50 transition-colors duration-150"
                                    data-customer-name="{{ strtolower($customer['name']) }}">
                                    <td class="py-4 px-6">
                                        <div class="flex items-center">
                                            <div
                                                class="w-8 h-8 bg-gradient-to-br from-purple-100 to-pink-100 rounded-lg flex items-center justify-center">
                                                <span
                                                    class="text-sm font-semibold text-purple-700">{{ $index + 1 }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-full flex items-center justify-center">
                                                <span class="font-semibold text-blue-600 text-sm">
                                                    {{ strtoupper(substr($customer['name'], 0, 2)) }}
                                                </span>
                                            </div>
                                            <div>
                                                <span
                                                    class="font-medium text-gray-800 block">{{ $customer['name'] }}</span>
                                                <span class="text-xs text-gray-500 mt-1">ID: {{ $customer['id'] }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-4 px-6">
                                        <div class="space-y-1">
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 8l7.89 4.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                                <span class="text-sm text-gray-700">{{ $customer['email'] }}</span>
                                            </div>
                                            <div class="flex items-center gap-2">
                                                <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z">
                                                    </path>
                                                </svg>
                                                <span
                                                    class="text-sm text-gray-700">{{ $customer['no_telp'] ?: 'Belum diisi' }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <td class="py-4 px-6">
                                        @php
                                            $roleConfig = [
                                                'superadmin' => [
                                                    'bg' => 'bg-red-50',
                                                    'text' => 'text-red-700',
                                                    'border' => 'border border-red-100',
                                                    'icon' =>
                                                        'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z',
                                                ],
                                                'admin' => [
                                                    'bg' => 'bg-blue-50',
                                                    'text' => 'text-blue-700',
                                                    'border' => 'border border-blue-100',
                                                    'icon' =>
                                                        'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                                ],
                                                'user' => [
                                                    'bg' => 'bg-green-50',
                                                    'text' => 'text-green-700',
                                                    'border' => 'border border-green-100',
                                                    'icon' =>
                                                        'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z',
                                                ],
                                            ];

                                            $config = $roleConfig[$customer['role']] ?? $roleConfig['user'];
                                        @endphp

                                        @if (auth()->user()->role === 'superadmin')
                                            <form action="{{ route('user.update', $customer['id']) }}" method="POST">
                                                @csrf
                                                @method('PUT')
                                                <select name="role" onchange="this.form.submit()"
                                                    class="px-3 py-1.5 rounded-full text-sm font-medium transition-all duration-200 ease-in-out 
                                                           {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }} 
                                                           focus:outline-none focus:ring-2 focus:ring-opacity-50 
                                                           focus:ring-{{ explode('-', $config['text'])[1] }}-500 
                                                           cursor-pointer appearance-none">
                                                    <option value="superadmin"
                                                        {{ $customer['role'] === 'superadmin' ? 'selected' : '' }}>
                                                        Super Admin
                                                    </option>
                                                    <option value="admin"
                                                        {{ $customer['role'] === 'admin' ? 'selected' : '' }}>
                                                        Admin
                                                    </option>
                                                    <option value="user"
                                                        {{ $customer['role'] === 'user' ? 'selected' : '' }}>
                                                        User
                                                    </option>
                                                </select>
                                            </form>
                                        @else
                                            <div
                                                class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full
                                                       {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}
                                                       transition-all duration-200 ease-in-out">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="{{ $config['icon'] }}"></path>
                                                </svg>
                                                <span class="text-sm font-medium capitalize tracking-wide">
                                                    {{ str_replace('_', ' ', $customer['role']) }}
                                                </span>
                                            </div>
                                        @endif
                                    </td>

                                    <td class="py-4 px-6">
                                        @php
                                            $statusStyles = [
                                                'active' => [
                                                    'bg' => 'bg-green-100',
                                                    'text' => 'text-green-800',
                                                    'border' => 'border-green-200',
                                                ],
                                                'inactive' => [
                                                    'bg' => 'bg-gray-100',
                                                    'text' => 'text-gray-800',
                                                    'border' => 'border-gray-200',
                                                ],
                                                'suspended' => [
                                                    'bg' => 'bg-red-100',
                                                    'text' => 'text-red-800',
                                                    'border' => 'border-red-200',
                                                ],
                                            ];

                                            $userStatus = $customer->email_verified_at ? 'active' : 'inactive';
                                            $style = $statusStyles[$userStatus] ?? $statusStyles['inactive'];
                                        @endphp

                                        <div
                                            class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full {{ $style['bg'] }} {{ $style['text'] }} border {{ $style['border'] }}">
                                            <div
                                                class="w-2 h-2 rounded-full {{ str_replace('text-', 'bg-', $style['text']) }}">
                                            </div>
                                            <span
                                                class="text-sm font-medium capitalize">{{ $userStatus == 'active' ? 'Aktif' : 'Nonaktif' }}</span>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center">
                                            <div
                                                class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5 0a4.5 4.5 0 11-9 0 4.5 4.5 0 019 0z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <h3 class="text-lg font-bold text-gray-500 mb-2">Belum ada customer</h3>
                                            <p class="text-gray-400 max-w-md text-center">
                                                Data customer akan muncul setelah pendaftaran
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @include('admin.layouts.chart')
@endsection
