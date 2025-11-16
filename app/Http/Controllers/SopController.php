<?php

namespace App\Http\Controllers;

use App\Models\Sop;
use Illuminate\Http\Request;

class SopController extends Controller
{
    /**
     * Display a listing of the SOPs with search and filters
     */
    public function index(Request $request)
    {
        $query = Sop::query();
        
        // Search
        if ($request->filled('search')) {
            $query->search($request->search);
        }
        
        // Filter by category
        if ($request->filled('category')) {
            $query->category($request->category);
        }
        
        // Filter by difficulty
        if ($request->filled('difficulty')) {
            $query->difficulty($request->difficulty);
        }
        
        // Filter active only
        if (!$request->has('show_inactive')) {
            $query->active();
        }
        
        // Sort
        $sort = $request->get('sort', 'recent');
        if ($sort === 'popular') {
            $query->popular();
        } else {
            $query->recent();
        }
        
        $sops = $query->paginate(15);
        
        // Statistics
        $stats = [
            'total' => Sop::active()->count(),
            'categories' => Sop::active()->distinct()->count('category'),
            'total_views' => Sop::sum('view_count'),
        ];
        
        // Get unique categories and difficulties for filters
        $categories = Sop::distinct()->pluck('category')->filter()->sort();
        $difficulties = ['Easy', 'Moderate', 'Advanced'];
        
        return view('sops.index', compact('sops', 'stats', 'categories', 'difficulties'));
    }

    /**
     * Show the form for creating a new SOP
     */
    public function create()
    {
        
        $categories = Sop::distinct()->pluck('category')->filter()->sort();
        $difficulties = ['Easy', 'Moderate', 'Advanced'];

        return view('sops.create', compact('categories', 'difficulties'));
    }

    /**
     * Store a newly created SOP in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'steps' => 'required|string',
            'tags' => 'nullable|string',
            'difficulty' => 'nullable|in:Easy,Moderate,Advanced',
            'estimated_time' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        Sop::create($validated);

        return redirect()->route('sops.index')
            ->with('success', 'Standard Operating Procedure created successfully!');
    }

    /**
     * Display the specified SOP
     */
    public function show(Sop $sop)
    {
        // Increment view count
        $sop->incrementViews();
        
        // Get related tickets
        $relatedTickets = $sop->tickets()->latest()->take(10)->get();
        
        return view('sops.show', compact('sop', 'relatedTickets'));
    }

    /**
     * Show the form for editing the specified SOP
     */
    public function edit(Sop $sop)
    {
        return view('sops.edit', compact('sop'));
    }

    /**
     * Update the specified SOP in storage
     */
    public function update(Request $request, Sop $sop)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'steps' => 'required|string',
            'tags' => 'nullable|string',
            'difficulty' => 'nullable|in:Easy,Moderate,Advanced',
            'estimated_time' => 'nullable|integer|min:1',
            'is_active' => 'boolean',
        ]);

        $sop->update($validated);

        return redirect()->route('sops.index')
            ->with('success', 'Standard Operating Procedure updated successfully!');
    }

    /**
     * Remove the specified SOP from storage
     */
    public function destroy(Sop $sop)
    {
        $sop->delete();

        return redirect()->route('sops.index')
            ->with('success', 'Standard Operating Procedure deleted successfully!');
    }
    
    /**
     * Link an SOP to a ticket
     */
    public function linkToTicket(Request $request, Sop $sop)
    {
        $request->validate([
            'ticket_id' => 'required|exists:tickets,id',
        ]);
        
        $sop->tickets()->syncWithoutDetaching([$request->ticket_id]);
        
        return redirect()->back()->with('success', 'SOP linked to ticket successfully!');
    }
}