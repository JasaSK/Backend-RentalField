<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundController extends Controller
{
    /**
     * User submit refund request
     */
    public function requestRefund(Request $request)
    {
        $request->validate([
            'userId' => 'required|integer|exists:users,id',
            'bookingId' => 'required|integer|exists:bookings,id',
            'reason' => 'required|string',
            'refund_method' => 'nullable|string'
        ], [
            'userId.required' => 'User ID wajib diisi.',
            'userId.integer' => 'User ID harus berupa angka.',
            'userId.exists' => 'User ID tidak ditemukan.',

            'bookingId.required' => 'Booking ID wajib diisi.',
            'bookingId.integer' => 'Booking ID harus berupa angka.',
            'bookingId.exists' => 'Booking ID tidak ditemukan.',

            'reason.required' => 'Alasan wajib diisi.',
            'reason.string' => 'Alasan harus berupa teks.',

            'refund_method.string' => 'Metode refund harus berupa teks.',
        ]);

        $booking = Booking::find($request->bookingId);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking tidak ditemukan.',
            ], 404);
        }

        $amountPaid = $booking->amount_paid;
        $refundAmount = $amountPaid * 0.3;
        $adminFee = $amountPaid * 0.7;

        // Create refund
        $refund = Refund::create([
            'booking_id'    => $booking->id,
            'user_id'       => Auth::id(),
            'amount_paid'   => $amountPaid,
            'refund_amount' => $refundAmount,
            'reason'        => $request->reason,
            'refund_status' => 'pending',
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Refund berhasil diajukan.',
            'data' => $refund
        ], 201);
    }
}
