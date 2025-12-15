@extends('admin.layouts.master')

@section('content')
    <div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 p-4 md:p-6">
        <!-- Header -->
        <div class="mb-8">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-2">Maintenance Lapangan</h1>
            <p class="text-gray-600">Kelola jadwal pemeliharaan lapangan dengan mudah</p>
        </div>

        <div class="max-w-7xl mx-auto space-y-8">

            <!-- Tambah Maintenance Card -->
            <div
                class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden transition-all duration-300 hover:shadow-2xl">
                <div class="p-6 md:p-8">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-3 bg-red-50 rounded-xl">
                            <svg class="w-6 h-6 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.732-.833-2.464 0L4.282 16.5c-.77.833.192 2.5 1.732 2.5z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-gray-800">Tambah Jadwal Maintenance</h2>
                    </div>

                    <form action="{{ route('admin.maintenance.store') }}" method="POST"
                        class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @csrf

                        <!-- Nama Lapangan -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                    </svg>
                                    Nama Lapangan
                                </span>
                            </label>
                            <select name="field_id" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300">
                                <option value="" disabled selected class="text-gray-400">Pilih Lapangan</option>
                                @foreach ($fields as $field)
                                    <option value="{{ $field->id }}" class="py-2">{{ $field->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Tanggal -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    Tanggal Maintenance
                                </span>
                            </label>
                            <input type="date" name="date" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300">
                        </div>

                        <!-- Jam Mulai & Selesai -->
                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Jam Mulai
                                </span>
                            </label>
                            <input type="time" name="start_time" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300">
                        </div>

                        <div class="space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                    </svg>
                                    Jam Selesai
                                </span>
                            </label>
                            <input type="time" name="end_time" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300">
                        </div>

                        <!-- Alasan (Full Width) -->
                        <div class="md:col-span-2 space-y-2">
                            <label class="block text-sm font-semibold text-gray-700">
                                <span class="flex items-center gap-2">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M13 16h-1v-4h1m0 0h-1m1 0v4m0 0v4h-1m1-4h6m-3-3v3m0 0v3" />
                                    </svg>
                                    Alasan Maintenance
                                </span>
                            </label>
                            <textarea name="reason" rows="3" required
                                class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-red-500 focus:border-transparent transition-all duration-300"
                                placeholder="Masukkan alasan maintenance..."></textarea>
                        </div>

                        <!-- Tombol Submit -->
                        <div class="md:col-span-2">
                            <button type="submit"
                                class="w-full md:w-auto px-8 py-4 bg-gradient-to-r from-red-600 to-red-700 hover:from-red-700 hover:to-red-800 text-white font-semibold rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                                <span class="flex items-center justify-center gap-2">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                                    </svg>
                                    Tambah Jadwal Maintenance
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Daftar Maintenance Card -->
            <div class="bg-white rounded-2xl shadow-xl border border-gray-100 overflow-hidden">
                <div class="p-6 md:p-8 border-b border-gray-100">
                    <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                        <div class="flex items-center gap-3">
                            <div class="p-3 bg-blue-50 rounded-xl">
                                <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                                </svg>
                            </div>
                            <div>
                                <h2 class="text-2xl font-bold text-gray-800">Daftar Jadwal Maintenance</h2>
                                <p class="text-gray-600 text-sm mt-1">{{ count($maintenances) }} jadwal maintenance aktif
                                </p>
                            </div>
                        </div>

                        <!-- Search & Filter (Optional) -->
                        <div class="relative">
                            <input type="text" placeholder="Cari maintenance..."
                                class="pl-10 pr-4 py-2.5 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent w-full md:w-64">
                            <svg class="absolute left-3 top-3 w-4 h-4 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                            </svg>
                        </div>
                    </div>
                </div>

                <!-- Table Container -->
                <div class="overflow-x-auto">
                    <table class="w-full">
                        <thead class="bg-gray-50">
                            <tr class="text-left">
                                <th
                                    class="py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider border-b border-gray-200">
                                    <div class="flex items-center gap-2">
                                        <span>#</span>
                                    </div>
                                </th>
                                <th
                                    class="py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider border-b border-gray-200">
                                    Lapangan
                                </th>
                                <th
                                    class="py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider border-b border-gray-200">
                                    Tanggal
                                </th>
                                <th
                                    class="py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider border-b border-gray-200">
                                    Waktu
                                </th>
                                <th
                                    class="py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider border-b border-gray-200">
                                    Alasan
                                </th>
                                <th
                                    class="py-4 px-6 font-semibold text-gray-700 text-sm uppercase tracking-wider border-b border-gray-200 text-center">
                                    Aksi
                                </th>
                            </tr>
                        </thead>

                        <tbody class="divide-y divide-gray-100">
                            @foreach ($maintenances as $index => $m)
                                <tr class="hover:bg-gray-50 transition-colors duration-200" data-id="{{ $m->id }}">
                                    <!-- No -->
                                    <td class="py-4 px-6">
                                        <span
                                            class="inline-flex items-center justify-center w-8 h-8 bg-gray-100 text-gray-700 rounded-lg font-medium">
                                            {{ $index + 1 }}
                                        </span>
                                    </td>

                                    <!-- Lapangan -->
                                    <td class="py-4 px-6">
                                        <div class="flex items-center gap-3">
                                            <div
                                                class="w-10 h-10 bg-gradient-to-br from-red-100 to-red-50 rounded-lg flex items-center justify-center">
                                                <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                                                </svg>
                                            </div>
                                            <div>
                                                <span class="font-semibold text-gray-800">{{ $m->field->name }}</span>
                                            </div>
                                        </div>
                                    </td>

                                    <!-- Tanggal -->
                                    <td class="py-4 px-6">
                                        <div class="inline-flex flex-col">
                                            <span class="font-semibold text-gray-800">
                                                {{ \Carbon\Carbon::parse($m->date)->format('d M Y') }}
                                            </span>
                                            <span class="text-sm text-gray-500">
                                                {{ \Carbon\Carbon::parse($m->date)->isoFormat('dddd') }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Waktu -->
                                    <td class="py-4 px-6">
                                        <div
                                            class="inline-flex items-center gap-2 bg-blue-50 text-blue-700 px-3 py-1.5 rounded-lg">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <span class="font-medium">{{ $m->start_time }} - {{ $m->end_time }}</span>
                                        </div>
                                    </td>

                                    <!-- Alasan -->
                                    <td class="py-4 px-6">
                                        <div class="max-w-xs">
                                            <span class="text-gray-700 line-clamp-2" title="{{ $m->reason }}">
                                                {{ $m->reason }}
                                            </span>
                                        </div>
                                    </td>

                                    <!-- Aksi -->
                                    <td class="py-4 px-6">
                                        <div class="flex items-center justify-center gap-2">
                                            <!-- Edit Button -->
                                            <button
                                                class="editMaintenanceBtn flex items-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg transition-all duration-300 transform hover:scale-105"
                                                data-id="{{ $m->id }}" data-field="{{ $m->field_id }}"
                                                data-date="{{ $m->date }}" data-start="{{ $m->start_time }}"
                                                data-end="{{ $m->end_time }}" data-reason="{{ $m->reason }}">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                    </path>
                                                </svg>
                                                Edit
                                            </button>

                                            <!-- Delete Button -->
                                            <form action="{{ route('admin.maintenance.destroy', $m->id) }}"
                                                method="POST" class="deleteForm"
                                                onsubmit="return confirmDelete(event)>
                                                @csrf
                                                @method('DELETE')
                                                 <button type="submit"
                                                class="bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm hover:shadow transition-all duration-200 flex items-center gap-2">
                                                <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                    </path>
                                                </svg>
                                                Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @endforeach

                            @if ($maintenances->isEmpty())
                                <tr>
                                    <td colspan="6" class="py-12 text-center">
                                        <div class="flex flex-col items-center justify-center text-gray-400">
                                            <svg class="w-16 h-16 mb-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M9.172 16.172a4 4 0 015.656 0M9 10h.01M15 10h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                            </svg>
                                            <h3 class="text-lg font-semibold mb-1">Belum ada maintenance</h3>
                                            <p>Tambah jadwal maintenance pertama Anda</p>
                                        </div>
                                    </td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Maintenance -->
    <div id="editMaintenanceModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center p-4 bg-black/50 backdrop-blur-sm transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-2xl w-full max-w-lg transform transition-all duration-300 scale-95 opacity-0"
            id="modalContent">
            <!-- Modal Header -->
            <div class="p-6 border-b border-gray-100">
                <div class="flex items-center justify-between">
                    <div class="flex items-center gap-3">
                        <div class="p-2 bg-blue-100 rounded-lg">
                            <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M11 5H9a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2v-1M11 5a2 2 0 002 2h2a2 2 0 002-2M11 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4" />
                            </svg>
                        </div>
                        <h2 class="text-xl font-bold text-gray-800">Edit Maintenance</h2>
                    </div>
                    <button id="closeMaintenanceModal" class="text-gray-400 hover:text-gray-600 transition-colors">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Modal Body -->
            <form id="editMaintenanceForm" method="POST" class="p-6 space-y-5">
                @csrf
                @method('PUT')
                <input type="hidden" id="maintenance_edit_id" name="id">

                <!-- Field Selection -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Lapangan</label>
                    <select id="maintenance_edit_field_id" name="field_id"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                        @foreach ($fields as $field)
                            <option value="{{ $field->id }}">{{ $field->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Date -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Tanggal</label>
                    <input type="date" id="maintenance_edit_date" name="date"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                </div>

                <!-- Time Range -->
                <div class="grid grid-cols-2 gap-4">
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Mulai</label>
                        <input type="time" id="maintenance_edit_start_time" name="start_time"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    </div>
                    <div class="space-y-2">
                        <label class="block text-sm font-semibold text-gray-700">Selesai</label>
                        <input type="time" id="maintenance_edit_end_time" name="end_time"
                            class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300">
                    </div>
                </div>

                <!-- Reason -->
                <div class="space-y-2">
                    <label class="block text-sm font-semibold text-gray-700">Alasan</label>
                    <textarea id="maintenance_edit_reason" name="reason" rows="3"
                        class="w-full px-4 py-3 border border-gray-300 rounded-xl focus:ring-2 focus:ring-blue-500 focus:border-transparent transition-all duration-300"></textarea>
                </div>

                <!-- Modal Footer -->
                <div class="flex justify-end gap-3 pt-4">
                    <button type="button" id="closeMaintenanceModal2"
                        class="px-6 py-3 border border-gray-300 text-gray-700 font-medium rounded-xl hover:bg-gray-50 transition-all duration-300">
                        Batal
                    </button>
                    
                    <button type="submit"
                        class="px-6 py-3 bg-blue-600 hover:bg-blue-700 text-white font-medium rounded-xl shadow-lg hover:shadow-xl transition-all duration-300 transform hover:-translate-y-0.5">
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>
@endsection
