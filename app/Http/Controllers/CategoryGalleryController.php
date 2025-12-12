<?php

namespace App\Http\Controllers;

use App\Models\CategoryGallery;
use Illuminate\Http\Request;

class CategoryGalleryController extends Controller
{
    public function index()
    {
        $categories = CategoryGallery::all();
        if (count($categories) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data kategori galery',
                'data' => []
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'List data kategori galery',
            'data' => $categories
        ], 200);
    }

    public function show($id)
    {
        $category = CategoryGallery::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori galery tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data kategori galery',
            'data' => $category
        ], 200);
    }

    // public function store(Request $request)
    // {
    //     $request->validate(
    //         [
    //             'name' => 'required|string|max:100',
    //         ],
    //         [
    //             'name.required' => 'Nama kategori galery wajib diisi.',
    //             'name.string' => 'Nama kategori galery harus berupa teks.',
    //             'name.max' => 'Nama kategori galery maksimal 100 karakter.',
    //         ]
    //     );

    //     $category = CategoryGallery::create([
    //         'name' => $request->name,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Kategori galery berhasil dibuat',
    //         'data' => $category
    //     ], 201);
    // }

    // public function update(Request $request, $id)
    // {
    //     $category = CategoryGallery::find($id);

    //     if (!$category) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Kategori galery tidak ditemukan',
    //             'data' => null
    //         ], 404);
    //     }

    //     $request->validate(
    //         [
    //             'name' => 'required|string|max:100',
    //         ],
    //         [
    //             'name.required' => 'Nama kategori galery wajib diisi.',
    //             'name.string' => 'Nama kategori galery harus berupa teks.',
    //             'name.max' => 'Nama kategori galery maksimal 100 karakter.',
    //         ]
    //     );

    //     $category->update([
    //         'name' => $request->name,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Kategori galery berhasil diperbarui',
    //         'data' => $category
    //     ], 200);
    // }

    // public function destroy($id)
    // {
    //     $category = CategoryGallery::find($id);

    //     if (!$category) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Kategori galery tidak ditemukan',
    //         ], 404);
    //     }

    //     $category->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Kategori galery berhasil dihapus',
    //     ], 200);
    // }
}
