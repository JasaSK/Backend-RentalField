<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Refund\AcceptRefundRequest;
use App\Models\Refund;
use Illuminate\Http\Request;

class RefundController extends Controller
{

    public function index()
    {
        $refunds = Refund::latest()->paginate(10);

        return view('admin.refund', compact('refunds'));
    }

    public function acceptRefund(AcceptRefundRequest $request, $id)
    {
        $validated = $request->validated();

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
            'refund_amount' => $validated['refund_amount'],
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
