<?php

namespace App\Http\Middleware;


use Closure;
use JWTAuth;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Support\Facades\Auth;



class AdminMiddleware
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
    
        // return response()->json([
        // 'message' => (!Auth::user()->Role=="admin"),
        // ]);
        
        
        if(!(Auth::user()->roles[0]['name']=="admin")){
            return response()->json([
                'message' => 'usuario no autorizado',
            ]);
        }
        return $next($request);
        
    }
    
}
