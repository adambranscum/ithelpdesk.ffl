<?php

namespace App\Http\Controllers;

use App\Models\Software;
use Illuminate\Http\Request;

class SoftwareController extends Controller
{
    
    /**
     * Display a listing of the software
     */
    public function index()
    {
        $software = Software::orderBy('renewal_date', 'asc')->paginate(15);
        
        // Calculate statistics - handle unlimited licenses
        $stats = [
            'total' => Software::count(),
            'expiring_soon' => Software::expiringSoon()->count(),
            'expired' => Software::expired()->count(),
            'total_licenses' => Software::where('unlimited', '!=', 1)
                                       ->orWhereNull('unlimited')
                                       ->sum('licence_quantity'),
        ];
        
        return view('software.index', compact('software', 'stats'));
    }

    
    /**
     * Show the form for creating a new software entry
     */
    public function create()
    {
        return view('software.create');
    }

    
    /**
     * Store a newly created software in storage
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'software' => 'required|string|max:255',
            'licence_quantity' => 'nullable|integer|min:0',
            'renewal_date' => 'nullable|date',
            'unlimited' => 'nullable|boolean',
            'forever' => 'nullable|boolean',
        ]);

        // Convert checkbox values
        $validated['unlimited'] = $request->has('unlimited') ? 1 : 0;
        $validated['forever'] = $request->has('forever') ? 1 : 0;
        
        // Set licence_quantity to null if unlimited is checked
        if ($validated['unlimited']) {
            $validated['licence_quantity'] = null;
        }
        
        // Set renewal_date to null if forever is checked
        if ($validated['forever']) {
            $validated['renewal_date'] = null;
        }

        Software::create($validated);

        return redirect()->route('software.index')
            ->with('success', 'Software added successfully!');
    }

    
    /**
     * Display the specified software
     */
    public function show(Software $software)
    {
        return view('software.show', compact('software'));
    }

    
    /**
     * Show the form for editing the specified software
     */
    public function edit(Software $software)
    {
        return view('software.edit', compact('software'));
    }

    
    /**
     * Update the specified software in storage
     */
    public function update(Request $request, Software $software)
    {
        $validated = $request->validate([
            'software' => 'required|string|max:255',
            'licence_quantity' => 'nullable|integer|min:0',
            'renewal_date' => 'nullable|date',
            'unlimited' => 'nullable|boolean',
            'forever' => 'nullable|boolean',
        ]);

        // Convert checkbox values
        $validated['unlimited'] = $request->has('unlimited') ? 1 : 0;
        $validated['forever'] = $request->has('forever') ? 1 : 0;
        
        // Set licence_quantity to null if unlimited is checked
        if ($validated['unlimited']) {
            $validated['licence_quantity'] = null;
        }
        
        // Set renewal_date to null if forever is checked
        if ($validated['forever']) {
            $validated['renewal_date'] = null;
        }

        $software->update($validated);

        return redirect()->route('software.index')
            ->with('success', 'Software updated successfully!');
    }

    
    /**
     * Remove the specified software from storage
     */
    public function destroy(Software $software)
    {
        $software->delete();

        return redirect()->route('software.index')
            ->with('success', 'Software deleted successfully!');
    }
}