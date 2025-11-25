<?php

namespace App\Http\Controllers;

use App\Helpers\TenantHelper;
use App\Models\Ticket;
use Illuminate\Http\Request;

class PublicLibraryTicketController extends Controller
{
    /**
     * Show the public ticket creation form for a library subdomain
     */
    public function create()
    {
        $library = TenantHelper::current();

        if (!$library || !$library->is_approved) {
            abort(404, 'Library not found or not approved');
        }

        return view('library.public.create-ticket', compact('library'));
    }

    /**
     * Store a ticket submitted from the public form
     */
    public function store(Request $request)
    {
        $library = TenantHelper::current();

        if (!$library || !$library->is_approved) {
            abort(404, 'Library not found or not approved');
        }

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'subject' => ['required', 'string', 'max:500'],
            'description' => ['required', 'string', 'max:5000'],
        ]);

        Ticket::create([
            'library_uid' => $library->uid,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'subject' => $validated['subject'],
            'body' => $validated['description'],
            'status' => 'new',
            'received_time' => now(),
        ]);

        return back()->with('success', 'Thank you! Your ticket has been submitted. We will get back to you shortly.');
    }
}
