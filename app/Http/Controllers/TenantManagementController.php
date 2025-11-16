<?php

namespace App\Http\Controllers\;

use App\Http\Controllers\Controller;
use App\Models\Tenant;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\DB;

class TenantManagementController extends Controller
{
    public function __construct()
    {
        $this->middleware(function ($request, $next) {
            if (!auth()->user()->isSuperAdmin()) {
                abort(403, 'Unauthorized access');
            }
            return $next($request);
        });
    }

    public function index(Request $request)
    {
        $query = Tenant::query();

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('name', 'LIKE', "%{$search}%")
                  ->orWhere('admin_email', 'LIKE', "%{$search}%")
                  ->orWhere('domain', 'LIKE', "%{$search}%");
            });
        }

        $tenants = $query->orderBy('created_at', 'desc')->paginate(15);

        $stats = [
            'total' => Tenant::count(),
            'pending' => Tenant::where('status', 'pending')->count(),
            'active' => Tenant::where('status', 'active')->count(),
            'suspended' => Tenant::where('status', 'suspended')->count(),
        ];

        return view('super-admin.tenants.index', compact('tenants', 'stats'));
    }

    public function show(Tenant $tenant)
    {
        return view('super-admin.tenants.show', compact('tenant'));
    }

    public function approve(Tenant $tenant)
    {
        if ($tenant->status !== 'pending') {
            return back()->withErrors(['error' => 'Only pending tenants can be approved.']);
        }

        DB::beginTransaction();

        try {
            // Create tenant database
            Artisan::call('tenants:migrate', [
                '--tenants' => [$tenant->id]
            ]);

            // Get stored password
            $hashedPassword = cache()->get('tenant_admin_password_' . $tenant->id);

            if (!$hashedPassword) {
                throw new \Exception('Admin password not found. Registration may have expired.');
            }

            // Initialize tenant and create admin user
            tenancy()->initialize($tenant);

            User::create([
                'name' => $tenant->admin_name,
                'email' => $tenant->admin_email,
                'password' => $hashedPassword,
                'role' => 'admin',
                'is_tenant_admin' => true,
                'status' => 'active',
                'admin' => 'yes', // For backwards compatibility
                'usertype' => 'ADMIN', // For backwards compatibility
                'email_verified_at' => now(),
            ]);

            tenancy()->end();

            // Approve tenant
            $tenant->approve();

            // Clear cached password
            cache()->forget('tenant_admin_password_' . $tenant->id);

            DB::commit();

            // Send approval email
            // Mail::to($tenant->admin_email)->send(new TenantApproved($tenant));

            return redirect()->route('super-admin.tenants.index')
                ->with('success', 'Tenant approved successfully!');

        } catch (\Exception $e) {
            DB::rollBack();
            tenancy()->end();
            return back()->withErrors(['error' => 'Approval failed: ' . $e->getMessage()]);
        }
    }

    public function suspend(Tenant $tenant)
    {
        $tenant->suspend();

        return redirect()->route('super-admin.tenants.index')
            ->with('success', 'Tenant suspended successfully!');
    }

    public function activate(Tenant $tenant)
    {
        $tenant->update(['status' => 'active']);

        return redirect()->route('super-admin.tenants.index')
            ->with('success', 'Tenant activated successfully!');
    }

    public function destroy(Tenant $tenant)
    {
        if ($tenant->isActive()) {
            return back()->withErrors(['error' => 'Cannot delete active tenant. Suspend first.']);
        }

        // Delete tenant database
        Artisan::call('tenants:delete', [
            'tenant' => $tenant->id
        ]);

        $tenant->delete();

        return redirect()->route('super-admin.tenants.index')
            ->with('success', 'Tenant deleted successfully!');
    }
}