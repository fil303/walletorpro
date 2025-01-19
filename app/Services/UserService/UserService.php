<?php

namespace App\Services\UserService;

use Exception;
use App\Models\Coin;
use App\Models\User;
use App\Enums\Status;
use App\Models\Wallet;
use App\Enums\TwoFactor;
use App\Enums\UserStatus;
use App\Facades\AuthFacade;
use App\Facades\FileFacade;
use Illuminate\Http\Request;
use App\Enums\FileDestination;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Notifications\NewUserByAdmin;
use App\Http\Requests\RegisterRequest;
use Illuminate\Support\Facades\Storage;
use PragmaRX\Google2FAQRCode\Google2FA;
use App\Notifications\NewUserVerifyEmail;
use App\Services\ResponseService\Response;
use App\Http\Requests\Admin\NewUserRequest;
use App\Services\UserService\AppUserService;
use Illuminate\Support\Facades\Notification;
use App\Http\Requests\User\PasswordResetRequest;
use App\Http\Requests\User\TwoFactorUpdateRequest;
use App\Http\Requests\User\PhoneVerificationRequest;
use App\Http\Requests\User\UserProfileUpdateRequest;

/**
 * User Service
 * 
 * @template T
 */
class UserService implements AppUserService
{
    public function __construct(){}

    /**
     * Get Auth User
     * @return \App\Models\User|null
     */
    public function getAuthUser(): User|null
    {
        if(Auth::check())
            return Auth::user();
        return null;
    }

    /**
     * Get Auth User Id
     * @return int
     */
    public function getAuthUserId(): int
    {
        if(Auth::check())
            return Auth::user()->id ?? 0;
        return 0;
    }

    /**
     * Get User ID
     * @param int $id
     * @return \App\Models\User|null
     */
    public function getUserById(int $id): User|null
    {
        return User::find($id);
    }

    /**
     * Get User By Email
     * @param string $email
     * @return \App\Models\User|null
     */
    public function getUserByEmail(string $email): User|null
    {
        return User::where("email", $email)->first();
    }

    /**
     * Get User By Unique Id
     * @param string $uniqueId
     * @return \App\Models\User|null
     */
    public function getUserByUniqueId(string $uniqueId): User|null
    {
        return User::where("uid", $uniqueId)->first();
    }

    /**
     * Set new user details.
     *
     * @param  RegisterRequest|NewUserRequest $user
     * @return User
     */
    public function prepareUser(RegisterRequest|NewUserRequest $user): User
    {
        $newUser = new User;
        $newUser->uid = uniqid("UID");
        $newUser->first_name = $user->first_name ?? "";
        $newUser->last_name = $user->last_name ?? "";
        $newUser->name =  ($user->first_name ?? "") ." ". ($user->last_name ?? "");
        $newUser->username = $user->username ?? "";
        $newUser->email = $user->email ?? "";
        $newUser->country = $user->country ?? "";
        $newUser->phone = $user->phone ?? "";
        $newUser->password = Hash::make($user->password ?? "123456");
        $newUser->language = "en";
        // $user->status = "";

        return $newUser;
    }

    /**
     * Add New User
     * @param \App\Http\Requests\Admin\NewUserRequest $request
     * @return array
     */
    public function addNewUser(NewUserRequest $request): array
    {
        // get User data
        $user = $this->prepareUser($request);

        // save user or return error message
        try{
            if($user->save()){
                Notification::send($user, new NewUserByAdmin($user));
                // return success message
                return success(_t("New user creation complete. We sent a welcome mail to your email address."));
            }
        } catch(Exception $e){
            logStore("registerProccess addNewUser", $e->getMessage());
        }

        return failed(_t("New user creation failed."));
    }

    /**
     * Update user records in the database.
     *
     * @param  array<string, T>  $user
     * @return int
     */
    public function updateUserFromArray(array $user):int
    {
        try {
            return User::query()
            ->where("id", $this->getAuthUserId())
            ->update($user);
        } catch (Exception $e) {
            logStore("updateUserFromArray", $e->getMessage());
            return 0;
        }
    }

    /**
     * Suspend User Status
     * @param \App\Models\User $user
     * @return int
     */
    public function suspendUserStatus(User $user):int
    {
        try {
            $user->status = enum(UserStatus::SUSPENDED);
            if($user->save()) return 1;
            return 0;
        } catch (\Throwable $th) {
            logStore("suspendUserStatus", $th->getMessage());
            return 0;
        }
    }

    /**
     * Active User Status
     * @param \App\Models\User $user
     * @return int
     */
    public function activeUserStatus(User $user):int
    {
        try {
            $user->status = enum(UserStatus::ACTIVE);
            if($user->save()) return 1;
            return 0;
        } catch (\Throwable $th) {
            logStore("activeUserStatus", $th->getMessage());
            return 0;
        }
    }

    /**
     * Delete User Status
     * @param \App\Models\User $user
     * @param bool $forceDelete
     * @return int
     */
    public function deleteUserStatus(User $user, bool $forceDelete = false):int
    {
        try {

            if($forceDelete){
                if($user->delete()) return 1;
                return 0;
            }

            $user->status = enum(UserStatus::DELETED);
            if($user->save()) return 1;
            return 0;
        } catch (\Throwable $th) {
            logStore("deleteUserStatus", $th->getMessage());
            return 0;
        }
    }

    /**
     * Suspend User
     * @param string $uid
     * @return array
     */
    public function suspendUser(string $uid): array
    {
        // check user in db
        if(! $user = $this->getUserByUniqueId($uid))
            return failed(_t("User not found."));

        // change user status to suspend
        if($this->suspendUserStatus($user))
            return success(_t("User suspended successfully."));
        return failed(_t("Failed to suspended user."));
    }

    /**
     * Active User
     * @param string $uid
     * @return array
     */
    public function activeUser(string $uid): array
    {
        // check user in db
        if(! $user = $this->getUserByUniqueId($uid))
            return failed(_t("User not found."));

        // change user status to suspend
        if($this->activeUserStatus($user))
            return success(_t("User activeted successfully."));
        return failed(_t("Failed to activet user."));
    }

    /**
     * Delete User
     * @param string $uid
     * @return array
     */
    public function deleteUser(string $uid): array
    {
        // check user in db
        if(! $user = $this->getUserByUniqueId($uid))
            return failed(_t("User not found."));

        // change user status to suspend
        if($this->deleteUserStatus($user))
            return success(_t("User deleted successfully."));
        return failed(_t("Failed to delete user."));
    }

    /**
     * Force Delete User
     * @param string $uid
     * @return array
     */
    public function forceDeleteUser(string $uid): array
    {
        // check user in db
        if(! $user = $this->getUserByUniqueId($uid))
            return failed(_t("User not found."));

        // change user status to suspend
        if($this->deleteUserStatus($user, true))
            return success(_t("User force deleted successfully."));
        return failed(_t("Failed to force delete user."));
    }

    /**
     * Edit User
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function editUser(Request $request): array
    {
        // check uid in request params
        if(! isset($request->uid))
            return failed( _t("User unique id is missing."));

        // check user by unique id
        if(! $this->getUserByUniqueId($request->uid))
            return failed( _t("User not found."));

        $prepareUserData = [
            "first_name" => $request->first_name,
            "last_name"  => $request->last_name,
            "name" => $request->first_name. " " . $request->last_name,
        ];

        if(! $this->updateUserFromArray($prepareUserData))
            return failed(_t("User failed to update."));
        return success(_t("User successfully updated."));
    }

    /**
     * Update User Wallets
     * @return void
     */
    public function updateUserWallets():void
    {
        if($user = $this->getAuthUser()){
            $coins = Coin::where("status", Status::ENABLE->value)->get();

            $coins->map(function($coin) use($user){
                try{
                    Wallet::firstOrCreate([
                        "coin_id" => $coin->id,
                        "user_id" => $user->id
                    ],[
                        "coin" => $coin->coin,
                        "uid" => uniqueCode($coin->type == "c" ? "CW" : "FW"),
                    ]);
                } catch(Exception $e){
                    Response::throw(
                        failed($e->getMessage())
                    );
                }

            });
        }
    }

    /**
     * Get User Profile Details
     * @return array
     */
    public function userProfileDetails(): array
    {
        $user = Auth::user();
        $data['user'] = $user;
        return success($data);
    }

    /**
     * Update User Profile
     * @param \App\Http\Requests\User\UserProfileUpdateRequest $request
     * @return array
     */
    public function userProfileUpdate(UserProfileUpdateRequest $request): array
    {
        /** @var User $user */
        $user = Auth::user();

        /** @var string $dial_code */
        $dial_code = countries_dial_code(ucwords(trim($request->country)));
        if(blank($dial_code)) return failed(_t("User profile update failed, phone dial code not found"));

        $updateData = [
            "first_name" => $request->first_name,
            "last_name"  => $request->last_name,
            "name"       => "$request->first_name $request->last_name",
            // "username"   => $request->username,
            "country"    => ucwords(trim($request->country)),
            "phone"      => trim($request->phone)
        ];

        if($request->phone != $user->phone)
            $updateData['phone_verified_at'] = NULL;

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
            $updateData['image'] = $image;
        }

        if($user->update($updateData))
            return success(_t("User profile update successfully"));
        return failed(_t("User profile update failed"));
    }

    /**
     * Update User Password
     * @param \App\Http\Requests\User\PasswordResetRequest $request
     * @return array
     */
    public function userResetPassword(PasswordResetRequest $request): array
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

    /**
     * Two Factor Details 
     * @return array
     */
    public function twoFactorDetails(): array
    {
        /** @var User $user */
        $user = Auth::user();
        $data = [];
        $data['user'] = $user;

        if(!$user->google_2fa){
            $google2fa = AuthFacade::getGoogle2FAQRCode($user);
            if($google2fa['status']){
                $data['google2fa_secret']= $google2fa['data']['secretKey'];
                $data['qrcode']          = $google2fa['data']['qrcode'];
            }
        }

        $data['is_2fa_enable']   = get_settings("is_2fa_enable");
        $data['secret_2fa_code'] = get_settings("secret_2fa_code");

        return success($data);
    }

    /**
     * Two Factor Update Process
     * @param \App\Http\Requests\User\TwoFactorUpdateRequest $request
     * @return array
     */
    public function twoFactorUpdateProcess(TwoFactorUpdateRequest $request): array
    {
        /** @var User $user */
        $user = Auth::user();
        $twoFactor = TwoFactor::tryFrom($request->type);

        if($twoFactor == TwoFactor::GOOGLE){

            $verify = AuthFacade::google2FAVerify(
                code     : $request->code,
                secretKey: $request->secretKey ?? $user->google_2fa_secret ?? ''
            );

            if($verify['status']){
                if($user->google_2fa){
                    $userData = [
                        "google_2fa_secret" => NULL,
                        "google_2fa"        => false
                    ];
                    if($user->update($userData))
                    return success(_t("Google 2FA disable successfully"));
                    return failed(_t("Google 2FA failed to disable"));
                }
                $userData = [
                    "google_2fa_secret" => $request->secretKey,
                    "google_2fa"        => true
                ];

                if($user->update($userData))
                return success(_t("Google 2FA verified and enabled successfully"));
            }
            return failed(_t("Google 2FA verify failed"));
        }
        
        if($twoFactor == TwoFactor::EMAIL){
            $verified = $user->pin_code == $request->code;
            if($verified) {
                $user->generateNewTwoFactorPin();
                if($user->email_2fa){
                    $userData = [
                        "email_2fa" => false
                    ];
                    if($user->update($userData))
                    return success(_t("Email 2FA disable successfully"));
                    return failed(_t("Email 2FA failed to disable"));
                }
                $userData = [
                    "email_2fa" => true
                ];

                if($user->update($userData))
                return success(_t("Email 2FA verified and enabled successfully"));
            }
            return failed(_t("Email 2FA verify failed"));
        }
        
        if($twoFactor == TwoFactor::PHONE){
            $verified = $user->pin_code == $request->code;
            if($verified) {
                $user->generateNewTwoFactorPin();
                if($user->phone_2fa){
                    $userData = [
                        "phone_2fa" => false
                    ];
                    if($user->update($userData))
                    return success(_t("Phone 2FA disable successfully"));
                    return failed(_t("Phone 2FA failed to disable"));
                }
                $userData = [
                    "phone_2fa" => true
                ];

                if($user->update($userData))
                return success(_t("Phone 2FA verified and enabled successfully"));
            }
            return failed(_t("Phone 2FA verify failed"));
        }

        return failed(_t("2FA verify failed"));
    }

    /**
     * Phone Verification
     * @param \App\Http\Requests\User\PhoneVerificationRequest $request
     * @return array
     */
    public function phoneVerification(PhoneVerificationRequest $request): array
    {
        /** @var User $user */
        $user = Auth::user();

        $verified = $user->pin_code == $request->code;
        if($verified) {
            $user->generateNewTwoFactorPin();
            $userData = [
                "phone_verified_at" => date("Y-m-d"),
            ];

            if($user->update($userData))
            return success(_t("Phone verification successfully"));
        }
        return failed(_t("Phone verification failed"));
    }
}