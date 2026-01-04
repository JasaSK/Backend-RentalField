<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Jobs\CancelUnpaidBooking;
use Illuminate\Http\Request;
use Midtrans\Config;
use App\Models\Booking;
use App\Models\Payment;
use App\Models\Ticket;
use Carbon\Carbon;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;


class PaymentController extends Controller
{
    public function __construct()
    {
        $serverKey   = config('services.midtrans.server_key');
        $isProduction = config('services.midtrans.is_production', false);
        $isSanitized  = true;
        $is3ds        = false;

        if (!$serverKey) {
            throw new \Exception("ServerKey Midtrans belum diset di .env");
        }
    }

    public function createQrisPayment($booking_id)
    {
        $booking = Booking::find($booking_id);

        if (!$booking) {
            return response()->json(['message' => 'Booking tidak ditemukan'], 404);
        }

        // ❌ booking waktu lampau (date + time seharusnya, tapi aku fokus payment)
        if ($booking->status === 'approved') {
            return response()->json([
                'message' => 'Booking sudah dibayar'
            ]);
        }

        $payment = Payment::where('booking_id', $booking_id)
            ->where('payment_status', 'unpaid')
            ->first();

        if (!$payment) {
            return response()->json([
                'message' => 'Payment tidak ditemukan atau sudah expired'
            ], 404);
        }

        // ⏰ kalau payment sudah expired → STOP
        if ($payment->expires_at && now()->greaterThan($payment->expires_at)) {
            return response()->json([
                'message' => 'Payment sudah expired'
            ], 400);
        }

        // Sudah pernah generate QRIS
        if ($payment->qris_url) {
            return response()->json([
                'message' => 'Gunakan pembayaran yang sudah ada',
                'qris_url' => $payment->qris_url,
                'order_id' => $payment->payment_order_id
            ]);
        }

        $orderId = $booking->code_booking . '-' . uniqid();

        $payload = [
            'payment_type' => 'qris',
            'transaction_details' => [
                'order_id' => $orderId,
                'gross_amount' => $booking->total_price
            ],
            'qris' => [
                'acquirer' => 'gopay'
            ]
        ];

        $response = Http::withBasicAuth(
            config('services.midtrans.server_key'),
            ''
        )->post('https://api.sandbox.midtrans.com/v2/charge', $payload);

        if (!$response->successful()) {
            return response()->json([
                'message' => 'Gagal membuat QRIS'
            ], 500);
        }

        $qrisUrl = $response->json('actions.0.url');

        $payment->update([
            'payment_order_id' => $orderId,
            'qris_url' => $qrisUrl,
        ]);

        return response()->json([
            'status' => true,
            'qris_url' => $qrisUrl,
            'expires_at' => $payment->expires_at
        ]);
    }

    public function expirePayment(Request $request, $booking_id)
    {
        $payment = Payment::where('booking_id', $booking_id)
            ->where('payment_status', 'unpaid')
            ->latest()
            ->first();

        if (!$payment) {
            return response()->json([
                'status' => false,
                'message' => 'Payment tidak ditemukan'
            ], 404);
        }

        // VALIDASI EXPIRED
        if (now()->diffInMilliseconds($payment->expires_at, false) > 0) {
            return response()->json([
                'message' => 'Payment belum expired'
            ], 400);
        }

        // HAPUS BOOKING (PAYMENT AKAN IKUT TERHAPUS)
        $booking = Booking::find($booking_id);
        if ($booking) {
            $booking->delete();
        }

        return response()->json([
            'status' => true,
            'message' => 'Payment expired, booking dibatalkan'
        ]);
    }


    public function midtransCallback(Request $request)
    {
        // \Log::info('MIDTRANS CALLBACK RECEIVED', $request->all());

        $serverKey = config('services.midtrans.server_key');

        $orderId      = $request->order_id;
        $statusCode   = $request->status_code;  // Midtrans pasti kirim
        $grossAmount  = $request->gross_amount;
        $signatureKey = $request->signature_key;

        // Generate signature
        $expectedSignature = hash(
            'sha512',
            $orderId .
                $statusCode .
                $grossAmount .
                $serverKey
        );

        if ($signatureKey !== $expectedSignature) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // Cari booking
        $payment = Payment::where('payment_order_id', $orderId)->first();

        if (!$payment) {
            return response()->json(['message' => 'Pembayaran tidak ditemukan, silahkan coba lagi'], 404);
        }


        // Update status
        if (in_array($request->transaction_status, ['settlement', 'capture'])) {
            $payment->payment_status = 'paid';
        } elseif ($request->transaction_status === 'pending') {
            $payment->payment_status = 'unpaid';
        } else {
            $payment->payment_status = 'cancelled';
        }

        // if ($payment->payment_status === 'paid') return;
        // $payment->payment_status =  $payment->status;
        $payment->save();

        if ($payment->payment_status == 'paid') {
            $booking = Booking::find($payment->booking_id);
            if ($booking->status != 'approved') {
                $booking->status = 'approved';
                $booking->save();
            }

            $ticketExists = Ticket::where('payment_id', $payment->id)->exists();

            if (!$ticketExists) {
                Ticket::create([
                    'booking_id' => $payment->booking_id,
                    'payment_id' => $payment->id,
                    'ticket_code' => 'TCK-' . strtoupper(Str::random(10)),
                    'status_ticket' => 'unused'
                ]);
            }
        }

        if ($payment->payment_status == 'cancelled') {
            $booking = Booking::find($payment->booking_id);
            $booking->status = 'rejected';
            $booking->save();
        }

        return response()->json([
            'message' => 'Callback processed',
            'order_id' => $orderId,
            'status' => $payment->status
        ]);
    }

    public function getQris($booking_id)
    {
        $payment = Payment::where('booking_id', $booking_id)->first();
        if (!$payment) {
            return response()->json([
                'status' => false,
                'message' => 'Pembayaran tidak ditemukan atau belum dibuat',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'Detail data pembayaran',
            'data' => $payment
        ]);
    }
}
