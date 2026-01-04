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

        if ($schedules->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data jadwal',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'List data jadwal',
            'data' => $schedules
        ], 200);
    }


    public function show($fieldId)
    {
        $schedule = Schedule::where('field_id', $fieldId)->get();

        if (!$schedule) {
            return response()->json([
                'status' => false,
                'message' => 'Jadwal maintenance tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail data jadwal maintenance',
            'data' => $schedule
        ], 200);
    }
}
