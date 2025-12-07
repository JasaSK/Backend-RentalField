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
        $verify = Booking::where('status_ticket', 'used')->get();
        return view('admin.verifyTicket', compact('verify'));
    }

    public function verifyTicket(Request $request)
    {
        // Validasi input
        $request->validate([
            'booking_id'   => 'required|exists:bookings,id',
            'ticket_code'  => 'required|string|exists:bookings,ticket_code',
        ], [
            'booking_id.required' => 'ID booking wajib diisi.',
            'booking_id.exists' => 'ID booking tidak ditemukan.',
            'ticket_code.required' => 'Kode tiket wajib diisi.',
            'ticket_code.string' => 'Format kode tiket tidak valid.',
            'ticket_code.exists' => 'Kode tiket tidak ditemukan.',
        ]);

        // Ambil booking berdasarkan ID + kode tiket
        $booking = Booking::where('id', $request->booking_id)
            ->where('ticket_code', $request->ticket_code)
            ->first();

        // Jika booking tidak ditemukan
        if (!$booking) {
            return back()->with('error', 'Tiket tidak valid.');
        }

        // Cek apakah status sudah approved dan tiket belum dipakai
        if ($booking->status !== 'approved') {
            return back()->with('error', 'Booking belum disetujui.');
        }

        if ($booking->status_ticket === 'used') {
            return back()->with('error', 'Tiket ini sudah pernah diverifikasi.');
        }

        // Update booking → tiket jadi used
        $booking->update(['status_ticket' => 'used']);

        // Log ke tabel Ticket
        Ticket::create([
            'ticket_code' => $request->ticket_code,
            'booking_id'  => $request->booking_id,
            'verified_at' => now(),
        ]);

        return back()->with('success', 'Tiket berhasil diverifikasi.');
    }
}
