<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminGalleryController extends Controller
{
    public function index(): View
    {
        $galleries = Gallery::latest()->paginate(12);

        return view('admin.gallery.index', compact('galleries'));
    }

    public function create(): View
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:200'],
            'description'  => ['nullable', 'string'],
            'image_path'   => ['required', 'image', 'mimes:jpeg,png,jpg', 'max:5120'], // max 5MB
            'category'     => ['nullable', 'string', 'max:50'],
            'is_published' => ['boolean'],
        ]);

        $validated['image_path'] = $request->file('image_path')->store('gallery', 'public');
        $validated['is_published'] = $request->boolean('is_published', true);

        Gallery::create($validated);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Foto galeri berhasil ditambahkan.');
    }

    public function edit(Gallery $gallery): View
    {
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery): RedirectResponse
    {
        $validated = $request->validate([
            'title'        => ['required', 'string', 'max:200'],
            'description'  => ['nullable', 'string'],
            'image_path'   => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'category'     => ['nullable', 'string', 'max:50'],
            'is_published' => ['boolean'],
        ]);

        if ($request->hasFile('image_path')) {
            if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
                Storage::disk('public')->delete($gallery->image_path);
            }
            $validated['image_path'] = $request->file('image_path')->store('gallery', 'public');
        } else {
            unset($validated['image_path']);
        }

        $validated['is_published'] = $request->boolean('is_published', false);

        $gallery->update($validated);

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Foto galeri berhasil diperbarui.');
    }

    public function destroy(Gallery $gallery): RedirectResponse
    {
        if ($gallery->image_path && Storage::disk('public')->exists($gallery->image_path)) {
            Storage::disk('public')->delete($gallery->image_path);
        }

        $gallery->delete();

        return redirect()
            ->route('admin.gallery.index')
            ->with('success', 'Foto galeri berhasil dihapus.');
    }
}