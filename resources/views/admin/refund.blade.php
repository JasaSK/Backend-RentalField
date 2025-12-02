@extends('admin.layouts.master')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-3">Kelola Refund</h1>

    <div class="p-3 flex-1">
        <div class="mx-auto w-[97%] max-w-[1500px] space-y-6 mb-6">

            @if (session('success'))
                <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">{{ session('error') }}</div>
            @endif

            <!-- Card Daftar Refund -->
            <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 mt-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Daftar Refund</h3>

                <table class="w-full border-collapse">
                    <thead class="text-center bg-gray-100">
                        <tr class="border-b border-gray-300">
                            <th class="py-3 px-3">No</th>
                            <th class="py-3 px-3">Kode Booking</th>
                            <th class="py-3 px-3">Alasan Refund</th>
                            <th class="py-3 px-3">Bukti Transfer</th>
                            <th class="py-3 px-3">Status</th>
                            <th class="py-3 px-3">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700">
                        @foreach ($refunds as $index => $refund)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="py-3 text-center">{{ $index + 1 }}</td>
                                <td class="py-3 text-center">{{ $refund->booking->code_booking ?? '-' }}</td>
                                <td class="py-3 text-center">{{ $refund->reason }}</td>

                                <td class="py-3 text-center">
                                    @if ($refund->proof)
                                        <img src="{{ asset('storage/' . $refund->proof) }}"
                                            class="w-20 h-14 object-cover rounded shadow mx-auto">
                                    @else
                                        <span class="text-gray-400">Tidak ada</span>
                                    @endif
                                </td>

                                <td class="py-3 text-center">
                                    @php
                                        $badge =
                                            [
                                                'approved' => 'bg-green-600',
                                                'pending' => 'bg-yellow-600',
                                                'rejected' => 'bg-red-600',
                                            ][$refund->refund_status] ?? 'bg-gray-500';
                                    @endphp
                                    <span class="text-white px-3 py-1 rounded-md shadow {{ $badge }}">
                                        {{ ucfirst($refund->refund_status) }}
                                    </span>
                                </td>

                                <td class="py-3">
                                    <div class="flex justify-center gap-2">

                                        {{-- Tombol hanya muncul jika refund masih pending --}}
                                        @if ($refund->refund_status === 'pending')
                                            {{-- Tombol Accept (buka modal) --}}
                                            <button
                                                class="editRefundBtn bg-blue-600 hover:bg-blue-700 text-white px-3 py-1.5 rounded-md text-sm shadow"
                                                data-id="{{ $refund->id }}" data-amount="{{ $refund->booking->amount }}"
                                                data-proof="{{ $refund->proof ? asset('storage/' . $refund->proof) : '' }}">
                                                Accept
                                            </button>

                                            {{-- Tombol Reject langsung proses --}}
                                            <form action="{{ route('admin.refund.reject', $refund->id) }}" method="POST"
                                                class="deleteForm">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-[#880719] hover:bg-[#a41e27] text-white px-3 py-1.5 rounded-md shadow text-sm">
                                                    Reject
                                                </button>
                                            </form>
                                        @else
                                            {{-- Jika approved atau rejected --}}
                                            <span class="text-gray-400 italic">Tidak ada aksi</span>
                                        @endif

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

                <!-- MODAL EDIT REFUND -->
                <div id="editRefundModal"
                    class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                    <div class="bg-white w-[380px] rounded-xl shadow-lg p-6">

                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Konfirmasi Refund</h2>

                        <form method="POST" id="editRefundForm" enctype="multipart/form-data">
                            @csrf
                            @method('POST')

                            <!-- Amount -->
                            <div class="mb-4">
                                <label class="text-sm font-medium">Jumlah Refund</label>
                                <input type="number" id="refundAmount" name="refund_amount"
                                    class="border rounded-lg w-full px-3 py-2" placeholder="Masukkan jumlah refund">
                            </div>

                            <!-- Preview Proof -->
                            <img id="refundPreviewImage" class="hidden w-32 mx-auto mb-3 rounded-md shadow">

                            <!-- Upload Proof -->
                            <div class="mb-4">
                                <label class="text-sm font-medium">Upload Bukti Transfer</label>
                                <input type="file" id="refundImageInput" name="proof"
                                    class="border rounded-lg w-full px-3 py-2">
                            </div>

                            <div class="flex justify-end gap-2 mt-5">
                                <button type="button" id="refundCancel" class="px-4 py-2 border rounded-lg">Batal</button>

                                <button type="submit"
                                    class="px-4 py-2 bg-[#880719] hover:bg-[#a41e27] text-white rounded-lg">
                                    Konfirmasi
                                </button>
                            </div>
                        </form>
                    </div>
                </div>


            </div>
        </div>
    </div>
@endsection
