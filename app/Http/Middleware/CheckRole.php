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

        // Check if the user has the role by the role's slug
        if (!$user->roles()->where('slug', $roleSlug)->exists()) {
            return redirect()->back()->with('error', "You don't have access to this page.");
        }

        return $next($request);
    }
}
