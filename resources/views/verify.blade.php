<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Verifikasi Email</title>
</head>

<body>
    <h2>Halo, {{ $user->name }}!</h2>
    <p>Terima kasih telah mendaftar di aplikasi kami.</p>

    <p>Kode verifikasi Anda adalah:</p>
    <h3 style="color:#007bff;">{{ $code }}</h3>

    <p>Atau Anda bisa langsung verifikasi dengan klik link di bawah ini:</p>
    <a href="{{ $verifyUrl }}"
        style="display:inline-block;padding:10px 20px;background:#007bff;color:white;text-decoration:none;border-radius:5px;">
        Verifikasi Sekarang
    </a>

    <p>Kode ini berlaku selama 10 menit.</p>
</body>

</html>
