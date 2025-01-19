<?php

namespace App\Facades;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Facade;
use App\Services\AuthService\AppAuthService;
use App\Http\Requests\TwoFactorVerifyRequest;

/**
 * This Facade contains authentication functionality
 * 
 * @method static User getUserByEmail(string $email)
 * @method static bool checkUserPassword(User $user, string $password)
 * @method static bool userLogin(User $user, bool $remember = FALSE)
 * @method static bool adminLogin(User $user, bool $remember = FALSE)
 * @method static array getGoogle2FAQRCode(User $user = null)
 * @method static array google2FAVerify(string $code, string $secretKey)
 * @method static array twoFactorVerify(TwoFactorVerifyRequest $request)
 * @method static array sendOTPCode(Request $request)
 * 
 * @see App\Services\AuthService\AuthService
 */
class AuthFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AppAuthService::class;
    }

}
