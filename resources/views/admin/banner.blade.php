@extends('admin.layouts.master')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-3">Info Banner</h1>
    <div class="p-3 flex-1">
        <div class="mx-auto w-[97%] max-w-[1500px] space-y-6 mb-6">

            <!-- Card Upload Banner -->
            <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6">
                <h3 class="text-xl font-semibold mb-4 text-gray-800">Upload Banner</h3>
                <form action="{{ route('admin.banner.store') }}" method="POST" enctype="multipart/form-data" class="w-full">
                    @csrf

                    <!-- Upload Gambar Banner -->
                    <p class="text-gray-700 mb-2">Upload Gambar Banner</p>
                    <div class="flex items-center gap-3 mb-4">
                        <input type="file" name="image"
                            class="border border-gray-300 rounded-lg px-3 py-2 w-full cursor-pointer focus:outline-none focus:ring-2 focus:ring-[#880719]" />
                    </div>

                    <!-- Name -->
                    <p class="text-gray-700 mb-2">Nama Banner</p>
                    <div class="flex items-center gap-3 mb-4">
                        <input type="text" name="name" placeholder="Masukkan judul banner"
                            class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#880719]" />
                    </div>

                    <!-- Description -->
                    <p class="text-gray-700 mb-2">Deskripsi</p>
                    <div class="flex items-center gap-3 mb-4">
                        <textarea name="description" placeholder="Masukkan deskripsi banner"
                            class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#880719]"></textarea>
                    </div>

                    <!-- Status / Option -->
                    <p class="text-gray-700 mb-2">Status Banner</p>
                    <div class="flex items-center gap-3 mb-4">
                        <select name="status"
                            class="border border-gray-300 rounded-lg px-3 py-2 w-full focus:outline-none focus:ring-2 focus:ring-[#880719]">
                            @foreach ($options as $status)
                                <option value="{{ $status }}">{{ ucfirst($status) }}</option>
                            @endforeach
                            {{-- <option value="non-active">Non-active</option> --}}
                        </select>
                    </div>

                    <!-- Tombol Submit -->
                    <button type="submit"
                        class="bg-[#880719] hover:bg-[#a41e27] text-white font-semibold px-5 py-2 rounded-lg shadow-md">
                        Upload Banner
                    </button>
                </form>

            </div>

            <!-- Card Daftar Banner -->
            <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Daftar Banner</h3>

                <table class="w-full border-collapse">
                    <thead class="text-center bg-gray-100">
                        <tr class="border-b border-gray-300">
                            <th class="py-3 px-2">No</th>
                            <th class="py-3 px-2">Gambar</th>
                            <th class="py-3 px-2">Nama</th>
                            <th class="py-3 px-2">Deskripsi</th>
                            <th class="py-3 px-2">Tanggal Upload</th>
                            <th class="py-3 px-2">Status</th>
                            <th class="py-3 px-2">Aksi</th>
                        </tr>
                    </thead>

                    <tbody class="text-gray-700 text-center">
                        @foreach ($banners as $index => $data)
                            <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                <td class="py-3 px-2">{{ $index + 1 }}</td>
                                <td class="py-3 px-2"> <img src="{{ $data->image ? asset('storage/' . $data->image) : '' }}"
                                        alt="Banners" class="banner-img w-20 mx-auto rounded-md shadow"></td>
                                <td class="py-3 px-2 nama">
                                    {{ $data['name'] }}
                                </td>
                                <td class="py-3 px-2 deskripsi">
                                    {{ $data['description'] }}
                                </td>
                                <td class="py-3 px-2 tanggal">
                                    {{ \Carbon\Carbon::parse($data['created_at'])->format('d M Y') }}
                                </td>
                                <td class="py-3 px-2 text-center">
                                    <span
                                        class="inline-block px-3 py-1 text-sm font-semibold rounded-full shadow text-white
                                        {{ $data['status'] === 'active' ? 'bg-green-600' : 'bg-gray-500' }}">
                                        {{ ucfirst($data['status']) }}
                                    </span>
                                </td>
                                <td class="py-3 px-2">
                                    <div class="flex w-full justify-center items-center gap-2">
                                        <!-- Tombol Edit -->
                                        <button
                                            class="editBannerBtn flex items-center gap-1 bg-blue-600 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded-md shadow-sm transition"
                                            data-id="{{ $data['id'] }}" data-name="{{ $data['name'] }}"
                                            data-description="{{ $data['description'] }}"
                                            data-status="{{ $data['status'] }}"
                                            data-image="{{ $data->image ? asset('storage/' . $data->image) : '' }}"
                                            data-created_at="{{ $data['created_at'] }}">
                                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-4 h-4"
                                                viewBox="0 0 24 24" stroke="currentColor">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M11 5h2m2 0h.01M6 20h12a2 2 0 002-2v-5a2 2 0 00-2-2H6a2 2 0 00-2 2v5a2 2 0 002 2zm6-7v.01" />
                                            </svg>
                                            Edit
                                        </button>

                                        <!-- Tombol Hapus -->
                                        <form action="{{ route('admin.banner.destroy', $data['id']) }}" method="POST"
                                            class="deleteForm">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit"
                                                class="hapusBtn flex items-center gap-1 bg-red-600 hover:bg-red-700 text-white text-xs font-medium px-3 py-1.5 rounded-md shadow-sm transition">
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

            <!-- 🔹 Modal Edit Banner -->
            <div id="editBannersModal"
                class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                <div class="bg-white rounded-xl shadow-lg p-6 w-[400px] relative">
                    <h2 class="text-xl font-semibold text-gray-800 mb-4">Edit Banner</h2>

                    <form action="" method="POST" id="editBannersForm" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')

                        <!-- Nama Banner -->
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Nama Banner</label>
                            <input type="text" id="editBannersName" name="name" placeholder="Masukkan nama banner"
                                class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]" />
                        </div>

                        <!-- Deskripsi -->
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Deskripsi</label>
                            <textarea id="editBannersDescription" name="description"
                                class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]"></textarea>
                        </div>

                        <!-- Tanggal Upload -->
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Upload</label>
                            <input type="date" id="editBannersDate" name="tanggal"
                                class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]" />
                        </div>
                        <!-- Preview Gambar -->
                        <img id="previewBannersImage" src="" alt="Preview Banner"
                            class="hidden w-32 mx-auto mb-3 rounded-md shadow">

                        <!-- Upload Gambar Baru -->
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Ganti Gambar Banner</label>
                            <input type="file" id="editBannersImage" name="image"
                                class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]" />
                        </div>

                        <!-- Status -->
                        <div class="mb-3">
                            <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                            <select id="editBannersStatus" name="status"
                                class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:outline-none focus:ring-2 focus:ring-[#880719]">
                                <option value="active">Aktif</option>
                                <option value="non-active">Nonaktif</option>
                            </select>
                        </div>


                        <div class="flex justify-end gap-2 mt-5">
                            <button type="button" id="cancelBannersEdit"
                                class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">Batal</button>
                            <button type="submit"
                                class="px-4 py-2 rounded-lg bg-[#880719] hover:bg-[#a41e27] text-white font-semibold">Simpan</button>
                        </div>
                    </form>

                </div>
            </div>

        </div>
    </div>
@endsection
