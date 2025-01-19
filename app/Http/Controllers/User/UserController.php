<?php

namespace App\Http\Controllers\User;

use App\Facades\ResponseFacade;
use App\Http\Controllers\Controller;
use App\Services\UserService\IUserService;
use App\Services\UserService\AppUserService;
use App\Http\Requests\User\PasswordResetRequest;
use App\Http\Requests\User\TwoFactorUpdateRequest;
use Illuminate\Support\Facades\View as ViewFactory;
use App\Http\Requests\User\PhoneVerificationRequest;
use App\Http\Requests\User\UserProfileUpdateRequest;

class UserController extends Controller
{
    protected IUserService $service;
    public function __construct(){
        $this->service = app(AppUserService::class);
    }

    /**
     * View Profile Page
     * @return mixed
     */
    public function profile(): mixed
    {
        $response = $this->service->userProfileDetails();
        return ViewFactory::make("user.profile.profile", $response['data']);
    }

    /**
     * View Password Reset Page
     * @return mixed
     */
    public function passwordResetPage(): mixed
    {
        $response = $this->service->userProfileDetails();
        return ViewFactory::make("user.profile.password_reset", $response['data']);
    }

    /**
     * Profile Update Process
     * @param \App\Http\Requests\User\UserProfileUpdateRequest $request
     * @return mixed
     */
    public function profileUpdateProcess(UserProfileUpdateRequest $request):mixed
    {
        $response = $this->service->userProfileUpdate($request);
        return ResponseFacade::result($response)->back()->send();
    }

    /**
     * Password reset process
     * @param \App\Http\Requests\User\PasswordResetRequest $request
     * @return mixed
     */
    public function passwordResetProcess(PasswordResetRequest $request):mixed
    {
        $response = $this->service->userResetPassword($request);
        return ResponseFacade::result($response)->send();
    }

    /**
     * Two Factor Setup Page
     * @return mixed
     */
    public function twoFactorSetupPage(): mixed
    {
        $response = $this->service->twoFactorDetails();
        return ViewFactory::make("user.profile.two_factor", $response['data']);
    }

    /**
     * Two Factor Setup Process
     * @param \App\Http\Requests\User\TwoFactorUpdateRequest $request
     * @return mixed
     */
    public function twoFactorSetupProcess(TwoFactorUpdateRequest $request):mixed
    {
        $response = $this->service->twoFactorUpdateProcess($request);
        return ResponseFacade::result($response)->send();
    }

    /**
     * Phone Verification Process
     * @param \App\Http\Requests\User\PhoneVerificationRequest $request
     * @return mixed
     */
    public function phoneVerificationProcess(PhoneVerificationRequest $request): mixed
    {
        $response = $this->service->phoneVerification($request);
        return ResponseFacade::result($response)->send();
    }
}
