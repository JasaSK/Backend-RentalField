@extends('admin.layouts.master')

@section('content')
    <!-- Konten -->
    <h1 class="text-3xl font-bold text-gray-800 mb-3">Info Galeri</h1>
    <div class="p-3 flex-1">

        <!-- Wrapper utama untuk atur lebar -->
        <div class="mx-auto w-[97%] max-w-[1500px] space-y-6 mb-6">

            <!-- Card Upload Galeri -->
            <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 mt-8">
                <form action="{{ route('admin.gallery.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf <!-- CSRF Token -->

                    <h3 class="text-2xl font-bold text-gray-800 mb-4">Upload Galeri Baru</h3>

                    <!-- Nama Gambar -->
                    <label class="block text-gray-700 font-medium mb-2" for="name">Nama Gambar</label>
                    <input type="text" name="name" id="name" placeholder="Nama Gambar"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#880719] mb-4"
                        value="{{ old('name') }}" />

                    <!-- Deskripsi Gambar -->
                    <label class="block text-gray-700 font-medium mb-2" for="description">Deskripsi Gambar</label>
                    <input type="text" name="description" id="description" placeholder="Deskripsi Gambar"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#880719] mb-4"
                        value="{{ old('description') }}" />

                    <!-- Dropdown Kategori -->
                    <label class="block text-gray-700 font-medium mb-2" for="category_gallery_id">Kategori</label>
                    <select name="category_gallery_id" id="category_gallery_id"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full mb-4 text-gray-700 focus:outline-none focus:ring-2 focus:ring-[#13810A]">
                        <option value="" disabled selected>Pilih kategori</option>
                        @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}"
                                {{ old('category_gallery_id') == $category['id'] ? 'selected' : '' }}>
                                {{ $category['name'] }}
                            </option>
                        @endforeach
                    </select>

                    <!-- Upload Gambar -->
                    <label class="block text-gray-700 font-medium mb-2" for="image">Upload Gambar Galeri</label>
                    <input type="file" name="image" id="image"
                        class="border border-gray-300 rounded-lg px-3 py-2 w-full cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#880719] mb-4" />

                    <button type="submit"
                        class="bg-[#880719] hover:bg-[#a41e27] text-white font-semibold px-5 py-2 rounded-lg shadow-md">
                        Upload Galeri
                    </button>
                </form>
            </div>

            <!-- Card Daftar Galeri -->
            <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 mt-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">
                    Daftar Galeri
                </h3>

                <!-- WRAPPER SCROLL -->
                <div class="overflow-x-auto overflow-y-auto max-h-[450px]">
                    <table class="w-full min-w-[900px] border-collapse">
                        <thead class="text-center bg-gray-100 sticky top-0 z-10">
                            <tr class="border-b border-gray-300">
                                <th class="py-3 px-2">No</th>
                                <th class="py-3 px-2">Gambar</th>
                                <th class="py-3 px-2">Nama</th>
                                <th class="py-3 px-2">Deskripsi</th>
                                <th class="py-3 px-2">Tanggal Upload</th>
                                <th class="py-3 px-2">Kategori</th>
                                <th class="py-3 px-2">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-700 text-center">
                            @foreach ($galleries as $index => $data)
                                <tr data-id="{{ $data['id'] }}"
                                    class="border-b border-gray-200 hover:bg-gray-50 transition">

                                    <td class="py-3 px-2">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="py-3 px-2">
                                        <div class="flex items-center justify-center">
                                            <img src="{{ $data->image ? asset('storage/' . $data->image) : '' }}"
                                                alt="Fasilitas" class="w-20 h-14 object-cover rounded-md shadow">
                                        </div>
                                    </td>

                                    <td class="py-3 px-2">
                                        {{ $data['name'] }}
                                    </td>

                                    <td class="py-3 px-2">
                                        {{ $data['description'] }}
                                    </td>

                                    <td class="py-3 px-2">
                                        {{ \Carbon\Carbon::parse($data['created_at'])->format('d M Y') }}
                                    </td>

                                    <td class="py-3 px-2">
                                        {{ $data->categoryGallery->name ?? 'Tidak ada kategori' }}
                                    </td>

                                    <td class="py-3 px-2">
                                        <div class="flex w-full justify-center items-center gap-2">

                                            <!-- Tombol Edit -->
                                            <button
                                                class="editBtn flex items-center gap-1 bg-blue-800 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded-md shadow-sm transition"
                                                data-id="{{ $data['id'] }}" data-name="{{ $data['name'] }}"
                                                data-description="{{ $data['description'] }}"
                                                data-category-id="{{ $data->category_gallery_id }}"
                                                data-category="{{ $data->categoryGallery->name ?? '' }}"
                                                data-image="{{ $data->image ? asset('storage/' . $data->image) : '' }}">

                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-4 h-4"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5h2m2 0h.01M6 20h12a2 2 0 002-2v-5a2 2 0 00-2-2H6a2 2 0 00-2 2v5a2 2 0 002 2zm6-7v.01" />
                                                </svg>
                                                Edit
                                            </button>

                                            <!-- Tombol Hapus -->
                                            <form action="{{ route('admin.gallery.destroy', $data['id']) }}" method="POST"
                                                class="deleteForm">
                                                @csrf
                                                @method('DELETE')

                                                <button
                                                    class="hapusBtn flex items-center gap-1 bg-[#880719] hover:bg-[#a41e27] text-white text-xs font-medium px-3 py-1.5 rounded-md shadow-sm transition">

                                                    <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-4 h-4"
                                                        viewBox="0 0 24 24" stroke="currentColor">
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
            </div>

        </div>
    </div>

    <!-- Modal Edit Galeri (full screen) -->
    <div id="editGalleryModal"
        class="hidden fixed top-0 left-0 w-screen h-screen bg-black bg-opacity-40 flex items-center justify-center z-[9999]">
        <div class="bg-white rounded-xl shadow-lg p-6 w-[400px] relative">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Galeri</h2>

            <form id="editGalleryForm" method="POST" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <input type="hidden" id="edit_id" name="id">

                <!-- Nama -->
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Nama Galeri</label>
                    <input type="text" id="edit_name" name="name"
                        class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]" />
                </div>

                <!-- Deskripsi -->
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                    <textarea id="edit_description" name="description"
                        class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]"></textarea>
                </div>

                <!-- Kategori -->
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kategori</label>
                    <select id="edit_category" name="category_gallery_id"
                        class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]">
                        @foreach ($categories as $cat)
                            <option value="{{ $cat['id'] }}">{{ $cat['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Preview Gambar -->
                <img id="previewGalleryImage" src="" alt="Preview Gambar"
                    class="hidden w-32 mx-auto mb-3 rounded-md shadow">

                <!-- Upload Gambar Baru -->
                <div class="mb-3">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Gambar Galeri</label>
                    <input type="file" id="editGalleryImage" name="image"
                        class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]" />
                </div>

                <!-- Tombol -->
                <div class="flex justify-end gap-2 mt-5">
                    <button type="button" id="closeGalleryModal"
                        class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Batal</button>
                    <button type="submit"
                        class="px-4 py-2 rounded-lg bg-[#880719] hover:bg-[#a41e27] text-white font-semibold">Simpan</button>
                </div>
            </form>
        </div>
    </div>
@endsection
