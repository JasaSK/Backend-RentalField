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

        // payload Snap
        $params = [
            'transaction_details' => [
                'order_id' => 'BOOK-' . $booking->id . '-' . time(),
                'gross_amount' => $booking->total_price,
            ],
            'enabled_payments' => ['qris'],  // QRIS only
            'customer_details' => [
                'first_name' => $booking->user->name,
                'email' => $booking->user->email,
            ],
        ];

        $snapToken = Snap::getSnapToken($params);

        return response()->json([
            'snap_token' => $snapToken
        ]);
    }

    // CALLBACK
    public function midtransCallback(Request $request)
    {
        $orderId = $request->order_id;
        $status = $request->transaction_status;
        $fraud = $request->fraud_status;

        // get booking id
        $booking_id = explode('-', $orderId)[1];
        $booking = Booking::find($booking_id);

        if (!$booking) {
            return response()->json(['message' => 'Booking not found'], 404);
        }

        $booking_id = explode('-', $orderId)[1];
        $booking = Booking::find($booking_id);

        if ($status == 'settlement') {
            $booking->status = 'approved'; // atau 'paid' kalau mau
        } elseif ($status == 'pending') {
            $booking->status = 'pending';
        } else {
            $booking->status = 'cancelled'; // misal failed
        }

        $booking->save();


        return response()->json(['message' => 'Callback processed']);
    }
}
