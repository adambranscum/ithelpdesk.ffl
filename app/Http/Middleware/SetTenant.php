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

        // Only treat as subdomain if there are at least 2 parts (subdomain.domain.ext)
        if (count($parts) >= 2) {
            // Get subdomain (first part before the domain)
            $subdomain = $parts[0];

            // Only process library subdomains (not www or localhost)
            if ($subdomain && $subdomain !== 'www' && $subdomain !== 'localhost') {
                $library = Library::bySubdomain($subdomain)->first();

                if ($library) {
                    session(['tenant_library' => $library]);
                    app()->bind('tenant_library', fn() => $library);

                    // On a library subdomain, only allow access to submit-ticket
                    $path = $request->getPathInfo();

                    // Redirect root to submit-ticket, block everything else
                    if ($path === '/') {
                        return redirect('/submit-ticket');
                    }

                    // Allow submit-ticket paths
                    if ($path !== '/submit-ticket' && strpos($path, '/submit-ticket/') !== 0) {
                        return redirect('/submit-ticket');
                    }
                } else {
                    // Subdomain doesn't exist in libraries table - return 404
                    abort(404, 'Library not found');
                }
            }
        }

        // For non-subdomain requests, redirect /submit-ticket to home
        // /submit-ticket is only for library subdomains
        if ($request->getPathInfo() === '/submit-ticket') {
            return redirect('/');
        }

        // For non-subdomain requests or main domain, if authenticated, ensure user's library matches tenant
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
