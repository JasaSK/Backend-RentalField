<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Ticket\VerifyRequest;
use App\Models\Ticket;

class TicketController extends Controller
{
    public function index()
    {
        $verify = Ticket::where('status_ticket', 'used')->get();
        return view('admin.verifyTicket', compact('verify'));
    }

    public function verifyTicket(VerifyRequest $request)
    {
        // Validasi input
        $validated = $request->validated();

        $ticket = Ticket::where('ticket_code', $validated['ticket_code'])->first();

        if (!$ticket) {
            return back()->with('error', 'Kode tiket tidak ditemukan.');
        }

        if ($ticket->status_ticket === 'used') {
            return back()->with('error', 'Tiket ini sudah pernah diverifikasi.');
        }
        if ($ticket->booking->status !== 'approved') {
            return back()->with('error', 'Booking belum disetujui.');
        }
        if ($ticket->payment->payment_status !== 'paid') {
            return back()->with('error', 'Pembayaran belum dilakukan.');
        }

        $ticket->update(['status_ticket' => 'used']);

        return back()->with('success', 'Tiket berhasil diverifikasi.');
    }
}
