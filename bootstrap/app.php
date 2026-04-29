<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use App\Http\Middleware\EmployerMiddleware;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        api: __DIR__.'/../routes/api.php',
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        channels: __DIR__.'/../routes/channels.php',
        health: '/up',
    )

    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            
            // AUTH
            'auth' => \App\Http\Middleware\Authenticate::class,

            // OPTIONAL EMAIL VERIFICATION
            'verified' => \Illuminate\Auth\Middleware\EnsureEmailIsVerified::class,

            // YOUR CUSTOM
            'admin' => \App\Http\Middleware\AdminMiddleware::class,
            'frontend' => \App\Http\Middleware\FrontendMiddleware::class,
            'employer' => EmployerMiddleware::class,
             'prevent.admin.frontend' => \App\Http\Middleware\PreventAdminFrontendAccess::class,
        ]);

    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })->create();