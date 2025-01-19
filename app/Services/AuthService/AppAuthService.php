<?php

namespace App\Services\AuthService;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\TwoFactorVerifyRequest;

interface AppAuthService
{
    /**
     * get user details by user email. 
     *
     * @param string $email
     * @return User
     */
    public function getUserByEmail(string $email): User;

    /**
     * this method to check user password. 
     *
     * @param User $user
     * @param string $password
     * @return bool
     */
    public function checkUserPassword(User $user, string $password): bool;

    /**
     * This method make user login to system.
     *
     * @param User $user
     * @param bool $remember
     * @return bool
     */
    public function userLogin(User $user, bool $remember = FALSE): bool;
   
    /**
     * This method make user login to system.
     *
     * @param User $user
     * @param bool $remember
     * @return bool
     */
    public function adminLogin(User $user, bool $remember = FALSE): bool;

    /**
     * Get Google 2FA secret and QR Url
     * @param \App\Models\User|null $user
     * @return array
     */
    public function getGoogle2FAQRCode(User $user = null): array;

    /**
     * Verify Google Authentication By PIN Code
     * @param string $code
     * @param string $secretKey
     * @return array
     */
    public function google2FAVerify(string $code, string $secretKey): array;

    /**
     * Two Factor Verification Process
     * @param TwoFactorVerifyRequest $request
     * @return array
     */
    public function twoFactorVerify(TwoFactorVerifyRequest $request): array;

    /**
     * Send OTP Code To SMS and EMAIL
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function sendOTPCode(Request $request): array;
}
