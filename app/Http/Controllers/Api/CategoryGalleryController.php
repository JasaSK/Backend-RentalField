<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\CategoryGallery;
use Illuminate\Http\Request;

class CategoryGalleryController extends Controller
{
    public function index()
    {
        $categories = CategoryGallery::all();
        if (count($categories) === 0) {
            return response()->json([
                'status' => false,
                'message' => 'Tidak ada data kategori galery',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'List data kategori galery',
            'data' => $categories
        ], 200);
    }

    public function show($id)
    {
        $category = CategoryGallery::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori galery tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail data kategori galery',
            'data' => $category
        ], 200);
    }
}
