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
class AdminController extends Controller
{
      
     //Display a listing of all tickets
     
    public function index(Request $request)
    {
        $user = Auth::user();
        $isAdmin = $user->admin;
        
        
        $userType = $user->usertype;

        
        if ($isAdmin === 'yes'){

      
        $query = Ticket::query();
        
        
        
        
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
            'total' => Ticket::count(),
            'new' => Ticket::where('status', 'new')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
        ];
        
        return view('admin.index', compact('tickets', 'stats', 'userType'));
    }

    else {

        return view('errors.403');

}

}
    
     //Display the specified ticket
     
    public function show(Ticket $ticket)
    {
        $user = Auth::user();
       $isAdmin = $user->admin;
        $userType = $user->usertype;
        $devices = Device::orderBy('device_name', 'asc')->get();
        $users = User::orderBy('usertype', 'asc')->get();
        $softwares =Software::orderBy('software', 'asc')->get();
        
        

        if ($isAdmin === 'yes') {
            return view('admin.show', compact('ticket', 'devices', 'users', 'softwares'));
        }
        else {
            return view('errors.403');
        }
        
    }
    
    //Transfer ticket from one assigned tech to another
    public function transfer(Request $request, Ticket $ticket)
{
    $user = Auth::user();
    $isAdmin = $user->admin;
    
    if ($isAdmin === 'yes') {
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

       return redirect()->route('admin.index')->with('success', 'Ticket transferred successfully.');
       
    }

    else {
    return view('errors.403');
    }
    
}
    
      // Update status of ticket 
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $user = Auth::user();
        $isAdmin = $user->admin;
        
        if ($isAdmin === 'yes') {
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

        else {
            return view('errors.403');
        }
        
       
    }
    
    
     //Add a comment to the ticket
     
    public function addComment(Request $request, Ticket $ticket)
    {
        $user = Auth::user();
        $isAdmin = $user->admin;
        
        
         if ($isAdmin === 'yes') {        
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

    else {
         return view('errors.403');
    }
    
}
    
     //Update ticket details
     
    public function update(Request $request, Ticket $ticket)
    {
        $user = Auth::user();
        $isAdmin = $user->admin;
        
       
        if ($isAdmin === 'yes') {
            $request->validate([
            'problem_type' => 'nullable|string|max:255',
            'device_name' => 'nullable|string|max:255',
            'software_name' => 'nullable|string|max:255',
            'network_name' => 'nullable|string|max:255',
            'website_name' => 'nullable|string|max:255',
        ]);
        
        $ticket->update($request->only([
            'problem_type',
            'device_name',
            'software_name',
            'network_name',
            'website_name',
        ]));
        
        return redirect()->back()->with('success', 'Ticket details updated successfully!');

        }

        else {
            return view('errors.403');
        }
        
     
    }
}



