<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankAccount;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class AdminBankAccountController extends Controller
{
    public function index(): View
    {
        $bankAccounts = BankAccount::orderBy('bank_name')->paginate(10);

        return view('admin.bank-accounts.index', compact('bankAccounts'));
    }

    public function create(): View
    {
        return view('admin.bank-accounts.create');
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'bank_name'      => ['required', 'string', 'max:50'],
            'account_number' => ['required', 'string', 'max:30'],
            'account_holder' => ['required', 'string', 'max:100'],
            'logo_path'      => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'is_active'      => ['boolean'],
        ]);

        // Handle logo upload (optional)
        if ($request->hasFile('logo_path')) {
            $validated['logo_path'] = $request->file('logo_path')->store('bank-logos', 'public');
        }
        unset($validated['logo_path_input']);

        $validated['is_active'] = $request->boolean('is_active');

        BankAccount::create($validated);

        return redirect()
            ->route('admin.bank-accounts.index')
            ->with('success', 'Rekening bank berhasil ditambahkan.');
    }

    public function edit(BankAccount $bankAccount): View
    {
        return view('admin.bank-accounts.edit', compact('bankAccount'));
    }

    public function update(Request $request, BankAccount $bankAccount): RedirectResponse
    {
        $validated = $request->validate([
            'bank_name'      => ['required', 'string', 'max:50'],
            'account_number' => ['required', 'string', 'max:30'],
            'account_holder' => ['required', 'string', 'max:100'],
            'logo_path'      => ['nullable', 'image', 'mimes:jpeg,png,jpg', 'max:2048'],
            'is_active'      => ['boolean'],
        ]);

        if ($request->hasFile('logo_path')) {
            // Hapus logo lama kalau ada
            if ($bankAccount->logo_path && Storage::disk('public')->exists($bankAccount->logo_path)) {
                Storage::disk('public')->delete($bankAccount->logo_path);
            }
            $validated['logo_path'] = $request->file('logo_path')->store('bank-logos', 'public');
        }

        $validated['is_active'] = $request->boolean('is_active');

        $bankAccount->update($validated);

        return redirect()
            ->route('admin.bank-accounts.index')
            ->with('success', 'Rekening bank berhasil diperbarui.');
    }

    public function destroy(BankAccount $bankAccount): RedirectResponse
    {
        // Hapus logo dari storage
        if ($bankAccount->logo_path && Storage::disk('public')->exists($bankAccount->logo_path)) {
            Storage::disk('public')->delete($bankAccount->logo_path);
        }

        $bankAccount->delete();

        return redirect()
            ->route('admin.bank-accounts.index')
            ->with('success', 'Rekening bank berhasil dihapus.');
    }
}