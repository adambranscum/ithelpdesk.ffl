<?php

namespace App\Http\Controllers;

use App\Models\Device;
use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DeviceController extends Controller
{
    
     //Display a listing of the devices
     
    public function index(Request $request)
    {
        $user = Auth::user();
        $query = Device::where('library_uid', $user->library_uid);


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
            'total' => Device::where('library_uid', $user->library_uid)->count(),
            'warranty_expiring' => Device::where('library_uid', $user->library_uid)->warrantyExpiringSoon()->count(),
            'warranty_expired' => Device::where('library_uid', $user->library_uid)->warrantyExpired()->count(),
        ];


        $branches = Device::where('library_uid', $user->library_uid)->distinct()->pluck('branch')->filter()->sort();
        $makes = Device::where('library_uid', $user->library_uid)->distinct()->pluck('make')->filter()->sort();

        return view('devices.index', compact('devices', 'stats', 'branches', 'makes'));
    }

    
     //Show the form for creating a new device
     
    public function create()
    {
        $user = Auth::user();
        $branches = Category::where('library_uid', $user->library_uid)
            ->where('type', 'branch')
            ->where('is_active', true)
            ->get();

        return view('devices.create', compact('branches'));
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
            'library_uid' => 'required|string',
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
        $user = Auth::user();
        $branches = Category::where('library_uid', $user->library_uid)
            ->where('type', 'branch')
            ->where('is_active', true)
            ->get();

        return view('devices.edit', compact('device', 'branches'));
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
            'library_uid' => 'required|string',
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