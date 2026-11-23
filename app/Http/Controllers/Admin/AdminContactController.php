<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Contact;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AdminContactController extends Controller
{

    public function index(): View
    {
        $contacts = Contact::latest()->paginate(10);

        $stats = [
            'total'  => Contact::count(),
            'unread' => Contact::where('is_read', false)->count(),
            'read'   => Contact::where('is_read', true)->count(),
        ];

        return view('admin.contacts.index', compact('contacts', 'stats'));
    }


    public function show(Contact $contact): View
    {
        if (!$contact->is_read) {
            $contact->markAsRead();
        }

        return view('admin.contacts.show', compact('contact'));
    }


    public function markAsUnread(Contact $contact): RedirectResponse
    {
        $contact->update(['is_read' => false]);

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Pesan ditandai sebagai belum dibaca.');
    }


    public function destroy(Contact $contact): RedirectResponse
    {
        $contact->delete();

        return redirect()
            ->route('admin.contacts.index')
            ->with('success', 'Pesan kontak berhasil dihapus.');
    }
}