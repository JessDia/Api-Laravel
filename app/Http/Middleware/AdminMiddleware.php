<?php

namespace App\Http\Middleware;


use Closure;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

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
        $denegarAcceso = true;

        if (Auth()->user()->hasRole(['role:admin']))$denegarAcceso = false;
        if (!$denegarAcceso) {
            return response()->json([
                'message' => 'No eres administrador',
            ]);
        }
        return $next($request);
    }
}