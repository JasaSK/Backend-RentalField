<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CategoryGallery;
use Illuminate\Http\Request;

class GalleryCategoryController extends Controller
{
    // Tampilkan semua kategori
    public function index()
    {
        $categories = CategoryGallery::orderBy('created_at', 'desc')->get();
        return view('admin.gallery-category', compact('categories'));
    }

    // Tambah kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
        ]);

        CategoryGallery::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
        ]);

        $category = CategoryGallery::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    // Hapus kategori
    public function destroy($id)
    {
        $category = CategoryGallery::findOrFail($id);

        // opsional: cek jika ada gallery terkait, bisa hapus atau batalkan
        if ($category->galleries()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori ini memiliki gallery terkait, tidak bisa dihapus!');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
