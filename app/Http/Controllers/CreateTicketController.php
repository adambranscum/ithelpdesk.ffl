<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Device;
use App\Models\User;
use App\Models\Software;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use App\Mail\TicketResolved;
use App\Mail\TicketInProgress;
use Mail;

class CreateTicketController extends Controller
{
    // Create new ticket
    public function create()
    {
        $user = Auth::user();

        $devices = Device::where('library_uid', $user->library_uid)->orderBy('device_name', 'asc')->get();
        $users = User::where('library_uid', $user->library_uid)->orderBy('name', 'asc')->get();
        $softwares = Software::where('library_uid', $user->library_uid)->orderBy('software', 'asc')->get();

        // Fetch active categories for this library grouped by type
        $categories = Category::where('library_uid', $user->library_uid)
            ->where('is_active', true)
            ->get()
            ->groupBy('type');

        return view('tickets.create', compact('devices', 'users', 'softwares', 'categories'));
    }


    public function store(Request $request)
    {
        $user = Auth::user();

        $validated = $request->validate([
            'subject' => 'required|string',
            'body' => 'required|string',
            'from_name' => 'required|string|max:255',
            'from_email' => 'required|email|max:255',
            'branch' => 'nullable|string|max:255',
            'department' => 'nullable|string|max:255',
            'problem_type' => 'nullable|string|max:255',
            'device_name' => 'nullable|string|max:255',
            'software_name' => 'nullable|string|max:255',
            'network_name' => 'nullable|string|max:255',
            'website_name' => 'nullable|string|max:255',
            'security_name' => 'nullable|string|max:255',
        ]);

        // Set default values
        $validated['library_uid'] = $user->library_uid;
        $validated['status'] = 'new';
        $validated['received_time'] = now();

        Ticket::create($validated);

        return redirect()->route('tickets.index')
            ->with('success', 'Ticket created successfully!');
    }
}
