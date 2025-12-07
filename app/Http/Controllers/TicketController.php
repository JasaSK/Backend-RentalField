<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Illuminate\Support\Str;

class TicketController extends Controller
{

    public function showTicket($id)
    {
        $booking = Booking::with('user', 'field')->find($id);

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
        }

        // Generate ticket code jika belum ada
        if (!$booking->ticket_code) {
            $booking->ticket_code = 'TCK-' . strtoupper(Str::random(12));
            $booking->save();
        }

        // === Generate QR code untuk frontend ===
        $qr = new QrCode(
            data: $booking->ticket_code,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10
        );
        $writer = new PngWriter();
        $result = $writer->write($qr);
        $qrBase64 = base64_encode($result->getString());

        // Kirim data booking + QR Base64 ke FE
        return response()->json([
            'success' => true,
            'booking' => $booking,
            'qrBase64' => $qrBase64
        ]);
    }


    public function downloadTicket($id)
    {
        $booking = Booking::with('user', 'field')->find($id);

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Booking not found'], 404);
        }

        if ($booking->status !== 'approved') {
            return response()->json(['success' => false, 'message' => 'Tiket hanya bisa diunduh setelah pembayaran berhasil'], 403);
        }

        if (!$booking->ticket_code) {
            $booking->ticket_code = 'TCK-' . strtoupper(Str::random(12));
            $booking->save();
        }

        // === QR CODE (Endroid QR v6 ENUMS) ===
        $qr = new QrCode(
            data: $booking->ticket_code,
            encoding: new Encoding('UTF-8'),
            errorCorrectionLevel: ErrorCorrectionLevel::High,
            size: 300,
            margin: 10
        );

        $writer = new PngWriter();
        $result = $writer->write($qr);

        $qrBase64 = base64_encode($result->getString());
        $widthPt = 210 / 25.4 * 72;
        $heightPt = 91.18 / 25.4 * 72; // 100mm = 283pt
        $pdf = Pdf::loadView('pdf.tickets', [
            'booking' => $booking,
            'qrBase64' => $qrBase64,
        ])->setPaper([0, 0, $widthPt, $heightPt]);

        return $pdf->stream('ticket-' . $booking->ticket_code . '.pdf');
    }


    public function verifyTicket(Request $request)
    {
        $request->validate([
            'ticket_code' => 'required|string',
        ], [
            'ticket_code.required' => 'Kode tiket wajib diisi.',
        ]);

        $booking = Booking::where('ticket_code', $request->ticket_code)->first();

        if (!$booking) {
            return response()->json(['success' => false, 'message' => 'Tiket tidak valid'], 404);
        }

        if ($booking->status !== 'approved') {
            return response()->json(['success' => false, 'message' => 'Tiket belum dapat diverifikasi karena pembayaran belum disetujui'], 403);
        }

        return response()->json([
            'success' => true,
            'message' => 'Tiket valid',
            'booking' => $booking
        ]);
    }
}
