<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Facades\ResponseFacade;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Services\AdminService\IAdminService;
use App\Http\Requests\Admin\PasswordResetRequest;
use Illuminate\Support\Facades\View as ViewFactory;
use App\Http\Requests\Admin\AdminProfileUpdateRequest;

class AdminController extends Controller
{
    public function __construct(protected IAdminService $service){}

    /**
     * Get Profile Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View
     */
    public function profilePage(Request $request): View
    {
        $data = [];
        $response = $this->service->adminProfileDetails();

        $data = $response['data'];
        if(isset($request->edit)) $data['edit'] = true;

        return ViewFactory::make("admin.profile.profile", $data);
    }

    /**
     * Profile Update Process
     * @param \App\Http\Requests\Admin\AdminProfileUpdateRequest $request
     * @return mixed
     */
    public function profileUpdateProcess(AdminProfileUpdateRequest $request): mixed
    {
        $response = $this->service->adminProfileUpdate($request);
        return ResponseFacade::result($response)->send();
    }

    /**
     * Get Reset Password Page
     * @return \Illuminate\Contracts\View\View
     */
    public function resetPasswordPage(): View
    {
        return ViewFactory::make("admin.profile.reset-password");
    }

    /**
     * Reset Password Process
     * @param \App\Http\Requests\Admin\PasswordResetRequest $request
     * @return mixed
     */
    public function resetPasswordProcess(PasswordResetRequest $request): mixed
    {
        $response = $this->service->adminResetPassword($request);
        return ResponseFacade::result($response)->send();
    }
}
