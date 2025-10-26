<?php

namespace App\Http;

use Illuminate\Foundation\Http\Kernel as HttpKernel;

class Kernel extends HttpKernel
{
    
    // The application's global HTTP middleware stack.
    
    // These middleware are run during every request to your application.

    protected $middleware = [
        // Trust proxies
        \App\Http\Middleware\TrustProxies::class,
        // Handle CORS
        \Fruitcake\Cors\HandleCors::class,
        // Prevent maintenance mode requests
        \App\Http\Middleware\PreventRequestsDuringMaintenance::class,
        // Validate post size
        \Illuminate\Foundation\Http\Middleware\ValidatePostSize::class,
        // Trim strings
        \App\Http\Middleware\TrimStrings::class,
        // Convert empty strings to null
        \Illuminate\Foundation\Http\Middleware\ConvertEmptyStringsToNull::class,
    ];

    
    // The application's route middleware groups.
    
    protected $middlewareGroups = [
        'web' => [
            \App\Http\Middleware\EncryptCookies::class,
            \Illuminate\Cookie\Middleware\AddQueuedCookiesToResponse::class,
            \Illuminate\Session\Middleware\StartSession::class,
            \Illuminate\View\Middleware\ShareErrorsFromSession::class,
            \App\Http\Middleware\VerifyCsrfToken::class,
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],

        'api' => [
            'throttle:api',
            \Illuminate\Routing\Middleware\SubstituteBindings::class,
        ],
    ];

    
    // The application's route middleware.
    
    // These middleware may be assigned to groups or used individually.
    
    protected $routeMiddleware = [
        'auth' => \App\Http\Middleware\Authenticate::class,
        'auth.basic' => \Illuminate\Auth\Middleware\AuthenticateWithBasicAuth::class,
        'guest' => \App\Http\Middleware\RedirectIfAuthenticated::class,
        'signed' => \Illuminate\Routing\Middleware\ValidateSignature::class,
        'throttle' => \Illuminate\Routing\Middleware\ThrottleRequests::class,
        'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

        // Add admin middleware
        'admin' => \App\Http\Middleware\AdminAuth::class,
    ];
}
