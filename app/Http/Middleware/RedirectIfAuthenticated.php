<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use App\Providers\RouteServiceProvider;;
use Symfony\Component\HttpFoundation\Response;

class RedirectIfAuthenticated
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next, string ...$guards): Response|RedirectResponse|Redirector
    {
        $guards = empty($guards) ? [null] : $guards;
        // dd(77);
        foreach ($guards as $guard) {
            if (Auth::guard($guard)->check()) {
                /** @var Redirector $redirect */
                $redirect = redirect();
                if(Auth::user()->role->isAdmin()){
                    return $redirect->route('adminDashboard');
                }
                return $redirect->route('userDashboard');
            }
        }

        return $next($request);
    }
}
