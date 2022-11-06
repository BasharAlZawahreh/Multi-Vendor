<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CheckAPIToken
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        $token = $request->header('x-api-token');
        if($token !== config('app.api_token')){
           return response()->json([
            'message' => 'Invalid X_API token'
            ], 400);
        }
        return $next($request);
    }
}
