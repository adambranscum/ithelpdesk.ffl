<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rules;

class UserManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isTenantAdmin()) {
                abort(403, 'Only tenant administrators can manage users');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = User::query()->where('role', '!=', 'super_admin');

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('role')) {
            $query->where('role', $request->role);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('email', 'LIKE', "%{$search}%")
                  ->orWhere('usertype', 'LIKE', "%{$search}%");
            });
        }

        $users = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => User::where('role', '!=', 'super_admin')->count(),
            'admins' => User::where('is_tenant_admin', true)->count(),
            'techs' => User::where('role', 'tech')->count(),
            'active' => User::where('status', 'active')->count(),
        ];

        return view('tenant-admin.users.index', compact('users', 'stats'));
    }

    public function create()
    {
        return view('tenant-admin.users.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'role' => ['required', 'in:admin,tech'],
            'usertype' => ['required', 'string', 'max:255'],
        ]);

        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'role' => $request->role,
            'is_tenant_admin' => $request->role === 'admin',
            'status' => 'active',
            'admin' => $request->role === 'admin' ? 'yes' : 'no',
            'usertype' => strtoupper($request->usertype),
            'email_verified_at' => now(),
        ]);

        return redirect()->route('tenant-admin.users.index')
            ->with('success', 'User created successfully!');
    }

    public function edit(User $user)
    {
        // Prevent editing super admin
        if ($user->isSuperAdmin()) {
            abort(403);
        }

        // Prevent non-super-admin from editing tenant admins (except themselves)
        if ($user->isTenantAdmin() && $user->id !== auth()->id()) {
            abort(403, 'You cannot edit other administrators');
        }

        return view('tenant-admin.users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        // Prevent editing super admin
        if ($user->isSuperAdmin()) {
            abort(403);
        }

        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,' . $user->id],
            'role' => ['required', 'in:admin,tech'],
            'usertype' => ['required', 'string', 'max:255'],
            'status' => ['required', 'in:active,suspended'],
        ]);

        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'role' => $request->role,
            'is_tenant_admin' => $request->role === 'admin',
            'admin' => $request->role === 'admin' ? 'yes' : 'no',
            'usertype' => strtoupper($request->usertype),
            'status' => $request->status,
        ]);

        return redirect()->route('tenant-admin.users.index')
            ->with('success', 'User updated successfully!');
    }

    public function destroy(User $user)
    {
        // Prevent deleting super admin
        if ($user->isSuperAdmin()) {
            abort(403);
        }

        // Prevent deleting yourself
        if ($user->id === auth()->id()) {
            return back()->withErrors(['error' => 'You cannot delete your own account']);
        }

        // Prevent deleting last tenant admin
        if ($user->isTenantAdmin() && User::where('is_tenant_admin', true)->count() <= 1) {
            return back()->withErrors(['error' => 'Cannot delete the last administrator']);
        }

        $user->delete();

        return redirect()->route('tenant-admin.users.index')
            ->with('success', 'User deleted successfully!');
    }

    public function resetPassword(Request $request, User $user)
    {
        $request->validate([
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
        ]);

        $user->update([
            'password' => Hash::make($request->password),
        ]);

        return back()->with('success', 'Password reset successfully!');
    }
}