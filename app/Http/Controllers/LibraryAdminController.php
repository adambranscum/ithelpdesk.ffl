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
     * Library admin dashboard
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
     * Show library settings
     */
    public function editSettings()
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        $library = $user->library;
        return view('library.admin.settings', compact('library'));
    }

    /**
     * Update library settings
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

        // Handle logo upload
        if ($request->hasFile('logo')) {
            // Delete old logo if exists
            if ($library->logo_path) {
                Storage::disk('public')->delete($library->logo_path);
            }
            $validated['logo_path'] = $request->file('logo')->store('library-logos', 'public');
        }

        $library->update($validated);

        return back()->with('success', 'Library settings updated successfully!');
    }

    /**
     * Show staff management page
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
     * Show form to create staff
     */
    public function showCreateStaff()
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        return view('library.admin.create-staff');
    }

    /**
     * Create new staff account
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
     * Deactivate a staff member
     */
    public function deactivateStaff(Request $request, User $member)
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');
        abort_if($member->library_uid !== $user->library_uid, 403, 'Unauthorized');
        abort_if($member->role !== 'staff', 400, 'Can only deactivate staff members');

        $member->update(['is_active' => false]);

        return back()->with('success', 'Staff member deactivated successfully!');
    }

    /**
     * Reactivate a staff member
     */
    public function reactivateStaff(Request $request, User $staffUser)
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');
        abort_if($staffUser->library_uid !== $user->library_uid, 403, 'Unauthorized');
        abort_if($staffUser->role !== 'staff', 400, 'Can only reactivate staff members');

        $staffUser->update(['is_active' => true]);

        return back()->with('success', 'Staff member reactivated successfully!');
    }

    /**
     * View library branding preview
     */
    public function brandingPreview()
    {
        $user = Auth::user();
        abort_if($user->role !== 'admin', 403, 'Unauthorized');

        $library = $user->library;
        return view('library.admin.branding-preview', compact('library'));
    }
}
