<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, $role): Response
    {
        if($request->user()->role != $role && $request->user()->role != 'admin'){
            if($request->user()->role === 'vendor'){
                return redirect()->route('vendor.dashboard');
            }else if($request->user()->role === 'user'){
                return redirect()->route('user.dashboard');
            }else{
                return redirect(RouteServiceProvider::HOME);
            }
        }
        return $next($request);
    }
}
