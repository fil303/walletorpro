<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Routing\Redirector;
use Illuminate\Routing\ResponseFactory;
use Symfony\Component\HttpFoundation\Response;

class CheckedInstalled
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        if(file_exists(storage_path('installed')))
        return $next($request);

        if($request->wantsJson()){
            /** @var ResponseFactory $response */
            $response = response();
            return $response->json(
                failed(_t("Web installation not complete!"))
            );
        }

        /** @var Redirector $redirect */
        $redirect = redirect();
        return $redirect->route(route: 'LaravelInstaller::welcome');
    }
}
