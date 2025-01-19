<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Env;
use Illuminate\Http\Request;
use App\Facades\ResponseFacade;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class DemoCheckAndPrevent
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(Auth::check() && Env("DEMO", false)){
            $route = Route::current()?->action;
            if (
                $request->isMethod('POST') ||
                $request->isMethod('DELETE') ||
                $request->isMethod('PUT') ||
                ($route['do_db_change'] ?? false)
            ){
                if(IS_API_REQUEST){
                    /** @var ResponseFactory $response */
                    $response = response();
                    return $response->json(
                        failed(_t("You can't do this action in demo mode"))
                    );
                }
                
                /** @var Redirector $redirect */
                $redirect = redirect();
                return $redirect->back()->with('error',_t("You can't do this action in demo mode"));
            }
            return $next($request);
        }
        return $next($request);
    }
}
