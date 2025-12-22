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
    public function update(BannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $request->validated();

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
