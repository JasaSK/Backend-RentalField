<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Midtrans\Config;
use App\Models\Booking;

class PaymentController extends Controller
{
    public function __construct()
    {
        Config::$serverKey   = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_IS_PRODUCTION') === 'true';
        Config::$isSanitized  = true;
        Config::$is3ds        = false;

        if (!Config::$serverKey) {
            throw new \Exception("ServerKey Midtrans belum diset di .env");
        }
    }

    public function createQrisPayment($booking_id)
    {
        $booking = Booking::findOrFail($booking_id);

        // Order ID harus unik untuk QRIS
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

            // Simpan order_id unik agar callback bisa dilacak
            $booking->update([
                'payment_order_id' => $orderId,
                'status' => 'pending'
            ]);

            return response()->json($response);
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], 500);
        }
    }

    public function midtransCallback(Request $request)
    {
        // Untuk QRIS, order_id berbentuk: CODEBOOKING-UNIQID
        $orderId = $request->order_id;

        $booking = Booking::where('payment_order_id', $orderId)->first();

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
