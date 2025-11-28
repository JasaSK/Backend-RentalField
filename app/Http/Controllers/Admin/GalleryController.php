<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\CategoryGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    // Tampilkan semua gallery
    public function index()
    {
        $galleries = Gallery::with('categoryGallery')->orderBy('created_at', 'desc')->get();
        $categories = CategoryGallery::all();

        return view('admin.gallery', compact('galleries', 'categories'));
    }

    // Tambah gallery baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_gallery_id' => 'required|exists:category_galleries,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gallery = new Gallery();
        $gallery->name = $request->name;
        $gallery->description = $request->description;
        $gallery->category_gallery_id = $request->category_gallery_id;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('galleries', 'public');
            $gallery->image = $path;
        }

        $gallery->save();

        return redirect()->back()->with('success', 'Gallery berhasil ditambahkan!');
    }

    // Update gallery
    public function update(Request $request, $id)
    {
        $gallery = Gallery::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'category_gallery_id' => 'required|exists:category_galleries,id',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $gallery->name = $request->name;
        $gallery->description = $request->description;
        $gallery->category_gallery_id = $request->category_gallery_id;

        if ($request->hasFile('image')) {
            // hapus gambar lama jika ada
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
            $path = $request->file('image')->store('galleries', 'public');
            $gallery->image = $path;
        }

        $gallery->save();

        return redirect()->back()->with('success', 'Gallery berhasil diperbarui!');
    }

    // Hapus gallery
    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);

        // hapus file gambar
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()->back()->with('success', 'Gallery berhasil dihapus!');
    }
}
