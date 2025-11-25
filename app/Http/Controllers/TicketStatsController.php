<?php

namespace App\Http\Controllers;

use App\Models\Ticket;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;
use App\Models\Device;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class TicketStatsController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();

        $startDate = $request->input('start_date', now()->subMonths(11)->startOfMonth());
        $endDate = $request->input('end_date', now()->endOfMonth());


        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        
        
        $ticketsByMonth = Ticket::where('library_uid', $user->library_uid)
            ->select(
                DB::raw('DATE_FORMAT(received_time, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('received_time', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();


        $ticketsByUsertype = Ticket::where('library_uid', $user->library_uid)
            ->join('users', 'tickets.assigned_to', '=', 'users.id')
            ->select('users.name as assigned_to', DB::raw('COUNT(*) as count'))
            ->whereBetween('received_time', [$startDate, $endDate])
            ->whereNotNull('assigned_to')
            ->groupBy('users.id', 'users.name')
            ->orderBy('count', 'desc')
            ->get();


        $ticketsByDevice = Ticket::where('library_uid', $user->library_uid)
            ->select('device_name', DB::raw('COUNT(*) as count'))
            ->whereBetween('received_time', [$startDate, $endDate])
            ->whereNotNull('device_name')
            ->where('problem_type', '=', 'Hardware')
            ->groupBy('device_name')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();


        $ticketsBySoftware = Ticket::where('library_uid', $user->library_uid)
            ->select('software_name', DB::raw('COUNT(*) as count'))
            ->whereBetween('received_time', [$startDate, $endDate])
            ->whereNotNull('software_name')
            ->where('problem_type', '=', 'Software')
            ->groupBy('software_name')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();


        $ticketsByProblemType = Ticket::where('library_uid', $user->library_uid)
            ->select('problem_type', DB::raw('COUNT(*) as count'))
            ->whereBetween('received_time', [$startDate, $endDate])
            ->whereNotNull('problem_type')
            ->where('problem_type', '!=', '')
            ->groupBy('problem_type')
            ->orderBy('count', 'desc')
            ->get();


        $ticketsByStatus = Ticket::where('library_uid', $user->library_uid)
            ->select('status', DB::raw('COUNT(*) as count'))
            ->whereBetween('received_time', [$startDate, $endDate])
            ->groupBy('status')
            ->get();


        $avgResolutionTime = Ticket::where('library_uid', $user->library_uid)
            ->whereNotNull('end_time')
            ->whereBetween('received_time', [$startDate, $endDate])
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, received_time, end_time)) as avg_hours')
            ->value('avg_hours');


        $monthlyByUsertype = Ticket::where('library_uid', $user->library_uid)
            ->join('users', 'tickets.assigned_to', '=', 'users.id')
            ->select(
                DB::raw('DATE_FORMAT(received_time, "%Y-%m") as month'),
                'users.name as assigned_to',
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('received_time', [$startDate, $endDate])
            ->whereNotNull('assigned_to')
            ->groupBy(DB::raw('DATE_FORMAT(received_time, "%Y-%m")'), 'users.id', 'users.name')
            ->orderBy('month', 'asc')
            ->get();

        $totalTickets = Ticket::where('library_uid', $user->library_uid)->whereBetween('received_time', [$startDate, $endDate])->count();
        $resolvedTickets = Ticket::where('library_uid', $user->library_uid)
            ->where('status', 'resolved')
            ->whereBetween('received_time', [$startDate, $endDate])
            ->count();
        $inProgressTickets = Ticket::where('library_uid', $user->library_uid)
            ->where('status', 'in_progress')
            ->whereBetween('received_time', [$startDate, $endDate])
            ->count();
        $newTickets = Ticket::where('library_uid', $user->library_uid)
            ->where('status', 'new')
            ->whereBetween('received_time', [$startDate, $endDate])
            ->count();
        
        return view('tickets.stats', compact(
            'ticketsByMonth',
            'ticketsByUsertype',
            'ticketsByDevice',
            'ticketsBySoftware',
            'ticketsByProblemType',
            'ticketsByStatus',
            'monthlyByUsertype',
            'avgResolutionTime',
            'totalTickets',
            'resolvedTickets',
            'inProgressTickets',
            'newTickets',
            'startDate',
            'endDate'
        ));
    }
}