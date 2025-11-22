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

            // Central Domain Routes - restricted to central domains only
            $this->mapCentralRoutes();
            
            // Tenant Routes - only loaded for tenant subdomains
            // The InitializeTenancyByDomain middleware handles tenant identification
            $this->mapTenantRoutes();
        });
    }

    /**
     * Define the "central" routes for the application.
     *
     * These routes are restricted to central domains defined in config/tenancy.php
     */
    protected function mapCentralRoutes()
    {
        foreach ($this->centralDomains() as $domain) {
            Route::middleware('web')
                ->domain($domain)
                ->group(base_path('routes/web.php'));
        }
    }

    /**
     * Define the "tenant" routes for the application.
     *
     * These routes are only accessible on tenant subdomains.
     */
    protected function mapTenantRoutes()
    {
        Route::middleware('web')
            ->group(base_path('routes/tenant.php'));
    }

    /**
     * Get the list of central domains from the tenancy config.
     *
     * @return array
     */
    protected function centralDomains()
    {
        return config('tenancy.central_domains', [
             'thecommunityhelpdesk.org',
            'www.thecommunityhelpdesk.org',
            '127.0.0.1',
            'localhost',
        ]);
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