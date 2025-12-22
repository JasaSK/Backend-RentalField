<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    // Tampilkan semua banner
    public function index()
    {
        $banners = Banner::orderBy('created_at', 'desc')->get();
        $options = ['active', 'non-active'];

        return view('admin.banner', compact('banners', 'options'));
    }

    // Tambah banner baru
    public function store(BannerRequest $request)
    {
        $request->validated();

        $imagePath = null;
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        Banner::create([
            'name' => $request->name,
            'description' => $request->description,
            'status' => $request->status,
            'image' => $imagePath
        ]);

        return redirect()->back()->with('success', 'Banner berhasil ditambahkan!');
    }

    // Update banner
    public function update(BannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);
        if (!$banner) {
            return redirect()->back()->with('error', 'Banner tidak ditemukan!');
        }
        $request->validated();
        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $imagePath = $request->file('image')->store('banners', 'public');
        }

        $banner->name = $request->name;
        $banner->description = $request->description;
        $banner->status = $request->status;
        $banner->image = $imagePath;
        $banner->save();

        return redirect()->back()->with('success', 'Banner berhasil diperbarui!');
    }

    // Hapus banner
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if (!$banner) {
            return redirect()->back()->with('error', 'Banner tidak ditemukan!');
        }
        // hapus file gambar
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->back()->with('success', 'Banner berhasil dihapus!');
    }
}
