<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Banner;
use Illuminate\Http\Request;
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
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,non-active',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $banner = new Banner();
        $banner->name = $request->name;
        $banner->description = $request->description;
        $banner->status = $request->status;

        if ($request->hasFile('image')) {
            $path = $request->file('image')->store('banners', 'public'); // simpan di storage/app/public/banners
            $banner->image = $path;
        }

        $banner->save();

        return redirect()->back()->with('success', 'Banner berhasil ditambahkan!');
    }

    // Update banner
    public function update(Request $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'status' => 'required|in:active,non-active',
            'image' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $banner->name = $request->name;
        $banner->description = $request->description;
        $banner->status = $request->status;

        if ($request->hasFile('image')) {
            // hapus gambar lama
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }
            $path = $request->file('image')->store('banners', 'public');
            $banner->image = $path;
        }

        $banner->save();

        return redirect()->back()->with('success', 'Banner berhasil diperbarui!');
    }

    // Hapus banner
    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);

        // hapus file gambar
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->back()->with('success', 'Banner berhasil dihapus!');
    }
}
