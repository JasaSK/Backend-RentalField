<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <title>Tiket Futsal</title>
    <style>
        @page {
            margin: 0;
        }

        body {
            margin: 0;
            padding: 0;
            font-family: Arial;
            background-color: transparent;
        }

        .ticket-wrapper {
            max-width: 595pt;
            /* lebar tiket */
            padding: 10pt;
            box-sizing: border-box;
            border: 2pt solid #13810A;
            border-radius: 0pt;
            display: flex;
            flex-direction: column;
        }

        .ticket-header {
            background-color: #13810A;
            color: #fff;
            text-align: center;
            padding: 8pt;
        }

        .ticket-header h1 {
            margin: 0;
            font-size: 16pt;
        }

        .ticket-body {
            display: flex;
            flex-wrap: wrap;
            justify-content: space-between;
            margin-top: 8pt;
        }

        .ticket-info {
            flex: 1 1 55%;
            /* fleksibel */
            min-width: 200pt;
            margin-bottom: 5pt;
        }

        .ticket-info p {
            margin: 3pt 0;
            font-size: 10pt;
        }

        .ticket-info .label {
            font-weight: bold;
            width: 60pt;
            display: inline-block;
        }

        .ticket-qr {
            flex: 1 1 35%;
            /* fleksibel */
            min-width: 100pt;
            text-align: center;
            align-self: center;
            margin-bottom: 5pt;
        }

        .ticket-qr img {
            width: 80pt;
            height: 80pt;
            border: 2pt solid #13810A;
            border-radius: 5pt;
        }

        .ticket-footer {
            text-align: center;
            font-size: 8pt;
            color: #555;
            border-top: 1pt dashed #13810A;
            padding-top: 3pt;
            margin-top: 5pt;
        }
    </style>

</head>

<body>
    <div class="ticket-wrapper">
        <div class="ticket-header">
            <h1>Tiket Futsal</h1>
        </div>

        <div class="ticket-body">
            <div class="ticket-info">
                <p><span class="label">Nama:</span> {{ $booking->user->name }}</p>
                <p><span class="label">Lapangan:</span> {{ $booking->field->name }}</p>
                <p><span class="label">Tanggal:</span> {{ \Carbon\Carbon::parse($booking->date)->format('d M Y') }}</p>
                <p><span class="label">Waktu:</span> {{ $booking->start_time }} - {{ $booking->end_time }}</p>
                <p><span class="label">Kode:</span> {{ $booking->ticket_code }}</p>
            </div>
            <div class="ticket-qr">
                <img src="data:image/png;base64,{{ $qrBase64 }}" alt="QR Code">
            </div>
        </div>

        <div class="ticket-footer">
            Tiket ini hanya berlaku untuk pemegang yang tercatat.<br>
            Harap tunjukkan QR code saat masuk.
        </div>
    </div>
</body>

</html>
