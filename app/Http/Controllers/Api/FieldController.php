<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FieldController extends Controller
{

    public function search(Request $request)
    {
        $query = Field::query();

        if ($request->filled('category_field_id')) {
            $query->where('category_field_id', $request->category_field_id);
        }

        $searchStart = $request->open_time;
        $searchEnd = $request->close_time;

        $searchDate = $request->tanggal_main ?? now()->toDateString();

        $fields = $query->with(['categoryField', 'schedules', 'bookings'])->get();

        $fields = $fields->map(function ($field) use ($searchStart, $searchEnd, $searchDate) {

            $status = 'available';

            if ($searchStart && $searchEnd) {
                if ($searchStart < $field->open_time || $searchEnd > $field->close_time) {
                    $status = 'closed';
                }
            }

            $maintenance = false;
            if ($searchStart && $searchEnd) {
                $maintenance = $field->schedules()
                    ->where('date', $searchDate)
                    ->where(function ($q) use ($searchStart, $searchEnd) {
                        $q->where(function ($q2) use ($searchStart, $searchEnd) {
                            $q2->where('start_time', '<', $searchEnd)
                                ->where('end_time', '>', $searchStart);
                        });
                    })->exists();
            }

            if ($maintenance) {
                $status = 'maintenance';
            }

            $booking = false;
            if ($searchStart && $searchEnd) {
                $booking = $field->bookings()
                    ->where('date', $searchDate)
                    ->where(function ($q) use ($searchStart, $searchEnd) {
                        $q->where(function ($q2) use ($searchStart, $searchEnd) {
                            $q2->where('start_time', '<', $searchEnd)
                                ->where('end_time', '>', $searchStart);
                        });
                    })->exists();
            }

            if ($booking) {
                $status = 'booked';
            }

            $field->status_now = $status;
            return $field;
        });

        return response()->json([
            'status' => true,
            'message' => 'Hasil pencarian lapangan',
            'data' => $fields
        ], 200);
    }

    public function index()
    {
        $fields = Field::all();

        if ($fields->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Data lapangan kosong',
            ], 404);
        }
        $fields->load('categoryField');
        return response()->json([
            'status' => true,
            'message' => 'List data lapangan',
            'data' => $fields
        ], 200);
    }
    public function show($id)
    {
        $field = Field::find($id);

        if (!$field) {
            return response()->json([
                'status' => false,
                'message' => 'Lapangan tidak ditemukan'
            ], 404);
        }

        $field->load('categoryField');

        return response()->json([
            'status' => true,
            'data' => $field
        ], 200);
    }
}
