<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;
use App\Models\Device;
use App\Models\User;
use App\Models\Software;
use Illuminate\Support\Facades\Auth;
use App\Mail\TicketResolved;
use App\Mail\TicketInProgress;
use App\Services\MicrosoftGraphService;
use Mail;

class CreateTicketController extends Controller
{
            // create new ticket
public function create(MicrosoftGraphService $graph)
{
    $devices = Device::orderBy('device_name', 'asc')->get();
    $users   = User::orderBy('usertype', 'asc')->get();
    $softwares =Software::orderBy('software', 'asc')->get();
    $departments = $graph->getDepartmentLocations();

    return view('tickets.create', compact('devices', 'users', 'softwares', 'departments'));
}


    public function store(Request $request)
{
    $validated = $request->validate([
        'subject' => 'required|string',
        'body' => 'required|string',
        'from_name' => 'required|string|max:255',
        'from_email' => 'required|email|max:255',
        'office_location' => 'nullable|string|max:255',
        'department' => 'nullable|string|max:255',
        'problem_type' => 'nullable|string|max:255',
        'device_name' => 'nullable|string|max:255',
        'software_name' => 'nullable|string|max:255',
        'network_name' => 'nullable|string|max:255',
        'website_name' => 'nullable|string|max:255',
        'security_name' => 'nullable|string|max:255',
    ]);

    // Set default values
    $validated['status'] = 'new';
    $validated['received_time'] = now();
    
  // Assign to appropriate tech based on office location
    $validated['assigned_to'] = $this->assignTicket($request->office_location);

    Ticket::create($validated);

    return redirect()->route('tickets.index')
        ->with('success', 'Ticket created successfully!');
}

/**
 * Assign ticket based on office location.
 */
private function assignTicket($office_location)
{
    switch (trim($office_location)) {
        case 'Argenta Branch':
        case 'The Hub':
            return 'ETHAN';

        case 'Laman Branch':
        case 'Rover Branch':
            return 'ROBERT';

        default:
            return 'ADAM'; // fallback if no match
    }
}
}
