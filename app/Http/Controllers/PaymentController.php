<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use App\Models\Booking;
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

        // BUAT order_id unik
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

        // CALL MIDTRANS API
        $response = Http::withBasicAuth(config('services.midtrans.server_key'), '')
            ->post('https://api.sandbox.midtrans.com/v2/charge', $payload);
        // SIMPAN KE DATABASE
        $booking->update([
            'payment_order_id' => $orderId,
            'qris_url' => $response['actions'][0]['url'] ?? null
        ]);

        return $response->json();
    }

    // CALLBACK
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
        $booking = Booking::where('payment_order_id', $orderId)->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // Update status
        if (in_array($request->transaction_status, ['settlement', 'capture'])) {
            $booking->status = 'approved';
        } elseif ($request->transaction_status === 'pending') {
            $booking->status = 'pending';
        } else {
            $booking->status = 'cancelled';
        }

        $booking->update([
            'status' => $booking->status,
            'ticket_code' => $booking->ticket_code ?? strtoupper(Str::random(10)),
        ]);

        $booking->save();

        return response()->json([
            'message' => 'Callback processed',
            'order_id' => $orderId,
            'status' => $booking->status
        ]);
    }
}
