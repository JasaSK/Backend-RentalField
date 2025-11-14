<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;

class GalleryController extends Controller
{
    public function index()
    {
        $galeries = Gallery::all();

        if ($galeries->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Data galery kosong',
                'data' => []
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'List data galery',
            'data' => $galeries
        ], 200);
    }

    public function show($id)
    {
        $galery = Gallery::find($id);

        if (!$galery) {
            return response()->json([
                'success' => false,
                'message' => 'Galery tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data galery',
            'data' => $galery
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate(
            [
                'name' => 'required|string|max:255',
                'description' => 'nullable|string',
                'image' => 'nullable|image|max:2048',
            ],
            [
                'name.required' => 'Nama galery wajib diisi.',
                'name.string' => 'Nama galery harus berupa teks.',
                'name.max' => 'Nama galery maksimal 255 karakter.',

                'description.string' => 'Deskripsi galery harus berupa teks.',

                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.max' => 'Ukuran gambar maksimal 2MB.',
            ]
        );

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('galleries', 'public');
        }

        $galery = Gallery::create([
            'name' => $request->name,
            'description' => $request->description,
            'image' => $imagePath,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Galery berhasil ditambahkan',
            'data' => $galery
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $galery = Gallery::find($id);

        if (!$galery) {
            return response()->json([
                'success' => false,
                'message' => 'Galery tidak ditemukan',
            ], 404);
        }

        $request->validate(
            [
                'name' => 'sometimes|required|string|max:255',
                'description' => 'sometimes|nullable|string',
                'image' => 'sometimes|nullable|image|max:2048',
            ],
            [
                'name.required' => 'Nama galery wajib diisi.',
                'name.string' => 'Nama galery harus berupa teks.',
                'name.max' => 'Nama galery maksimal 255 karakter.',

                'description.string' => 'Deskripsi galery harus berupa teks.',

                'image.image' => 'File yang diunggah harus berupa gambar.',
                'image.max' => 'Ukuran gambar maksimal 2MB.',
            ]
        );

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('galleries', 'public');
            $galery->image = $imagePath;
        }

        if ($request->has('name')) {
            $galery->name = $request->name;
        }

        if ($request->has('description')) {
            $galery->description = $request->description;
        }

        $galery->save();

        return response()->json([
            'success' => true,
            'message' => 'Galery berhasil diperbarui',
            'data' => $galery
        ], 200);
    }

    public function destroy($id)
    {
        $galery = Gallery::find($id);

        if (!$galery) {
            return response()->json([
                'success' => false,
                'message' => 'Galery tidak ditemukan',
            ], 404);
        }

        $galery->delete();

        return response()->json([
            'success' => true,
            'message' => 'Galery berhasil dihapus',
        ], 200);
    }
}
