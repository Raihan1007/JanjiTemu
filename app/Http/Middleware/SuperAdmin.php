<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SuperAdmin
{
    public function handle(Request $request, Closure $next)
    {
        if (auth('admin')->user()->role !== 'super_admin') {
           return response()->view(
            'errors.super-admin-only',
            [],
            403
           );
        }
        return $next($request);
    }
}
