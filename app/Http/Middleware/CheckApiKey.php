<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Validation\UnauthorizedException;
use Symfony\Component\HttpFoundation\Response;

class CheckApiKey
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {

        if ($request->header('X-API-KEY') !== config('auth.api_key')) {
            return response()->json(['message' => 'Unauthorized'], Response::HTTP_UNAUTHORIZED);

            // Avrei potuto lanciare anche un'eccezione UnauthorizedException, ma ho usato i codici ovunque mantengo la coerenza :)
        }

        return $next($request);
    }
}
