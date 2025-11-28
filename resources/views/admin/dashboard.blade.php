@extends('admin.layouts.master')

@section('content')
<h1 class="text-3xl font-bold text-gray-800 mb-8">Selamat Datang, Admin!</h1>

<!-- Grafik -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-7">
  <div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold text-gray-700 mb-4">Grafik Pemesanan Per Minggu</h3>
    <canvas id="chartPesanan" height="150"></canvas>
  </div>

  <div class="bg-white p-6 rounded-xl shadow">
    <h3 class="text-xl font-semibold text-gray-700 mb-4">Pendapatan per Minggu</h3>
    <canvas id="chartPendapatan" height="150"></canvas>
  </div>
</div>

<!-- Kartu Statistik -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-7">
  <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition space-y-3 text-center">
    <h3 class="text-lg font-semibold text-gray-700">Pendapatan Bulan Ini</h3>
    <p class="text-3xl font-bold text-[#13810A]">RP 12.000.000</p>
    <p class="text-lg font-semibold text-gray-700">Naik 5% Dari Bulan Lalu</p>
  </div>

  <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition space-y-3 text-center">
    <h3 class="text-lg font-semibold text-gray-700">Jumlah Booking Hari Ini</h3>
    <p class="text-3xl font-bold text-[#13810A]">8 Booking</p>
    <p class="text-lg font-semibold text-gray-700">Dari Total 8 Lapangan</p>
  </div>

  <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition space-y-3 text-center">
    <h3 class="text-lg font-semibold text-gray-700">Lapangan Aktif</h3>
    <p class="text-3xl font-bold text-[#13810A]">8</p>
  </div>

  <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition space-y-3 text-center">
    <h3 class="text-lg font-semibold text-gray-700">Maintenance</h3>
    <p class="text-3xl font-bold text-[#13810A]">4</p>
  </div>
</div>
@endsection
<!-- script js -->
@push('scripts')
<script src="{{ asset('js/usercard.js') }}"></script>
<script src="{{ asset('js/chart.js') }}"></script>
@endpush