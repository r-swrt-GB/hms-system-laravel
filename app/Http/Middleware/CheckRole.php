<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckRole
{
    public function handle($request, Closure $next, $roleSlug)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Check if the user exists
        if (!$user) {
            return response()->json(['error' => "Unauthorized"], 403);
        }

        // Define permitted roles based on the requested role
        $permittedRoles = [];

        if ($roleSlug === 'lecturer') {
            $permittedRoles = ['lecturer', 'admin'];
        } elseif ($roleSlug === 'student') {
            $permittedRoles = ['student', 'admin', 'lecturer'];
        } else {
            // If the roleSlug is not specifically handled, check only for that role
            $permittedRoles = [$roleSlug];
        }

        // Check if the user has any of the permitted roles
        $hasAccess = collect($permittedRoles)->contains(function ($permittedRole) use ($user) {
            return $user->hasRole($permittedRole);
        });

        if (!$hasAccess) {
            return response()->json(['error' => "Unauthorized"], 403);
        }

        return $next($request);
    }
}
