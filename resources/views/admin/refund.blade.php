@extends('admin.layouts.master')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-3">Kelola Refund</h1>

    <div class="p-3 flex-1">
        <div class="mx-auto w-[97%] max-w-[1500px] space-y-6 mb-6">

            <!-- Flash Message -->
            @if (session('success'))
                <div class="bg-green-500 text-white px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if (session('error'))
                <div class="bg-red-500 text-white px-4 py-2 rounded mb-4">
                    {{ session('error') }}
                </div>
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
                                <td class="py-3 px-2 text-center">{{ $index + 1 }}</td>
                                <td class="py-3 px-2 text-center">{{ $refund->booking->code_booking ?? '-' }}</td>
                                <td class="py-3 px-2 text-center">{{ $refund->reason ?? '-' }}</td>
                                <td class="py-3 px-2">
                                    <div class="flex justify-center">
                                        @if ($refund->proof)
                                            <img src="{{ asset('storage/' . $refund->proof) }}" alt="Bukti Transfer"
                                                class="w-20 h-14 object-cover rounded-md shadow">
                                        @else
                                            <span class="text-gray-400">Belum ada</span>
                                        @endif
                                    </div>
                                </td>
                                <td class="py-3 px-2 text-center">
                                    @php
                                        $statusColor = match ($refund->refund_status) {
                                            'approved' => 'bg-green-600',
                                            'pending' => 'bg-yellow-600',
                                            'rejected' => 'bg-red-700',
                                            default => 'bg-gray-400',
                                        };
                                    @endphp
                                    <span
                                        class="{{ $statusColor }} text-white text-sm font-semibold px-3 py-1 rounded-lg shadow">
                                        {{ ucfirst($refund->refund_status ?? 'Pending') }}
                                    </span>
                                </td>
                                <td class="py-3 px-3">
                                    <div class="flex justify-center gap-3">
                                        @if ($refund->refund_status === 'pending')
                                            <form action="{{ route('admin.refund.accept', $refund->id) }}" method="POST"
                                                enctype="multipart/form-data">
                                                @csrf
                                                <input type="hidden" name="refund_amount"
                                                    value="{{ $refund->booking->amount ?? 0 }}">
                                                <input type="file" name="proof" required
                                                    class="hidden proof-input-{{ $refund->id }}">
                                                <button type="button"
                                                    onclick="document.querySelector('.proof-input-{{ $refund->id }}').click()"
                                                    class="bg-[#120A81] hover:bg-blue-900 text-white text-sm font-semibold px-3 py-1 rounded-lg shadow">
                                                    Upload & Konfirmasi
                                                </button>
                                                <button type="submit"
                                                    class="hidden submit-btn-{{ $refund->id }}"></button>
                                            </form>
                                            <form action="{{ route('admin.refund.reject', $refund->id) }}" method="POST">
                                                @csrf
                                                <button type="submit"
                                                    class="bg-[#880719] hover:bg-[#a41e27] text-white text-sm font-semibold px-3 py-1 rounded-lg shadow">
                                                    Tolak
                                                </button>
                                            </form>
                                        @else
                                            <span class="text-gray-400">Tidak ada aksi</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        document.querySelectorAll('input[type="file"]').forEach(input => {
            input.addEventListener('change', function() {
                if (this.files.length > 0) {
                    this.parentElement.querySelector('button[type="submit"]').click();
                }
            });
        });
    </script>
@endpush
