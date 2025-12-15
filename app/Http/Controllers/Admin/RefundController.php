<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{

    public function index()
    {
        $refunds = Refund::latest()->paginate(10);

        return view('admin.refund', compact('refunds'));
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
            return back()->with('error', 'Refund tidak ditemukan.');
        }

        if ($refund->booking->status !== 'approved') {
            return back()->with('error', 'Refund hanya dapat diproses jika booking berstatus approved.');
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
        $refund->booking->ticket->update([
            'status_ticket' => 'refunded'
        ]);

        $refund->payment->update([
            'payment_status' => 'refunded'
        ]);
        return redirect()->route('admin.refund')->with('success', 'Refund berhasil diterima.');
    }

    public function rejectRefund($id)
    {
        $refund = Refund::find($id);

        if (!$refund) {
            return back()->with('error', 'Refund tidak ditemukan.');
        }

        $refund->update([
            'refund_status' => 'rejected',
        ]);
        return redirect()->route('admin.refund')->with('success', 'Refund berhasil ditolak.');
    }
}
