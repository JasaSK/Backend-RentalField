<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\CategoryField;

class FieldCategoryController extends Controller
{
    // Tampilkan daftar kategori
    public function index()
    {
        // Ambil semua kategori dari database
        $categories = CategoryField::all();

        return view('admin.field-category', compact('categories'));
    }

    // Simpan kategori baru
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
        ]);

        CategoryField::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Update kategori
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:255',
        ], [
            'name.required' => 'Nama kategori wajib diisi.',
        ]);

        $category = CategoryField::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diupdate.');
    }

    // Hapus kategori
    public function destroy($id)
    {
        $category = CategoryField::findOrFail($id);
        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus.');
    }
}
