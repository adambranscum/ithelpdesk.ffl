<?php

namespace App\Http\Middleware;

use App\Models\Library;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SetTenant
{
    public function handle(Request $request, Closure $next)
    {
        // Extract subdomain from request
        $host = $request->getHost();
        $parts = explode('.', $host);

        // Get subdomain (first part before the domain)
        $subdomain = $parts[0] ?? null;

        if ($subdomain && $subdomain !== 'www' && $subdomain !== 'localhost') {
            $library = Library::bySubdomain($subdomain)->first();

            if ($library) {
                session(['tenant_library' => $library]);
                app()->bind('tenant_library', fn() => $library);
            }
        }

        // If authenticated, ensure user's library matches tenant
        if (Auth::check()) {
            $user = Auth::user();
            if ($user->library_uid) {
                session(['tenant_library' => $user->library]);
                app()->bind('tenant_library', fn() => $user->library);
            }
        }

        return $next($request);
    }
}
