@extends('admin.layouts.master')

@section('content')
    <div class="grid grid-cols-1 gap-6 mb-8">
        <!-- Recent Bookings -->
        <div class="bg-white border border-gray-200 shadow-xl rounded-2xl overflow-hidden">
            <div class="border-b border-gray-200 bg-gradient-to-r from-blue-50 to-white px-6 py-5">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">

                    <!-- Left: Title -->
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

                    <!-- Right: Search + Back Button -->
                    <div class="flex flex-col sm:flex-row gap-3 w-full sm:w-auto">

                        <!-- Search -->
                        <div class="relative w-full sm:w-64">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                                </svg>
                            </div>
                            <input type="text" id="searchBooking" placeholder="Cari booking..."
                                class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 w-full transition-colors duration-200"
                                title="Cari berdasarkan nama customer, lapangan, atau status">
                        </div>

                        <!-- Back Button -->
                        <a href="{{ url()->previous() }}"
                            class="inline-flex items-center justify-center gap-2 px-4 py-2.5 
                          bg-gray-100 text-gray-700 border border-gray-300 rounded-lg 
                          hover:bg-gray-200 transition">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7">
                                </path>
                            </svg>
                            Kembali
                        </a>

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
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Customer</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Lapangan</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Tanggal</span>
                            </th>
                            <th class="py-4 px-6 text-left">
                                <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</span>
                            </th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-100" id="bookingTableBody">
                        @forelse ($bookings as $index => $booking)
                            @php
                                $customerName = $booking['user']['name'] ?? 'Guest';
                                $customerEmail = $booking['user']['email'] ?? '';
                                $fieldName = $booking['field']['name'] ?? 'N/A';
                                $bookingDate = $booking['date']
                                    ? \Carbon\Carbon::parse($booking['date'])->format('d M Y')
                                    : 'N/A';
                                $timeRange = $booking['start_time'] . ' - ' . $booking['end_time'];
                                $bookingStatus = $booking['status'] ?? 'pending';
                                $searchData = strtolower(
                                    $customerName .
                                        ' ' .
                                        $customerEmail .
                                        ' ' .
                                        $fieldName .
                                        ' ' .
                                        $bookingStatus .
                                        ' ' .
                                        $bookingDate .
                                        ' ' .
                                        $timeRange,
                                );
                            @endphp
                            <tr class="hover:bg-gray-50 transition-colors duration-150 booking-row"
                                data-booking="{{ $searchData }}">
                                <td class="py-4 px-6">
                                    <div class="flex items-center">
                                        <div
                                            class="w-8 h-8 bg-gradient-to-br from-blue-100 to-cyan-100 rounded-lg flex items-center justify-center">
                                            <span class="text-sm font-semibold text-blue-700">{{ $index + 1 }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="flex items-center gap-3">
                                        <div
                                            class="w-10 h-10 bg-gradient-to-br from-blue-50 to-cyan-50 rounded-full flex items-center justify-center">
                                            <span class="font-semibold text-blue-600 text-sm">
                                                {{ strtoupper(substr($customerName, 0, 2)) }}
                                            </span>
                                        </div>
                                        <div>
                                            <span class="font-medium text-gray-800 block">{{ $customerName }}</span>
                                            <span class="text-xs text-gray-500 mt-1">{{ $customerEmail }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    <span class="font-medium text-gray-700">{{ $fieldName }}</span>
                                </td>
                                <td class="py-4 px-6">
                                    <div class="space-y-1">
                                        <div class="text-sm text-gray-700">{{ $bookingDate }}</div>
                                        <div class="text-xs text-gray-500">{{ $timeRange }}</div>
                                    </div>
                                </td>
                                <td class="py-4 px-6">
                                    @php
                                        $statusConfig = [
                                            'pending' => [
                                                'bg' => 'bg-yellow-100',
                                                'text' => 'text-yellow-800',
                                                'border' => 'border-yellow-200',
                                                'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                            ],
                                            'approved' => [
                                                'bg' => 'bg-green-100',
                                                'text' => 'text-green-800',
                                                'border' => 'border-green-200',
                                                'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                            ],
                                            'completed' => [
                                                'bg' => 'bg-blue-100',
                                                'text' => 'text-blue-800',
                                                'border' => 'border-blue-200',
                                                'icon' => 'M5 13l4 4L19 7',
                                            ],
                                            'refunded' => [
                                                'bg' => 'bg-purple-100',
                                                'text' => 'text-purple-800',
                                                'border' => 'border-purple-200',
                                                'icon' =>
                                                    'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z',
                                            ],
                                            'rejected' => [
                                                'bg' => 'bg-red-100',
                                                'text' => 'text-red-800',
                                                'border' => 'border-red-200',
                                                'icon' =>
                                                    'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
                                            ],
                                            'cancelled' => [
                                                'bg' => 'bg-gray-100',
                                                'text' => 'text-gray-800',
                                                'border' => 'border-gray-200',
                                                'icon' => 'M6 18L18 6M6 6l12 12',
                                            ],
                                        ];
                                        $config = $statusConfig[$bookingStatus] ?? $statusConfig['pending'];
                                    @endphp
                                    <div
                                        class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full {{ $config['bg'] }} {{ $config['text'] }} border {{ $config['border'] }}">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                            xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="{{ $config['icon'] }}"></path>
                                        </svg>
                                        <span class="text-sm font-medium capitalize">{{ $bookingStatus }}</span>
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr id="noBookingResult">
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

                <!-- No Results Message (hidden by default) -->
                @if (count($bookings) > 0)
                    <div id="noResultsMessage" class="hidden px-6 py-12 text-center border-t border-gray-100">
                        <div class="flex flex-col items-center justify-center">
                            <div
                                class="w-20 h-20 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-10 h-10 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z">
                                    </path>
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-gray-500 mb-2">Tidak ditemukan</h3>
                            <p class="text-gray-400 max-w-md text-center">
                                Tidak ada booking yang sesuai dengan pencarian Anda
                            </p>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Search functionality for bookings
            const searchInput = document.getElementById('searchBooking');
            const bookingRows = document.querySelectorAll('.booking-row');
            const noResultsMessage = document.getElementById('noResultsMessage');
            const emptyStateRow = document.getElementById('noBookingResult');

            // Sembunyikan empty state awal jika ada data
            if (emptyStateRow && bookingRows.length > 0) {
                emptyStateRow.style.display = 'none';
            }

            if (searchInput) {
                searchInput.addEventListener('input', function() {
                    const keyword = this.value.toLowerCase().trim();
                    let visibleRows = 0;

                    // Cari di semua baris booking
                    bookingRows.forEach(row => {
                        const searchData = row.getAttribute('data-booking') || '';
                        if (keyword === '' || searchData.includes(keyword)) {
                            row.style.display = '';
                            visibleRows++;
                        } else {
                            row.style.display = 'none';
                        }
                    });

                    // Tampilkan/sembunyikan pesan tidak ditemukan
                    if (noResultsMessage) {
                        if (keyword !== '' && visibleRows === 0) {
                            noResultsMessage.classList.remove('hidden');
                            if (emptyStateRow) emptyStateRow.style.display = 'none';
                        } else {
                            noResultsMessage.classList.add('hidden');
                            if (emptyStateRow && bookingRows.length === 0) {
                                emptyStateRow.style.display = '';
                            }
                        }
                    }
                });
            }
        });
    </script>
@endsection
