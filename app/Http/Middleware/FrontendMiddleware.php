<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class FrontendMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        // 1️⃣ Check if user is logged in
        if (!Auth::check()) {
            return redirect()->route('jobseeker.login'); // change to your frontend login route
        }

        // 2️⃣ Restrict access by role
        if (!in_array(Auth::user()->role, ['jobseeker', 'employer'])) {
            abort(403, 'Unauthorized Access');
        }

        // 3️⃣ Pass request forward
        return $next($request);
    }
}