<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules;

class TenantRegistrationController extends Controller
{
    public function create()
    {
        return view('tenant.register');
    }

   public function store(Request $request)
{
    $request->validate([
        'library_name' => ['required', 'string', 'max:255'],
        'subdomain' => ['required', 'string', 'max:63', 'alpha_dash', 'unique:tenants,domain'],
        'admin_name' => ['required', 'string', 'max:255'],
        'admin_email' => ['required', 'string', 'email', 'max:255', 'unique:tenants,admin_email'],
        'password' => ['required', 'confirmed', Rules\Password::defaults()],
    ]);

    DB::beginTransaction();

    try {
        // Create tenant
        $tenant = Tenant::create([
            'name' => $request->library_name,
            'domain' => $request->subdomain,
            'database' => 'tenant_' . Str::slug($request->subdomain),
            'status' => 'pending',
            'admin_email' => $request->admin_email,
            'admin_name' => $request->admin_name,
            'data' => [], // Add this line - empty array for now
        ]);

        // Create domain
        $tenant->domains()->create([
            'domain' => $request->subdomain . '.' . config('app.domain'),
        ]);

        // Store temporary admin credentials (encrypted)
        cache()->put(
            'tenant_admin_password_' . $tenant->id,
            Hash::make($request->password),
            now()->addDays(30)
        );

        DB::commit();

        return redirect()->route('tenant.pending')
            ->with('tenant_id', $tenant->id)
            ->with('success', 'Registration submitted! Your account is pending approval.');

    } catch (\Exception $e) {
        DB::rollBack();
        return back()->withErrors(['error' => 'Registration failed: ' . $e->getMessage()])->withInput();
    }
}

    public function pending()
    {
        $tenantId = session('tenant_id');
        $tenant = $tenantId ? Tenant::find($tenantId) : null;

        return view('tenant.pending', compact('tenant'));
    }
}