<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Email Verification | EZFutsal</title>
</head>

<body style="background-color:#f7f7f7; font-family: Arial, sans-seri    f; margin:0; padding:0;">
    <!-- Header -->
    <div style="background-color:#13810A; padding:20px 0; text-align:center;">
        <h1 style="color:#ffffff; font-size:24px; margin:0;">Your Email Verification Code</h1>
    </div>
    <!-- Main Container -->
    <div
        style="max-width:600px; background-color:#ffffff; margin:40px auto; border-radius:10px; box-shadow:0 4px 10px rgba(0,0,0,0.1); padding:30px; text-align:center;">
        <p style="color:#333; font-size:16px; margin-bottom:15px;">Halo, <strong>{{ $user->name }}</strong> 👋</p>

        <p style="color:#555; margin-bottom:20px;">
            Terima kasih telah mendaftar di <span style="color:#13810A; font-weight:bold;">EZFutsal</span>.
            {{ $emailMessage }}
        </p>

        <!-- Kode OTP -->
        <div style="text-align:center; margin:30px 0;">

            <p style="color:#555; margin-bottom:20px; font-size:15px; text-align:center;">
                Berikut {{ $emailSubject }}:
            </p>

            @foreach (str_split($code) as $digit)
                <div
                    style="
                display:inline-block;
                width:30px;
                height:45px;
                line-height:45px;
                margin:0 3px;
                background-color:#13810A;
                color:#fff;
                font-size:20px;
                font-weight:bold;
                border-radius:8px;
                text-align:center;
                box-shadow:0 3px 8px rgba(0,0,0,0.1);
            ">
                    {{ $digit }}
                </div>
            @endforeach

        </div>

        <a href="{{ $verifyUrl }}"
            style="display:inline-block; background-color:#13810A; color:white; padding:12px 25px; border-radius:8px; text-decoration:none; font-weight:bold;">
            Verifikasi Sekarang
        </a>

        <p style="color:#e3342f; font-size:13px; font-weight:bold; margin-top:25px;">
            ⚠ Kode ini hanya berlaku selama 10 menit. Jangan bagikan kepada siapa pun.
        </p>

        <p style="color:#999; font-size:12px; margin-top:20px;">
            Jika Anda tidak mendaftar di EZFutsal, abaikan email ini.
        </p>

        <p style="color:#333; font-weight:bold; margin-top:35px;">
            Tim EZFutsal
        </p>
    </div>
</body>

</html>
