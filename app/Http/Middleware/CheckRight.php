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

        // Check if any of the user's roles has the right by its slug
        $hasRight = $user->roles()->whereHas('rights', function($query) use ($rightSlug) {
            $query->where('slug', $rightSlug);
        })->exists();

        if (!$hasRight) {
            return redirect()->back()->with('error', "You don't have the right to access this page.");
        }

        return $next($request);
    }
}
