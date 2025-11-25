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
    /**
     * Check if user has admin role
     */
    protected function authorizeAdmin()
    {
        $user = Auth::user();
        if ($user->role !== 'admin') {
            abort(403, 'Unauthorized');
        }
    }

    /**
     * Display a listing of all tickets for the library
     */
    public function index(Request $request)
    {
        $this->authorizeAdmin();
        $user = Auth::user();

        $query = Ticket::where('library_uid', $user->library_uid);

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
            'total' => Ticket::where('library_uid', $user->library_uid)->count(),
            'new' => Ticket::where('library_uid', $user->library_uid)->where('status', 'new')->count(),
            'in_progress' => Ticket::where('library_uid', $user->library_uid)->where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('library_uid', $user->library_uid)->where('status', 'resolved')->count(),
        ];

        return view('admin.index', compact('tickets', 'stats'));
    }
    
    /**
     * Display the specified ticket
     */
    public function show(Ticket $ticket)
    {
        $this->authorizeAdmin();
        $user = Auth::user();

        // Check if ticket belongs to user's library
        if ($ticket->library_uid !== $user->library_uid) {
            abort(403, 'Unauthorized');
        }

        $devices = Device::where('library_uid', $user->library_uid)->orderBy('device_name', 'asc')->get();
        $users = User::where('library_uid', $user->library_uid)
            ->whereIn('role', ['staff', 'admin'])
            ->orderBy('name', 'asc')
            ->get();
        $softwares = Software::where('library_uid', $user->library_uid)->orderBy('software', 'asc')->get();

        return view('admin.show', compact('ticket', 'devices', 'users', 'softwares'));
    }
    
    /**
     * Transfer ticket from one assigned tech to another
     */
    public function transfer(Request $request, Ticket $ticket)
    {
        $this->authorizeAdmin();
        $user = Auth::user();

        // Check if ticket belongs to user's library
        if ($ticket->library_uid !== $user->library_uid) {
            abort(403, 'Unauthorized');
        }

        $request->validate([
            'assigned_to' => 'required|exists:users,id',
        ]);

        // Get the assigned user to verify they belong to this library
        $assignedUser = User::findOrFail($request->assigned_to);
        if ($assignedUser->library_uid !== $user->library_uid) {
            abort(403, 'Unauthorized');
        }

        $ticket->update([
            'assigned_to' => $request->assigned_to,
        ]);

        return redirect()->route('admin.index')->with('success', 'Ticket transferred successfully.');
    }
    
    /**
     * Update status of ticket
     */
    public function updateStatus(Request $request, Ticket $ticket)
    {
        $this->authorizeAdmin();
        $user = Auth::user();

        // Check if ticket belongs to user's library
        if ($ticket->library_uid !== $user->library_uid) {
            abort(403, 'Unauthorized');
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
    
    
    /**
     * Add a comment to the ticket
     */
    public function addComment(Request $request, Ticket $ticket)
    {
        $this->authorizeAdmin();
        $user = Auth::user();

        // Check if ticket belongs to user's library
        if ($ticket->library_uid !== $user->library_uid) {
            abort(403, 'Unauthorized');
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
    
    /**
     * Update ticket details
     */
    public function update(Request $request, Ticket $ticket)
    {
        $this->authorizeAdmin();
        $user = Auth::user();

        // Check if ticket belongs to user's library
        if ($ticket->library_uid !== $user->library_uid) {
            abort(403, 'Unauthorized');
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



