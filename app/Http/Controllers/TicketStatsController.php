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
        
        $startDate = $request->input('start_date', now()->subMonths(11)->startOfMonth());
        $endDate = $request->input('end_date', now()->endOfMonth());
        
        
        $startDate = Carbon::parse($startDate);
        $endDate = Carbon::parse($endDate);
        
        
        $ticketsByMonth = Ticket::select(
                DB::raw('DATE_FORMAT(received_time, "%Y-%m") as month'),
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('received_time', [$startDate, $endDate])
            ->groupBy('month')
            ->orderBy('month', 'asc')
            ->get();
        
        
        $ticketsByUsertype = Ticket::select('assigned_to', DB::raw('COUNT(*) as count'))
            ->whereBetween('received_time', [$startDate, $endDate])
            ->whereNotNull('assigned_to')
            ->groupBy('assigned_to')
            ->orderBy('count', 'desc')
            ->get();
        
        
        $ticketsByDevice = Ticket::select('device_name', DB::raw('COUNT(*) as count'))
            ->whereBetween('received_time', [$startDate, $endDate])
            ->whereNotNull('device_name')
            ->where('problem_type', '=', 'Hardware')
            ->groupBy('device_name')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
        
        
        $ticketsBySoftware = Ticket::select('software_name', DB::raw('COUNT(*) as count'))
            ->whereBetween('received_time', [$startDate, $endDate])
            ->whereNotNull('software_name')
            ->where('problem_type', '=', 'Software')
            ->groupBy('software_name')
            ->orderBy('count', 'desc')
            ->limit(10)
            ->get();
        
        
        $ticketsByProblemType = Ticket::select('problem_type', DB::raw('COUNT(*) as count'))
            ->whereBetween('received_time', [$startDate, $endDate])
            ->whereNotNull('problem_type')
            ->where('problem_type', '!=', '')
            ->groupBy('problem_type')
            ->orderBy('count', 'desc')
            ->get();
        
  
        $ticketsByStatus = Ticket::select('status', DB::raw('COUNT(*) as count'))
            ->whereBetween('received_time', [$startDate, $endDate])
            ->groupBy('status')
            ->get();
        
        
        $avgResolutionTime = Ticket::whereNotNull('end_time')
            ->whereBetween('received_time', [$startDate, $endDate])
            ->selectRaw('AVG(TIMESTAMPDIFF(HOUR, received_time, end_time)) as avg_hours')
            ->value('avg_hours');
        
       
        $monthlyByUsertype = Ticket::select(
                DB::raw('DATE_FORMAT(received_time, "%Y-%m") as month'),
                'assigned_to',
                DB::raw('COUNT(*) as count')
            )
            ->whereBetween('received_time', [$startDate, $endDate])
            ->whereNotNull('assigned_to')
            ->groupBy('month', 'assigned_to')
            ->orderBy('month', 'asc')
            ->get();
    
        $totalTickets = Ticket::whereBetween('received_time', [$startDate, $endDate])->count();
        $resolvedTickets = Ticket::where('status', 'resolved')
            ->whereBetween('received_time', [$startDate, $endDate])
            ->count();
        $inProgressTickets = Ticket::where('status', 'in_progress')
            ->whereBetween('received_time', [$startDate, $endDate])
            ->count();
        $newTickets = Ticket::where('status', 'new')
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