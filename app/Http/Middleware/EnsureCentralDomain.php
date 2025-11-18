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
        $centralDomains = config('tenancy.central_domains', ['127.0.0.1', 'localhost']);
        
        if (!in_array($currentHost, $centralDomains)) {
            abort(404, 'Page not found on this domain');
        }

        return $next($request);
    }
}