<?php

namespace App\Http\Controllers;

use App\Models\Field;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class FieldController extends Controller
{

    public function search(Request $request)
    {
        $query = Field::query();

        if ($request->has('name')) {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        if ($request->has('status')) {
            $query->where('status', $request->status);
        }

        $fields = $query->get();
        $fields->load('categoryField');

        return response()->json([
            'success' => true,
            'message' => 'Hasil pencarian lapangan',
            'data' => $fields
        ], 200);
    }

    public function index()
    {
        $fields = Field::all();

        if ($fields->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data lapangan kosong',
                'data' => []
            ], 404);
        }
        $fields->load('categoryField');
        return response()->json([
            'success' => true,
            'message' => 'List data lapangan',
            'data' => $fields
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:100',
                'category_field_id' => 'required|exists:category_fields,id',
                'description' => 'required|string',
                'price_per_hour' => 'required|integer',
                'open_time' => 'required|date_format:H:i',
                'close_time' => 'required|date_format:H:i|after:open_time',
                'status' => 'required|in:available,closed,maintenance,booked,pending',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',

            ],
            [
                'name.required' => 'Nama lapangan wajib diisi.',
                'name.string' => 'Nama lapangan harus berupa teks.',
                'name.max' => 'Nama lapangan maksimal 100 karakter.',

                'category_field_id.required' => 'Kategori lapangan wajib diisi.',
                'category_field_id.exists' => 'Kategori lapangan tidak ditemukan.',

                'description.required' => 'Deskripsi lapangan wajib diisi.',
                'description.string' => 'Deskripsi harus berupa teks.',

                'price_per_hour.required' => 'Harga per jam wajib diisi.',
                'price_per_hour.integer' => 'Harga per jam harus berupa angka.',

                'open_time.required' => 'Jam buka wajib diisi.',
                'open_time.date_format' => 'Format waktu buka tidak valid (HH:MM).',
                'close_time.required' => 'Jam tutup wajib diisi.',
                'close_time.after' => 'Jam tutup harus setelah jam buka.',
                'close_time.date_format' => 'Format waktu tutup tidak valid (HH:MM).',

                'status.required' => 'Status lapangan wajib diisi.',
                'status.in' => 'Status harus bernilai "available", "closed", "maintenance", "booked", atau "pending".',

                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.mimes' => 'Gambar harus berformat JPG, JPEG, atau PNG.',
                'image.max' => 'Ukuran gambar maksimal 2MB.',
            ]
        );

        // Upload image jika ada
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('fields', 'public');
        }

        $field = Field::create([
            'name' => $request->name,
            'category_field_id' => $request->category_field_id,
            'description' => $request->description,
            'price_per_hour' => $request->price_per_hour,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'status' => $request->status,
            'image' => $imagePath,
        ]);

        $field->load('categoryField');

        return response()->json([
            'success' => true,
            'message' => 'Lapangan berhasil ditambahkan',
            'data' => $field
        ], 201);
    }
    public function show($id)
    {
        $field = Field::find($id);

        if (!$field) {
            return response()->json([
                'success' => false,
                'message' => 'Lapangan tidak ditemukan'
            ], 404);
        }

        $field->load('categoryField');

        return response()->json([
            'success' => true,
            'data' => $field
        ], 200);
    }

    public function update(Request $request, $id)
    {
        $field = Field::find($id);

        if (!$field) {
            return response()->json([
                'success' => false,
                'message' => 'Lapangan tidak ditemukan'
            ], 404);
        }

        $request->validate(
            [
                'name' => 'required|string|max:100',
                'category_field_id' => 'required|exists:category_fields,id',
                'price_per_hour' => 'required|integer',
                'duration' => 'required|integer',
                'open_time' => 'required|date_format:H:i',
                'close_time' => 'required|date_format:H:i|after:open_time',
                'status' => 'required|in:avalilable,closed,maintenance,booked,pending',
                'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            ],
            [
                'name.required' => 'Nama lapangan wajib diisi.',
                'name.string' => 'Nama lapangan harus berupa teks.',
                'name.max' => 'Nama lapangan maksimal 100 karakter.',

                'category_field_id.required' => 'Kategori lapangan wajib diisi.',
                'category_field_id.exists' => 'Kategori lapangan tidak ditemukan.',

                'description.required' => 'Deskripsi lapangan wajib diisi.',
                'description.string' => 'Deskripsi harus berupa teks.',

                'price_per_hour.required' => 'Harga per jam wajib diisi.',
                'price_per_hour.integer' => 'Harga per jam harus berupa angka.',

                'open_time.required' => 'Jam buka wajib diisi.',
                'open_time.date_format' => 'Format waktu buka tidak valid (HH:MM).',
                'close_time.required' => 'Jam tutup wajib diisi.',
                'close_time.after' => 'Jam tutup harus setelah jam buka.',
                'close_time.date_format' => 'Format waktu tutup tidak valid (HH:MM).',

                'status.required' => 'Status lapangan wajib diisi.',
                'status.in' => 'Status harus bernilai "available", "closed", "maintenance", "booked", atau "pending".',

                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.mimes' => 'Gambar harus berformat JPG, JPEG, atau PNG.',
                'image.max' => 'Ukuran gambar maksimal 2MB.',
            ]
        );

        // Update image jika ada
        if ($request->hasFile('image')) {
            if ($field->image && Storage::disk('public')->exists($field->image)) {
                Storage::disk('public')->delete($field->image);
            }
            $field->image = $request->file('image')->store('fields', 'public');
        }

        $field->update($request->only([
            'name',
            'category_field_id',
            'description',
            'price_per_hour',
            'open_time',
            'close_time',
            'status'
        ]));
        $field->load('categoryField');

        return response()->json([
            'success' => true,
            'message' => 'Lapangan berhasil diperbarui',
            'data' => $field
        ], 200);
    }

    public function destroy($id)
    {
        $field = Field::find($id);

        if (!$field) {
            return response()->json([
                'success' => false,
                'message' => 'Lapangan tidak ditemukan'
            ], 404);
        }

        if ($field->image && Storage::disk('public')->exists($field->image)) {
            Storage::disk('public')->delete($field->image);
        }

        $field->delete();

        $field->load('categoryField');

        return response()->json([
            'success' => true,
            'message' => 'Lapangan berhasil dihapus'
        ], 200);
    }
}
