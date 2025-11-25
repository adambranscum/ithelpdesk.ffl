<?php

namespace App\Http\Controllers;

use App\Helpers\TenantHelper;
use Illuminate\Http\Request;
use App\Models\Ticket;

class HomeController extends Controller
{
    public function index()
    {
        // If on a subdomain with a library, redirect to public ticket submission
        $library = TenantHelper::current();
        if ($library && $library->is_approved) {
            return redirect()->route('library.public.submit');
        }

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
