<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\NameRequest;
use App\Models\CategoryGallery;
use Faker\Guesser\Name;
use Illuminate\Http\Request;

class GalleryCategoryController extends Controller
{
    public function index()
    {
        $categories = CategoryGallery::orderBy('created_at', 'desc')->get();
        return view('admin.gallery-category', compact('categories'));
    }

    public function store(NameRequest $request)
    {
        $request->validated();

        CategoryGallery::create([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil ditambahkan!');
    }

    public function update(NameRequest $request, $id)
    {
        $request->validated();

        $category = CategoryGallery::findOrFail($id);
        $category->update([
            'name' => $request->name,
        ]);

        return redirect()->back()->with('success', 'Kategori berhasil diperbarui!');
    }

    public function destroy($id)
    {
        $category = CategoryGallery::findOrFail($id);

        if ($category->galleries()->count() > 0) {
            return redirect()->back()->with('error', 'Kategori ini memiliki gallery terkait, tidak bisa dihapus!');
        }

        $category->delete();

        return redirect()->back()->with('success', 'Kategori berhasil dihapus!');
    }
}
