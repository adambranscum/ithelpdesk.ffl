<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Ticket;

class HomeController extends Controller
{
     public function index()
    {
        // Get overall statistics for all tickets for home page
        
        $stats = [
            'total' => Ticket::count(),
            'new' => Ticket::where('status', 'new')->count(),
            'in_progress' => Ticket::where('status', 'in_progress')->count(),
            'resolved' => Ticket::where('status', 'resolved')->count(),
        ];
        
        return view('welcome', compact('stats'));
    }
}
