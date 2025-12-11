@extends('admin.layouts.master')

@section('content')
    <h1 class="text-3xl font-bold text-gray-800 mb-8">Selamat Datang, {{ Auth::user()->name }}!</h1>

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
            <p class="text-3xl font-bold text-[#13810A]">RP {{ $incomeThisMonth }}</p>
            <p class="text-lg font-semibold text-gray-700">Naik {{ $percentageChange }}% Dari Bulan Lalu</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition space-y-3 text-center">
            <h3 class="text-lg font-semibold text-gray-700">Jumlah Booking Hari Ini</h3>
            <p class="text-3xl font-bold text-[#13810A]">{{ $bookingCount }} Booking</p>
            <p class="text-lg font-semibold text-gray-700">Dari Total {{ $fieldCount }} Lapangan</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition space-y-3 text-center">
            <h3 class="text-lg font-semibold text-gray-700">Lapangan Aktif</h3>
            <p class="text-3xl font-bold text-[#13810A]">{{ $fieldStatus }}</p>
        </div>

        <div class="bg-white p-6 rounded-xl shadow hover:shadow-lg transition space-y-3 text-center">
            <h3 class="text-lg font-semibold text-gray-700">Maintenance</h3>
            <p class="text-3xl font-bold text-[#13810A]">{{ $maintenanceCount }}</p>
        </div>
    </div>

    <div class="bg-white border border-gray-200 shadow-md rounded-xl p-6 mt-6">
        <h3 class="text-2xl font-bold text-gray-800 mb-4">Daftar Customer</h3>

        <table class="w-full border-collapse">
            <thead class="text-center bg-gray-100">
                <tr class="border-b border-gray-300">
                    <th class="py-3 px-3">No</th>
                    <th class="py-3 px-3">Nama Customer</th>
                    <th class="py-3 px-3">Email</th>
                    <th class="py-3 px-3">No Telepon</th>
                    <th class="py-3 px-3">Role</th>

                </tr>
            </thead>

            <tbody class="text-gray-700">
                @foreach ($user as $index => $user)
                    <tr class="border-b border-gray-200 hover:bg-gray-50 transition">
                        <td class="py-3 px-2 text-center">{{ $index + 1 }}</td>
                        <td class="py-3 px-2 text-center">{{ $user['name'] }}</td>
                        <td class="py-3 px-2 text-center">{{ $user['email'] }}</td>
                        <td class="py-3 px-2 text-center">{{ $user['no_telp'] }}</td>
                        <td class="py-3 px-2 text-center">{{ $user['role'] }}</td>
                    </tr>
                @endforeach
            </tbody>
        </table>
        <script>
            const weeklyOrders = @json($weeklyOrders);
            const weeklyIncome = @json($weeklyIncome);
        </script>
    @endsection
