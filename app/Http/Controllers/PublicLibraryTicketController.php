<?php

namespace App\Http\Controllers;

use App\Helpers\TenantHelper;
use App\Models\Ticket;
use App\Models\Category;
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

        // Fetch active categories for this library grouped by type
        $categories = Category::where('library_uid', $library->uid)
            ->where('is_active', true)
            ->get()
            ->groupBy('type');

        return view('library.public.create-ticket', compact('library', 'categories'));
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
            'branch' => ['nullable', 'string', 'max:255'],
            'department' => ['nullable', 'string', 'max:255'],
        ]);

        Ticket::create([
            'library_uid' => $library->uid,
            'from_name' => $validated['name'],
            'from_email' => $validated['email'],
            'subject' => $validated['subject'],
            'body' => $validated['description'],
            'branch' => $validated['branch'] ?? null,
            'department' => $validated['department'] ?? null,
            'status' => 'new',
            'received_time' => now(),
        ]);

        return back()->with('success', 'Thank you! Your ticket has been submitted. We will get back to you shortly.');
    }
}
