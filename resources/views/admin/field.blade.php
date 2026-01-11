@extends('admin.layouts.master')

@section('content')
    <div class="p-6">
        <!-- Header Section -->
        <div class="mb-8">
            <div class="flex items-center gap-4 mb-3">
                <div class="p-3 bg-gradient-to-br from-emerald-100 to-green-100 rounded-xl">
                    <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6">
                        </path>
                    </svg>
                </div>
                <div>
                    <h1 class="text-3xl font-bold text-gray-800">Kelola Lapangan</h1>
                    <p class="text-gray-600 mt-1">Tambah dan kelola informasi lapangan olahraga</p>
                </div>
            </div>

            <!-- Stats Cards -->
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-8">
                <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Total Lapangan</p>
                            <p class="text-2xl font-bold text-gray-800 mt-1">{{ $fields->count() }}</p>
                        </div>
                        <div class="p-3 bg-gray-100 rounded-lg">
                            <svg class="w-6 h-6 text-gray-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                </path>
                            </svg>
                        </div>
                    </div>
                </div>

                <div class="bg-gradient-to-br from-white to-gray-50 border border-gray-200 rounded-xl p-5 shadow-sm">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-sm text-gray-600 font-medium">Tersedia</p>
                            <p class="text-2xl font-bold text-emerald-600 mt-1">
                                {{ $fields->where('status', 'available')->count() }}</p>
                        </div>
                        <div class="p-3 bg-emerald-50 rounded-lg">
                            <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Flash Messages -->
        @if (session('success'))
            <div
                class="mb-6 bg-gradient-to-r from-green-50 to-emerald-50 border border-green-200 rounded-xl p-4 flex items-center gap-3 animate-fade-in">
                <div class="w-10 h-10 bg-green-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-green-600" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z"
                            clip-rule="evenodd"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-green-800">{{ session('success') }}</p>
                </div>
            </div>
        @endif

        @if (session('error'))
            <div
                class="mb-6 bg-gradient-to-r from-red-50 to-rose-50 border border-red-200 rounded-xl p-4 flex items-center gap-3 animate-fade-in">
                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                    </svg>
                </div>
                <div>
                    <p class="font-medium text-red-800">{{ session('error') }}</p>
                </div>
            </div>
        @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <!-- Form Tambah Lapangan -->
            <div class="lg:col-span-1">
                <div class="bg-white border border-gray-200 shadow-xl rounded-2xl p-6 h-fit sticky top-6">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="p-2.5 bg-gradient-to-br from-emerald-500 to-green-600 rounded-lg">
                            <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                        </div>
                        <h3 class="text-xl font-bold text-gray-800">Tambah Lapangan Baru</h3>
                    </div>

                    <form action="{{ route('admin.fields.store') }}" method="POST" enctype="multipart/form-data"
                        class="space-y-5">
                        @csrf

                        <!-- Nama Lapangan -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Nama Lapangan <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                        </path>
                                    </svg>
                                </div>
                                <input type="text" name="name" placeholder="Contoh: Lapangan Futsal 1"
                                    class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                    required>
                            </div>
                        </div>

                        <!-- Gambar -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Gambar Lapangan <span class="text-red-500">*</span>
                            </label>

                            <div class="flex items-center justify-center w-full">
                                <label
                                    class="relative flex items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200 overflow-hidden">

                                    <!-- Preview Image -->
                                    <img id="fieldImagePreview"
                                        class="absolute inset-0 w-full h-full object-cover hidden" />

                                    <!-- Placeholder -->
                                    <div id="fieldUploadPlaceholder"
                                        class="flex flex-col items-center justify-center pt-5 pb-6 text-center">
                                        <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                        <p class="mb-2 text-sm text-gray-500">
                                            <span class="font-semibold">Klik untuk upload</span> atau drag and drop
                                        </p>
                                        <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 5MB)</p>
                                    </div>

                                    <input name="image" type="file" id="fieldImageInput" class="hidden"
                                        accept="image/*" required>
                                </label>
                            </div>
                        </div>

                        <!-- Jam Operasional -->
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jam Buka <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="time" name="open_time"
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                        required>
                                </div>
                            </div>
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">
                                    Jam Tutup <span class="text-red-500">*</span>
                                </label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                        </svg>
                                    </div>
                                    <input type="time" name="close_time"
                                        class="block w-full pl-10 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                        required>
                                </div>
                            </div>
                        </div>

                        <!-- Harga -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Harga per Jam (Rp) <span class="text-red-500">*</span>
                            </label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500 font-medium">Rp</span>
                                </div>
                                <input type="number" name="price_per_hour" placeholder="50000"
                                    class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                    required>
                            </div>
                        </div>

                        <!-- Deskripsi -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Deskripsi
                            </label>
                            <textarea name="description" rows="3" placeholder="Masukkan deskripsi lapangan..."
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"></textarea>
                        </div>

                        <!-- Kategori -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Kategori Lapangan <span class="text-red-500">*</span>
                            </label>
                            <select name="category_field_id"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                required>
                                <option value="">-- Pilih Kategori --</option>
                                @foreach ($categories as $category)
                                    <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                                @endforeach
                            </select>
                        </div>

                        <!-- Status -->
                        <div>
                            <label class="block text-sm font-medium text-gray-700 mb-2">
                                Status <span class="text-red-500">*</span>
                            </label>
                            <select name="status"
                                class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-emerald-500 focus:border-emerald-500 transition-colors duration-200"
                                required>
                                <option value="">-- Pilih Status --</option>
                                <option value="available">Tersedia</option>
                                <option value="booked">Sudah Dibooking</option>
                                <option value="maintenance">Perbaikan</option>
                                <option value="closed">Ditutup</option>
                                <option value="pending">Menunggu Pembayaran</option>
                            </select>
                        </div>

                        <!-- Submit Button -->
                        <button type="submit"
                            class="w-full bg-gradient-to-r from-emerald-600 to-green-600 hover:from-emerald-700 hover:to-green-700 text-white font-semibold py-3 px-4 rounded-lg shadow-lg hover:shadow-xl transition-all duration-200 transform hover:-translate-y-0.5 flex items-center justify-center gap-2">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4">
                                </path>
                            </svg>
                            Tambah Lapangan
                        </button>
                    </form>
                </div>
            </div>

            <!-- Daftar Lapangan -->
            <div class="lg:col-span-2">
                <div class="bg-white border border-gray-200 shadow-xl rounded-2xl overflow-hidden">
                    <!-- Header -->
                    <div class="border-b border-gray-200 bg-gradient-to-r from-gray-50 to-white px-6 py-5">
                        <div class="flex flex-col sm:flex-row sm:items-center justify-between">
                            <div class="flex items-center gap-3">
                                <div class="p-2 bg-emerald-100 rounded-lg">
                                    <svg class="w-6 h-6 text-emerald-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2">
                                        </path>
                                    </svg>
                                </div>
                                <div>
                                    <h3 class="text-xl font-bold text-gray-800">Daftar Lapangan</h3>
                                    <p class="text-gray-600 text-sm mt-1">Total {{ $fields->count() }} lapangan tersedia
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Table Container -->
                    <div class="overflow-x-auto">
                        <div class="min-w-[1200px]">
                            <table class="w-full">
                                <thead class="bg-gray-50">
                                    <tr class="border-b border-gray-200">
                                        <th class="py-4 px-6 text-left">
                                            <span
                                                class="text-xs font-semibold text-gray-600 uppercase tracking-wider">#</span>
                                        </th>
                                        <th class="py-4 px-6 text-left">
                                            <span
                                                class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Gambar</span>
                                        </th>
                                        <th class="py-4 px-6 text-left">
                                            <span
                                                class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Nama</span>
                                        </th>
                                        <th class="py-4 px-6 text-left">
                                            <span class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Jam
                                                Operasional</span>
                                        </th>
                                        <th class="py-4 px-6 text-left">
                                            <span
                                                class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Harga/Jam</span>
                                        </th>
                                        <th class="py-4 px-6 text-left">
                                            <span
                                                class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Kategori</span>
                                        </th>
                                        <th class="py-4 px-6 text-left">
                                            <span
                                                class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Status</span>
                                        </th>
                                        <th class="py-4 px-6 text-left">
                                            <span
                                                class="text-xs font-semibold text-gray-600 uppercase tracking-wider">Aksi</span>
                                        </th>
                                    </tr>
                                </thead>

                                <tbody class="divide-y divide-gray-100" id="fieldTableBody">
                                    @forelse ($fields as $index => $data)
                                        <tr class="hover:bg-gray-50 transition-colors duration-150"
                                            data-field-name="{{ strtolower($data['name']) }}">
                                            <td class="py-4 px-6">
                                                <div class="flex items-center">
                                                    <div
                                                        class="w-8 h-8 bg-gradient-to-br from-emerald-100 to-green-100 rounded-lg flex items-center justify-center">
                                                        <span
                                                            class="text-sm font-semibold text-emerald-700">{{ $index + 1 }}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="py-4 px-6">
                                                <div class="group relative">
                                                    @if ($data->image)
                                                        <img src="{{ asset('storage/' . $data->image) }}"
                                                            alt="{{ $data->name }}"
                                                            class="w-20 h-14 object-cover rounded-lg shadow-sm border border-gray-200 cursor-pointer hover:shadow-md transition-shadow duration-200"
                                                            onclick="openImageModal('{{ asset('storage/' . $data->image) }}')">
                                                        <div
                                                            class="absolute inset-0 bg-black bg-opacity-0 group-hover:bg-opacity-10 rounded-lg transition-all duration-200">
                                                        </div>
                                                        <div
                                                            class="opacity-0 group-hover:opacity-100 absolute -top-8 left-1/2 transform -translate-x-1/2 bg-gray-800 text-white text-xs px-2 py-1 rounded pointer-events-none transition-opacity duration-200">
                                                            Klik untuk memperbesar
                                                        </div>
                                                    @else
                                                        <div
                                                            class="w-20 h-14 bg-gray-100 rounded-lg flex items-center justify-center">
                                                            <svg class="w-8 h-8 text-gray-400" fill="none"
                                                                stroke="currentColor" viewBox="0 0 24 24"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                                </path>
                                                            </svg>
                                                        </div>
                                                    @endif
                                                </div>
                                            </td>

                                            <td class="py-4 px-6">
                                                <div class="max-w-xs">
                                                    <span
                                                        class="font-medium text-gray-800 block">{{ $data['name'] }}</span>
                                                    <p class="text-xs text-gray-500 mt-1 line-clamp-2">
                                                        {{ $data['description'] ?: 'Tidak ada deskripsi' }}</p>
                                                </div>
                                            </td>

                                            <td class="py-4 px-6">
                                                <div class="flex flex-col">
                                                    <div class="flex items-center gap-1 mb-1">
                                                        <svg class="w-4 h-4 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <span
                                                            class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($data['open_time'])->format('H:i') }}</span>
                                                    </div>
                                                    <div class="flex items-center gap-1">
                                                        <svg class="w-4 h-4 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                                        </svg>
                                                        <span
                                                            class="text-sm font-medium text-gray-700">{{ \Carbon\Carbon::parse($data['close_time'])->format('H:i') }}</span>
                                                    </div>
                                                </div>
                                            </td>

                                            <td class="py-4 px-6">
                                                <div class="font-bold text-emerald-700">
                                                    Rp {{ number_format($data['price_per_hour'], 0, ',', '.') }}
                                                </div>
                                                <div class="text-xs text-gray-500 mt-1">per jam</div>
                                            </td>

                                            <td class="py-4 px-6">
                                                <span
                                                    class="inline-flex items-center px-3 py-1.5 rounded-full text-sm font-medium bg-indigo-100 text-indigo-800 border border-indigo-200">
                                                    {{ $data->categoryField->name ?? 'Tidak ada kategori' }}
                                                </span>
                                            </td>

                                            <td class="py-4 px-6">
                                                @php
                                                    $statusConfig = [
                                                        'available' => [
                                                            'bg' => 'bg-emerald-100',
                                                            'text' => 'text-emerald-800',
                                                            'border' => 'border border-emerald-200',
                                                            'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z',
                                                        ],
                                                        'booked' => [
                                                            'bg' => 'bg-blue-100',
                                                            'text' => 'text-blue-800',
                                                            'border' => 'border border-blue-200',
                                                            'icon' =>
                                                                'M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z',
                                                        ],
                                                        'maintenance' => [
                                                            'bg' => 'bg-yellow-100',
                                                            'text' => 'text-yellow-800',
                                                            'border' => 'border border-yellow-200',
                                                            'icon' =>
                                                                'M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-2.5L13.732 4c-.77-.833-1.928-.833-2.698 0L4.342 16.5c-.77.833.192 2.5 1.732 2.5z',
                                                        ],
                                                        'closed' => [
                                                            'bg' => 'bg-red-100',
                                                            'text' => 'text-red-800',
                                                            'border' => 'border border-red-200',
                                                            'icon' =>
                                                                'M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z',
                                                        ],
                                                        'pending' => [
                                                            'bg' => 'bg-purple-100',
                                                            'text' => 'text-purple-800',
                                                            'border' => 'border border-purple-200',
                                                            'icon' => 'M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z',
                                                        ],
                                                    ];
                                                    $config =
                                                        $statusConfig[$data['status']] ?? $statusConfig['available'];
                                                @endphp

                                                <div
                                                    class="inline-flex items-center gap-2 px-3 py-1.5 rounded-full {{ $config['bg'] }} {{ $config['text'] }} {{ $config['border'] }}">
                                                    <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                        viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2" d="{{ $config['icon'] }}"></path>
                                                    </svg>
                                                    <span
                                                        class="text-sm font-medium capitalize">{{ $data['status'] }}</span>
                                                </div>
                                            </td>

                                            <td class="py-4 px-6">
                                                <div class="flex items-center gap-2">
                                                    <!-- Edit Button -->
                                                    <button
                                                        class="editFieldBtn bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm hover:shadow transition-all duration-200 flex items-center gap-2 group"
                                                        data-id="{{ $data['id'] }}" data-name="{{ $data['name'] }}"
                                                        data-image="{{ $data->image ? asset('storage/' . $data->image) : '' }}"
                                                        data-open_time="{{ $data['open_time'] }}"
                                                        data-close_time="{{ $data['close_time'] }}"
                                                        data-description="{{ $data['description'] }}"
                                                        data-price="{{ $data['price_per_hour'] }}"
                                                        data-category="{{ $data['category_field_id'] }}"
                                                        data-status="{{ $data['status'] }}">
                                                        <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                            viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                                                            </path>
                                                        </svg>
                                                        Edit
                                                    </button>

                                                    <!-- Delete Button -->
                                                    <form action="{{ route('admin.fields.destroy', $data['id']) }}"
                                                        method="POST" class="deleteForm inline"
                                                        onsubmit="return confirmDelete(event)">
                                                        @csrf
                                                        @method('DELETE')
                                                        <button type="submit"
                                                            class="bg-gradient-to-r from-red-500 to-rose-600 hover:from-red-600 hover:to-rose-700 text-white px-4 py-2 rounded-lg text-sm font-medium shadow-sm hover:shadow transition-all duration-200 flex items-center gap-2">
                                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                                <path stroke-linecap="round" stroke-linejoin="round"
                                                                    stroke-width="2"
                                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16">
                                                                </path>
                                                            </svg>
                                                            Hapus
                                                        </button>
                                                    </form>
                                                </div>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="8" class="py-12 text-center">
                                                <div class="flex flex-col items-center justify-center">
                                                    <div
                                                        class="w-24 h-24 bg-gradient-to-br from-gray-100 to-gray-200 rounded-full flex items-center justify-center mb-4">
                                                        <svg class="w-12 h-12 text-gray-400" fill="none"
                                                            stroke="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4">
                                                            </path>
                                                        </svg>
                                                    </div>
                                                    <h3 class="text-lg font-bold text-gray-500 mb-2">Belum ada lapangan
                                                    </h3>
                                                    <p class="text-gray-400 max-w-md text-center">
                                                        Tambahkan lapangan pertama Anda untuk mulai menerima booking
                                                    </p>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Modal Edit Lapangan -->
    <div id="editFieldModal" class="hidden fixed inset-0 z-50 overflow-y-auto flex items-center justify-center p-4">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-gray-900 bg-opacity-50 transition-opacity backdrop-blur-sm" id="modalOverlay"></div>

        <!-- Modal panel -->
        <div
            class="relative w-full max-w-md bg-white shadow-2xl rounded-2xl p-6 transform transition-all animate-modal-appear z-10 max-h-[90vh] overflow-y-auto">
            <!-- Modal header -->
            <div class="flex items-center justify-between mb-6">
                <div class="flex items-center gap-3">
                    <div class="p-2 bg-blue-100 rounded-lg">
                        <svg class="w-6 h-6 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z">
                            </path>
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800">Edit Lapangan</h3>
                        <p class="text-gray-600 text-sm mt-1">Perbarui informasi lapangan</p>
                    </div>
                </div>
                <button id="cancelFieldEdit"
                    class="text-gray-400 hover:text-gray-600 transition-colors duration-200 hover:bg-gray-100 rounded-lg p-1">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                        </path>
                    </svg>
                </button>
            </div>

            <!-- Modal form -->
            <form action="" method="POST" id="editFieldForm" enctype="multipart/form-data">
                @csrf
                @method('PUT')

                <!-- Current Image Preview -->
                <div id="currentImageContainer" class="mb-6">
                    <p class="text-sm font-medium text-gray-700 mb-2">Gambar Saat Ini</p>
                    <img id="editFieldPreview"
                        class="w-full max-h-48 object-contain rounded-lg border border-gray-200 shadow-sm mb-4">

                    <!-- Replace Image -->
                    <label class="block text-sm font-medium text-gray-700 mb-2">Ganti Gambar (Opsional)</label>
                    <div class="flex items-center justify-center w-full">
                        <label for="editFieldImage"
                            class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors duration-200">
                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                <svg class="w-10 h-10 mb-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                    </path>
                                </svg>
                                <p class="mb-2 text-sm text-gray-500">
                                    <span class="font-semibold">Klik untuk upload</span> gambar baru
                                </p>
                                <p class="text-xs text-gray-500">PNG, JPG, JPEG (MAX. 5MB)</p>
                            </div>
                            <input id="editFieldImage" name="image" type="file" class="hidden" accept="image/*">
                        </label>
                    </div>
                </div>

                <!-- Field Name -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Nama Lapangan <span class="text-red-500">*</span>
                    </label>
                    <input type="text" id="editFieldName" name="name"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                        required>
                </div>

                <!-- Operating Hours -->
                <div class="grid grid-cols-2 gap-4 mb-4">
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jam Buka <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="editFieldOpen" name="open_time"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                            required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium text-gray-700 mb-2">
                            Jam Tutup <span class="text-red-500">*</span>
                        </label>
                        <input type="time" id="editFieldClose" name="close_time"
                            class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                            required>
                    </div>
                </div>

                <!-- Price -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Harga per Jam (Rp) <span class="text-red-500">*</span>
                    </label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <span class="text-gray-500 font-medium">Rp</span>
                        </div>
                        <input type="number" id="editFieldPrice" name="price_per_hour"
                            class="block w-full pl-12 pr-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                            required>
                    </div>
                </div>

                <!-- Description -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Deskripsi
                    </label>
                    <textarea id="editFieldDescription" name="description" rows="3"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"></textarea>
                </div>

                <!-- Category -->
                <div class="mb-4">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Kategori Lapangan <span class="text-red-500">*</span>
                    </label>
                    <select id="editFieldCategory" name="category_field_id"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                        required>
                        @foreach ($categories as $category)
                            <option value="{{ $category['id'] }}">{{ $category['name'] }}</option>
                        @endforeach
                    </select>
                </div>

                <!-- Status -->
                <div class="mb-6">
                    <label class="block text-sm font-medium text-gray-700 mb-2">
                        Status <span class="text-red-500">*</span>
                    </label>
                    <select id="editFieldStatus" name="status"
                        class="block w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors duration-200"
                        required>
                        <option value="available">Tersedia</option>
                        <option value="booked">Sudah Dibooking</option>
                        <option value="maintenance">Perbaikan</option>
                        <option value="closed">Ditutup</option>
                        <option value="pending">Menunggu Pembayaran</option>
                    </select>
                </div>

                <!-- Modal footer -->
                <div class="flex justify-end gap-3 pt-6 border-t border-gray-200">
                    <button type="button" id="modalCancel"
                        class="px-5 py-2.5 text-gray-700 bg-gray-100 hover:bg-gray-200 rounded-lg font-medium transition-colors duration-200">
                        Batal
                    </button>
                    <button type="submit"
                        class="px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white rounded-lg font-medium shadow-sm hover:shadow transition-all duration-200 flex items-center gap-2">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                            xmlns="http://www.w3.org/2000/svg">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7">
                            </path>
                        </svg>
                        Simpan Perubahan
                    </button>
                </div>
            </form>
        </div>
    </div>

    <!-- Image Modal -->
    <div id="imageModal" class="hidden fixed inset-0 z-50 flex items-center justify-center p-4">
        <!-- Background overlay -->
        <div class="fixed inset-0 bg-black bg-opacity-90 transition-opacity" onclick="closeImageModal()"></div>

        <!-- Modal content -->
        <div class="relative max-w-7xl max-h-[90vh] z-10">
            <button onclick="closeImageModal()"
                class="absolute -top-12 right-0 text-white hover:text-gray-300 transition-colors duration-200 bg-black bg-opacity-50 rounded-full p-2 hover:bg-opacity-70">
                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                    xmlns="http://www.w3.org/2000/svg">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12">
                    </path>
                </svg>
            </button>
            <img id="modalImage" class="max-w-full max-h-[90vh] object-contain rounded-lg shadow-2xl animate-zoom-in">
        </div>
    </div>

    <script src="{{ asset('js/edit-lapangan.js') }}"></script>
@endsection
