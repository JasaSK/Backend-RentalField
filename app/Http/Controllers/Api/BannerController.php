<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();

        if ($banners->isEmpty()) {
            return response()->json([
                'status' => false,
                'message' => 'Banner tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'List data banner',
            'data' => $banners
        ], 200);
    }

    public function show($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json([
                'status' => false,
                'message' => 'Banner tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => true,
            'message' => 'Detail data banner',
            'data' => $banner
        ], 200);
    }
}
