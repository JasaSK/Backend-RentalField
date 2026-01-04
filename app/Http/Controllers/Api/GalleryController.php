<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
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
                'status' => false,
                'message' => 'Data galery kosong',
            ], 404);
        }
        $galeries->load('categoryGallery');
        return response()->json([
            'status' => true,
            'message' => 'List data galery',
            'data' => $galeries
        ], 200);
    }

    public function show($id)
    {
        $galery = Gallery::find($id);

        if (!$galery) {
            return response()->json([
                'status' => false,
                'message' => 'Galery tidak ditemukan',
            ], 404);
        }
        $galery->load('categoryGallery');

        return response()->json([
            'status' => true,
            'message' => 'Detail data galery',
            'data' => $galery
        ], 200);
    }
}
