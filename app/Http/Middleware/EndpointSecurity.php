<?php
// app/Http/Middleware/EndpointSecurity.php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class EndpointSecurity
{
    public function handle(Request $request, Closure $next)
    {
        $providedApiKey = $request->header('X-API-KEY');
        $validApiKey = config('api.key');  // Updated to use new config

        if (!$providedApiKey || $providedApiKey !== $validApiKey) {
            return response()->json([
                'status' => 'error',
                'message' => 'Unauthorized access. Invalid or missing API key'
            ], 401);
        }

        return $next($request);
    }
}
