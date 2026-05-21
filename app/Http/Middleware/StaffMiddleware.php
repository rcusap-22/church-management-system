<?php
namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class StaffMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if (!auth()->check() || auth()->user()->isMember()) {
            abort(403, 'Access denied.');
        }
        return $next($request);
    }
}