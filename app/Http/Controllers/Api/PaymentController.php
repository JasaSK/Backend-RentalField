<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
        if (Carbon::parse($booking->date)->startOfDay()->lessThan(Carbon::now()->startOfDay())) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak boleh booking tanggal yang sudah lewat'
            ], 400);
        }

        if ($booking->status == 'approved') {
            return response()->json([
                'message' => 'Booking sudah dibayar'
            ]);
        }

        $existingPayment = Payment::where('booking_id', $booking_id)
            ->where('payment_status', 'unpaid')
            ->latest()
            ->first();

        if ($existingPayment) {
            return response()->json([
                'message' => 'Gunakan pembayaran yang sudah ada',
                'qris_url' => $existingPayment->qris_url,
                'order_id' => $existingPayment->payment_order_id
            ]);
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

        $qrisUrl = $response->json()['actions'][0]['url'] ?? null;
        Payment::create([
            'booking_id' => $booking_id,
            'payment_order_id' => $orderId,
            'payment_status' => 'unpaid',
            'qris_url' => $qrisUrl
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
