<?php

namespace App\Services\UserService;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Requests\RegisterRequest;
use App\Services\UserService\IUserService;
use App\Http\Requests\Admin\NewUserRequest;

interface AppUserService extends IUserService
{
    /**
     * Get Auth User
     * @return \App\Models\User|null
     */
    public function getAuthUser(): User|null;

    /**
     * Prepare User
     * @param RegisterRequest|NewUserRequest $user
     * @return \App\Models\User
     */
    public function prepareUser(RegisterRequest|NewUserRequest $user): User;

    /**
     * Add New User
     * @param \App\Http\Requests\Admin\NewUserRequest $request
     * @return array
     */
    public function addNewUser(NewUserRequest $request): array;

    /**
     * Get User By Id
     * @param int $id
     * @return \App\Models\User|null
     */
    public function getUserById(int $id): User|null;

    /**
     * Get User By Unique Id
     * @param string $uniqueId
     * @return \App\Models\User|null
     */
    public function getUserByUniqueId(string $uniqueId): User|null;

    /**
     * Get User By Email
     * @param string $email
     * @return \App\Models\User|null
     */
    public function getUserByEmail(string $email): User|null;

    /**
     * Updatee User
     * @param array<string> $user
     * @return int
     */
    public function updateUserFromArray(array $user):int;

    /**
     * Delete User Status
     * @param \App\Models\User $user
     * @param bool $forceDelete
     * @return int
     */
    public function deleteUserStatus(User $user, bool $forceDelete = false):int;

    /**
     * Active User Status
     * @param \App\Models\User $user
     * @return int
     */
    public function activeUserStatus(User $user):int;

    /**
     * Suspend User Status
     * @param \App\Models\User $user
     * @return int
     */
    public function suspendUserStatus(User $user):int;

    /**
     * Suspend User
     * @param string $uid
     * @return array
     */
    public function suspendUser(string $uid): array;

    /**
     * Active User
     * @param string $uid
     * @return array
     */
    public function activeUser(string $uid): array;

    /**
     * Delete User
     * @param string $uid
     * @return array
     */
    public function deleteUser(string $uid): array;

    /**
     * Force Delete User
     * @param string $uid
     * @return array
     */
    public function forceDeleteUser(string $uid): array;

    /**
     * Edit User
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function editUser(Request $request): array;
}