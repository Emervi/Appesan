<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class CekNullRole
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

        $roles = [
            'admin' => 'admin-dashboard',
            'cashier' => 'cashier-dashboard',
            'chef' => 'chef-dashboard',
            'customer' => 'menu',
        ];

        foreach( $roles as $role => $route ) {
            if( session()->has($role) ) {
                return redirect()->route($route);
            }
        }

        return $next($request);
    }
}
