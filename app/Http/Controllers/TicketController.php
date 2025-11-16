<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use App\Models\Device;
use App\Models\User;
use App\Models\Software;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Mail\TicketResolved;
use App\Mail\TicketInProgress;
use Mail;

class TicketController extends Controller
{
   //Index for tickets.index
    public function index(Request $request)
{
    $user = Auth::user();        
    
    $userType = $user->usertype;        
    
    $query = Ticket::where('status', '!=', 'resolved');

    $query->where('assigned_to', $userType);
    
    if ($request->filled('status')) {
        $query->where('status', $request->status);
    }
    
    if ($request->filled('search')) {
        $search = $request->search;
        $query->where(function($q) use ($search) {
            $q->where('subject', 'LIKE', "%{$search}%")
              ->orWhere('from_email', 'LIKE', "%{$search}%")
              ->orWhere('from_name', 'LIKE', "%{$search}%");
        });
    }

    $tickets = $query->recent()->paginate(15)->appends($request->except('page'));
   
    $stats = [
        'total' => Ticket::where('assigned_to', $userType)->count(),
        'new' => Ticket::where('assigned_to', $userType)->where('status', 'new')->count(),
        'in_progress' => Ticket::where('assigned_to', $userType)->where('status', 'in_progress')->count(),
        'resolved' => Ticket::where('assigned_to', $userType)->where('status', 'resolved')->count(),
    ];
    
    return view('tickets.index', compact('tickets', 'stats', 'userType'));
}
    
    // show individual ticket
    public function show(Ticket $ticket)
    {
        $user = Auth::user();
        $userType = $user->usertype;
        $devices = Device::orderBy('device_name', 'asc')->get();
        $users = User::orderBy('usertype', 'asc')->get();
        $softwares =Software::orderBy('software', 'asc')->get();
        
        if ($ticket->assigned_to !== $userType) {
            return view('errors.403');

        }
        
        return view('tickets.show', compact('ticket', 'devices', 'users', 'softwares'));
    }
    

    //Transfer ticket from one assigned tech to another
    public function transfer(Request $request, Ticket $ticket)
{
    $user = Auth::user();

    
    if ($ticket->assigned_to !== $user->usertype) {
        return view('errors.403');
    }

    $request->validate([
        'transfer_to' => 'required',
    ]);

    $oldAssignee = $ticket->assigned_to;
    $newAssignee = $request->transfer_to;

    if ($oldAssignee == $newAssignee) {
        return view('errors.403');
    }

    $ticket->update([
        'assigned_to' => $newAssignee,
    ]);

       return redirect()->route('tickets.index')->with('success', 'Ticket transferred successfully.');
}

  
    // Update status of ticket 
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $user = Auth::user();
        $userType = $user->usertype;
        
        if ($ticket->assigned_to !== $userType) {
            return view('errors.403');
        }
        
        $request->validate([
            'status' => 'required|in:new,in_progress,resolved,closed',
        ]);
        
        $oldStatus = $ticket->status;
        $newStatus = $request->status;
        
        $ticket->update([
            'status' => $newStatus,
            'end_time' => $newStatus === 'resolved' || $newStatus === 'closed' ? now() : null,
        ]);
        
        try {
            if ($oldStatus !== 'in_progress' && $newStatus === 'in_progress') {
                \Mail::to($ticket->from_email)->send(new \App\Mail\TicketInProgress($ticket));
            }
            
            if ($oldStatus !== 'resolved' && $newStatus === 'resolved') {
                \Mail::to($ticket->from_email)->send(new \App\Mail\TicketResolved($ticket));
            }
        } catch (\Exception $e) {
            \Log::error('Failed to send ticket status email: ' . $e->getMessage());
        }
        
        return redirect()->back()->with('success', 'Ticket status updated successfully!');
    }
    
    // add comment for ticket
    public function addComment(Request $request, Ticket $ticket)
    {
        $user = Auth::user();
        $userType = $user->usertype;
        
        if ($ticket->assigned_to !== $userType) {
            return view('errors.403');
        }
        
        $request->validate([
            'comment' => 'required|string',
        ]);
        
        $existingComment = $ticket->comment ?? '';
        $newComment = "[" . now()->format('Y-m-d H:i:s') . "] " . $user->name . ": " . $request->comment . "\n\n";
        
        $ticket->update([
            'comment' => $newComment . $existingComment,
        ]);
        
        return redirect()->back()->with('success', 'Comment added successfully!');
    }
    
 
    //update info on ticket
    public function update(Request $request, Ticket $ticket)
    {
        $user = Auth::user();
        $userType = $user->usertype;
        
        // Check if user is assigned to this ticket
        if ($ticket->assigned_to !== $userType) {
            return view('errors.403');
        }
        
        $request->validate([
            'problem_type' => 'nullable|string|max:255',
            'device_name' => 'nullable|string|max:255',
            'software_name' => 'nullable|string|max:255',
            'network_name' => 'nullable|string|max:255',
            'website_name' => 'nullable|string|max:255',
            'security_name' => 'nullable|string|max:255',
        ]);
        
        $ticket->update($request->only([
            'problem_type',
            'device_name',
            'software_name',
            'network_name',
            'website_name',
            'security_name',
        ]));
        
        return redirect()->back()->with('success', 'Ticket details updated successfully!');
    }
    

}