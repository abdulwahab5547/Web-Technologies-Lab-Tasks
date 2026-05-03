<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsAdmin
{
    public function handle(Request $request, Closure $next): Response
    {
        if (! $request->user() || ! $request->user()->is_admin) {
            // Redirect with a flash message rather than a bare 403
            // so guests or non-admins land somewhere sensible.
            return redirect()->route('home')
                ->with('error', 'You do not have permission to access that page.');
        }

        return $next($request);
    }
}
