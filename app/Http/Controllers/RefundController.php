<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Refund;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RefundController extends Controller
{
    public function requestRefund(Request $request)
    {
        $request->validate([
            'user_id' => 'required|integer|exists:users,id',
            'booking_id' => 'required|integer|exists:bookings,id',
            'amount_paid' => 'required|integer',
            'reason' => 'required|string',
            'refund_method' => 'nullable|string',
            'account_number' => 'nullable|string',
        ], [
            'userId.required' => 'User ID wajib diisi.',
            'userId.integer' => 'User ID harus berupa angka.',
            'userId.exists' => 'User ID tidak ditemukan.',

            'bookingId.required' => 'Booking ID wajib diisi.',
            'bookingId.integer' => 'Booking ID harus berupa angka.',
            'bookingId.exists' => 'Booking ID tidak ditemukan.',

            'amount_paid.required' => 'Jumlah yang dibayar wajib diisi.',
            'amount_paid.integer' => 'Jumlah yang dibayar harus berupa angka.',

            'total_price.required' => 'Total harga wajib diisi.',
            'total_price.integer' => 'Total harga harus berupa angka.',

            'total_price.required' => 'Total harga wajib diisi.',
            'total_price.integer' => 'Total harga harus berupa angka.',

            'reason.required' => 'Alasan wajib diisi.',
            'reason.string' => 'Alasan harus berupa teks.',

            'refund_method.string' => 'Metode refund harus berupa teks.',
        ]);

        $booking = Booking::find($request->booking_id);

        if (!$booking) {
            return response()->json([
                'status' => false,
                'message' => 'Booking tidak ditemukan.',
            ], 404);
        };

        if ($request->amount_paid > $booking->total_price) {
            return response()->json([
                'status' => false,
                'message' => 'Jumlah yang dibayar tidak boleh lebih besar dari total harga.',
            ], 400);
        }

        if ($request->amount_paid < $booking->total_price) {
            return response()->json([
                'status' => false,
                'message' => 'Jumlah yang dibayar tidak boleh lebih kecil dari total harga.',
            ], 400);
        }

        if ($booking->status !== 'approved') {
            return response()->json([
                'status' => false,
                'message' => 'Booking belum dibayar.',
            ]);
        }

        if ($booking->user_id !== $request->user_id) {
            return response()->json([
                'status' => false,
                'message' => 'Booking tidak ditemukan.',
            ]);
        }

        $refund = Refund::where('booking_id', $booking->id)->first();

        if ($refund) {
            return response()->json([
                'status' => false,
                'message' => 'Refund sudah diajukan.',
            ], 400);
        }

        if ($refund->status !== 'pending') {
            return response()->json([
                'status' => false,
                'message' => 'Refund sudah diajukan.',
            ]);
        }

        // Create refund
        $refund = Refund::create([
            'booking_id'     => $booking->id,
            'user_id'        => $request->user_id,
            'amount_paid'   => $booking->total_price,
            'refund_amount'  => null,
            'reason'        => $request->reason,
            'refund_method' => $request->refund_method,
            'account_number' => $request->account_number,
            'refund_status' => 'pending',
            'proof' => null
        ]);

        return response()->json([
            'status' => true,
            'message' => 'Refund berhasil diajukan.',
            'data' => $refund->load('booking')
        ], 201);
    }

    public function getRefund()
    {
        $user = Auth::user();
        $refunds = Refund::where('user_id', $user->id)->get();
        return response()->json([
            'status' => true,
            'message' => 'Daftar refund',
            'data' => $refunds
        ], 200);
    }

    public function getAllRefund()
    {
        $refunds = Refund::all();
        return response()->json([
            'status' => true,
            'message' => 'Daftar refund',
            'data' => $refunds
        ], 200);
    }


    public function acceptRefund(Request $request, $id)
    {
        $request->validate([
            'refund_amount' => 'required|integer',
            'proof' => 'required|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'refund_amount.required' => 'Jumlah refund wajib diisi.',
            'refund_amount.integer' => 'Jumlah refund harus berupa angka.',
            'proof.required' => 'Bukti wajib diisi.',
            'proof.image' => 'Bukti harus berupa gambar.',
            'proof.mimes' => 'Format gambar harus JPG, JPEG, atau PNG.',
            'proof.max' => 'Ukuran gambar maksimal 2MB.',
        ]);

        $refund = Refund::find($id);

        if (!$refund) {
            return response()->json([
                'status' => false,
                'message' => 'Refund tidak ditemukan.',
            ], 404);
        }

        if ($refund->booking->status !== 'approved') {
            return response()->json([
                'status' => false,
                'message' => 'Refund hanya dapat diproses jika booking berstatus approved.',
            ], 400);
        }

        // Upload bukti
        $imagePath = $request->file('proof')->store('refunds', 'public');

        // Update refund
        $refund->update([
            'refund_amount' => $request->refund_amount,
            'proof' => $imagePath,
            'refund_status' => 'approved',
            'refunded_at' => now(),
        ]);
        $refund->booking->update([
            'status' => 'refunded'
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Refund berhasil disetujui.',
            'data' => $refund
        ], 200);
    }

    public function rejectRefund($id)
    {
        $refund = Refund::find($id);

        if (!$refund) {
            return response()->json([
                'status' => false,
                'message' => 'Refund tidak ditemukan.',
            ], 404);
        }

        $refund->update([
            'refund_status' => 'rejected',
        ]);
        return response()->json([
            'status' => true,
            'message' => 'Refund berhasil ditolak.',
            'data' => $refund
        ], 200);
    }
}
