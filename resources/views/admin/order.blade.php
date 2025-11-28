@extends('admin.layouts.master')

@section('content')
<!-- Konten -->
<h1 class="text-3xl font-bold text-gray-800 mb-3">Info Pemesanan</h1>
<div class="p-3 flex-1">

  <!-- Card Konten 1 -->
  <div class="mx-auto w-[97%] max-w-[1500px] space-y-6 mb-6">
    <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6">
      <h3 class="text-2xl font-bold mb-4">Detail Pesanan</h3>

      <p class="text-gray-800 text-lg">Lapangan 1</p>
      <p class="text-gray-800 text-lg">00-00-0000</p>
      <p class="text-gray-800 text-lg mb-3">00.00 - 00.00</p>

      <!-- Detail Pemesan -->
      <div class="grid grid-cols-4 gap-y-2 text-lg mb-3">
        <p class="text-gray-800">Nama Customer</p>
        <span>test@gmail.com</span>
        <span>0123456789</span>
        <span></span>

        <p class="text-gray-800">Rp0</p>
        <span>BO-001</span>
        <span></span>
        <span></span>
        <span>Keterangan</span>
      </div>

      <!-- Bukti Pembayaran -->
      <div class="text-center mt-6">
        <h3 class="font-semibold mb-5 text-lg">Bukti Pembayaran</h3>
        <img src="{{ asset('aset/bill.jpg') }}" alt="Bukti Pembayaran" class="w-60 mx-auto rounded-md border">
      </div>

      <!-- Tombol Aksi -->
      <div class="flex justify-center gap-60 mt-6 mb-3">
        <button class="bg-[#880719] hover:bg-[#a41e27] text-white font-semibold px-4 py-2 rounded-lg shadow-md">
          Tolak & Refund
        </button>
        <button type="button"
          class="btnKonfirmasi bg-[#880719] hover:bg-[#a41e27] text-white font-semibold px-4 py-2 rounded-lg shadow-md">
          Konfirmasi
        </button>
      </div>
      <!-- Snackbar / Toast -->
      <div class="popup hidden absolute inset-0 flex justify-center items-center bg-black/40 backdrop-blur-sm transition-all duration-300">
        <div class="bg-[#13810A]/90 rounded-xl p-8 text-center text-white shadow-lg w-[90%] max-w-sm">
          <h3 class="text-lg font-semibold mb-4">Pesanan telah di konfirmasi!</h3>
          <button class="closeBtn bg-[#8B0000] hover:bg-[#a00000] text-white font-semibold py-2 px-6 rounded-lg transition">
            Kembali
          </button>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Card Konten 2 -->
<div class="mx-auto w-[97%] max-w-[1500px] space-y-6">
  <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6">
    <h3 class="text-2xl font-bold mb-4">Detail Pesanan</h3>

    <p class="text-gray-800 text-lg">Lapangan 1</p>
    <p class="text-gray-800 text-lg">00-00-0000</p>
    <p class="text-gray-800 text-lg mb-3">00.00 - 00.00</p>

    <!-- Detail Pemesan -->
    <div class="grid grid-cols-4 gap-y-2 text-lg mb-3">
      <p class="text-gray-800">Nama Customer</p>
      <span>test@gmail.com</span>
      <span>0123456789</span>
      <span></span>

      <p class="text-gray-800">Rp0</p>
      <span>BO-001</span>
      <span></span>
      <span></span>
      <span>Keterangan</span>
    </div>

    <!-- Bukti Pembayaran -->
    <div class="text-center mt-6">
      <h3 class="font-semibold mb-5 text-lg">Bukti Pembayaran</h3>
      <img src="{{ asset('aset/bill.jpg') }}" alt="Bukti Pembayaran" class="w-60 mx-auto rounded-md border">
    </div>

    <!-- Tombol Aksi -->
    <div class="flex justify-center gap-60 mt-6 mb-3">
      <button class="bg-[#880719] hover:bg-[#a41e27] text-white font-semibold px-4 py-2 rounded-lg shadow-md">
        Tolak & Refund
      </button>
      <button type="button"
        class="btnKonfirmasi bg-[#880719] hover:bg-[#a41e27] text-white font-semibold px-4 py-2 rounded-lg shadow-md">
        Konfirmasi
      </button>
    </div>
    <!-- Snackbar / Toast -->
    <div class="popup hidden absolute inset-0 flex justify-center items-center bg-black/40 backdrop-blur-sm transition-all duration-300">
      <div class="bg-[#13810A]/90 rounded-xl p-8 text-center text-white shadow-lg w-[90%] max-w-sm">
        <h3 class="text-lg font-semibold mb-4">Pesanan telah di konfirmasi!</h3>
        <button class="closeBtn bg-[#8B0000] hover:bg-[#a00000] text-white font-semibold py-2 px-6 rounded-lg transition">
          Kembali
        </button>
      </div>
    </div>
  </div>
</div>
</div>
@endsection
<!-- script js -->
@push('scripts')
<script src="{{ asset('js/usercard.js') }}"></script>
<script src="{{ asset('js/konfirmasi-pemesanan.js') }}"></script>
@endpush