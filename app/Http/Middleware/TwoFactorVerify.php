<?php

namespace App\Http\Middleware;

use Closure;
use App\Models\User;
use Illuminate\Http\Request;
use App\Facades\ResponseFacade;
use Illuminate\Routing\Redirector;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class TwoFactorVerify
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $need_verification_to_continue = false;
        
        /** @var User $user */
        $user     = Auth::user();
        $verified = Session::has("two-factor-verified");

        if(!$verified && $user->google_2fa) $need_verification_to_continue  = true;
        if(!$verified && $user->email_2fa )  $need_verification_to_continue = true;
        if(!$verified && $user->phone_2fa )  $need_verification_to_continue = true;

        if($need_verification_to_continue){
            if(IS_API_REQUEST){

                /** @var RedirectResponse $response*/
                $response = ResponseFacade::result(
                    failed(
                        messageOrData: _t("Two Factor Verification Required"),
                        topLevelData : [ "code" => 302 ]
                    )
                )->send();

                return $response;
            }

            /** @var Redirector $redirect*/
            $redirect = redirect();
            return $redirect->route("twoFactorVerify");
        }

        return $next($request);
    }
}
