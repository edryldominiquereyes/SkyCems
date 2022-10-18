<?php

namespace App\Http\Middleware;

use App\Providers\RouteServiceProvider;
use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @param  string|null  ...$guards
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next, ...$guards)
    {
        $guards = empty($guards) ? [null] : $guards;

        foreach ($guards as $guard) {
            // if (Auth::guard($guard)->check()) {
            //     return redirect(RouteServiceProvider::HOME);
            // }
            if (Auth::guard($guard)->check() && Auth::user()->role == "admin"){
                return redirect()->route('admin.dashboard');
            }
            elseif(Auth::guard($guard)->check() && Auth::user()->role == "host" && Auth::user()->status == 1){
                return redirect()->route('host.index');
            }elseif(Auth::guard($guard)->check() && Auth::user()->role == "visitor"){
                return redirect()->route('visitor.index');
            }elseif(Auth::guard($guard)->check() && Auth::user()->role == "organizer"){
                return redirect()->route('organizer.index');
            }
            
        }

        return $next($request);
    }
}
