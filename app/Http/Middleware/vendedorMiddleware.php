<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;


class vendedorMiddleware
{
    public function handle(Request $request, Closure $next)
    {
        if(!(Auth::user()->roles[0]['name']==="vendedor")){
            return response()->json([
                'message' => 'usuario no autorizado',
            ]);
        }
        return $next($request);
    }
}
