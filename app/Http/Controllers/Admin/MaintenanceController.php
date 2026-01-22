<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Maintence\MaintenceRequest;
use App\Models\Field;
use App\Models\Schedule;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

class MaintenanceController extends Controller
{
    public function index()
    {
        $maintenances  = Schedule::all();
        $fields = Field::all();
        return view('admin.maintenance', compact('maintenances', 'fields'));
    }
    public function store(MaintenceRequest $request)
    {
        $validated = $request->validated();

        $field = Field::findOrFail($validated['field_id']);

        $openTime  = Carbon::createFromFormat('H:i:s', $field->open_time);
        $closeTime = Carbon::createFromFormat('H:i:s', $field->close_time);
        $startTime = Carbon::createFromFormat('H:i', $validated['start_time']);
        $endTime   = Carbon::createFromFormat('H:i', $validated['end_time']);

        if (Carbon::parse($validated['date'])->lt(Carbon::today())) {
            return back()->with('error', 'Tanggal maintenance tidak boleh lewat.');
        }
        if ($startTime->gte($endTime)) {
            return back()->with('error', 'Jam mulai harus lebih kecil dari jam selesai.');
        }

        if ($startTime->lt($openTime) || $endTime->gt($closeTime)) {
            return back()->with(
                'error',
                'Waktu harus sesuai jam operasional (' .
                    $openTime->format('H:i') . ' - ' . $closeTime->format('H:i') . ')'
            );
        }

        $overlap = Schedule::where('field_id', $validated['field_id'])
            ->where('date', $validated['date'])
            ->where(function ($q) use ($validated) {
                $q->whereBetween('start_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhereBetween('end_time', [$validated['start_time'], $validated['end_time']])
                    ->orWhere(function ($q2) use ($validated) {
                        $q2->where('start_time', '<=', $validated['start_time'])
                            ->where('end_time', '>=', $validated['end_time']);
                    });
            })
            ->exists();

        if ($overlap) {
            return back()->with('error', 'Jadwal maintenance bentrok dengan jadwal lain.');
        }

        Schedule::create($validated);

        return redirect()
            ->route('admin.maintenance')
            ->with('success', 'Jadwal maintenance berhasil ditambahkan.');
    }


    public function update(MaintenceRequest $request, $id)
    {
        // dd($request->all());
        $schedule = Schedule::find($id);

        if (!$schedule) {
            return back()->with('error', 'Jadwal maintenance tidak ditemukan.');
        }

        $validated = $request->validated();

        // fallback ke data lama jika tidak dikirim
        $field_id   = $validated['field_id']   ?? $schedule->field_id;
        $date       = $validated['date']       ?? $schedule->date;
        $start_time = $validated['start_time'] ?? $schedule->start_time;
        $end_time   = $validated['end_time']   ?? $schedule->end_time;

        $field = Field::findOrFail($field_id);

        if (Carbon::parse($date)->lt(Carbon::today())) {
            return back()->with('error', 'Tanggal maintenance tidak boleh kurang dari hari ini.');
        }

        $openTime  = Carbon::createFromFormat('H:i:s', $field->open_time);
        $closeTime = Carbon::createFromFormat('H:i:s', $field->close_time);

        $startTime = Carbon::createFromFormat('H:i', $start_time);
        $endTime   = Carbon::createFromFormat('H:i', $end_time);

        if ($startTime->gte($endTime)) {
            return back()->with('error', 'Jam mulai harus lebih kecil dari jam selesai.');
        }

        // jam di luar operasional
        if ($startTime->lt($openTime) || $endTime->gt($closeTime)) {
            return back()->with(
                'error',
                'Waktu harus sesuai jam operasional (' .
                    $openTime->format('H:i') . ' - ' . $closeTime->format('H:i') . ')'
            );
        }

        // jika tanggal hari ini, jam tidak boleh lewat sekarang
        if ($date === now()->toDateString() && $startTime->lt(now())) {
            return back()->with('error', 'Jam maintenance tidak boleh kurang dari waktu sekarang.');
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
            return back()->with('error', 'Jadwal maintenance bentrok dengan jadwal lain.');
        }

        $schedule->update([
            'field_id'   => $field_id,
            'date'       => $date,
            'start_time' => $start_time,
            'end_time'   => $end_time,
            'reason'     => $validated['reason'] ?? $schedule->reason,
        ]);

        return redirect()
            ->route('admin.maintenance')
            ->with('success', 'Jadwal maintenance berhasil diperbarui.');
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
