@extends('admin.layouts.master')

@section('content')
    <div class="max-w-5xl mx-auto mt-10">

        {{-- CARD SCANNER --}}
        <div class="bg-white shadow-xl rounded-xl p-6 border mb-10">
            <h1 class="text-2xl font-bold text-gray-800 mb-6 text-center">
                Verifikasi Tiket
            </h1>

            <div class="flex flex-col items-center">
                <form id="verifyForm" action="{{ route('admin.verify.ticket.process') }}" method="POST"
                    class="flex flex-col items-center">
                    @csrf

                    <input type="hidden" name="ticket_code" id="ticket_code">

                    <div id="reader" class="w-72 h-72 border-2 border-gray-300 rounded-lg shadow-inner hidden"></div>

                    <p id="loadingText" class="text-gray-500 text-sm mt-3 hidden animate-pulse">
                        Mengaktifkan kamera...
                    </p>

                    <div id="result" class="mt-4 font-medium text-center"></div>

                    <div class="mt-6 flex gap-4">
                        <button type="button" id="startScan"
                            class="px-5 py-2 bg-[#13810A] hover:bg-green-700 text-white rounded-lg font-semibold shadow">
                            Start Scan
                        </button>

                        <button type="button" id="stopScan"
                            class="px-5 py-2 bg-[#880719] hover:bg-[#a41e27] text-white rounded-lg font-semibold shadow hidden">
                            Stop Scan
                        </button>
                    </div>
                </form>
            </div>
        </div>

        {{-- TABLE --}}
        <div class="bg-white shadow-xl rounded-xl p-6 border">
            <h2 class="text-xl font-bold text-gray-800 mb-4">
                Tiket Terverifikasi
            </h2>

            <!-- Wrapper Scroll -->
            <div class="overflow-x-auto overflow-y-auto max-h-[400px] border border-gray-200 rounded-lg">
                <table class="min-w-[600px] w-full border-collapse text-left">
                    <thead class="bg-gray-100 sticky top-0 z-10">
                        <tr class="border-b">
                            <th class="p-3 font-semibold text-gray-700">No</th>
                            <th class="p-3 font-semibold text-gray-700">Kode Tiket</th>
                            <th class="p-3 font-semibold text-gray-700">Waktu Scan</th>
                        </tr>
                    </thead>

                    <tbody id="ticketTable">
                        @foreach ($verify as $index => $data)
                            <tr class="hover:bg-gray-50 transition">
                                <td class="p-3 border-b text-gray-700">
                                    {{ $index + 1 }}
                                </td>
                                <td class="p-3 border-b text-gray-700">
                                    {{ $data->ticket_code }}
                                </td>
                                <td class="p-3 border-b text-gray-700">
                                    {{ $data->created_at }}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <script>
        let html5QrCode;
        let isRunning = false;
        let scanned = false;

        document.addEventListener("DOMContentLoaded", function() {
            html5QrCode = new Html5Qrcode("reader");

            const startBtn = document.getElementById("startScan");
            const stopBtn = document.getElementById("stopScan");
            const form = document.getElementById("verifyForm");
            const resultBox = document.getElementById("result");

            startBtn.addEventListener("click", function() {
                if (isRunning) return;

                scanned = false;
                resultBox.innerHTML = "";
                isRunning = true;

                document.getElementById("reader").classList.remove("hidden");
                document.getElementById("loadingText").classList.remove("hidden");

                startBtn.classList.add("hidden");
                stopBtn.classList.remove("hidden");

                html5QrCode.start({
                        facingMode: "environment"
                    }, {
                        fps: 10,
                        qrbox: {
                            width: 250,
                            height: 250
                        }
                    },

                    async (decodedText) => {
                        if (scanned) return;
                        scanned = true;

                        document.getElementById("ticket_code").value = decodedText;

                        resultBox.innerHTML =
                            `<span class='text-green-600 font-semibold'>Kode Tiket: ${decodedText}</span>`;

                        await html5QrCode.stop();
                        form.submit();
                    }
                ).catch(err => {
                    resultBox.innerHTML =
                        "<span class='text-red-600 font-semibold'>Camera tidak bisa diakses</span>";
                });
            });

            stopBtn.addEventListener("click", function() {
                if (!isRunning) return;

                html5QrCode.stop().then(() => {
                    isRunning = false;
                    scanned = false;

                    document.getElementById("reader").classList.add("hidden");
                    document.getElementById("loadingText").classList.add("hidden");

                    stopBtn.classList.add("hidden");
                    startBtn.classList.remove("hidden");

                    resultBox.innerHTML = "";
                });
            });
        });
    </script>
@endsection
