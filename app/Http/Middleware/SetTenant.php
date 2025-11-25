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
        
        $host = $request->getHost();
        $parts = explode('.', $host);

        $isLibrarySubdomain = false;

  
        if (count($parts) >= 3) {
            // Get subdomain (first part before the domain)
            $subdomain = $parts[0];

            if ($subdomain && $subdomain !== 'www' && $subdomain !== 'localhost') {
                $library = Library::bySubdomain($subdomain)->first();

                if ($library) {
                    $isLibrarySubdomain = true;
                    session(['tenant_library' => $library]);
                    app()->bind('tenant_library', fn() => $library);


                    $path = $request->getPathInfo();

                    if ($path === '/') {
                        return redirect('/submit-ticket');
                    }


                    if ($path !== '/submit-ticket' && strpos($path, '/submit-ticket/') !== 0) {
                        return redirect('/submit-ticket');
                    }
                } else {

                    abort(404, 'Library not found');
                }
            }
        }


        if (!$isLibrarySubdomain && $request->getPathInfo() === '/submit-ticket') {
            return redirect('/');
        }

        
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
