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
     *
     * Typically, users are redirected here after authentication.
     *
     * @var string
     */
    public const HOME = '/tickets';

    /**
     * Define your route model bindings, pattern filters, and other route configuration.
     *
     * @return void
     */
    public function boot()
    {
        $this->configureRateLimiting();

        $this->routes(function () {
            // API Routes
            Route::middleware('api')
                ->prefix('api')
                ->group(base_path('routes/api.php'));

            // Central Domain Routes (NO tenancy middleware!)
            Route::middleware('web')
                ->group(base_path('routes/web.php'));
            
            // Tenant Routes - The tenancy middleware is defined INSIDE routes/tenant.php
            // DO NOT add tenancy middleware here - it's already in the tenant.php file
            $this->mapTenantRoutes();
        });
    }

    /**
     * Map tenant routes
     * The middleware is applied inside the routes/tenant.php file itself
     */
    protected function mapTenantRoutes()
    {
        // Simply include the tenant routes file
        // The middleware is handled inside that file
        if (file_exists(base_path('routes/tenant.php'))) {
            require base_path('routes/tenant.php');
        }
    }

    /**
     * Configure the rate limiters for the application.
     *
     * @return void
     */
    protected function configureRateLimiting()
    {
        RateLimiter::for('api', function (Request $request) {
            return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
        });
    }
    
    /**
     * Get the home path based on user role.
     *
     * @param  \App\Models\User  $user
     * @return string
     */
    public static function redirectTo($user)
    {
        // Check if user is super admin
        if ($user->isSuperAdmin()) {
            return '/super-admin/tenants';
        }
        
        // Check if user is tenant admin
        if ($user->isTenantAdmin()) {
            return '/manage-users';
        }
        
        // Default redirect for regular users
        return self::HOME;
    }
}