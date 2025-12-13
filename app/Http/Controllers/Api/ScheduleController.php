<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Schedule;
use Illuminate\Http\Request;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = Schedule::with('field')->get();

        return response()->json([
            'success' => true,
            'message' => 'List data jadwal',
            'data' => $schedules
        ], 200);
    }


    public function show($id)
    {
        $schedule = Schedule::with('field')->find($id);

        if (!$schedule) {
            return response()->json([
                'success' => false,
                'message' => 'Jadwal maintenance tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data jadwal maintenance',
            'data' => $schedule
        ], 200);
    }


    // public function store(Request $request)
    // {
    //     // Validasi input dasar
    //     $request->validate([
    //         'field_id' => 'required|exists:fields,id',
    //         'date' => 'required|date',
    //         'start_time' => 'required|date_format:H:i',
    //         'end_time' => 'required|date_format:H:i|after:start_time',
    //         'reason' => 'nullable|string',
    //     ], [
    //         'field_id.required' => 'ID lapangan wajib diisi.',
    //         'field_id.exists' => 'Lapangan tidak ditemukan.',

    //         'date.required' => 'Tanggal wajib diisi.',
    //         'date.date' => 'Format tanggal tidak valid.',

    //         'start_time.required' => 'Waktu mulai wajib diisi.',
    //         'start_time.date_format' => 'Format waktu mulai tidak valid (HH:MM).',

    //         'end_time.required' => 'Waktu selesai wajib diisi.',
    //         'end_time.date_format' => 'Format waktu selesai tidak valid (HH:MM).',
    //         'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',

    //         'reason.string' => 'Alasan harus berupa teks.',
    //     ]);

    //     // Ambil data field untuk pengecekan jam operasional
    //     $field = Field::find($request->field_id);

    //     // 1. Validasi maintenance harus dalam jam buka - tutup
    //     if ($request->start_time < $field->open_time || $request->end_time > $field->close_time) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Waktu maintenance harus berada dalam jam operasional lapangan ('
    //                 . $field->open_time . ' - ' . $field->close_time . ').'
    //         ], 422);
    //     }

    //     // 2. Validasi bentrok dengan maintenance lain
    //     $overlap = Schedule::where('field_id', $request->field_id)
    //         ->where('date', $request->date)
    //         ->where(function ($q) use ($request) {
    //             $q->whereBetween('start_time', [$request->start_time, $request->end_time])
    //                 ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
    //                 ->orWhere(function ($q2) use ($request) {
    //                     $q2->where('start_time', '<=', $request->start_time)
    //                         ->where('end_time', '>=', $request->end_time);
    //                 });
    //         })
    //         ->exists();

    //     if ($overlap) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Jadwal maintenance bertabrakan dengan jadwal lain.'
    //         ], 422);
    //     }

    //     // Jika lolos semua validasi → buat data
    //     $schedule = Schedule::create($request->all());

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Jadwal maintenance berhasil ditambahkan.',
    //         'data' => $schedule
    //     ], 201);
    // }

    // public function update(Request $request, $id)
    // {
    //     $schedule = Schedule::find($id);

    //     if (!$schedule) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Jadwal maintenance tidak ditemukan'
    //         ], 404);
    //     }

    //     // Validasi input dasar
    //     $request->validate([
    //         'field_id' => 'sometimes|required|exists:fields,id',
    //         'date' => 'sometimes|required|date',
    //         'start_time' => 'sometimes|required|date_format:H:i',
    //         'end_time' => 'sometimes|required|date_format:H:i|after:start_time',
    //         'reason' => 'nullable|string',
    //     ]);

    //     // Tentukan field_id dan date final (pakai value baru jika ada, atau data lama)
    //     $field_id = $request->field_id ?? $schedule->field_id;
    //     $date = $request->date ?? $schedule->date;
    //     $start_time = $request->start_time ?? $schedule->start_time;
    //     $end_time = $request->end_time ?? $schedule->end_time;

    //     // Ambil data field
    //     $field = Field::find($field_id);

    //     // 1. Cek apakah waktu maintenance masih dalam jam operasional
    //     if ($start_time < $field->open_time || $end_time > $field->close_time) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Waktu maintenance harus berada dalam jam operasional lapangan ('
    //                 . $field->open_time . ' - ' . $field->close_time . ').'
    //         ], 422);
    //     }

    //     // 2. Cek bentrok dengan maintenance lain (kecuali dirinya sendiri)
    //     $overlap = Schedule::where('field_id', $field_id)
    //         ->where('date', $date)
    //         ->where('id', '!=', $schedule->id) // ⬅ abaikan dirinya sendiri
    //         ->where(function ($q) use ($start_time, $end_time) {
    //             $q->whereBetween('start_time', [$start_time, $end_time])
    //                 ->orWhereBetween('end_time', [$start_time, $end_time])
    //                 ->orWhere(function ($q2) use ($start_time, $end_time) {
    //                     $q2->where('start_time', '<=', $start_time)
    //                         ->where('end_time', '>=', $end_time);
    //                 });
    //         })
    //         ->exists();

    //     if ($overlap) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Jadwal maintenance bertabrakan dengan jadwal lain.'
    //         ], 422);
    //     }

    //     // Update data jadwal
    //     $schedule->update([
    //         'field_id' => $field_id,
    //         'date' => $date,
    //         'start_time' => $start_time,
    //         'end_time' => $end_time,
    //         'reason' => $request->reason ?? $schedule->reason,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Jadwal maintenance berhasil diperbarui',
    //         'data' => $schedule
    //     ], 200);
    // }



    // public function destroy($id)
    // {
    //     $schedule = Schedule::find($id);

    //     if (!$schedule) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Jadwal maintenance tidak ditemukan'
    //         ], 404);
    //     }

    //     $schedule->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Jadwal maintenance berhasil dihapus'
    //     ], 200);
    // }
}
