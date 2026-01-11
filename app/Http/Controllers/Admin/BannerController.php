<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Banner\BannerRequest;
use App\Models\Banner;
use Illuminate\Support\Facades\Storage;

class BannerController extends Controller
{
    public function index()
    {
        $banners = Banner::orderBy('created_at', 'desc')->get();
        $options = ['active', 'non-active'];

        return view('admin.banner', compact('banners', 'options'));
    }

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
    public function update(BannerRequest $request, $id)
    {
        $banner = Banner::findOrFail($id);

        $validated = $request->validated();

        $imagePath = $banner->image;

        if ($request->hasFile('image')) {
            if ($banner->image && Storage::disk('public')->exists($banner->image)) {
                Storage::disk('public')->delete($banner->image);
            }

            $imagePath = $request->file('image')->store('banners', 'public');
        }

        $banner->update([
            'name'        => $validated['name'],
            'description' => $validated['description'],
            'status'      => $validated['status'],
            'image'       => $imagePath,
        ]);

        return redirect()->back()->with('success', 'Banner berhasil diperbarui!');
    }


    public function destroy($id)
    {
        $banner = Banner::findOrFail($id);
        if (!$banner) {
            return redirect()->back()->with('error', 'Banner tidak ditemukan!');
        }
        if ($banner->image && Storage::disk('public')->exists($banner->image)) {
            Storage::disk('public')->delete($banner->image);
        }

        $banner->delete();

        return redirect()->back()->with('success', 'Banner berhasil dihapus!');
    }
}
