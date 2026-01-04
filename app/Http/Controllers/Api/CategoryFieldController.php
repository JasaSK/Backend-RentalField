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
                'status' => false,
                'message' => 'Tidak ada data kategori lapangan',
            ], 404);
        }
        return response()->json([
            'status' => true,
            'message' => 'List data kategori lapangan',
            'data' => $categories
        ], 200);
    }

    public function show($id)
    {
        $category = CategoryField::find($id);

        if (!$category) {
            return response()->json([
                'status' => false,
                'message' => 'Kategori lapangan tidak ditemukan',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail data kategori lapangan',
            'data' => $category
        ], 200);
    }
}
