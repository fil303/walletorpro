<?php

namespace App\Services\AdminService;

use App\Models\User;
use App\Facades\AuthFacade;
use App\Facades\FileFacade;
use App\Enums\FileDestination;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use App\Services\AdminService\IAdminService;
use App\Services\FileService\AppFileService;
use App\Http\Requests\Admin\PasswordResetRequest;
use App\Http\Requests\Admin\AdminProfileUpdateRequest;

class AdminService implements IAdminService
{
    public function __construct(){}

    /**
     * Admin Profile Details
     * @return mixed
     */
    public function adminProfileDetails(): mixed
    {
        $user = Auth::user();
        $data['user'] = $user;
        return success($data);
    }

    /**
     * Update Admin Profile
     * @param AdminProfileUpdateRequest $request
     * @return array
     */
    public function adminProfileUpdate(AdminProfileUpdateRequest $request): array
    {
        /** @var User $user */
        $user = Auth::user();

        $userUpdateData = [];

        if($request->hasFile("image")){

            /** @var UploadedFile $file */
            $file = $request->file("image");

            $image = FileFacade::saveImageInPublicStorage(
                file: $file,
                destination: FileDestination::PROFILE_IMAGE_PATH,
            );

            if(filled($image) && filled($user->image))
            {
                FileFacade::removePublicStorageFile($user->image);
            }

            if(filled($image))
            $userUpdateData['image'] = $image;
        }

        $userUpdateData['first_name'] = $request->first_name;
        $userUpdateData['last_name']  = $request->last_name;
        $userUpdateData['email']      = $request->email;

        if($user->update($userUpdateData)){
            return success(_t("Profile Updated successfully"));
        }
        return failed(_t("Failed to update profile"));
    }

    /**
     * Admin Reset Password
     * @param \App\Http\Requests\Admin\PasswordResetRequest $request
     * @return array
     */
    public function adminResetPassword(PasswordResetRequest $request): array
    {
        /** @var User $user */
        $user = Auth::user();

        if(!AuthFacade::checkUserPassword($user, $request->current_password))
            return failed(_t("Your current password is wrong"));

        $password = Hash::make($request->password);

        if($user->update(["password" => $password]))
            return success(_t("Password reset successfully"));
        return failed(_t("Password reset failed"));
    }
}
