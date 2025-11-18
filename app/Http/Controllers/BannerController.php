<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

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
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,non-active',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ], [
            'name.required' => 'Judul banner wajib diisi.',
            'name.string' => 'Judul banner harus berupa teks.',
            'name.max' => 'Judul banner maksimal 255 karakter.',

            'description.required' => 'Deskripsi banner wajib diisi.',
            'description.string' => 'Deskripsi banner harus berupa teks.',

            'status.required' => 'Status banner wajib diisi.',
            'status.in' => 'Status banner harus berupa "active" atau "non-active".',

            'image.image' => 'Gambar banner harus berupa file gambar.',
            'image.mimes' => 'Gambar banner harus berformat jpg, jpeg, atau png.',
            'image.max' => 'Ukuran gambar banner maksimal 2MB.',
        ]);

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        $banner = Banner::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $imagePath,

        ]);
        // $banner->image = $imagePath ? url('storage/' . $imagePath) : null;

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
            'name' => 'sometimes|required|string|max:255',
            'description' => 'sometimes|required|string',
            'status' => 'sometimes|required|in:active,non-active',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->only(['name', 'description', 'status']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
            $data['image'] = $imagePath; // pastikan string path disimpan
        }

        $banner->update($data); // pakai update langsung

        $bannerArray = $banner->toArray();
        if (!empty($banner->image)) {
            $bannerArray['image'] = url('storage/' . $banner->image);
        }

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil diperbarui',
            'data' => $bannerArray
        ], 200);
    }

    public function destroy($id)
    {
        $banner = Banner::find($id);

        if (!$banner) {
            return response()->json(['message' => 'Banner tidak ditemukan'], 404);
        }

        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return response()->json([
            'success' => true,
            'message' => 'Banner berhasil dihapus'
        ], 200);
    }
}
