<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EnsureTenantApproved
{
    public function handle(Request $request, Closure $next)
    {
        $library = session('tenant_library') ?? app()->make('tenant_library', fn() => null);

        if ($library && !$library->is_approved) {
            return redirect('/')->with('error', 'This library account is pending approval.');
        }

        return $next($request);
    }
}
