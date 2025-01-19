<?php

namespace App\Services\AdminService;

use App\Http\Requests\Admin\PasswordResetRequest;
use App\Http\Requests\Admin\AdminProfileUpdateRequest;

interface IAdminService
{
    /**
     * Get Admin Profile Details
     * @return mixed
     */
    public function adminProfileDetails(): mixed;
    
    /**
     * Update Admin Profile
     * @param AdminProfileUpdateRequest $request
     * @return array
     */
    public function adminProfileUpdate(AdminProfileUpdateRequest $request): array;

    /**
     * Reset Admin Password
     * @param PasswordResetRequest $request
     * @return array
     */
    public function adminResetPassword(PasswordResetRequest $request): array;
}
