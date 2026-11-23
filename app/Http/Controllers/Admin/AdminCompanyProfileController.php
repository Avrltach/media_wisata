<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CompanyProfile;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminCompanyProfileController extends Controller
{

    public function edit(): View
    {
        $profile = CompanyProfile::getInstance();

        return view('admin.company-profile.edit', compact('profile'));
    }


    public function update(Request $request): RedirectResponse
    {
        $profile = CompanyProfile::getInstance();

        $validated = $request->validate([
            'name'            => ['required', 'string', 'max:100'],
            'description'     => ['nullable', 'string'],
            'address'         => ['nullable', 'string'],
            'phone'           => ['nullable', 'string', 'max:20'],
            'email'           => ['nullable', 'email', 'max:100'],
            'whatsapp'        => ['nullable', 'string', 'max:20'],
            'instagram'       => ['nullable', 'url', 'max:255'],
            'facebook'        => ['nullable', 'url', 'max:255'],
            'tiktok'          => ['nullable', 'url', 'max:255'],
            'maps_embed'      => ['nullable', 'string'],
            'logo_path'       => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'operating_hours' => ['nullable', 'string', 'max:100'],
            'founded_year'    => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
        ]);

        if ($request->hasFile('logo_path')) {
            if ($profile->logo_path && Storage::disk('public')->exists($profile->logo_path)) {
                Storage::disk('public')->delete($profile->logo_path);
            }
            $validated['logo_path'] = $request->file('logo_path')->store('company', 'public');
        } else {
            unset($validated['logo_path']);
        }

        $profile->update($validated);

        return redirect()
            ->route('admin.company-profile.edit')
            ->with('success', 'Profil perusahaan berhasil diperbarui.');
    }
}