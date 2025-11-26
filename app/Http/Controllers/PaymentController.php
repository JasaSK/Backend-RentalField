<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use App\Models\Booking;
use Illuminate\Support\Facades\Http;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey   = config('services.midtrans.server_key');
        Config::$isProduction = config('services.midtrans.is_production', false);
        Config::$isSanitized  = true;
        Config::$is3ds        = false;

        if (!Config::$serverKey) {
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

        // SIMPAN KE DATABASE
        $booking->update([
            'payment_order_id' => $orderId
        ]);

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

        return $response->json();
    }

    // CALLBACK
    public function midtransCallback(Request $request)
    {
        $serverKey = config('services.midtrans.server_key');

        $orderId   = $request->order_id;
        $status    = $request->transaction_status;
        $signature = $request->signature_key;

        $grossAmount = (string) intval($request->gross_amount);

        $expectedSignature = hash(
            'sha512',
            $orderId .
                $request->status_code .
                $grossAmount .
                $serverKey
        );

        if ($signature !== $expectedSignature) {
            return response()->json(['message' => 'Invalid signature'], 403);
        }

        // CARI BOOKING DARI payment_order_id
        $booking = Booking::where('payment_order_id', $orderId)->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        // UPDATE STATUS
        if (in_array($status, ['settlement', 'capture'])) {
            $booking->status = 'approved';
        } elseif ($status === 'pending') {
            $booking->status = 'pending';
        } else {
            $booking->status = 'cancelled';
        }

        $booking->save();

        return response()->json([
            'message' => 'Callback processed',
            'order_id' => $orderId,
            'status' => $booking->status
        ]);
    }
}
