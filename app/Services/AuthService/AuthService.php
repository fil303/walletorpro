<?php

namespace App\Services\AuthService;

use Exception;
use App\Models\User;
use App\Enums\TwoFactor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use PragmaRX\Google2FAQRCode\Google2FA;
use App\Services\AuthService\AppAuthService;
use App\Http\Requests\TwoFactorVerifyRequest;
use App\Services\SmsService\TwilioService;

class AuthService implements AppAuthService
{
    /**
     * get user details by user email. 
     *
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): User
    {
        if($user = User::where("email", $email)->first()) return $user;
        throw new \Exception("User not found by email");
    }
    
    /**
     * this method to check user password. 
     *
     * @param User $user
     * @param string $password
     * @return bool
     */
    public function checkUserPassword(User $user, string $password): bool
    {
        if(Hash::check($password, $user->password ?? "")) return TRUE;
        return FALSE;
    }

    /**
     * This method make user login to system.
     *
     * @param User $user
     * @param bool $remember
     * @return bool
     */
    public function userLogin(User $user, bool $remember = FALSE): bool
    {
        Auth::login($user, $remember);
        return Auth::check();
    }

    /**
     * This method make admin login to system.
     *
     * @param User $user
     * @param bool $remember
     * @return bool
     */
    public function adminLogin(User $user, bool $remember = FALSE): bool
    {
        Auth::login($user, $remember);
        return Auth::check();
    }

    /**
     * Get Google 2FA secret and QR Url
     * @param \App\Models\User|null $user
     * @return array
     */
    public function getGoogle2FAQRCode(User $user = null): array
    {
        $user    ??= Auth::user();
        $google2fa = new Google2FA();

        try {
            $secretKey     = $google2fa->generateSecretKey();
            $google2fa_url = $google2fa->getQRCodeUrl(
                company: 'company',
                holder : $user->email ?? 'user@email.com',
                secret : $secretKey
            );

            if(filled($secretKey) && filled($google2fa_url)){
                return success(["secretKey" => $secretKey, "qrcode" => $google2fa_url]);
            }   return failed();
        } catch (Exception $e) {
            logStore("Auth Service getGoogle2FAQRCode", $e->getMessage());
            return failed();
        }
    }

    /**
     * Verify Google Authentication By PIN Code
     * @param string $code
     * @param string $secretKey
     * @return array
     */
    public function google2FAVerify(string $code, string $secretKey): array
    {
        $google2fa = new Google2FA();
        
        try {
            $valid = $google2fa->verifyKey($secretKey, $code);
            if($valid) return success();
            return failed();
        } catch (Exception $e) {
            logStore("Auth Service google2FAVerify", $e->getMessage());
            return failed();
        }
    }

    /**
     * Two Factor Verification Process
     * @param \App\Http\Requests\TwoFactorVerifyRequest $request
     * @return array
     */
    public function twoFactorVerify(TwoFactorVerifyRequest $request): array
    {
        /** @var User $user */
        $user = Auth::user();
        $twoFactor = TwoFactor::tryFrom($request->type);

        if($twoFactor == TwoFactor::GOOGLE){
            $verified = $this->google2FAVerify($request->code, $user->google_2fa_secret ?? "");
            if($verified['status']) {
                Session::put("two-factor-verified", true);
                return success(_t("Verification Success"));
            }
            return failed(_t("Verification failed"));
        }

        if($twoFactor == TwoFactor::EMAIL){
            $verified = $user->pin_code == $request->code;
            if($verified) {
                Session::put("two-factor-verified", true);
                return success(_t("Verification Success"));
            }
            return failed(_t("Verification failed"));
        }
        
        if($twoFactor == TwoFactor::PHONE){
            $verified = $user->pin_code == $request->code;
            if($verified) {
                Session::put("two-factor-verified", true);
                return success(_t("Verification Success"));
            }
            return failed(_t("Verification failed"));
        }

        return failed(_t("Verification failed"));
    }

    /**
     * Send OTP Code
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function sendOTPCode(Request $request): array
    {
        /** @var User $user */
        $user = Auth::user();
        $user->generateNewTwoFactorPin();

        if($request->type == "email"){

            return success();
        }
        if($request->type == "phone"){
            $phone   = $user->phone_number();
            $message = "Here your pin code: $user->pin_code";

            $messageService = new TwilioService;
            $messageService->send(
                phone_number: $phone,
                message     : $message
            );
            return success();
        }
        return failed();
    }
}
