@extends('admin.layouts.master')

@section('content')
    <!-- Konten -->
    <h1 class="text-3xl font-bold text-gray-800 mb-3">Info Kategori Lapangan</h1>
    <div class="p-3 flex-1">

        <div class="mx-auto w-[97%] max-w-[1500px] space-y-6 mb-6">

            <!-- Card Tambah Kategori -->
            <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 mt-8">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">Tambah Kategori Lapangan</h3>

                <form action="{{ route('admin.field-categories.store') }}" method="POST" class="space-y-4">
                    @csrf

                    <!-- Nama kategori -->
                    <label class="block text-gray-700 font-semibold mb-1">Nama Kategori</label>
                    <input type="text" name="name" placeholder="Masukkan kategori lapangan"
                        class="bg-gray-100 border border-gray-300 rounded-lg w-full px-4 py-2 text-gray-700 placeholder-gray-400 focus:outline-none focus:ring-2 focus:ring-[#13810A]" />

                    <!-- Tombol -->
                    <button type="submit"
                        class="bg-[#880719] hover:bg-[#a41e27] text-white font-semibold px-5 py-2 rounded-lg shadow-md transition-all">
                        Tambah Kategori
                    </button>
                </form>
            </div>

            <!-- Card Daftar Kategori -->
            <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 mt-6">
                <h3 class="text-2xl font-bold text-gray-800 mb-4">
                    Daftar Kategori Lapangan
                </h3>

                <!-- WRAPPER SCROLL -->
                <div class="overflow-x-auto overflow-y-auto max-h-[450px]">
                    <table class="w-full min-w-[600px] border-collapse">
                        <thead class="text-center bg-gray-100 sticky top-0 z-10">
                            <tr class="border-b border-gray-300">
                                <th class="py-3 px-3">No</th>
                                <th class="py-3 px-3">Nama Kategori</th>
                                <th class="py-3 px-3">Aksi</th>
                            </tr>
                        </thead>

                        <tbody class="text-gray-700">
                            @foreach ($categories as $index => $category)
                                <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                                    <td class="py-3 px-2 text-center">
                                        {{ $index + 1 }}
                                    </td>

                                    <td class="py-3 px-2 text-center">
                                        {{ $category['name'] }}
                                    </td>

                                    <td class="py-3 px-2">
                                        <div class="flex justify-center items-center gap-2">

                                            <!-- Tombol Edit -->
                                            <button
                                                class="editFieldCategoryBtn flex items-center gap-1 bg-blue-800 hover:bg-blue-700 text-white text-xs font-medium px-3 py-1.5 rounded-md shadow-sm transition"
                                                data-id="{{ $category['id'] }}" data-name="{{ $category['name'] }}">
                                                <svg xmlns="http://www.w3.org/2000/svg" fill="none" class="w-4 h-4"
                                                    viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M11 5h2m2 0h.01M6 20h12a2 2 0 002-2v-5a2 2 0 00-2-2H6a2 2 0 00-2 2v5a2 2 0 002 2zm6-7v.01" />
                                                </svg>
                                                Edit
                                            </button>

                                            <!-- Tombol Delete -->
                                            <form action="{{ route('admin.field-categories.destroy', $category['id']) }}"
                                                method="POST" class="deleteForm">
                                                @csrf
                                                @method('DELETE')

                                                <button type="submit"
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

                <!-- MODAL EDIT (DI LUAR SCROLL) -->
                <div id="editFieldCategoryModal"
                    class="hidden fixed inset-0 bg-black bg-opacity-40 flex items-center justify-center z-50">
                    <div class="bg-white rounded-xl shadow-lg p-6 w-[400px] relative">
                        <h2 class="text-xl font-semibold text-gray-800 mb-4">
                            Edit Kategori
                        </h2>

                        <form action="" method="POST" id="editFieldCategoryForm">
                            @csrf
                            @method('PUT')

                            <div class="mb-3">
                                <label class="block text-sm font-medium text-gray-700 mb-1">
                                    Nama Kategori
                                </label>
                                <input type="text" id="editFieldCategoryName" name="name"
                                    class="border border-gray-300 rounded-lg w-full px-3 py-2 focus:ring-2 focus:ring-[#880719]" />
                            </div>

                            <div class="flex justify-end gap-2 mt-5">
                                <button type="button" id="cancelFieldCategoryEdit"
                                    class="px-4 py-2 rounded-lg border border-gray-300 text-gray-700 hover:bg-gray-100">
                                    Batal
                                </button>
                                <button type="submit"
                                    class="px-4 py-2 rounded-lg bg-[#880719] hover:bg-[#a41e27] text-white font-semibold">
                                    Simpan
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection
