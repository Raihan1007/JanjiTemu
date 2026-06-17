<?php

use Illuminate\Foundation\Application;
use Illuminate\Foundation\Configuration\Exceptions;
use Illuminate\Foundation\Configuration\Middleware;
use Illuminate\Http\Request;

return Application::configure(basePath: dirname(__DIR__))
    ->withRouting(
        web: __DIR__.'/../routes/web.php',
        commands: __DIR__.'/../routes/console.php',
        health: '/up',
    )
    ->withMiddleware(function (Middleware $middleware): void {

        $middleware->alias([
            'super_admin' => \App\Http\Middleware\SuperAdmin::class,
        ]);

        $middleware->redirectGuestsTo(function (Request $request) {

            // 🔥 kalau admin
            if ($request->is('admin') || $request->is('admin/*')) {
                return route('admin.login');
            }

            // 🔥 user biasa
            return route('login.user');
        });

    })

    ->withExceptions(function (Exceptions $exceptions): void {
        //
    })

    ->create();
