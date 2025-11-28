<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>forgot password | EZFutsal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<!-- layout utama  -->

<body class="bg-white flex flex-col items-center min-h-screen">
    <!-- topbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-300">
        <div class="flex justify-between items-center px-6 md:px-12 py-4">
            <h1 class="text-xl md:text-3xl font-bold text-[#13810A]">
                EZFutsal
            </h1>
        </div>
    </nav>

    <!-- Spacer untuk navbar -->
    <div class="h-28"></div>

    <!-- CARD UTAMA -->
    <div class="relative w-[95%] max-w-[970px] h-auto md:h-[520px] rounded-2xl overflow-hidden shadow-2xl bg-white">

        <!-- BACKGROUND (muncul hanya di tablet & desktop) -->
        <div class="hidden md:block absolute inset-0">
            <div class="w-full h-full bg-[url('/aset/forgotpassword-bg.jpg')] bg-cover bg-center"></div>
            <div class="absolute inset-0 bg-black/25"></div>
        </div>
        <!-- TEKS (hanya di tablet & desktop) -->
        <div class="hidden md:block absolute top-1/2 transform -translate-y-1/2 left-[60px] md:left-[100px] text-white text-lg md:text-xl font-semibold drop-shadow-lg max-w-sm leading-relaxed text-justify">
            <h3 class="font-bold text-2xl mb-2">Lupa Kata Sandi?</h3>
            <p>Jangan khawatir! Cukup masukkan alamat email Anda, dan kami akan mengirimkan tautan untuk membuat kata sandi baru.</p>
        </div>
        <!-- CARD LOGIN -->
        <div class="relative md:absolute md:top-6 md:right-6 md:bottom-6 bg-[#13810A] bg-opacity-65 md:backdrop-blur-md p-8 rounded-2xl shadow-2xl w-full md:w-[360px] text-white flex flex-col justify-center items-center transition-all duration-300">
            <div class="flex flex-col items-center w-full">
                <!-- ICON -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mt-2 md:mt-6 mb-1" fill="currentColor" viewBox="0 0 24 24">
                    <path d="M19 10h-2V7c0-2.76-2.24-5-5-5S7 4.24 7 7v3H5c-1.1 0-2 .9-2 2v8c0 1.1.9 2 2 2h14c1.1 0 2-.9 2-2v-8c0-1.1-.9-2-2-2zM9 7c0-1.66 1.34-3 3-3s3 1.34 3 3v3H9V7zm6 8h-2v2h-2v-2H9v-2h6v2z" />
                </svg>
                <h2 class="text-2xl font-bold mb-6">forgot Password</h2>

                <!-- FORM LOGIN -->
                <form action="{{ route('verifikasi-kode') }}" method="GET" class="w-full flex flex-col gap-4">
                    <!-- Email -->
                    <div>
                        <label class="block mb-1 text-sm">Email</label>
                        <input
                            type="text"
                            placeholder="Masukkan Email"
                            class="w-full p-2 rounded-md text-black placeholder-gray-400 focus:ring-2 focus:ring-green-400 outline-none">
                    </div>

                    <!-- Tombol kirim -->
                    <div class="flex justify-center mt-4">
                        <button
                            type="submit"
                            class="bg-white text-[#13810A] font-bold py-2.5 px-6 rounded-md hover:bg-gray-100 transition w-fit">
                            Kirim
                        </button>
                    </div>
                </form>

            </div>
        </div>
    </div>
</body>

</html>