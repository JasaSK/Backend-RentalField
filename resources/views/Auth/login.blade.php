<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Login | EZFutsal</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css"
        integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>

<body class="bg-white flex flex-col items-center min-h-screen">

    <!-- Navbar -->
    <nav class="fixed top-0 left-0 right-0 z-50 bg-white/80 backdrop-blur-md border-b border-gray-300">
        <div class="flex justify-between items-center px-6 md:px-12 py-4">
            <h1 class="text-xl md:text-3xl font-bold text-[#13810A]">EZFutsal</h1>
        </div>
    </nav>

    <div class="h-28"></div> <!-- Spacer navbar -->

    <!-- CARD LOGIN -->
    <div class="relative w-[95%] max-w-[970px] h-auto md:h-[520px] rounded-2xl overflow-hidden shadow-2xl">

        <!-- Background hanya tampil di tablet/desktop -->
        <div class="hidden md:block absolute inset-0 bg-[url('/aset/login-bg2.jpg')] bg-cover bg-center"></div>
        <div class="hidden md:block absolute inset-0 bg-black/40 rounded-2xl"></div>

        <!-- Teks sambutan -->
        <div
            class="hidden md:block absolute top-1/2 left-[60px] md:left-[100px] -translate-y-1/2 text-white text-lg md:text-xl font-semibold drop-shadow-lg max-w-sm leading-relaxed">
            Welcome back admin, Have a great day!<br>
            <span class="pl-6">Let's manage EZFutsal smoothly.</span>
        </div>

        <!-- FORM LOGIN -->
        <div
            class="relative md:absolute md:top-6 md:right-6 md:bottom-6 bg-[#13810A] md:bg-white/25 md:backdrop-blur-md p-8 rounded-2xl shadow-2xl w-full md:w-[360px] flex flex-col justify-center items-center transition-all duration-300">

            <div class="flex flex-col items-center w-full">
                <!-- Icon / Logo -->
                <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mt-2 md:mt-6 mb-1" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                </svg>

                <h2 class="text-2xl font-bold mb-6 text-black">Login</h2>

                <form action="{{ route('admin.login') }}" method="POST" class="w-full flex flex-col gap-4">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label class="block mb-1 text-sm text-black">Email</label>
                        <input type="text" name="email" placeholder="Masukkan Email"
                            class="w-full p-2 rounded-md text-black placeholder-gray-400 focus:ring-2 focus:ring-[#880719] outline-none">
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password -->
                    <div>
                        <label class="block mb-1 text-sm text-black">Password</label>
                        <input type="password" name="password" placeholder="Masukkan Password"
                            class="w-full p-2 rounded-md text-black placeholder-gray-400 focus:ring-2 focus:ring-[#880719] outline-none">
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember me -->
                    <div class="flex justify-start items-center text-sm mt-1 w-full px-1 gap-4">
                        <label class="flex items-center gap-2">
                            <input type="checkbox" class="accent-green-500">
                            <span class="text-black">Remember me</span>
                        </label>
                    </div>

                    <!-- Tombol Login -->
                    <div class="flex justify-center mt-4">
                        <button type="submit"
                            class="bg-[#880719] text-white font-bold py-2.5 px-6 rounded-md hover:bg-[#a41e27] transition w-fit">
                            Login
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    @include('admin.layouts.script')
</body>

</html>
