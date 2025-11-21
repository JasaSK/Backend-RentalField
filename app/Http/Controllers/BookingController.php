<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Field;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::all();

        if (! $bookings) {
            return response()->json([
                'success' => false,
                'message' => 'No bookings found'
            ], 404);
        }
        $bookings->load('user', 'field');
        return response()->json($bookings);
    }

    public function show($id)
    {
        $booking = Booking::find($id);

        if (! $booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        return response()->json($booking);
    }

    public function store(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'user_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
        ], [
            'field_id.required' => 'Field ID tidak boleh kosong.',
            'field_id.exists' => 'Field tidak ditemukan.',

            'user_id.required' => 'User ID tidak boleh kosong.',
            'user_id.exists' => 'User tidak ditemukan.',

            'date.required' => 'Tanggal tidak boleh kosong.',
            'date.date' => 'Format tanggal tidak valid.',

            'start_time.required' => 'Waktu mulai tidak boleh kosong.',
            'start_time.date_format' => 'Format waktu mulai tidak valid (HH:MM).',

            'end_time.required' => 'Waktu selesai tidak boleh kosong.',
            'end_time.date_format' => 'Format waktu selesai tidak valid (HH:MM).',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
        ]);

        // Cek bentrok booking lain
        $conflict = Booking::where('field_id', $request->field_id)
            ->where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal bentrok, lapangan sudah dibooking pada waktu tersebut'
            ], 409);
        }

        // Cek maintenance
        $maintenanceConflict = Schedule::where('field_id', $request->field_id)
            ->where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
            })
            ->exists();

        if ($maintenanceConflict) {
            return response()->json([
                'success' => false,
                'message' => 'Lapangan sedang maintenance pada jam tersebut'
            ], 409);
        }

        // Cek lapangan
        $field = Field::find($request->field_id);
        if ($field->status !== 'available') {
            return response()->json([
                'success' => false,
                'message' => 'Lapangan sedang off / maintenance'
            ], 400);
        }

        // Cek jam buka
        if ($request->start_time < $field->open_time) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak boleh sebelum lapangan dibuka (' . $field->open_time . ')'
            ], 400);
        }

        // Cek jam tutup
        if ($request->end_time > $field->close_time) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak boleh melewati jam tutup lapangan (' . $field->close_time . ')'
            ], 400);
        }

        // Cek tanggal
        if ($request->date < now()->toDateString()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak boleh booking tanggal yang sudah lewat'
            ], 400);
        }

        // Generate booking code
        $bookingCode = 'BK-' . strtoupper(Str::random(8));

        // Hitung total harga
        $duration = (strtotime($request->end_time) - strtotime($request->start_time)) / 3600;
        $totalPrice = $field->price_per_hour * $duration;

        // Build data
        $data = $request->all();
        $data['code_booking'] = $bookingCode;
        $data['status'] = 'pending';
        $data['total_price'] = $totalPrice;

        // Create booking
        $booking = Booking::create($data);


        return response()->json([
            'success' => true,
            'message' => 'Booking created successfully',
            'data' => $booking
        ], 201);
    }


    public function update(Request $request, $id)
    {
        $booking = Booking::find($id);

        if (! $booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        $request->validate(
            [
                'field_id' => 'sometimes|exists:fields,id',
                'user_id' => 'sometimes|exists:users,id',
                'date' => 'sometimes|date',
                'start_time' => 'sometimes|date_format:H:i',
                'end_time' => 'sometimes|date_format:H:i|after:start_time',
            ],
            [
                'field_id.required' => 'Field ID tidak boleh kosong.',
                'field_id.exists' => 'Field tidak ditemukan.',

                'user_id.required' => 'User ID tidak boleh kosong.',
                'user_id.exists' => 'User tidak ditemukan.',

                'date.required' => 'Tanggal tidak boleh kosong.',
                'date.date' => 'Format tanggal tidak valid.',

                'start_time.required' => 'Waktu mulai tidak boleh kosong.',
                'start_time.date_format' => 'Format waktu mulai tidak valid (HH:MM).',

                'end_time.required' => 'Waktu selesai tidak boleh kosong.',
                'end_time.date_format' => 'Format waktu selesai tidak valid (HH:MM).',
                'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',

            ]
        );

        // CEK BENTROK (kecuali dengan dirinya sendiri)
        $conflict = Booking::where('field_id', $request->field_id)
            ->where('date', $request->date)
            ->where('id', '!=', $booking->id)  // ← penting!
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal bentrok, lapangan sudah dibooking pada waktu tersebut'
            ], 409);
        }

        // CEK MAINTENANCE
        $maintenanceConflict = Schedule::where('field_id', $request->field_id)
            ->where('date', $request->date)
            ->where(function ($query) use ($request) {
                $query->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
            })
            ->exists();

        if ($maintenanceConflict) {
            return response()->json([
                'success' => false,
                'message' => 'Lapangan sedang maintenance pada jam tersebut'
            ], 409);
        }

        // CEK JAM BUKA & TUTUP
        $field = Field::find($request->field_id);

        if ($request->start_time < $field->open_time) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak boleh sebelum lapangan dibuka (' . $field->open_time . ')'
            ], 400);
        }

        if ($request->end_time > $field->close_time) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak boleh melewati jam tutup lapangan (' . $field->close_time . ')'
            ], 400);
        }

        // HITUNG ULANG TOTAL HARGA
        $duration = (strtotime($request->end_time) - strtotime($request->start_time)) / 3600;
        $totalPrice = $field->price_per_hour * $duration;

        // DATA UPDATE
        $data = $request->all();
        $data['total_price'] = $totalPrice;

        // UPDATE DATA
        $booking->update($data);


        return response()->json([
            'success' => true,
            'message' => 'Booking updated successfully',
            'data' => $booking
        ], 200);
    }

    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (! $booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking not found'
            ], 404);
        }

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking deleted successfully'
        ], 200);
    }
}
