<?php

namespace App\Http\Controllers;

use App\Models\Gallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
        $galeries->load('categoryGallery');
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
        $galery->load('categoryGallery');

        return response()->json([
            'success' => true,
            'message' => 'Detail data galery',
            'data' => $galery
        ], 200);
    }

    // public function store(Request $request)
    // {
    //     $request->validate(
    //         [
    //             'name' => 'required|string|max:255',
    //             'description' => 'nullable|string',
    //             'image' => 'nullable|image|max:2048',
    //             'category_gallery_id' => 'required|exists:category_galleries,id',
    //         ],
    //         [
    //             'name.required' => 'Nama galery wajib diisi.',
    //             'name.string' => 'Nama galery harus berupa teks.',
    //             'name.max' => 'Nama galery maksimal 255 karakter.',

    //             'description.string' => 'Deskripsi galery harus berupa teks.',

    //             'image.image' => 'File yang diunggah harus berupa gambar.',
    //             'image.max' => 'Ukuran gambar maksimal 2MB.',

    //             'category_gallery_id.required' => 'Kategori galery wajib diisi.',
    //             'category_gallery_id.exists' => 'Kategori galery tidak ditemukan.',
    //         ]
    //     );

    //     $imagePath = null;
    //     if ($request->hasFile('image')) {
    //         $imagePath = $request->file('image')->store('galleries', 'public');
    //     }

    //     $galery = Gallery::create([
    //         'name' => $request->name,
    //         'description' => $request->description,
    //         'image' => $imagePath,
    //         'category_gallery_id' => $request->category_gallery_id,
    //     ]);

    //     $galery->load('categoryGallery');

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Galery berhasil ditambahkan',
    //         'data' => $galery
    //     ], 201);
    // }

    // public function update(Request $request, $id)
    // {
    //     $galery = Gallery::find($id);

    //     if (!$galery) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Galery tidak ditemukan',
    //         ], 404);
    //     }

    //     $request->validate(
    //         [
    //             'name' => 'sometimes|required|string|max:255',
    //             'description' => 'sometimes|nullable|string',
    //             'image' => 'sometimes|nullable|image|max:2048',
    //             'category_gallery_id' => 'sometimes|required|exists:category_galleries,id',
    //         ],
    //         [
    //             'name.required' => 'Nama galery wajib diisi.',
    //             'name.string' => 'Nama galery harus berupa teks.',
    //             'name.max' => 'Nama galery maksimal 255 karakter.',

    //             'description.string' => 'Deskripsi galery harus berupa teks.',

    //             'image.image' => 'File yang diunggah harus berupa gambar.',
    //             'image.max' => 'Ukuran gambar maksimal 2MB.',

    //             'category_gallery_id.required' => 'Kategori galery wajib diisi.',
    //             'category_gallery_id.exists' => 'Kategori galery tidak ditemukan.',
    //         ]
    //     );

    //     // Ambil data yang boleh diupdate
    //     $data = $request->only(['name', 'description', 'category_gallery_id']);

    //     // Jika ada gambar, proses upload
    //     if ($request->hasFile('image')) {

    //         // Hapus gambar lama jika ada
    //         if ($galery->image && Storage::disk('public')->exists($galery->image)) {
    //             Storage::disk('public')->delete($galery->image);
    //         }

    //         // Upload baru
    //         $imagePath = $request->file('image')->store('galleries', 'public');

    //         // Masukkan ke $data agar ikut diupdate
    //         $data['image'] = $imagePath;
    //     }

    //     // Update gallery sekali saja
    //     $galery->update($data);

    //     // Load relasi category
    //     $galery->load('categoryGallery');

    //     // Format response
    //     $galeryArray = $galery->toArray();
    //     $galeryArray['image_url'] = $galery->image ? url('storage/' . $galery->image) : null;

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Galery berhasil diperbarui',
    //         'data' => $galeryArray
    //     ], 200);
    // }

    // public function destroy($id)
    // {
    //     $galery = Gallery::find($id);

    //     if (!$galery) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Galery tidak ditemukan',
    //         ], 404);
    //     }

    //     if ($galery->image && Storage::disk('public')->exists($galery->image)) {
    //         Storage::disk('public')->delete($galery->image);
    //     }

    //     $galery->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Galery berhasil dihapus',
    //     ], 200);
    // }
}
