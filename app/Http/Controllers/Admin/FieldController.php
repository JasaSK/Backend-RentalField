<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Field;
use App\Models\CategoryField;
use Illuminate\Support\Facades\Storage;

class FieldController extends Controller
{
    // Tampilkan semua field
    public function index()
    {
        $fields = Field::with('categoryField')->orderBy('created_at', 'desc')->get();
        $categories = CategoryField::all();

        return view('admin.field', compact('fields', 'categories'));
    }

    // Simpan field baru
    public function store(Request $request)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'category_field_id' => 'required|integer',
            'open_time'         => 'required',
            'close_time'        => 'required',
            'description'       => 'required|string',
            'status'            => 'required|string|max:255',
            'price_per_hour'    => 'required|numeric',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only([
            'name',
            'category_field_id',
            'description',
            'price_per_hour',
            'open_time',
            'close_time',
            'status'
        ]);

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('fields', 'public');
            $data['image'] = $path;
        }

        Field::create($data);

        return redirect()->route('admin.fields')->with('success', 'Field berhasil ditambahkan.');
    }

    // Update field
    public function update(Request $request, $id)
    {
        $request->validate([
            'name'              => 'required|string|max:255',
            'category_field_id' => 'required|integer',
            'open_time'         => 'required',
            'close_time'        => 'required',
            'description'       => 'required|string',
            'status'            => 'required|string|max:255',
            'price_per_hour'    => 'required|numeric',
            'image'             => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $field = Field::findOrFail($id);

        $data = $request->only([
            'name',
            'category_field_id',
            'description',
            'price_per_hour',
            'open_time',
            'close_time',
            'status'
        ]);

        if ($request->hasFile('image')) {
            // Hapus gambar lama jika ada
            if ($field->image && Storage::disk('public')->exists($field->image)) {
                Storage::disk('public')->delete($field->image);
            }
            $data['image'] = $request->file('image')->store('fields', 'public');
        }

        $field->update($data);

        return redirect()->route('admin.fields')->with('success', 'Field berhasil diperbarui.');
    }

    // Hapus field
    public function destroy($id)
    {
        $field = Field::findOrFail($id);

        if ($field->image && Storage::disk('public')->exists($field->image)) {
            Storage::disk('public')->delete($field->image);
        }

        $field->delete();

        return redirect()->route('admin.fields')->with('success', 'Field berhasil dihapus.');
    }
}
