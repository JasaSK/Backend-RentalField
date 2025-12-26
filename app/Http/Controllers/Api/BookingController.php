<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Booking\StoreRequest;
use App\Models\Booking;
use App\Models\Field;
use App\Models\Payment;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with('user', 'field')->get();

        if ($bookings->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data booking'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Daftar semua booking',
            'data' => $bookings
        ], 200);
    }

    public function show($id)
    {
        $booking = Booking::with('user', 'field')->find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail booking',
            'data' => $booking
        ], 200);
    }

    public function store(StoreRequest $request)
    {
        $request->validated();

        $bookingDateTime = Carbon::parse($request->date . ' ' . $request->start_time);

        if ($bookingDateTime->lessThanOrEqualTo(now())) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak boleh booking waktu yang sudah lewat'
            ], 400);
        }



        $conflict = Booking::where('field_id', $request->field_id)
            ->where('date', $request->date)
            ->whereNotIn('status', ['canceled', 'refunded'])
            ->where(function ($q) use ($request) {
                $q->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
            })
            ->exists();

        if ($conflict) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal bentrok, lapangan sudah dibooking pada waktu tersebut'
            ], 409);
        }

        $maintenanceConflict = Schedule::where('field_id', $request->field_id)
            ->where('date', $request->date)
            ->where(function ($q) use ($request) {
                $q->where('start_time', '<', $request->end_time)
                    ->where('end_time', '>', $request->start_time);
            })
            ->exists();

        if ($maintenanceConflict) {
            return response()->json([
                'success' => false,
                'message' => 'Lapangan sedang maintenance pada jam tersebut'
            ], 409);
        }

        $field = Field::find($request->field_id);

        if ($field->status !== 'available') {
            return response()->json([
                'success' => false,
                'message' => 'Lapangan sedang tidak tersedia'
            ], 400);
        }

        if (Carbon::parse($request->start_time)->lt(Carbon::parse($field->open_time))) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak boleh sebelum lapangan dibuka (' . $field->open_time . ')'
            ], 400);
        }

        if (Carbon::parse($request->end_time)->gt(Carbon::parse($field->close_time))) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak boleh melewati jam tutup lapangan (' . $field->close_time . ')'
            ], 400);
        }



        $bookingCode = 'BK-' . strtoupper(Str::random(8));
        $duration = (strtotime($request->end_time) - strtotime($request->start_time)) / 3600;
        $totalPrice = $field->price_per_hour * $duration;

        $data = $request->all();
        $data['code_booking'] = $bookingCode;
        $data['status'] = 'pending';
        $data['total_price'] = $totalPrice;

        $booking = Booking::create($data);
        Payment::create([
            'booking_id' => $booking->id,
            'payment_status' => 'unpaid',
            'expires_at' => now()->addMinutes(15),
        ]);
        
        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dibuat',
            'data' => $booking->load('user', 'field')
        ], 201);
    }

    // public function update(Request $request, $id)
    // {
    //     $booking = Booking::find($id);

    //     if (!$booking) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Booking tidak ditemukan'
    //         ], 404);
    //     }

    //     $request->validate([
    //         'field_id' => 'sometimes|exists:fields,id',
    //         'user_id' => 'sometimes|exists:users,id',
    //         'date' => 'sometimes|date',
    //         'start_time' => 'sometimes|date_format:H:i',
    //         'end_time' => 'sometimes|date_format:H:i|after:start_time',
    //     ], [
    //         'field_id.exists' => 'Field tidak ditemukan',
    //         'user_id.exists' => 'User tidak ditemukan',
    //         'date.date' => 'Format tanggal tidak valid',
    //         'start_time.date_format' => 'Format waktu mulai tidak valid (HH:MM)',
    //         'end_time.date_format' => 'Format waktu selesai tidak valid (HH:MM)',
    //         'end_time.after' => 'Waktu selesai harus setelah waktu mulai'
    //     ]);

    //     $conflict = Booking::where('field_id', $request->field_id)
    //         ->where('date', $request->date)
    //         ->where('id', '!=', $booking->id)
    //         ->where(function ($q) use ($request) {
    //             $q->where('start_time', '<', $request->end_time)
    //                 ->where('end_time', '>', $request->start_time);
    //         })
    //         ->exists();

    //     if ($conflict) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Jadwal bentrok, lapangan sudah dibooking pada waktu tersebut'
    //         ], 409);
    //     }

    //     $maintenanceConflict = Schedule::where('field_id', $request->field_id)
    //         ->where('date', $request->date)
    //         ->where(function ($q) use ($request) {
    //             $q->where('start_time', '<', $request->end_time)
    //                 ->where('end_time', '>', $request->start_time);
    //         })
    //         ->exists();

    //     if ($maintenanceConflict) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Lapangan sedang maintenance pada jam tersebut'
    //         ], 409);
    //     }

    //     $field = Field::find($request->field_id);

    //     if ($request->start_time && $request->start_time < $field->open_time) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Booking tidak boleh sebelum lapangan dibuka (' . $field->open_time . ')'
    //         ], 400);
    //     }

    //     if ($request->end_time && $request->end_time > $field->close_time) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Booking tidak boleh melewati jam tutup lapangan (' . $field->close_time . ')'
    //         ], 400);
    //     }

    //     $duration = (strtotime($request->end_time) - strtotime($request->start_time)) / 3600;
    //     $totalPrice = $field->price_per_hour * $duration;

    //     $data = $request->all();
    //     if ($request->start_time && $request->end_time) {
    //         $data['total_price'] = $totalPrice;
    //     }

    //     $booking->update($data);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Booking berhasil diperbarui',
    //         'data' => $booking
    //     ], 200);
    // }

    public function destroy($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }

        $booking->delete();

        return response()->json([
            'success' => true,
            'message' => 'Booking berhasil dihapus'
        ], 200);
    }

    public function history(Request $request)
    {
        $user = $request->user();

        if (!$user) {
            return response()->json([
                'success' => false,
                'message' => 'User belum login'
            ], 401);
        }

        $bookings = Booking::where('user_id', $user->id)
            ->with('field', 'ticket', 'refunds')
            ->orderBy('created_at', 'desc')
            ->get();

        if ($bookings->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada booking untuk user ini'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Daftar booking untuk user ini',
            'data' => $bookings
        ], 200);
    }

    public function bookedHours(Request $request, $fieldId)
    {
        $request->validate([
            'date' => 'required|date'
        ], [
            'date.required' => 'Tanggal harus diisi',
            'date.date' => 'Format tanggal tidak valid'
        ]);

        $date = $request->date;
        $bookedHours = [];

        $bookings = Booking::where('field_id', $fieldId)
            ->where('date', $date)
            ->get();

        foreach ($bookings as $booking) {
            $start = strtotime($booking->start_time);
            $end = strtotime($booking->end_time);
            for ($time = $start; $time < $end; $time += 3600) {
                $bookedHours[] = date('H:i', $time);
            }
        }

        $maintenances = Schedule::where('field_id', $fieldId)
            ->where('date', $date)
            ->get();

        foreach ($maintenances as $schedule) {
            $start = strtotime($schedule->start_time);
            $end = strtotime($schedule->end_time);
            for ($time = $start; $time < $end; $time += 3600) {
                $bookedHours[] = date('H:i', $time);
            }
        }

        $bookedHours = array_unique($bookedHours);
        sort($bookedHours);

        return response()->json([
            'success' => true,
            'date' => $date,
            'booked_hours' => $bookedHours
        ], 200);
    }

    public function getStatus($id)
    {
        $booking = Booking::find($id);
        if (!$booking) {
            return response()->json([
                'success' => false,
                'message' => 'Booking tidak ditemukan'
            ], 404);
        }
        return response()->json([
            'success' => true,
            'status' => $booking->status
        ], 200);
    }
}
