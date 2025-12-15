<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $verify = Ticket::where('status_ticket', 'used')->get();
        return view('admin.verifyTicket', compact('verify'));
    }

    public function verifyTicket(Request $request)
    {
        // Validasi input
        $request->validate([
            // 'booking_id'   => 'required|exists:bookings,id',
            'ticket_code'  => 'required|string|exists:ticket,ticket_code',
        ], [
            // 'booking_id.required' => 'ID booking wajib diisi.',
            // 'booking_id.exists' => 'ID booking tidak ditemukan.',
            'ticket_code.required' => 'Kode tiket wajib diisi.',
            'ticket_code.string' => 'Format kode tiket tidak valid.',
            'ticket_code.exists' => 'Kode tiket tidak ditemukan.',
        ]);

        $ticket = Ticket::where('ticket_code', $request->ticket_code)->first();

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

        // Ticket::create([
        //     'ticket_code' => $request->ticket_code,
        //     'booking_id'  => $ticket->id,
        //     'verified_at' => now(),
        // ]);

        return back()->with('success', 'Tiket berhasil diverifikasi.');
    }
}
