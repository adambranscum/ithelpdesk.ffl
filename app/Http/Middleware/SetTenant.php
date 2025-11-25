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

                // On a library subdomain, only allow access to root and submit-ticket
                $path = $request->getPathInfo();

                // Allow root and submit-ticket paths
                if ($path !== '/' && $path !== '/submit-ticket' && strpos($path, '/submit-ticket/') !== 0) {
                    return redirect('/submit-ticket');
                }
            }
        } else {
            // On main domain, if authenticated, ensure user's library matches tenant
            if (Auth::check()) {
                $user = Auth::user();
                if ($user->library_uid) {
                    session(['tenant_library' => $user->library]);
                    app()->bind('tenant_library', fn() => $user->library);
                }
            }
        }

        return $next($request);
    }
}
