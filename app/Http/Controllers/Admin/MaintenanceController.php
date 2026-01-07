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
        $request->validated();

        $field = Field::findOrFail($request->field_id);

        $openTime  = Carbon::createFromFormat('H:i:s', $field->open_time);
        $closeTime = Carbon::createFromFormat('H:i:s', $field->close_time);
        $startTime = Carbon::createFromFormat('H:i', $request->start_time);
        $endTime   = Carbon::createFromFormat('H:i', $request->end_time);

        if (Carbon::parse($request->date)->lt(Carbon::today())) {
            return back()->with('error', 'Tanggal maintenance tidak boleh lewat.');
        }

        if ($startTime->lt($openTime) || $endTime->gt($closeTime)) {
            return back()->with(
                'error',
                'Waktu harus sesuai jam operasional (' .
                    $openTime->format('H:i') . ' - ' . $closeTime->format('H:i') . ')'
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
            return back()->with('error', 'Jadwal maintenance bentrok dengan jadwal lain.');
        }

        Schedule::create($request->all());

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

        $request->validated();

        // fallback ke data lama jika tidak dikirim
        $field_id   = $request->field_id   ?? $schedule->field_id;
        $date       = $request->date       ?? $schedule->date;
        $start_time = $request->start_time ?? $schedule->start_time;
        $end_time   = $request->end_time   ?? $schedule->end_time;

        $field = Field::findOrFail($field_id);

        if (Carbon::parse($date)->lt(Carbon::today())) {
            return back()->with('error', 'Tanggal maintenance tidak boleh kurang dari hari ini.');
        }

        $openTime  = Carbon::createFromFormat('H:i:s', $field->open_time);
        $closeTime = Carbon::createFromFormat('H:i:s', $field->close_time);

        $startTime = Carbon::createFromFormat('H:i', $start_time);
        $endTime   = Carbon::createFromFormat('H:i', $end_time);

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
            'reason'     => $request->reason ?? $schedule->reason,
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
