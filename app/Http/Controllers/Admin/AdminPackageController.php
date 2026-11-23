<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Package;
use App\Models\PackageImage;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class AdminPackageController extends Controller
{

    public function index(Request $request): View
    {
        $query = Package::query();

        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        if ($request->filled('status')) {
            $query->where('is_active', $request->boolean('status'));
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('location', 'like', "%{$search}%");
            });
        }

        $packages = $query->latest()->paginate(10)->withQueryString();

        return view('admin.packages.index', compact('packages'));
    }


    public function create(): View
    {
        return view('admin.packages.create');
    }


    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name'                 => ['required', 'string', 'max:200'],
            'category'             => ['required', 'in:paket_wisata,event_organizer,sewa_transport'],
            'description'          => ['nullable', 'string'],
            'price'                => ['required', 'numeric', 'min:0'],
            'duration'             => ['required', 'string', 'max:50'],
            'location'             => ['required', 'string', 'max:200'],
            'included_facilities'  => ['nullable', 'string'],
            'excluded_facilities'  => ['nullable', 'string'],
            'itinerary'            => ['nullable', 'string'],
            'main_image'           => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'gallery_images'       => ['nullable', 'array'],
            'gallery_images.*'     => ['image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'is_featured'          => ['boolean'],
            'is_active'            => ['boolean'],
            'sort_order'           => ['nullable', 'integer', 'min:0'],
        ]);

        $validated['slug'] = Str::slug($validated['name']) . '-' . Str::lower(Str::random(6));

        if ($request->hasFile('main_image')) {
            $validated['main_image'] = $request->file('main_image')->store('packages/main', 'public');
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $galleryImages = $request->file('gallery_images', []);
        $packageData = collect($validated)->except('gallery_images')->toArray();
        $package = Package::create($packageData);

        if (!empty($galleryImages)) {
            $sortOrder = 0;
            foreach ($galleryImages as $image) {
                $path = $image->store('packages/gallery', 'public');
                $package->images()->create([
                    'image_path' => $path,
                    'caption'    => null,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        return redirect()
            ->route('admin.packages.index')
            ->with('success', "Paket '{$package->name}' berhasil ditambahkan.");
    }


    public function show(Package $package): View
    {
        $package->load('images');

        return view('admin.packages.show', compact('package'));
    }


    public function edit(Package $package): View
    {
        $package->load('images');

        return view('admin.packages.edit', compact('package'));
    }


    public function update(Request $request, Package $package): RedirectResponse
    {
        $validated = $request->validate([
            'name'                 => ['required', 'string', 'max:200'],
            'category'             => ['required', 'in:paket_wisata,event_organizer,sewa_transport'],
            'description'          => ['nullable', 'string'],
            'price'                => ['required', 'numeric', 'min:0'],
            'duration'             => ['required', 'string', 'max:50'],
            'location'             => ['required', 'string', 'max:200'],
            'included_facilities'  => ['nullable', 'string'],
            'excluded_facilities'  => ['nullable', 'string'],
            'itinerary'            => ['nullable', 'string'],
            'main_image'           => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'gallery_images'       => ['nullable', 'array'],
            'gallery_images.*'     => ['image', 'mimes:jpeg,png,jpg', 'max:5120'],
            'is_featured'          => ['boolean'],
            'is_active'            => ['boolean'],
            'sort_order'           => ['nullable', 'integer', 'min:0'],
        ]);

        if ($package->name !== $validated['name']) {
            $validated['slug'] = Str::slug($validated['name']) . '-' . Str::lower(Str::random(6));
        }

        if ($request->hasFile('main_image')) {
            if ($package->main_image && Storage::disk('public')->exists($package->main_image)) {
                Storage::disk('public')->delete($package->main_image);
            }
            $validated['main_image'] = $request->file('main_image')->store('packages/main', 'public');
        }

        $validated['is_featured'] = $request->boolean('is_featured');
        $validated['is_active'] = $request->boolean('is_active', true);
        $validated['sort_order'] = $validated['sort_order'] ?? 0;

        $packageData = collect($validated)->except('gallery_images')->toArray();
        $package->update($packageData);

        $galleryImages = $request->file('gallery_images', []);
        if (!empty($galleryImages)) {
            $lastOrder = $package->images()->max('sort_order') ?? -1;
            $sortOrder = $lastOrder + 1;
            foreach ($galleryImages as $image) {
                $path = $image->store('packages/gallery', 'public');
                $package->images()->create([
                    'image_path' => $path,
                    'caption'    => null,
                    'sort_order' => $sortOrder++,
                ]);
            }
        }

        return redirect()
            ->route('admin.packages.index')
            ->with('success', "Paket '{$package->name}' berhasil diperbarui.");
    }


    public function deleteImage(Package $package, PackageImage $image): RedirectResponse
    {
        if ($image->package_id !== $package->id) {
            abort(404);
        }

        if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
            Storage::disk('public')->delete($image->image_path);
        }

        $image->delete();

        return redirect()
            ->back()
            ->with('success', 'Foto galeri berhasil dihapus dari paket.');
    }


    public function destroy(Package $package): RedirectResponse
    {
        if ($package->main_image && Storage::disk('public')->exists($package->main_image)) {
            Storage::disk('public')->delete($package->main_image);
        }

        foreach ($package->images as $image) {
            if ($image->image_path && Storage::disk('public')->exists($image->image_path)) {
                Storage::disk('public')->delete($image->image_path);
            }
        }

        $packageName = $package->name;
        $package->delete(); 

        return redirect()
            ->route('admin.packages.index')
            ->with('success', "Paket '{$packageName}' berhasil dihapus.");
    }
}