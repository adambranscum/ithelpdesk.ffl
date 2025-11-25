<?php

namespace App\Http\Controllers;

use App\Helpers\TenantHelper;
use App\Models\Library;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rules\Password;

class LibraryAdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
        $this->middleware('verified');
    }

    /**
     * Show the admin's main dashboard with quick stats about their library
     */
    public function dashboard()
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        $library = $user->library;
        $staffCount = $library->users()->where('role', 'staff')->count();
        $ticketCount = $library->tickets()->count();

        return view('library.admin.dashboard', compact('library', 'staffCount', 'ticketCount'));
    }

    /**
     * Display the library's settings page so they can customize their profile
     */
    public function editSettings()
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        $library = $user->library;
        return view('library.admin.settings', compact('library'));
    }

    /**
     * Save changes to the library's settings (colors, address, logo, etc.)
     */
    public function updateSettings(Request $request)
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        $library = $user->library;

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
            'city' => ['nullable', 'string', 'max:100'],
            'state' => ['nullable', 'string', 'max:100'],
            'zip' => ['nullable', 'string', 'max:20'],
            'brand_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'primary_color' => ['nullable', 'string', 'regex:/^#[0-9A-Fa-f]{6}$/'],
            'ticket_page_title' => ['nullable', 'string', 'max:500'],
            'ticket_page_description' => ['nullable', 'string', 'max:1000'],
            'logo' => ['nullable', 'image', 'max:2048', 'dimensions:min_width=100,min_height=100'],
        ]);

        // Handle uploading and storing the library's logo
        if ($request->hasFile('logo')) {
            // Clean up the old logo so we don't clutter storage
            if ($library->logo_path) {
                Storage::disk('public')->delete($library->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('library-logos', 'public');
        }

        $library->update($validated);

        return back()->with('success', 'Library settings updated successfully!');
    }

    /**
     * Show all the staff members and let the admin manage them
     */
    public function manageStaff()
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        $library = $user->library;
        $staff = $library->users()->where('role', 'staff')->get();

        return view('library.admin.staff', compact('library', 'staff'));
    }

    /**
     * Show the form to add a new staff member to the library
     */
    public function showCreateStaff()
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        return view('library.admin.create-staff');
    }

    /**
     * Actually create the new staff account with their login details
     */
    public function createStaff(Request $request)
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email'],
            'password' => ['required', Password::defaults()],
        ]);

        User::create([
            'library_uid' => $user->library_uid,
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role' => 'staff',
            'is_active' => true,
            'email_verified_at' => now(),
        ]);

        return redirect('/library/admin/staff')->with('success', 'Staff account created successfully!');
    }

    /**
     * Open up the form to edit a specific staff member's details
     */
    public function editStaff($id)
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        $staff = User::findOrFail($id);
        abort_if($staff->library_uid !== $user->library_uid, 403, 'Unauthorized');
        abort_if($staff->role !== 'staff', 400, 'Can only edit staff members');

        return view('library.admin.edit-staff', compact('staff'));
    }

    /**
     * Save changes made to a staff member's account
     */
    public function updateStaff(Request $request, $id)
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        $staff = User::findOrFail($id);
        abort_if($staff->library_uid !== $user->library_uid, 403, 'Unauthorized');
        abort_if($staff->role !== 'staff', 400, 'Can only edit staff members');

        $rules = [
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', 'unique:users,email,' . $id],
        ];

        // Check if they're trying to change the password
        if ($request->filled('password')) {
            $rules['password'] = ['required', 'confirmed', Password::defaults()];
        }

        $validated = $request->validate($rules);

        // Only hash and save the password if they actually provided one
        if (isset($validated['password'])) {
            $validated['password'] = Hash::make($validated['password']);
        }

        $staff->update($validated);

        return redirect()->route('library.admin.staff')->with('success', 'Staff member updated successfully!');
    }

    /**
     * Disable a staff member's account so they can't log in anymore
     */
    public function deactivateStaff(Request $request, $memberId)
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        $member = User::findOrFail($memberId);
        abort_if($member->library_uid !== $user->library_uid, 403, 'Unauthorized');
        abort_if($member->role !== 'staff', 400, 'Can only deactivate staff members');

        $member->update(['is_active' => false]);

        return back()->with('success', 'Staff member deactivated successfully!');
    }

    /**
     * Turn a staff member's account back on so they can log in again
     */
    public function reactivateStaff(Request $request, $memberId)
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        $member = User::findOrFail($memberId);
        abort_if($member->library_uid !== $user->library_uid, 403, 'Unauthorized');
        abort_if($member->role !== 'staff', 400, 'Can only reactivate staff members');

        $member->update(['is_active' => true]);

        return back()->with('success', 'Staff member reactivated successfully!');
    }

    /**
     * Show a preview of how the library's custom branding looks
     */
    public function brandingPreview()
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        $library = $user->library;
        return view('library.admin.branding-preview', compact('library'));
    }
}
