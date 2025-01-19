<?php

namespace App\Facades;

use App\Models\User;
use Illuminate\Support\Facades\Facade;
use App\Services\UserService\AppUserService;

/**
 * This facade has user functionality
 * 
 * @method static User prepareUser(object $user)
 * @method static void updateUserWallets()
 * 
 * @see App\Services\UserService\UserService
 */
class UserFacade extends Facade
{
    /**
     * Get the registered name of the component.
     *
     * @return string
     */
    protected static function getFacadeAccessor()
    {
        return AppUserService::class;
    }

}
