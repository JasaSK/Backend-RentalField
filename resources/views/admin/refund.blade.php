@extends('admin.layouts.master')

@section('content')
<!-- Konten -->
<h1 class="text-3xl font-bold text-gray-800 mb-3">Kelola Refund</h1>
<div class="p-3 flex-1">

  <!-- Wrapper utama untuk atur lebar -->
  <div class="mx-auto w-[97%] max-w-[1500px] space-y-6 mb-6">

    <!-- Card Daftar Refund -->
    <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 mt-6">
      <h3 class="text-2xl font-bold text-gray-800 mb-4">Daftar Refund</h3>

      <table class="w-full border-collapse">
        <thead class="text-center bg-gray-100">
          <tr class="border-b border-gray-300">
            <th class="py-3 px-3">No</th>
            <th class="py-3 px-3">Kode Boking</th>
            <th class="py-3 px-3">Alasan Refund</th>
            <th class="py-3 px-3">Bukti Transfer</th>
            <th class="py-3 px-3">Status</th>
            <th class="py-3 px-3">Aksi</th>
          </tr>
        </thead>

        <tbody class="text-gray-700">
          <!-- Baris 1 -->
          <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
            <td class="py-3 px-2 text-center">1</td>
            <td class="py-3 px-2 text-center">Bo-001</td>
            <td class="py-3 px-2 text-center">Maintenance</td>
            <td class="py-3 px-2">
              <div class="flex justify-center">
                <img src="{{ asset('aset/bill.jpg') }}" alt="Bukti Transfer" class="w-20 h-14 object-cover rounded-md shadow">
              </div>
            </td>
            <td class="py-3 px-2 text-center">
              <span class="bg-[#13810A] text-white text-sm font-semibold px-3 py-1 rounded-lg shadow">
                Sukses
              </span>
            </td>
            <td class="py-3 px-3">
              <div class="flex justify-center gap-3">
                <button class="bg-[#120A81] hover:bg-blue-900 text-white text-sm font-semibold px-3 py-1 rounded-lg shadow">
                  Konfirmasi
                </button>
                <button class="bg-[#880719] hover:bg-[#a41e27] text-white text-sm font-semibold px-3 py-1 rounded-lg shadow">
                  Tolak
                </button>
              </div>
            </td>
          </tr>

          <!-- Baris 2 -->
          <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
            <td class="py-3 px-2 text-center">2</td>
            <td class="py-3 px-2 text-center">Bo-002</td>
            <td class="py-3 px-2 text-center">Maintenance</td>
            <td class="py-3 px-2">
              <div class="flex justify-center">
                <img src="{{ asset('aset/bill.jpg') }}" alt="Bukti Transfer" class="w-20 h-14 object-cover rounded-md shadow">
              </div>
            </td>
            <td class="py-3 px-2 text-center">
              <span class="bg-[#D37B00] text-white text-sm font-semibold px-3 py-1 rounded-lg shadow">
                Pending
              </span>
            </td>
            <td class="py-3 px-3">
              <div class="flex justify-center gap-3">
                <button class="bg-[#120A81] hover:bg-blue-900 text-white text-sm font-semibold px-3 py-1 rounded-lg shadow">
                  Konfirmasi
                </button>
                <button class="bg-[#880719] hover:bg-[#a41e27] text-white text-sm font-semibold px-3 py-1 rounded-lg shadow">
                  Tolak
                </button>
              </div>
            </td>
          </tr>

          <!-- Baris 3 -->
          <tr class="hover:bg-gray-50 transition">
            <td class="py-3 px-2 text-center">3</td>
            <td class="py-3 px-2 text-center">Bo-003</td>
            <td class="py-3 px-2 text-center">Maintenance</td>
            <td class="py-3 px-2">
              <div class="flex justify-center">
                <img src="{{ asset('aset/bill.jpg') }}" alt="Bukti Transfer" class="w-20 h-14 object-cover rounded-md shadow">
              </div>
            </td>
            <td class="py-3 px-2 text-center">
              <span class="bg-[#B50C0F] text-white text-sm font-semibold px-3 py-1 rounded-lg shadow">
                Ditolak
              </span>
            </td>
            <td class="py-3 px-3">
              <div class="flex justify-center gap-3">
                <button class="bg-[#120A81] hover:bg-blue-900 text-white text-sm font-semibold px-3 py-1 rounded-lg shadow">
                  Konfirmasi
                </button>
                <button class="bg-[#880719] hover:bg-[#a41e27] text-white text-sm font-semibold px-3 py-1 rounded-lg shadow">
                  Tolak
                </button>
              </div>
            </td>
          </tr>
        </tbody>
      </table>
    </div>
    @endsection
    <!-- script js -->
    @push('scripts')
    <script src="{{ asset('js/usercard.js') }}"></script>
    @endpush