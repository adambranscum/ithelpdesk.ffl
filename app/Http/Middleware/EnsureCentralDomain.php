<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class EnsureCentralDomain
{
    public function handle(Request $request, Closure $next): Response
    {
        $currentHost = $request->getHost();
        $centralDomains = config('tenancy.central_domains', ['www.thecommunityhelpdesk.org', 'thecommunityhelpdesk.org']);
        
        if (!in_array($currentHost, $centralDomains)) {
            abort(404, 'Page not found on this domain');
        }

        return $next($request);
    }
}