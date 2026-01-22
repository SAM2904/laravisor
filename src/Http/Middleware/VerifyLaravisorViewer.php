<?php

namespace Sam\Laravisor\Http\Middleware;

use Closure;

class VerifyLaravisorViewer
{
    public function handle($request, Closure $next)
    {
        $token = $request->bearerToken();

        if ($token !== config('laravisor.project_key')) {
            return response()->json(['error' => 'Unauthorized'], 401);
        }

        return $next($request);
    }
}
