<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Field;
use App\Models\Schedule;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances  = Schedule::all();
        $fields = Field::all();
        return view('admin.maintenance', compact('maintenances', 'fields'));
    }
    public function store(Request $request)
    {
        $request->validate([
            'field_id' => 'required|exists:fields,id',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'reason' => 'nullable|string',
        ], [
            'field_id.required' => 'Lapangan wajib diisi.',
            'field_id.exists' => 'Lapangan tidak valid.',
            'date.required' => 'Tanggal wajib diisi.',
            'date.date' => 'Format tanggal tidak valid.',
            'start_time.required' => 'Waktu mulai wajib diisi.',
            'start_time.date_format' => 'Format waktu mulai tidak valid. Gunakan format HH:MM.',
            'end_time.required' => 'Waktu selesai wajib diisi.',
            'end_time.date_format' => 'Format waktu selesai tidak valid. Gunakan format HH:MM.',
            'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
        ]);

        $field = Field::find($request->field_id);

        if ($request->start_time < $field->open_time || $request->end_time > $field->close_time) {
            return redirect()->back()->with(
                'error',
                'Waktu harus sesuai jam operasional (' . $field->open_time . ' - ' . $field->close_time . ')'
            );
        }

        $overlap = Schedule::where('field_id', $request->field_id)
            ->where('date', $request->date)
            ->where(function ($q) use ($request) {
                $q->whereBetween('start_time', [$request->start_time, $request->end_time])
                    ->orWhereBetween('end_time', [$request->start_time, $request->end_time])
                    ->orWhere(function ($q2) use ($request) {
                        $q2->where('start_time', '<=', $request->start_time)
                            ->where('end_time', '>=', $request->end_time);
                    });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()->with('error', 'Jadwal maintenance bentrok dengan jadwal lain.');
        }

        Schedule::create($request->all());

        return redirect()->route('admin.maintenance')->with('success', 'Jadwal maintenance berhasil ditambahkan.');
    }
    public function update(Request $request, $id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return redirect()->back()->with('error', 'Jadwal maintenance tidak ditemukan.');
        }

        $request->validate(
            [
                'field_id' => 'required|exists:fields,id',
                'date' => 'required|date',
                'start_time' => 'required|date_format:H:i',
                'end_time' => 'required|date_format:H:i|after:start_time',
                'reason' => 'nullable|string',
            ],
            [
                'field_id.required' => 'Lapangan wajib diisi.',
                'field_id.exists' => 'Lapangan tidak valid.',
                'date.required' => 'Tanggal wajib diisi.',
                'date.date' => 'Format tanggal tidak valid.',
                'start_time.required' => 'Waktu mulai wajib diisi.',
                'start_time.date_format' => 'Format waktu mulai tidak valid. Gunakan format HH:MM.',
                'end_time.required' => 'Waktu selesai wajib diisi.',
                'end_time.date_format' => 'Format waktu selesai tidak valid. Gunakan format HH:MM.',
                'end_time.after' => 'Waktu selesai harus setelah waktu mulai.',
            ]
        );

        // dd($request->all());

        $field_id = $request->field_id ?? $schedule->field_id;
        $date = $request->date ?? $schedule->date;
        $start_time = $request->start_time ?? $schedule->start_time;
        $end_time = $request->end_time ?? $schedule->end_time;

        $field = Field::find($field_id);

        if ($start_time < $field->open_time || $end_time > $field->close_time) {
            return redirect()->back()->with(
                'error',
                'Waktu harus sesuai jam operasional (' . $field->open_time . ' - ' . $field->close_time . ').'
            );
        }

        $overlap = Schedule::where('field_id', $field_id)
            ->where('date', $date)
            ->where('id', '!=', $schedule->id)
            ->where(function ($q) use ($start_time, $end_time) {
                $q->whereBetween('start_time', [$start_time, $end_time])
                    ->orWhereBetween('end_time', [$start_time, $end_time])
                    ->orWhere(function ($q2) use ($start_time, $end_time) {
                        $q2->where('start_time', '<=', $start_time)
                            ->where('end_time', '>=', $end_time);
                    });
            })
            ->exists();

        if ($overlap) {
            return redirect()->back()->with('error', 'Jadwal maintenance bentrok dengan jadwal lain.');
        }

        $schedule->update([
            'field_id' => $field_id,
            'date' => $date,
            'start_time' => $start_time,
            'end_time' => $end_time,
            'reason' => $request->reason ?? $schedule->reason,
        ]);

        return redirect()->route('admin.maintenance')->with('success', 'Jadwal berhasil diperbarui.');
    }
    public function destroy($id)
    {
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return redirect()->back()->with('error', 'Data tidak ditemukan.');
        }

        $schedule->delete();

        return redirect()->route('admin.maintenance')->with('success', 'Jadwal berhasil dihapus.');
    }
}
