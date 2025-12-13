<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryField;
use Illuminate\Http\Request;

class CategoryFieldController extends Controller
{
    public function index()
    {
        $categories = CategoryField::all();

        if (count($categories) === 0) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak ada data kategori lapangan',
                'data' => []
            ], 404);
        }
        return response()->json([
            'success' => true,
            'message' => 'List data kategori lapangan',
            'data' => $categories
        ], 200);
    }

    public function show($id)
    {
        $category = CategoryField::find($id);

        if (!$category) {
            return response()->json([
                'success' => false,
                'message' => 'Kategori lapangan tidak ditemukan',
                'data' => null
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data kategori lapangan',
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
    //             'name.required' => 'Nama kategori lapangan wajib diisi.',
    //             'name.string' => 'Nama kategori lapangan harus berupa teks.',
    //             'name.max' => 'Nama kategori lapangan maksimal 100 karakter.',
    //         ]
    //     );

    //     $category = CategoryField::create([
    //         'name' => $request->name,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Kategori lapangan berhasil ditambahkan',
    //         'data' => $category
    //     ], 201);
    // }

    // public function update(Request $request, $id)
    // {
    //     $category = CategoryField::find($id);

    //     if (!$category) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Kategori lapangan tidak ditemukan',
    //             'data' => null
    //         ], 404);
    //     }

    //     $request->validate(
    //         [
    //             'name' => 'required|string|max:100',
    //         ],
    //         [
    //             'name.required' => 'Nama kategori lapangan wajib diisi.',
    //             'name.string' => 'Nama kategori lapangan harus berupa teks.',
    //             'name.max' => 'Nama kategori lapangan maksimal 100 karakter.',
    //         ]
    //     );

    //     $category->update([
    //         'name' => $request->name,
    //     ]);

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Kategori lapangan berhasil diperbarui',
    //         'data' => $category
    //     ], 200);
    // }

    // public function destroy($id)
    // {
    //     $category = CategoryField::find($id);

    //     if (!$category) {
    //         return response()->json([
    //             'success' => false,
    //             'message' => 'Kategori lapangan tidak ditemukan',
    //             'data' => null
    //         ], 404);
    //     }

    //     $category->delete();

    //     return response()->json([
    //         'success' => true,
    //         'message' => 'Kategori lapangan berhasil dihapus',
    //         'data' => null
    //     ], 200);
    // }   
}
