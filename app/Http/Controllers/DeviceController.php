<?php

namespace App\Http\Controllers;

use App\Models\Device;
use Illuminate\Http\Request;

class DeviceController extends Controller
{
    
     //Display a listing of the devices
     
    public function index(Request $request)
    {
        $query = Device::query();
        
       
        if ($request->filled('branch')) {
            $query->where('branch', $request->branch);
        }
        
      
        if ($request->filled('make')) {
            $query->where('make', $request->make);
        }
        
        
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('device_name', 'LIKE', "%{$search}%")
                  ->orWhere('serial', 'LIKE', "%{$search}%")
                  ->orWhere('model', 'LIKE', "%{$search}%");
            });
        }
        
        $devices = $query->orderBy('warranty_end', 'asc')->paginate(15);
        
        
        $stats = [
            'total' => Device::count(),
            'warranty_expiring' => Device::warrantyExpiringSoon()->count(),
            'warranty_expired' => Device::warrantyExpired()->count(),
        ];
        
        
        $branches = Device::distinct()->pluck('branch')->filter()->sort();
        $makes = Device::distinct()->pluck('make')->filter()->sort();
        
        return view('devices.index', compact('devices', 'stats', 'branches', 'makes'));
    }

    
     //Show the form for creating a new device
     
    public function create()
    {
        return view('devices.create');
    }

    
     //Store a newly created device in storage
    
    public function store(Request $request)
    {
        $validated = $request->validate([
            'device_name' => 'nullable|string',
            'purchased' => 'nullable|date',
            'warranty_end' => 'nullable|date',
            'warranty' => 'nullable|string|max:255',
            'make' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
        ]);

        Device::create($validated);

        return redirect()->route('devices.index')
            ->with('success', 'Device added successfully!');
    }

    
     //Display the specified device
     
    public function show(Device $device)
    {
        return view('devices.show', compact('device'));
    }

    
     //Show the form for editing the specified device
     
    public function edit(Device $device)
    {
        return view('devices.edit', compact('device'));
    }

    /**
     * Update the specified device in storage
     */
    public function update(Request $request, Device $device)
    {
        $validated = $request->validate([
            'device_name' => 'nullable|string',
            'purchased' => 'nullable|date',
            'warranty_end' => 'nullable|date',
            'warranty' => 'nullable|string|max:255',
            'make' => 'nullable|string|max:255',
            'model' => 'nullable|string|max:255',
            'serial' => 'nullable|string|max:255',
            'branch' => 'nullable|string|max:255',
        ]);

        $device->update($validated);

        return redirect()->route('devices.index')
            ->with('success', 'Device updated successfully!');
    }

    
     //Remove the specified device from storage
     
    public function destroy(Device $device)
    {
        $device->delete();

        return redirect()->route('devices.index')
            ->with('success', 'Device deleted successfully!');
    }
}