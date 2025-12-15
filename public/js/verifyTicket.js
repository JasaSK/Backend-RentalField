let html5QrCode;
        let isRunning = false;
        let scanned = false;

        document.addEventListener("DOMContentLoaded", function() {
            html5QrCode = new Html5Qrcode("reader");

            const startBtn = document.getElementById("startScan");
            const stopBtn = document.getElementById("stopScan");
            const form = document.getElementById("verifyForm");
            const resultBox = document.getElementById("result");
            const scanPlaceholder = document.getElementById("scanPlaceholder");
            const reader = document.getElementById("reader");

            startBtn.addEventListener("click", function() {
                if (isRunning) return;

                scanned = false;
                resultBox.innerHTML = "";
                isRunning = true;

                // Tampilkan scanner dan sembunyikan placeholder
                reader.classList.remove("hidden");
                scanPlaceholder.classList.add("hidden");
                document.getElementById("loadingText").classList.remove("hidden");

                // Toggle tombol
                startBtn.classList.add("hidden");
                stopBtn.classList.remove("hidden");

                // Mulai scanning
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

                            // Tampilkan animasi sukses
                            resultBox.innerHTML = `
                            <div class="flex flex-col items-center">
                                <div class="w-16 h-16 bg-gradient-to-r from-green-500 to-emerald-600 rounded-full flex items-center justify-center mb-4 animate-pulse">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                                    </svg>
                                </div>
                                <div class="text-center">
                                    <p class="text-green-600 font-bold text-lg mb-1">Tiket Ditemukan!</p>
                                    <p class="text-gray-700 font-mono bg-green-50 px-4 py-2 rounded-lg border border-green-200">${decodedText}</p>
                                    <p class="text-gray-500 text-sm mt-2">Mengirim data verifikasi...</p>
                                </div>
                            </div>
                        `;

                            // Stop scanner dan kirim form
                            await html5QrCode.stop();

                            // Delay kecil untuk memberikan feedback visual sebelum submit
                            setTimeout(() => {
                                form.submit();
                            }, 1000);
                        },

                        (errorMessage) => {
                            // Error handling yang lebih baik
                        }
                ).catch(err => {
                    resultBox.innerHTML = `
                        <div class="bg-red-50 border border-red-200 rounded-xl p-4 max-w-md mx-auto">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 bg-red-100 rounded-full flex items-center justify-center">
                                    <svg class="w-5 h-5 text-red-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <div>
                                    <p class="text-red-700 font-semibold">Kamera tidak dapat diakses</p>
                                    <p class="text-red-600 text-sm">Pastikan kamera telah diizinkan dan tidak sedang digunakan aplikasi lain</p>
                                </div>
                            </div>
                        </div>
                    `;

                    // Reset state
                    isRunning = false;
                    startBtn.classList.remove("hidden");
                    stopBtn.classList.add("hidden");
                    scanPlaceholder.classList.remove("hidden");
                    reader.classList.add("hidden");
                    document.getElementById("loadingText").classList.add("hidden");
                });
            });

            stopBtn.addEventListener("click", function() {
                if (!isRunning) return;

                html5QrCode.stop().then(() => {
                    isRunning = false;
                    scanned = false;

                    // Sembunyikan scanner dan tampilkan placeholder
                    reader.classList.add("hidden");
                    scanPlaceholder.classList.remove("hidden");
                    document.getElementById("loadingText").classList.add("hidden");

                    // Toggle tombol
                    stopBtn.classList.add("hidden");
                    startBtn.classList.remove("hidden");

                    // Hapus hasil scan
                    resultBox.innerHTML = "";
                });
            });
        });