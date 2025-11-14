<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::all();

        if ($banners->isEmpty()) {
            return response()->json(['message' => 'Banner tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'List data banner',
            'data' => $banners
        ], 200);
    }

    public function show($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['message' => 'Banner tidak ditemukan'], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Detail data banner',
            'data' => $banner
        ], 200);
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'image' => 'required|string',
        ], [
            'title.required' => 'Judul banner wajib diisi.',
            'title.string' => 'Judul banner harus berupa teks.',
            'title.max' => 'Judul banner maksimal 255 karakter.',

            'description.required' => 'Deskripsi banner wajib diisi.',
            'description.string' => 'Deskripsi banner harus berupa teks.',

            'image.required' => 'Gambar banner wajib diisi.',
            'image.string' => 'Gambar banner harus berupa teks.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        $banner = Banner::create([
            'title' => $request->title,
            'description' => $request->description,
            'image' => $request->image,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil ditambahkan',
            'data' => $banner
        ], 201);
    }

    public function update(Request $request, $id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['message' => 'Banner tidak ditemukan'], 404);
        }

        $request->validate([
            'title' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'image' => 'sometimes|required|string',
        ], [
            'title.required' => 'Judul banner wajib diisi.',
            'title.string' => 'Judul banner harus berupa teks.',
            'title.max' => 'Judul banner maksimal 255 karakter.',

            'description.required' => 'Deskripsi banner wajib diisi.',
            'description.string' => 'Deskripsi banner harus berupa teks.',

            'image.required' => 'Gambar banner wajib diisi.',
            'image.string' => 'Gambar banner harus berupa teks.',
        ]);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
            $request->merge(['image' => $imagePath]);
        }

        $banner->update($request->only(['title', 'description', 'image']));


        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil diperbarui',
            'data' => $banner
        ], 200);
    }
    public function destroy($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['message' => 'Banner tidak ditemukan'], 404);
        }

        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil dihapus'
        ], 200);
    }
}
