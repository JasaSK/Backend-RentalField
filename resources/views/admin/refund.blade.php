@extends('admin.layouts.master')

@section('content')
    <div class="p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-3">
                <div class="p-3 bg-gradient-to-br from-rose-100 to-red-100 rounded-xl">
                    <svg class="w-8 h-8 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                        </path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Kelola Refund</h1>
                    <p class="text-gray-600 mt-1">Kelola permintaan refund dari pengguna</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-8">
                <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Total Refund</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $refunds->total() }}</p>
                        </div>
                        <div class="p-3 bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Pending</p>
                            <p class="text-2xl font-bold text-yellow-600 mt-1">
                                {{ $refunds->where('refund_status', 'pending')->count() }}</p>
                        </div>
                        <div class="p-3 bg-yellow-50 rounded-lg">
                            <svg class="w-6 h-6 text-yellow-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Approved</p>
                            <p class="text-2xl font-bold text-green-600 mt-1">
                                {{ $refunds->where('refund_status', 'approved')->count() }}</p>
                        </div>
                        <div class="p-3 bg-green-50 rounded-lg">
                            <svg class="w-6 h-6 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div
                class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 animate-fade-in">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div
                class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl p-4 flex items-center gap-3 animate-fade-in">
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <!-- Main Card -->
        <div class="bg-white border border-gray-200 shadow-xl rounded-2xl overflow-hidden">
            <!-- Card Header -->
            <div class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white px-6 py-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Daftar Permintaan Refund</h3>
                        <p class="text-gray-600 text-sm mt-1">Kelola semua permintaan refund dalam satu tempat</p>
                    </div>
                    <div class="mt-3 sm:mt-0">
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="searchRefund" placeholder="Cari refund..."
                                class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full sm:w-64">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Table Container -->
            <div class="overflow-x-auto">
                <table class="w-full">
                    <thead class="bg-gray-50">
                        <tr class="border-b border-gray-200">
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">No</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Kode
                                    Booking</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Total
                                    Harga</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Alasan
                                    Refund</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Bukti
                                    Transfer</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</span>
                            </th>
                        </tr>
                    </thead>

                    <tbody class="divide-y divide-gray-100" id="refundTableBody">
                        @forelse ($refunds as $index => $refund)
                            @php
                                $bookingCode =
                                    $refund->booking->code_booking ??
                                    'BOOK-' . str_pad($refund->id, 6, '0', STR_PAD_LEFT);
                                $totalPrice = $refund->booking->total_price ?? ($refund->amount_paid ?? 0);
                                $reason = $refund->reason ?? 'Tidak disebutkan';
                                $paymentMethod = $refund->payment_method ?? 'Transfer Bank';
                                $createdDate = $refund->created_at->format('d M Y H:i');
                                $refundStatus = $refund->refund_status ?? 'pending';
                            @endphp

                            <tr class="hover:bg-gray-50 transition-colors duration-150 refund-row"
                                data-refund="{{ strtolower($bookingCode . ' ' . $reason . ' ' . $refundStatus . ' ' . $paymentMethod) }}">

                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div class="w-8 h-8 bg-gray-100 rounded-lg flex items-center justify-center">
                                            <span class="text-sm font-medium text-gray-700">{{ $index + 1 }}</span>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-6">
                                    <div class="flex flex-col">
                                        <span class="font-mono font-semibold text-gray-800">
                                            {{ $bookingCode }}
                                        </span>
                                        <span class="text-xs text-gray-500 mt-1">ID: {{ $refund->id }}</span>
                                        <span class="text-xs text-gray-400 mt-1">
                                            {{ $createdDate }}
                                        </span>
                                        <span class="text-xs text-blue-600 mt-1">
                                            {{ $refund->user->name ?? 'Guest' }}
                                        </span>
                                    </div>
                                </td>

                                <td class="py-4 px-6">
                                    <div class="flex flex-col">
                                        <div class="flex items-center gap-2">
                                            <span class="text-lg font-bold text-emerald-600">
                                                Rp {{ number_format($totalPrice, 0, ',', '.') }}
                                            </span>
                                            @if ($totalPrice >= 500000)
                                                <span
                                                    class="text-xs px-2 py-1 bg-emerald-100 text-emerald-700 rounded-full font-medium">
                                                    Large
                                                </span>
                                            @endif
                                        </div>
                                        <div class="flex items-center gap-1 mt-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span class="text-xs text-gray-500">
                                                {{ $paymentMethod }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-6">
                                    <div class="max-w-xs">
                                        <div class="text-gray-700 line-clamp-2" title="{{ $reason }}">
                                            {{ $reason }}
                                        </div>
                                        <div class="flex items-center gap-1 mt-2">
                                            <svg class="w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                </path>
                                            </svg>
                                            <span class="text-xs text-gray-500">
                                                {{ $createdDate }}
                                            </span>
                                        </div>
                                    </div>
                                </td>

                                <td class="py-4 px-6">
                                    @if ($refund->proof)
                                        <div class="group relative inline-block">
                                            <img src="{{ asset('storage/' . $refund->proof) }}"
                                                class="w-20 h-14 object-cover rounded-lg shadow-sm border border-gray-200 cursor-pointer hover:shadow-md transition-shadow duration-200"
                                                onclick="openImageModal('{{ asset('storage/' . $refund->proof) }}')"
                                                alt="Bukti Transfer">
                                            <div
                                                class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-lg transition-all duration-200">
                                            </div>
                                            <div
                                                class="opacity-0 group-hover:opacity-100 absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded pointer-events-none transition-opacity duration-200 whitespace-nowrap">
                                                Klik untuk memperbesar
                                            </div>
                                        </div>
                                    @else
                                        <div class="flex flex-col items-center justify-center w-20">
                                            <div
                                                class="w-10 h-10 bg-gray-100 rounded-full flex items-center justify-center">
                                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                    </path>
                                                </svg>
                                            </div>
                                            <span class="text-xs text-gray-400 mt-1">Tidak ada</span>
                                        </div>
                                    @endif
                                </td>

                                <td class="py-4 px-6">
                                    @php
                                        $statusConfig = [
                                            'approved' => [
                                                'bg' => 'bg-green-100',
                                                'text' => 'text-green-800',
                                                'border' => 'border border-green-200',
                                                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                                'label' => 'Disetujui',
                                            ],
                                            'pending' => [
                                                'bg' => 'bg-yellow-100',
                                                'text' => 'text-yellow-800',
                                                'border' => 'border border-yellow-200',
                                                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                                'label' => 'Menunggu',
                                            ],
                                            'rejected' => [
                                                'bg' => 'bg-red-100',
                                                'text' => 'text-red-800',
                                                'border' => 'border border-red-200',
                                                'icon' =>
                                                    'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
                                                'label' => 'Ditolak',
                                            ],
                                            'completed' => [
                                                'bg' => 'bg-blue-100',
                                                'text' => 'text-blue-800',
                                                'border' => 'border border-blue-200',
                                                'icon' => 'M5 13l4 4L19 7',
                                                'label' => 'Selesai',
                                            ],
                                            'processing' => [
                                                'bg' => 'bg-purple-100',
                                                'text' => 'text-purple-800',
                                                'border' => 'border border-purple-200',
                                                'icon' => 'M13 10V3L4 14h7v7l9-11h-7z',
                                                'label' => 'Diproses',
                                            ],
                                        ];
                                        $config = $statusConfig[$refundStatus] ?? $statusConfig['pending'];
                                    @endphp

                                    <div
                                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $config['icon'] }}"></path>
                                        </svg>
                                        <span class="text-sm font-medium">{{ $config['label'] }}</span>
                                    </div>

                                    @if ($refundStatus === 'approved')
                                        <div class="mt-1 text-xs text-gray-500">
                                            {{ $refund->updated_at->format('d M Y') }}
                                        </div>
                                    @endif
                                </td>

                                <td class="py-4 px-6">
                                    <div class="flex flex-col sm:flex-row sm:items-center gap-2">
                                        @if ($refundStatus === 'pending')
                                            <!-- Process Button -->
                                            <button type="button"
                                                class="editRefundBtn bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2 group w-full sm:w-auto"
                                                data-id="{{ $refund->id }}" data-amount="{{ $totalPrice }}"
                                                data-proof="{{ $refund->proof ? asset('storage/' . $refund->proof) : '' }}"
                                                data-code="{{ $bookingCode }}" data-reason="{{ $reason }}"
                                                data-date="{{ $createdDate }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                </svg>
                                                Proses
                                            </button>

                                            <!-- Reject Button -->
                                            <form action="{{ route('admin.refund.reject', $refund->id) }}" method="POST"
                                                class="w-full sm:w-auto rejected">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2 w-full">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
                                                        </path>
                                                    </svg>
                                                    Tolak
                                                </button>
                                            </form>
                                        @elseif($refundStatus === 'approved')
                                            <!-- View Approved Details -->
                                            <div class="flex flex-col gap-2">
                                                <span class="text-xs text-green-600 font-medium">
                                                    ✓ Disetujui
                                                </span>
                                                <span class="text-xs text-gray-500">
                                                    {{ $refund->updated_at->format('d M Y') }}
                                                </span>
                                                @if ($refund->refund_proof)
                                                    <a href="{{ asset('storage/' . $refund->refund_proof) }}"
                                                        target="_blank"
                                                        class="text-xs text-blue-600 hover:underline flex items-center gap-1">
                                                        <svg class="w-3 h-3" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z">
                                                            </path>
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z">
                                                            </path>
                                                        </svg>
                                                        Bukti Refund
                                                    </a>
                                                @endif
                                            </div>
                                        @elseif($refundStatus === 'rejected')
                                            <!-- View Rejection Reason -->
                                            <div class="flex flex-col gap-2">
                                                <span class="text-xs text-red-600 font-medium">
                                                    ✗ Ditolak
                                                </span>
                                                @if ($refund->rejection_reason)
                                                    <button type="button"
                                                        onclick="showRejectionReason('{{ $refund->rejection_reason }}')"
                                                        class="text-xs text-gray-600 hover:text-gray-800 underline text-left">
                                                        Lihat alasan
                                                    </button>
                                                @endif
                                                <span class="text-xs text-gray-500">
                                                    {{ $refund->updated_at->format('d M Y') }}
                                                </span>
                                            </div>
                                        @else
                                            <span class="text-gray-400 text-sm font-medium italic">
                                                Tidak ada aksi
                                            </span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <!-- Empty state row - ditampilkan saat tidak ada data -->
                            <tr id="noRefundResult">
                                <td colspan="7" class="py-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="text-lg font-bold text-gray-500 mb-2">Belum ada permintaan refund</h3>
                                        <p class="text-gray-400 max-w-md text-center">
                                            Saat ini tidak ada permintaan refund yang perlu ditangani
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>

                <!-- No Results Message (hidden by default) - DIPINDAHKAN SETELAH TABEL -->
                @if ($refunds->count() > 0)
                    <div id="noResultsMessage" class="hidden px-6 py-12 text-center">
                        <div class="flex flex-col items-center justify-center">
                            <div
                                class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-500 mb-2">Tidak ditemukan</h3>
                            <p class="text-gray-400 max-w-md text-center">
                                Tidak ada data refund yang sesuai dengan pencarian Anda
                            </p>
                        </div>
                    </div>
                @endif

                <!-- Pagination -->
                @if ($refunds->hasPages())
                    <div class="px-6 py-4 border-t border-gray-200">
                        {{ $refunds->links() }}
                    </div>
                @endif
            </div>
        </div>
    </div>

    <!-- Modal Edit Refund -->
    <div id="editRefundModal" class="hidden fixed inset-0 z-50 overflow-y-auto">
        <div class="flex items-center justify-center min-h-screen px-4 pt-4 pb-20 text-center sm:block sm:p-0">
            <!-- Background overlay -->
            <div class="fixed inset-0 transition-opacity bg-gray-500 bg-opacity-75" id="modalOverlay"></div>

            <!-- Modal panel -->
            <div
                class="inline-block w-full max-w-md p-6 my-8 text-left align-middle transition-all transform bg-white shadow-xl rounded-2xl">
                <!-- Modal header -->
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Konfirmasi Refund</h3>
                        <p class="text-gray-600 text-sm mt-1">Masukkan jumlah refund dan upload bukti transfer</p>
                    </div>
                    <button type="button" id="refundCancel"
                        class="text-gray-400 hover:text-gray-600 transition-colors duration-200">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <!-- Modal form -->
                <form method="POST" id="editRefundForm" enctype="multipart/form-data">
                    @csrf
                    <input type="hidden" id="refundId" name="refund_id">

                    <!-- Refund Info -->
                    <div class="mb-6 p-4 bg-gray-50 rounded-lg">
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-500">Kode Booking:</p>
                                <p class="font-semibold text-gray-800" id="modalBookingCode"></p>
                            </div>

                            <div>
                                <p class="text-gray-500">Total Harga:</p>
                                <p class="font-semibold text-emerald-600" id="modalTotalPrice"></p>
                            </div>

                            <div class="col-span-2">
                                <p class="text-gray-500">Alasan Refund:</p>
                                <p class="font-medium text-gray-800" id="modalRefundReason"></p>
                            </div>
                        </div>
                    </div>

                    <!-- Current Proof Preview -->
                    <div id="currentProofContainer" class="mb-6">
                        <p class="text-sm font-medium text-gray-700 mb-2">Bukti Transfer Pengguna</p>
                        <img id="currentProofImage"
                            class="w-full max-h-48 object-contain rounded-lg border border-gray-200 shadow-sm mb-2">
                        <p class="text-xs text-gray-500">Bukti transfer yang diupload oleh pengguna</p>
                    </div>

                    <!-- Amount Input -->
                    <div class="mb-6">
                        <label for="refundAmount" class="block text-sm font-medium text-gray-700 mb-2">
                            Jumlah Refund (Rp)
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <span class="text-gray-500 font-medium">Rp</span>
                            </div>
                            <input type="number" id="refundAmount" name="refund_amount" min="0" step="1000"
                                class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                                placeholder="0" required>
                        </div>
                        <p class="text-xs text-gray-500 mt-2">Masukkan jumlah yang akan direfund ke pengguna</p>
                    </div>

                    <!-- File Upload -->
                    <div class="mb-6">
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Upload Bukti Transfer Baru (Opsional)
                        </label>
                        <div class="flex items-center justify-center w-full">
                            <label for="refundImageInput"
                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                                <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                    <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                        </path>
                                    </svg>
                                    <p class="mb-2 text-sm text-gray-500">
                                        <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                    </p>
                                    <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 5MB)</p>
                                </div>
                                <input id="refundImageInput" name="proof" type="file" class="hidden"
                                    accept="image/*">
                            </label>
                        </div>
                        <!-- Image preview -->
                        <div id="imagePreviewContainer" class="hidden mt-4">
                            <p class="text-sm font-medium text-gray-700 mb-2">Preview:</p>
                            <img id="imagePreview"
                                class="w-full max-h-48 object-contain rounded-lg border border-gray-200 shadow-sm">
                        </div>
                    </div>

                    <!-- Modal footer -->
                    <div class="flex flex-col sm:flex-row justify-end gap-3 pt-6 border-t border-gray-200">
                        <button type="button" id="modalCancel"
                            class="px-5 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors duration-200 w-full sm:w-auto">
                            Batal
                        </button>
                        <button type="submit"
                            class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-medium shadow-sm hover:shadow transition-all duration-200 flex items-center justify-center gap-2 w-full sm:w-auto">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                                </path>
                            </svg>
                            Konfirmasi Refund
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4">
        <div class="relative max-w-4xl w-full">
            <button onclick="closeImageModal()" class="absolute -top-10 right-0 text-white hover:text-gray-300 z-10">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <div class="bg-white rounded-lg overflow-hidden">
                <img id="modalImage" class="w-full max-h-[80vh] object-contain">
            </div>
        </div>
    </div>

    <!-- Rejection Reason Modal -->
    <div id="rejectionModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-75 p-4">
        <div class="bg-white rounded-xl max-w-md w-full p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="text-lg font-bold text-gray-800">Alasan Penolakan</h3>
                <button onclick="closeRejectionModal()" class="text-gray-400 hover:text-gray-600">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>
            <div class="p-4 bg-red-50 rounded-lg">
                <p id="rejectionReasonText" class="text-gray-700"></p>
            </div>
            <div class="mt-6 flex justify-end">
                <button onclick="closeRejectionModal()"
                    class="px-4 py-2 bg-gray-200 hover:bg-gray-300 text-gray-800 rounded-lg font-medium transition-colors duration-200">
                    Tutup
                </button>
            </div>
        </div>
    </div>

    <script src="{{ asset('js/edit-refund.js') }}"></script>
@endsection
