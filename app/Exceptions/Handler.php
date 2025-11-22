<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;
use Stancl\Tenancy\Exceptions\TenantCouldNotBeIdentifiedOnDomainException;
use Symfony\Component\Routing\Exception\RouteNotFoundException;

class Handler extends ExceptionHandler
{
    /**
     * A list of exception types with their corresponding custom log levels.
     *
     * @var array<class-string<\Throwable>, \Psr\Log\LogLevel::*>
     */
    protected $levels = [
        //
    ];

    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<\Throwable>>
     */
    protected $dontReport = [
        TenantCouldNotBeIdentifiedOnDomainException::class,
    ];

    /**
     * A list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
        
        // Handle tenant identification errors
        $this->renderable(function (TenantCouldNotBeIdentifiedOnDomainException $e, $request) {
            // If on central domain, redirect to home
            $currentHost = $request->getHost();
            $centralDomains = config('tenancy.central_domains', []);
            
            if (in_array($currentHost, $centralDomains)) {
                return redirect('/')->with('error', 'This feature is only available on tenant subdomains.');
            }
            
            // Otherwise show 404
            return response()->view('errors.404', [], 404);
        });
        
        // Handle route not found errors (like tickets.index on central domain)
        $this->renderable(function (RouteNotFoundException $e, $request) {
            // Check if we're on central domain
            $currentHost = $request->getHost();
            $centralDomains = config('tenancy.central_domains', []);
            
            if (in_array($currentHost, $centralDomains)) {
                // If authenticated, show a helpful message
                if (auth()->check()) {
                    return redirect('/')->with('info', 'Please access tenant features through your library subdomain.');
                }
                // Otherwise just redirect to home
                return redirect('/');
            }
            
            // For tenant domains, show normal 404
            return response()->view('errors.404', [], 404);
        });
    }
}
