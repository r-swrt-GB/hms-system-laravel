<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class CheckRight
{
    public function handle($request, Closure $next, $rightSlug)
    {
        if (!Auth::check()) {
            return redirect('login');
        }

        $user = Auth::user();

        // Admins have unrestricted access
        if ($user->roles()->where('slug', 'admin')->exists()) {
            return $next($request);
        }

        // Define specific access rights based on the right slug
        $roleAccessMapping = [
            'student-access' => ['student'],
            'lecturer-access' => ['lecturer'],
            'admin-access' => ['admin'],
        ];

        // Check if the requested right slug has specific roles
        if (array_key_exists($rightSlug, $roleAccessMapping)) {
            $roles = $roleAccessMapping[$rightSlug];

            // Check if the user has any of the permitted roles
            $hasAccess = collect($roles)->contains(function ($role) use ($user) {
                return $user->hasRole($role);
            });

            if (!$hasAccess) {
                return response()->json(['error' => "Unauthorized"], 403);
            }
        } else {
            $hasRight = $user->roles()->whereHas('rights', function ($query) use ($rightSlug) {
                $query->where('slug', $rightSlug);
            })->exists();

            if (!$hasRight) {
                return response()->json(['error' => "Unauthorized"], 403);
            }
        }

        return $next($request);
    }
}
