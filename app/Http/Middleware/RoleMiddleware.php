<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
    //     // Check if user is logged in and has role_id 2
    // if (auth()->check() && auth()->user()->role_id === 2) {
    //     return $next($request); // User with role_id 2 is allowed to proceed
    // }

    //     // Check if user is logged in and has role_id 1
    // if (auth()->check() && auth()->user()->role_id === 1) {
    //     return redirect()->route('index'); // Redirect user with role_id 1 to the tasks route
    // }

    // // For all other cases, including unauthenticated users, return 403 Forbidden
    // abort(403);


    return $next($request);
}

}
