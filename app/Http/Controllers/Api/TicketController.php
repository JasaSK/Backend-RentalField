<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;
use Endroid\QrCode\Encoding\Encoding;
use Endroid\QrCode\Writer\PngWriter;
use Endroid\QrCode\QrCode;
use Endroid\QrCode\ErrorCorrectionLevel;
use Illuminate\Support\Str;

class TicketController extends Controller
{

    public function showTicket($booking_id)
    {
        $ticket = Ticket::where('booking_id', $booking_id)->first();
        if (!$ticket) {
            return response()->json(['status' => false, 'message' => 'Tiket tidak ditemukan'], 404);
        }
        $qr = new QrCode(
            data: $ticket->ticket_code,
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
            'status' => true,
            'data' => [
                'ticket' => $ticket->load('booking'),
                'qrBase64' => $qrBase64
            ]
        ], 200);
    }

    public function downloadTicket($bookingId)
    {
        $ticket = Ticket::with('booking')->where('booking_id', $bookingId)->first();

        if (!$ticket) {
            return response()->json([
                'status' => false,
                'message' => 'Tiket tidak ditemukan'
            ], 404);
        }

        if ($ticket->booking->status !== 'approved') {
            return response()->json([
                'status' => false,
                'message' => 'Tiket hanya bisa diunduh setelah pembayaran berhasil'
            ], 403);
        }

        // === QR CODE (Endroid QR v6 ENUMS) ===
        $qr = new QrCode(
            data: $ticket->ticket_code,
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
            'booking' => $ticket->booking,
            'qrBase64' => $qrBase64,
        ])->setPaper([0, 0, $widthPt, $heightPt]);

        return $pdf->stream('ticket-' . $ticket->ticket_code . '.pdf');
    }
}
