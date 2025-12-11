@extends('admin.layouts.master')

@section('content')
    <!-- Konten -->
    <h1 class="text-3xl font-bold text-gray-800 mb-3">Info Lapangan</h1>
    <div class="p-3 flex-1">

        <!-- Wrapper utama untuk atur lebar -->
        <div class="mx-auto w-[97%] max-w-[1500px] space-y-6 mb-6">

            <!-- Card Upload Galeri -->
            <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 mt-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Kelola Lapangan</h3>

                <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
                    @csrf

                    <!-- Lapangan -->
                    <label class="block text-gray-700 font-semibold mb-1">Nama Lapangan</label>
                    <input type="text" name="name" placeholder="contoh: Lapangan 1"
                        class="bg-gray-100 border border-gray-300 rounded-lg w-full px-4 py-2 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#13810A]" />

                    <!-- Upload Gambar -->
                    <label class="block text-gray-700 font-medium mb-1">Upload Gambar Galeri</label>
                    <input type="file" name="image"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#880719]" />

                    <!-- Jam Buka -->
                    <label class="block text-gray-700 font-medium mb-1">Jam Buka</label>
                    <input type="time" name="open_time"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#880719]" />

                    <!-- Jam Tutup -->
                    <label class="block text-gray-700 font-medium mb-1">Jam Tutup</label>
                    <input type="time" name="close_time"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#880719]" />

                    <!-- Harga per jam -->
                    <label class="block text-gray-700 font-medium mb-1">Harga per Jam</label>
                    <input type="number" name="price_per_hour" placeholder="contoh: 50000"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#880719]" />

                    <!-- Deskripsi -->
                    <label class="block text-gray-700 font-medium mb-1">Deskripsi</label>
                    <textarea name="description" rows="3" placeholder="Masukkan deskripsi..."
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#880719]"></textarea>

                    <!-- Kategori -->
                    <label class="block text-gray-700 font-medium mb-1">Kategori Lapangan</label>
                    <select name="category_field_id"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#880719]"
                        required>
                        @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                        @endforeach
                    </select>

                    <!-- Status -->
                    <label class="block text-gray-700 font-medium mb-1">Status</label>
                    <select name="status"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#880719]">
                        <option value="">-- Pilih Status --</option>
                        <option value="available">Tersedia</option>
                        <option value="booked">Sudah Dibooking</option>
                        <option value="maintenance">Perbaikan</option>
                        <option value="closed">Ditutup</option>
                        <option value="pending">Menunggu Pembayaran</option>
                    </select>


                    <!-- Tombol -->
                    <button type="submit"
                        class="bg-[#880719] hover:bg-[#a41e27] text-white font-semibold px-5 py-2 rounded-lg shadow-md">
                        Upload Galeri
                    </button>
                </form>
            </div>

            <!-- Card Daftar Lapangan -->
            <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 mt-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Daftar Lapangan</h3>
                <div class="overflow-y-auto max-h-[500px] border border-gray-200 rounded-lg shadow">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-100 sticky top-0">
                            <tr>
                                <th class="py-3 px-2 text-center">#</th>
                                <th class="py-3 px-2 text-center">Gambar</th>
                                <th class="py-3 px-2 text-center">Nama</th>
                                <th class="py-3 px-2 text-center">Open Time</th>
                                <th class="py-3 px-2 text-center">Close Time</th>
                                <th class="py-3 px-2 text-center">Deskripsi</th>
                                <th class="py-3 px-2 text-center">Harga</th>
                                <th class="py-3 px-2 text-center">Kategori</th>
                                <th class="py-3 px-2 text-center">Status</th>
                                <th class="py-3 px-2 text-center">Aksi</th>
                            </tr>
                        </thead>
                        <tbody class="text-gray-700">
                            @foreach ($fields as $index => $data)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="py-3 px-2 text-center">{{ $index + 1 }}</td>
                                    <td class="py-3 px-2">
                                        <div class="flex justify-center">
                                            <img src="{{ $data->image ? asset('storage/' . $data->image) : '' }}"
                                                alt="{{ $data->name }}" class="w-20 h-14 object-cover rounded-md shadow">
                                        </div>
                                    </td>
                                    <td class="py-3 px-2 text-center">{{ $data['name'] }}</td>
                                    <td class="py-3 px-2 text-center">{{ $data['open_time'] }}</td>
                                    <td class="py-3 px-2 text-center">{{ $data['close_time'] }}</td>
                                    <td class="py-3 px-2 text-center">{{ $data['description'] }}</td>
                                    <td class="py-3 px-2 text-center">{{ $data['price_per_hour'] }}</td>
                                    <td class="py-3 px-2 text-center status">
                                        <span
                                            class="status-label bg-[#13810A] text-white text-sm font-semibold px-3 py-1 rounded-lg shadow">
                                            {{ $data->categoryField->name ?? 'Tidak ada status' }}
                                        </span>
                                    </td>
                                    <td class="py-3 px-2 text-center">{{ $data['status'] }}</td>
                                    <td class="py-3 px-2">
                                        <div class="flex w-full justify-center items-center gap-2">
                                            <!-- Tombol Edit -->
                                            <button
                                                class="editFieldBtn flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded-md shadow-sm transition"
                                                data-id="{{ $data['id'] }}" data-name="{{ $data['name'] }}"
                                                data-image="{{ $data->image ? asset('storage/' . $data->image) : '' }}"
                                                data-open_time="{{ $data['open_time'] }}"
                                                data-close_time="{{ $data['close_time'] }}"
                                                data-description="{{ $data['description'] }}"
                                                data-price="{{ $data['price_per_hour'] }}"
                                                data-category="{{ $data['category_field_id'] }}"
                                                data-status="{{ $data['status'] }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-4 h-4"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5h2m2 0h.01M6 20h12a2 2 0 002-2v-5a2 2 0 00-2-2H6a2 2 0 00-2 2v5a2 2 0 002 2zm6-7v.01" />
                                                </svg>
                                                Edit
                                            </button>
                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.fields.destroy', $data['id']) }}"
                                                method="POST" class="deleteForm">
                                                @csrf
                                                @method('DELETE')
                                                <button
                                                    class="hapusBtn flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3 py-1.5 rounded-md shadow-sm transition">
                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none"
                                                        class="w-4 h-4" viewBox="0 0 24 24" stroke="currentColor">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="M6 18L18 6M6 6l12 12" />
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


                <!-- 🔹 Modal Edit Lapangan -->
                <div id="editFieldModal"
                    class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl shadow-lg p-6 w-[450px] relative">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Lapangan</h2>

                        <form action="" method="POST" id="editFieldForm" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <!-- Nama Lapangan -->
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Nama Lapangan</label>
                                <input type="text" id="editFieldName" name="name"
                                    class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:ring-2 focus:ring-[#880719]" />
                            </div>

                            <!-- Jam Buka -->
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Buka</label>
                                <input type="time" id="editFieldOpen" name="open_time"
                                    class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:ring-2 focus:ring-[#880719]" />
                            </div>

                            <!-- Jam Tutup -->
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Jam Tutup</label>
                                <input type="time" id="editFieldClose" name="close_time"
                                    class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:ring-2 focus:ring-[#880719]" />
                            </div>

                            <!-- Harga -->
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Harga per Jam</label>
                                <input type="number" id="editFieldPrice" name="price_per_hour"
                                    class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:ring-2 focus:ring-[#880719]" />
                            </div>

                            <!-- Deskripsi -->
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                                <textarea id="editFieldDescription" name="description"
                                    class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:ring-2 focus:ring-[#880719]"></textarea>
                            </div>

                            <!-- Kategori -->
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Kategori Lapangan</label>
                                <select id="editFieldCategory" name="category_field_id"
                                    class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:ring-2 focus:ring-[#880719]">
                                    @foreach ($categories as $category)
                                        <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- Status -->
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                                <select id="editFieldStatus" name="status"
                                    class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:ring-2 focus:ring-[#880719]">
                                    <option value="available">Tersedia</option>
                                    <option value="booked">Sudah Dibooking</option>
                                    <option value="maintenance">Perbaikan</option>
                                    <option value="closed">Ditutup</option>
                                    <option value="pending">Menunggu Pembayaran</option>
                                </select>
                            </div>

                            <!-- Preview Gambar -->
                            <img id="editFieldPreview" src="" class="hidden w-32 mx-auto mb-3 rounded-md shadow">

                            <!-- Upload Gambar Baru -->
                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Gambar</label>
                                <input type="file" id="editFieldImage" name="image"
                                    class="border border-gray-300 rounded-lg px-3 py-2 w-full cursor-pointer focus:ring-2 focus:ring-[#880719]" />
                            </div>

                            <div class="flex justify-end gap-2 mt-5">
                                <button type="button" id="cancelFieldEdit"
                                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Batal</button>
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-[#880719] hover:bg-[#a41e27] text-white font-semibold">Simpan</button>
                            </div>
                        </form>

                    </div>
                </div>

            </div>
        </div>
    </div>
@endsection
