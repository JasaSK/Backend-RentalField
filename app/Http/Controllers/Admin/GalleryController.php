<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Gallery\GalleryRequest;
use App\Models\Gallery;
use App\Models\CategoryGallery;
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
    public function store(GalleryRequest $request)
    {
        $request->validated();
        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('galleries', 'public');
        }
        Gallery::create([
            'name' => $request->name,
            'description' => $request->description,
            'category_gallery_id' => $request->category_gallery_id,
            'image' => $imagePath
        ]);
        return redirect()->back()->with('success', 'Gallery berhasil ditambahkan!');
    }

    // Update gallery
    public function update(GalleryRequest $request, $id)
    {
        $gallery = Gallery::findOrFail($id);
        $request->validated();

        if ($request->hasFile('image')) {
            if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
                Storage::disk('public')->delete($gallery->image);
            }
            $imagepath = $request->file('image')->store('galleries', 'public');
        }

        $gallery->name = $request->name;
        $gallery->description = $request->description;
        $gallery->category_gallery_id = $request->category_gallery_id;
        $gallery->image = $imagepath;
        $gallery->save();

        return redirect()->back()->with('success', 'Gallery berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $gallery = Gallery::findOrFail($id);
        if (!$gallery) {
            return redirect()->back()->with('error', 'Gallery tidak ditemukan!');
        }
        if ($gallery->image && Storage::disk('public')->exists($gallery->image)) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()->back()->with('success', 'Gallery berhasil dihapus!');
    }
}
