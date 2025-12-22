<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NameRequest;
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
    public function store(NameRequest $request)
    {
        $request->validated();

        CategoryField::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan.');
    }

    // Update kategori
    public function update(NameRequest $request, $id)
    {
        $request->validated();

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
