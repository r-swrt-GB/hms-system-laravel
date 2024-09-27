<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class ApiLogMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response) $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $startTime = microtime(true);

        $response = $next($request);

        // Calculate the response time
        $responseTime = microtime(true) - $startTime;

        $log = [
            'uri' => $request->getRequestUri(),
            'method' => $request->getMethod(),
            'request_body' => $request->all(),
            'response_body' => $response->getContent(),
            'status_code' => $response->getStatusCode(),
            'response_time' => round($responseTime * 1000, 2) . ' ms',
            'success' => $response->isSuccessful(),
        ];

        // Log the data
        Log::info(json_encode($log));

        return $response;
    }
}
