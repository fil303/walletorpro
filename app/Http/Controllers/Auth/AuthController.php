<?php

namespace App\Http\Controllers\Auth;

use Exception;
use App\Models\User;
use App\Facades\AuthFacade;
use App\Facades\UserFacade;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use App\Facades\ResponseFacade;
use Illuminate\Routing\Redirector;
use App\Http\Requests\LoginRequest;
use App\Http\Controllers\Controller;
use App\Notifications\ResetPassword;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Session;
use App\Notifications\NewUserVerifyEmail;
use App\Services\ResponseService\Response;
use App\Http\Requests\PasswordResetRequest;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\TwoFactorVerifyRequest;

class AuthController extends Controller implements AuthInterface
{
    public function __construct(){}

    /**
     * New User register page.
     *
     * @return mixed
     */
    public function registerPage(Request $request): mixed
    {
        return view("auth.register");
    }

    /**
     * User login page.
     *
     * @return mixed
     */
    public function loginPage(Request $request): mixed
    {
        Auth::logout();
        return view("auth.login");
    }

    /**
     * Admin login page.
     *
     * @return mixed
     */
    public function adminLoginPage(Request $request): mixed
    {
        Auth::logout();
        return view("auth.admin-login");
    }

    /**
     * User logout request.
     *
     * @return mixed
     */
    public function logout(): mixed
    {
        Session::forget("two-factor-verified");
        $isUser = Auth::user()->role->isUser();
        Auth::logout();
        return Response::send(
            success(_t("Logout successfully")),
            $isUser ? "loginPage" : "adminLoginPage"
        );
    }

    /**
     * Forgot password page.
     *
     * @return mixed
     */
    public function forgotPasswordPage(Request $request): mixed
    {
        return view("auth.forgot");
    }

    /**
     * View password reset page.
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function passwordResetPage(Request $request): mixed
    {
        // check url signature
        if (! app('url')->hasValidSignature($request)) {
            abort(403, 'Unauthorized access!');
        }

        // check user id
        if(blank($request->email)){
            /** @var Redirector $redirect */
            $redirect = redirect();
            return $redirect->route("loginPage")->with("error", _t("Requested user email not found."));
        }

        // check user by email address
        $getUserSafely = safe_code( fn() => AuthFacade::getUserByEmail($request->email) );
        if(!$getUserSafely['status']){
            /** @var Redirector $redirect */
            $redirect = redirect();
            return $redirect->route("loginPage")->with("error", _t("Requested user not found."));
        }
        $user = $getUserSafely['data']['result'];

        $data["email"] = $user->email;
        $data["password_reset_token"] = $str = random_str();

        try {
            $user->password_reset_token = $str;
            $user->save();
        } catch (Exception $e) {
            logStore("passwordResetPage", $e->getMessage());
            abort(403, 'Password reset token generation failed');
        }

        return view("auth.reset-password", $data);
    }


    /**
     * New user register method.
     *
     * @param  RegisterRequest $request
     * @return mixed
     */
    public function registerProccess(RegisterRequest $request): mixed
    {
        /// set new user data in user object
        $userRequest = $request;
        $user = UserFacade::prepareUser($request);

        // save user or return error message
        try{
            if($user->save()){
                Notification::send($user, new NewUserVerifyEmail($user));
                // return success message
                /** @var \Illuminate\Routing\Redirector $redirect */
                $redirect = redirect();
                return $redirect->route('loginPage')->with("success",  _t("New user registration complete. We sent a welcome mail to your email address."));
            }
        } catch(Exception $e){
            logStore("registerProccess", $e->getMessage());
        }

        // return error resposne
        /** @var \Illuminate\Routing\Redirector $redirect */
        $redirect = redirect();
        return $redirect->back()->with("error",  _t("New user registration failed."))->withInput();
    }

    /**
     * User login method.
     *
     * param  email and password
     * @return mixed
     */
    public function loginProcess(LoginRequest $request): mixed
    {
        /** @var Redirector $redirect */
        $redirect = redirect();

        // find user or return error message
        $getUserSafely = safe_code( fn() => AuthFacade::getUserByEmail($request->email) );

        if(!$getUserSafely['status'])
            return $redirect->back()->with("error", _t("A user with this credentials does not exist"));

        $user = $getUserSafely['data']['result'];

        if($loginUser = AuthFacade::checkUserPassword($user, $request->password)){
            if($user->role->isAdmin() && isset($request->admin)){
                if(AuthFacade::adminLogin($user, isset($request->remember))){
                    return $redirect->route("adminDashboard")->with("success", _t("Login success"));
                }
            }
            if($user->role->isUser() && !isset($request->admin)){
                if(AuthFacade::userLogin($user, isset($request->remember))){
                    return $redirect->route("userDashboard")->with("success", _t("Login success"));
                }
            }
            return $redirect->back()->with("error", _t("Login not success"));
        }
        return $redirect->back()->with("error", _t("A user with this credentials does not exist"));
    }

    /**
     * Forgot password method to send reset password email to user.
     *
     * param  email
     * @return mixed
     */
    public function forgotPassword(Request $request): mixed
    {
        /** @var \Illuminate\Routing\Redirector $redirect */
        $redirect = redirect();

        // check email in request
        if(! isset($request->email) && blank($request->email))        
            return $redirect->back()->with("error", _t("Enter your email address"));

        // find user or return error message
        $getUserSafely = safe_code( fn() => AuthFacade::getUserByEmail($request->email) );
        if(!$getUserSafely['status'])
            return $redirect->back()->with("success", _t("We have sent an email to :email with instructions.", [ "email" => $request->email ]));
        $user = $getUserSafely['data']['result'];

        // send email notification
        try {
            Notification::send($user, new ResetPassword($user));
            return $redirect->route('loginPage')->with("success", _t("We have sent an email to :email with instructions.", [ "email" => $request->email ]));
        } catch(Exception $e){
            logStore("forgotPassword", $e->getMessage());
            return $redirect->route('loginPage')->with("error", _t("Password reset email sending failed"));
        }
    }

    /**
     * User Account Verification
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function userAccountVerification(Request $request): mixed
    {
        /** @var \Illuminate\Routing\Redirector $redirect */
        $redirect = redirect();

        // check url signature
        if (! app('url')->hasValidSignature($request)){
            abort(403, 'Unauthorized access!');
        }

        // check user id
        if(blank($request->id))
            return $redirect->route("loginPage")->with("error", _t("User identification not exist."));

        // find user by id
        if(! $user = User::find($request->id))
            return $redirect->route("loginPage")->with("error", _t("User not exist."));

        // current time
        $now = Carbon::now()->format("Y-m-d H:i:s");

        // update user and return success response
        if($user->update(["email_verified_at" => $now, "status" => "active"]))
            return $redirect->route("loginPage")->with("success", _t("Your account verification complete."));

        // return failed response
            return $redirect->route("loginPage")->with("error", _t("Your account verification not success."));
    }

    /**
     * View Password Reset Page
     * @param \App\Http\Requests\PasswordResetRequest $request
     * @return mixed
     */
    public function passwordReset(PasswordResetRequest $request): mixed
    {
        /** @var \Illuminate\Routing\Redirector $redirect */
        $redirect = redirect();

        // check user by email
        $getUserSafely = safe_code( fn() => AuthFacade::getUserByEmail($request->email) );
        if(!$getUserSafely['status'])
            return $redirect->route("loginPage")->with("error", _t("Requested user not found."));
        $user = $getUserSafely['data']['result'];

        // check reset token
        if(! $user->password_reset_token == $request->password_reset_token)
            return $redirect->route("loginPage")->with("error", _t("Password reset token invalid."));

        $user->password = Hash::make($request->password);

        try{
            if($user->save())
                return $redirect->route("loginPage")->with("success", _t("Password reset successfully"));
            return $redirect->back()->with("error", _t("Password reset failed."));
        } catch (Exception $e) {
            logStore("passwordReset", $e->getMessage());
            return $redirect->back()->with("error", _t("Password reset failed."));
        }
    }

    /**
     * Two Factor Verify Process
     * @param \App\Http\Requests\TwoFactorVerifyRequest $request
     * @return mixed
     */
    public function twoFactorVerifyProcess(TwoFactorVerifyRequest $request): mixed
    {
        $dashboard = Auth::user()->role->isAdmin() ? "adminDashboard" : "userDashboard";
        $response  = AuthFacade::twoFactorVerify($request);
        return ResponseFacade::result($response)->next($dashboard)->send();
    }

    /**
     * Send OTP Code
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function sendOTPCode(Request $request): mixed
    {
        $dashboard = Auth::user()->role->isAdmin() ? "adminDashboard" : "userDashboard";
        $response  = AuthFacade::sendOTPCode($request);
        return ResponseFacade::result($response)->send();
    }
}
