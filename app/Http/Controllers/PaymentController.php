<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\Booking;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey   = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') === 'true';
        Config::$isSanitized  = env('MIDTRANS_IS_SANITIZED') === 'true';
        Config::$is3ds        = env('MIDTRANS_IS_3DS') === 'true';

        if (!Config::$serverKey) {
            throw new \Exception("ServerKey Midtrans belum diset di .env");
        }
    }


    public function createPayment($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        $params = [
            'transaction_details' => [
                'order_id' => $booking->code_booking,      // 🔥 GUNAKAN INI
                'gross_amount' => (int) $booking->total_price,
            ],
            'enabled_payments' => ['qris'],
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
            ],
        ];

        try {
            $snapToken = Snap::getSnapToken($params);
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage(),
                'params_sent' => $params
            ], 500);
        }
    }

    public function createQrisPayment($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        // Pastikan order_id selalu unik
        $orderId = $booking->code_booking . '-' . uniqid();

        $params = [
            "payment_type" => "qris",
            "transaction_details" => [
                "order_id" => $orderId,
                "gross_amount" => (int) $booking->total_price,
            ],
        ];

        try {
            $response = \Midtrans\CoreApi::charge($params);
            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }


    public function midtransCallback(Request $request)
    {
        $orderId = $request->order_id; // contoh: BK-YNGE5GQG

        $booking = Booking::where('code_booking', $orderId)->first();

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $status = $request->transaction_status;

        if ($status === 'settlement') {
            $booking->status = 'approved';
        } elseif ($status === 'pending') {
            $booking->status = 'pending';
        } else {
            $booking->status = 'cancelled';
        }

        $booking->save();

        return response()->json(['message' => 'Callback processed']);
    }
}
