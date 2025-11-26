<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class LibraryApproved
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Check if the user is approved (is_active)
        if ($request->user() && !$request->user()->is_active) {
            // Allow access only to the pending approval page
            if ($request->routeIs('library.pending')) {
                return $next($request);
            }

            // Redirect all other requests to pending approval page
            // If in library context, use library.pending; otherwise redirect to home
            $pendingRoute = $request->is('library/*') ? 'library.pending' : 'home';
            return redirect()->route($pendingRoute);
        }

        return $next($request);
    }
}
