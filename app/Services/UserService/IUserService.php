<?php

namespace App\Services\UserService;

use App\Http\Requests\User\PasswordResetRequest;
use App\Http\Requests\User\TwoFactorUpdateRequest;
use App\Http\Requests\User\PhoneVerificationRequest;
use App\Http\Requests\User\UserProfileUpdateRequest;

interface IUserService
{
    /**
     * Get User Profile Details
     * @return array
     */
    public function userProfileDetails(): array;

    /**
     * Update User Profile
     * @param \App\Http\Requests\User\UserProfileUpdateRequest $request
     * @return array
     */
    public function userProfileUpdate(UserProfileUpdateRequest $request): array;

    /**
     * Reset User Password
     * @param PasswordResetRequest $request
     * @return array
     */
    public function userResetPassword(PasswordResetRequest $request): array;
    
    /**
     * Two Factor Details
     * @return array
     */
    public function twoFactorDetails(): array;

    /**
     * Two Factor Update Process
     * @param \App\Http\Requests\User\TwoFactorUpdateRequest $request
     * @return array
     */
    public function twoFactorUpdateProcess(TwoFactorUpdateRequest $request): array;

    /**
     * Phone Verification
     * @param \App\Http\Requests\User\PhoneVerificationRequest $request
     * @return array
     */
    public function phoneVerification(PhoneVerificationRequest $request): array;
}
