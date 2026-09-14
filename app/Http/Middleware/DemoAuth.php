<?php

namespace App\Http\Middleware;

use App\Support\DemoSession;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * Stands in for `auth` in the middleware demo — redirects to the demo login
 * screen unless DemoSession says we're signed in.
 *
 * Deliberately plain Laravel middleware, so the point of the demo is that
 * NOTHING here knows it is running on a native navigation rather than an
 * HTTP request.
 */
class DemoAuth
{
    public function handle(Request $request, Closure $next): Response
    {
        DemoSession::record('DemoAuth ran for /'.ltrim($request->path(), '/'));

        if (! DemoSession::signedIn()) {
            return redirect('/middleware-demo/login');
        }

        return $next($request);
    }
}
