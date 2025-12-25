<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Field\FieldRequest;
use Illuminate\Http\Request;
use App\Models\Field;
use App\Models\CategoryField;
use Illuminate\Support\Facades\Storage;

class FieldController extends Controller
{
    // Tampilkan semua field
    public function index()
    {
        $fields = Field::with('categoryField')->orderBy('created_at', 'asc')->get();
        $categories = CategoryField::all();

        return view('admin.field', compact('fields', 'categories'));
    }

    // Simpan field baru
    public function store(FieldRequest $request)
    {
        $request->validated();
        // dd($request->all());
        if ($request->open_time > $request->close_time) {
            return redirect()->back()->with('error', 'Waktu buka tidak boleh lebih besar dari waktu tutup.');
        }

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('fields', 'public');
        }


        Field::create([
            'name' => $request->name,
            'category_field_id' => $request->category_field_id,
            'description' => $request->description,
            'price_per_hour' => $request->price_per_hour,
            'open_time' => $request->open_time,
            'close_time' => $request->close_time,
            'status' => $request->status,
            'image' => $imagePath
        ]);

        return redirect()->route('admin.fields')->with('success', 'Field berhasil ditambahkan.');
    }

    public function update(FieldRequest $request, $id)
    {
        $validated = $request->validated();

        $field = Field::findOrFail($id);

        if ($request->hasFile('image')) {
            if ($field->image && Storage::disk('public')->exists($field->image)) {
                Storage::disk('public')->delete($field->image);
            }

            $validated['image'] = $request->file('image')->store('fields', 'public');
        }

        $field->update([
            'name' => $validated['name'],
            'category_field_id' => $validated['category_field_id'],
            'description' => $validated['description'],
            'price_per_hour' => $validated['price_per_hour'],
            'open_time' => $validated['open_time'],
            'close_time' => $validated['close_time'],
            'status' => $validated['status'],
            'image' => $validated['image'] ?? $field->image,
        ]);

        return redirect()
            ->route('admin.fields')
            ->with('success', 'Field berhasil diperbarui.');
    }


    // Hapus field
    public function destroy($id)
    {
        $field = Field::findOrFail($id);
        if (!$field) {
            return redirect()->back()->with('error', 'Field tidak ditemukan!');
        }
        if ($field->image && Storage::disk('public')->exists($field->image)) {
            Storage::disk('public')->delete($field->image);
        }

        $field->delete();

        return redirect()->route('admin.fields')->with('success', 'Field berhasil dihapus.');
    }
}
