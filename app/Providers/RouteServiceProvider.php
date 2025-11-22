<?php

namespace App\Providers;

use Illuminate\Cache\RateLimiting\Limit;
use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider
{
    /**
     * The path to the "home" route for your application.
     */
    public const HOME = '/tickets';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // API Routes
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Central Domain Routes
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            
            // Tenant Routes
            Route::middleware('web')
                ->group(base_path('routes/tenant.php'));
        });
    }

    /**
     * Configure the rate limiters for the application.
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
    
    /**
     * Get the home path based on user role.
     */
    public static function redirectTo($user)
    {
        if ($user->isSuperAdmin()) {
            return '/super-admin/tenants';
        }
        
        if ($user->isTenantAdmin()) {
            return '/manage-users';
        }
        
        return self::HOME;
    }
}