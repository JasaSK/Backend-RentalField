@extends('admin.layouts.master')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-3">Maintenance Lapangan</h1>
    <div class="p-3 flex-1">

        <div class="mx-auto w-[97%] max-w-[1500px] space-y-6 mb-6">

            <!-- Card Tambah Maintenance -->
            <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 mt-8">
                <form action="{{ route('admin.maintenance.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf

                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Tambah Jadwal Maintenance</h3>

                    <!-- Nama Lapangan -->
                    <label class="block text-gray-700 font-medium mb-2">Nama Lapangan</label>
                    <select name="field_id"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full mb-4 focus:ring-2 focus:ring-[#13810A]">
                        <option value="" disabled selected>Pilih Lapangan</option>
                        @foreach ($fields as $field)
                            <option value="{{ $field->id }}">{{ $field->name }}</option>
                        @endforeach
                    </select>

                    <!-- Tanggal -->
                    <label class="block text-gray-700 font-medium mb-2">Tanggal</label>
                    <input type="date" name="date"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full mb-4 focus:ring-2 focus:ring-[#13810A]" />

                    <!-- Jam Buka -->
                    <label class="block text-gray-700 font-medium mb-2">Jadwal Buka</label>
                    <input type="time" name="start_time"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full mb-4 focus:ring-2 focus:ring-[#13810A]" />

                    <!-- Jam Tutup -->
                    <label class="block text-gray-700 font-medium mb-2">Jadwal Tutup</label>
                    <input type="time" name="end_time"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full mb-4 focus:ring-2 focus:ring-[#13810A]" />

                    <!-- Alasan -->
                    <label class="block text-gray-700 font-medium mb-2">Alasan Maintenance</label>
                    <textarea name="reason" rows="3"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full mb-4 focus:ring-2 focus:ring-[#13810A]"></textarea>

                    <button type="submit"
                        class="bg-[#880719] hover:bg-[#a41e27] text-white font-semibold px-5 py-2 rounded-lg shadow-md">
                        Tambah Maintenance
                    </button>
                </form>
            </div>

            <!-- Card Table Maintenance -->
            <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 mt-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Daftar Jadwal Maintenance</h3>

                <table class="w-full border-collapse">
                    <thead class="text-center bg-gray-100">
                        <tr class="border-b border-gray-300">
                            <th class="py-3 px-2">No</th>
                            <th class="py-3 px-2">Lapangan</th>
                            <th class="py-3 px-2">Tanggal</th>
                            <th class="py-3 px-2">Buka</th>
                            <th class="py-3 px-2">Tutup</th>
                            <th class="py-3 px-2">Alasan</th>
                            <th class="py-3 px-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700 text-center">
                        @foreach ($maintenances as $index => $m)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition" data-id="{{ $m->id }}">
                                <td class="py-3 px-2">{{ $index + 1 }}</td>
                                <td class="py-3 px-2">{{ $m->field->name }}</td>
                                <td class="py-3 px-2">{{ \Carbon\Carbon::parse($m->date)->format('d M Y') }}</td>
                                <td class="py-3 px-2">{{ $m->start_time }}</td>
                                <td class="py-3 px-2">{{ $m->end_time }}</td>
                                <td class="py-3 px-2">{{ $m->reason }}</td>
                                </td>
                                <td class="py-3 px-2">
                                    <div class="flex w-full justify-center items-center gap-2">

                                        <!-- Edit -->
                                        <button
                                            class="editMaintenanceBtn flex items-center gap-1 bg-blue-800 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded-md shadow-sm transition"
                                            data-id="{{ $m->id }}" data-field="{{ $m->field_id }}"
                                            data-date="{{ $m->date }}" data-start="{{ $m->start_time }}"
                                            data-end="{{ $m->end_time }}" data-reason="{{ $m->reason }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-4 h-4"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5h2m2 0h.01M6 20h12a2 2 0 002-2v-5a2 2 0 00-2-2H6a2 2 0 00-2 2v5a2 2 0 002 2zm6-7v.01" />
                                            </svg>
                                            Edit
                                        </button>

                                        <!-- Hapus -->
                                        <form action="{{ route('admin.maintenance.destroy', $m->id) }}" method="POST">
                                            @csrf @method('DELETE')
                                            <button type="submit"
                                                class="hapusBtn flex items-center gap-1  bg-[#880719] hover:bg-[#a41e27] text-white text-xs font-medium px-3 py-1.5 rounded-md shadow-sm transition">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-4 h-4"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M6 18L18 6M6 6l12 12" />
                                                </svg>
                                                Hapus
                                            </button>
                                        </form>

                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <!-- Modal Edit Maintenance -->
    <div id="editMaintenanceModal"
        class="hidden fixed inset-0 z-50 flex items-center justify-center bg-black bg-opacity-40 overflow-y-auto p-4">

        <div class="bg-white rounded-xl shadow-lg w-full max-w-[450px] relative p-6 flex flex-col">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Maintenance</h2>

            <form id="editMaintenanceForm" method="POST" class="flex-1 flex flex-col gap-3">
                @csrf
                @method('PUT')

                <input type="hidden" id="maintenance_edit_id" name="id">

                <!-- Pilih Lapangan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lapangan</label>
                    <select id="maintenance_edit_field_id" name="field_id"
                        class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]">
                        @foreach ($fields as $field)
                            <option value="{{ $field->id }}">{{ $field->name }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Tanggal -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" id="maintenance_edit_date" name="date"
                        class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]">
                </div>

                <!-- Waktu Mulai -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Mulai</label>
                    <input type="time" id="maintenance_edit_start_time" name="start_time"
                        class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]">
                </div>

                <!-- Waktu Selesai -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Waktu Selesai</label>
                    <input type="time" id="maintenance_edit_end_time" name="end_time"
                        class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]">
                </div>

                <!-- Alasan -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Alasan Maintenance</label>
                    <textarea id="maintenance_edit_reason" name="reason"
                        class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]"></textarea>
                </div>

                <!-- Tombol -->
                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" id="closeMaintenanceModal"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-[#880719] hover:bg-[#a41e27] text-white font-semibold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
    </div>
@endsection
