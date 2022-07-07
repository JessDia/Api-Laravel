<?php

namespace App\Http\Middleware;

use Closure;
use JWTAuth;
use Exception;
use Tymon\JWTAuth\Http\Middleware\BaseMiddleware;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminVendedorMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        if(!(Auth::user()->roles[0]['name']=="admin" || Auth::user()->roles[0]['name']=="vendedor" )){
            return response()->json([
                'message' => 'usuario no autorizado',
            ]);
        }
        return $next($request);
    }
}