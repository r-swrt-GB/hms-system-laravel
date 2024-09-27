<?php

namespace App\Http\Middleware;

use App\Models\Module;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;
use Illuminate\Support\Facades\Auth;

class ModuleAccessMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param Request $request
     * @param Closure(Request): (Response) $next
     * @return Response
     */
    public function handle(Request $request, Closure $next): Response
    {
        $user = Auth::user();

        $moduleId = $request->route('module')->id;

        // Allow admin access
        if ($user && $user->hasRole('admin')) {
            return $next($request);
        }

        $module = Module::find($moduleId);
        if (!$module) {
            return response()->json([
                'error' => 'Not Found',
                'message' => 'Module not found.'
            ], 404);
        }

        if ($user && !$user->modules()->where('modules.id', $moduleId)->exists()) {
            return response()->json([
                'error' => 'Unauthorized',
                'message' => 'You do not have access to this module.'
            ], 403);
        }

        return $next($request);
    }
}
