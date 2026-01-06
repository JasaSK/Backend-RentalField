@extends('admin.layouts.master')

@section('content')
    <div class="max-w-6xl mx-auto mt-10 px-4">

        {{-- CARD SCANNER MODERN --}}
        <div class="bg-gradient-to-br from-white to-gray-50 shadow-2xl rounded-2xl p-8 mb-10 border border-gray-100">
            <div class="text-center mb-8">
                <div
                    class="inline-flex items-center justify-center w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full shadow-lg mb-4">
                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                        </path>
                    </svg>
                </div>
                <h1 class="text-3xl font-bold text-gray-800 mb-2">
                    Verifikasi Tiket
                </h1>
                <p class="text-gray-600 max-w-lg mx-auto">
                    Scan QR Code tiket untuk verifikasi kehadiran pengunjung
                </p>
            </div>

            <div class="flex flex-col items-center">
                <form id="verifyForm" action="{{ route('admin.verify.ticket.process') }}" method="POST"
                    class="w-full max-w-lg">
                    @csrf
                    <input type="hidden" name="ticket_code" id="ticket_code">

                    <div class="relative mb-8">
                        <div id="reader"
                            class="w-full max-w-md h-80 mx-auto border-4 border-dashed border-gray-200 rounded-2xl shadow-inner overflow-hidden bg-gradient-to-b from-gray-50 to-white hidden">
                        </div>

                        <div id="scanPlaceholder"
                            class="w-full max-w-md h-80 mx-auto border-4 border-dashed border-gray-200 rounded-2xl shadow-inner bg-gradient-to-b from-gray-50 to-white flex flex-col items-center justify-center">
                            <div
                                class="w-24 h-24 bg-gradient-to-r from-gray-200 to-gray-300 rounded-full flex items-center justify-center mb-4">
                                <svg class="w-12 h-12 text-gray-500" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z">
                                    </path>
                                </svg>
                            </div>
                            <p class="text-gray-500 font-medium">Kamera scanner siap digunakan</p>
                            <p class="text-gray-400 text-sm mt-1">Klik tombol "Mulai Scan" untuk memulai</p>
                        </div>

                        <div class="flex justify-center mt-4">
                            <div id="loadingText" class="hidden">
                                <div class="flex items-center space-x-3 bg-blue-50 px-4 py-3 rounded-xl">
                                    <div
                                        class="w-5 h-5 border-2 border-blue-500 border-t-transparent rounded-full animate-spin">
                                    </div>
                                    <span class="text-blue-600 font-medium">Mengaktifkan kamera...</span>
                                </div>
                            </div>
                        </div>

                        <div id="result" class="mt-6 text-center"></div>
                    </div>

                    <div class="flex flex-col sm:flex-row items-center justify-center gap-4 mt-8">
                        <button type="button" id="startScan"
                            class="px-8 py-3.5 bg-gradient-to-r from-emerald-500 to-green-600 hover:from-emerald-600 hover:to-green-700 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-3 min-w-[160px] justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z">
                                </path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                            Mulai Scan
                        </button>

                        <button type="button" id="stopScan"
                            class="px-8 py-3.5 bg-gradient-to-r from-rose-500 to-red-600 hover:from-rose-600 hover:to-red-700 text-white rounded-xl font-bold shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 transition-all duration-200 flex items-center gap-3 min-w-[160px] justify-center hidden">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z"></path>
                            </svg>
                            Stop Scan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE MODERN --}}
        <div class="bg-white shadow-2xl rounded-2xl p-8 border border-gray-100">
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-8">
                <div>
                    <h2 class="text-2xl font-bold text-gray-800 mb-2">
                        Tiket Terverifikasi
                    </h2>
                    <p class="text-gray-600">Daftar tiket yang sudah berhasil diverifikasi</p>
                </div>
                <div
                    class="mt-4 sm:mt-0 bg-gradient-to-r from-emerald-50 to-green-50 px-4 py-2.5 rounded-xl border border-emerald-100">
                    <p class="text-emerald-700 font-semibold flex items-center gap-2">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z"
                                clip-rule="evenodd"></path>
                        </svg>
                        Total: {{ $verify->count() }} Tiket
                    </p>
                </div>
            </div>

            <!-- Wrapper Scroll -->
            <div class="overflow-x-auto overflow-y-auto max-h-[480px] border border-gray-200 rounded-xl shadow-inner">
                <table class="min-w-full border-collapse">
                    <thead class="bg-gradient-to-r from-gray-50 to-gray-100 sticky top-0 z-10">
                        <tr class="border-b border-gray-200">
                            <th class="p-4 font-bold text-gray-700 text-sm uppercase tracking-wider text-center w-16">No
                            </th>
                            <th class="p-4 font-bold text-gray-700 text-sm uppercase tracking-wider text-left">Kode Tiket
                            </th>
                            <th class="p-4 font-bold text-gray-700 text-sm uppercase tracking-wider text-left">Customer</th>
                            <th class="p-4 font-bold text-gray-700 text-sm uppercase tracking-wider text-left">Lapangan</th>
                            <th class="p-4 font-bold text-gray-700 text-sm uppercase tracking-wider text-left">Tanggal</th>
                            <th class="p-4 font-bold text-gray-700 text-sm uppercase tracking-wider text-left">Waktu</th>
                            <th class="p-4 font-bold text-gray-700 text-sm uppercase tracking-wider text-left">Harga</th>
                            <th class="p-4 font-bold text-gray-700 text-sm uppercase tracking-wider text-left">Waktu Scan
                            </th>
                        </tr>
                    </thead>

                    <tbody id="ticketTable">
                        @foreach ($verify as $index => $data)
                            <tr
                                class="hover:bg-gray-50 transition-all duration-150 border-b border-gray-100 {{ $loop->even ? 'bg-gray-50/50' : '' }}">
                                <td class="p-4 text-center">
                                    <span
                                        class="inline-flex items-center justify-center w-8 h-8 bg-gradient-to-br from-emerald-100 to-green-100 text-emerald-700 font-bold rounded-full text-sm">
                                        {{ $index + 1 }}
                                    </span>
                                </td>
                                <td class="p-4">
                                    <div
                                        class="font-mono font-bold text-gray-800 bg-gray-100 px-3 py-1.5 rounded-lg inline-block">
                                        {{ $data->ticket_code }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="font-medium text-gray-800 flex items-center gap-2">
                                        {{ $data->user->name }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="font-medium text-gray-800 flex items-center gap-2">
                                        <div class="w-2 h-2 bg-emerald-500 rounded-full"></div>
                                        {{ $data->booking->field->name }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="text-gray-700 font-medium">
                                        {{ \Carbon\Carbon::parse($data->booking->date)->translatedFormat('d M Y') }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="text-gray-800 font-medium">{{ $data->booking->start_time }}</span>
                                        <span class="text-gray-500 text-sm">s/d {{ $data->booking->end_time }}</span>
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="font-bold text-emerald-700">
                                        Rp {{ number_format($data->booking->total_price, 0, ',', '.') }}
                                    </div>
                                </td>
                                <td class="p-4">
                                    <div class="flex flex-col">
                                        <span class="text-gray-700 font-medium">
                                            {{ \Carbon\Carbon::parse($data->created_at)->translatedFormat('d M Y') }}
                                        </span>
                                        <span class="text-gray-500 text-sm">
                                            {{ \Carbon\Carbon::parse($data->created_at)->format('H:i') }}
                                        </span>
                                    </div>
                                </td>
                            </tr>
                        @endforeach

                        @if ($verify->count() == 0)
                            <tr>
                                <td colspan="7" class="p-12 text-center">
                                    <div class="flex flex-col items-center justify-center">
                                        <div
                                            class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-6">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                                </path>
                                            </svg>
                                        </div>
                                        <h3 class="text-xl font-bold text-gray-500 mb-2">Belum ada tiket terverifikasi</h3>
                                        <p class="text-gray-400 max-w-md">
                                            Mulai scan QR Code tiket untuk menampilkan data verifikasi di sini
                                        </p>
                                    </div>
                                </td>
                            </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script></script>
@endsection
