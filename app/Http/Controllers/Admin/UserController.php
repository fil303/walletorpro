<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\User;
use App\Models\Wallet;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use App\Services\ResponseService\Response;
use App\Http\Requests\Admin\NewUserRequest;
use App\Services\UserService\AppUserService;
use Illuminate\Support\Facades\View as ViewFactory;
use App\Services\TableActionGeneratorService\UserTableAction\ActiveUserAction;
use App\Services\TableActionGeneratorService\UserTableAction\DeleteUserAction;
use App\Services\TableActionGeneratorService\UserTableAction\SuspendUserAction;

class UserController extends Controller
{
    public function __construct(private AppUserService $userService) {}

    /**
     * View Add User Page
     * @return mixed
     */
    public function addUserPage(): mixed
    {
        return view("admin.users.add_user");
    }

    /**
     * Add New User
     * @param \App\Http\Requests\Admin\NewUserRequest $request
     * @return mixed
     */
    public function addUser(NewUserRequest $request): mixed
    {
        // return response
        return Response::send(
            $this->userService->addNewUser($request)
        );
    }

    /**
     * View Active User List Page
     * @return mixed
     */
    public function userActiveListPage(): mixed
    {
        if(IS_API_REQUEST){
            $users = User::where('status', 'active')->where('role', '<>', 1);

            return DataTables::of($users)
            ->editColumn("name", function($user){
                return view('admin.users.components.name', compact('user'));
            })
            ->editColumn("email_verified_at", function($user){
                if(!$user->email_verified_at)
                    return '<span class="icon-[subway--tick]" style="color: #57e389;"></span>';
                return '<span class="icon-[emojione-v1--cross-mark]"></span>';
            })
            ->editColumn("country", function($user){
                return countries($user->country ?? '');
            })
            ->addColumn("action", function($user){
                return ActiveUserAction::getInstance($user)->option();
            })
            ->rawColumns(['name', 'email_verified_at', 'action'])
            ->make();
        }
        return view("admin.users.active_users");
    }

    /**
     * View Suspend User List Page
     * @return mixed
     */
    public function userSuspendListPage(): mixed
    {
        if(IS_API_REQUEST){
            $users = User::where('status', 'suspended')->where('role', '<>', 1);
            
            return DataTables::of($users)
            ->addColumn("action", function($user){
                return SuspendUserAction::getInstance($user)->button();
            })
            ->editColumn("country", function($user){
                return countries($user->country ?? '');
            })
            ->make();
        }
        return view("admin.users.suspend_users");
    }

    /**
     * View Delete User List Page
     * @return mixed
     */
    public function userDeleteListPage(): mixed
    {
        if(IS_API_REQUEST){
            $users = User::where('status', 'deleted')->where('role', '<>', 1);
            
            return DataTables::of($users)
            ->addColumn("action", function($user){
                return DeleteUserAction::getInstance($user)->button();
            })
            ->editColumn("country", function($user){
                return countries($user->country ?? '');
            })
            ->make();
        }
        return view("admin.users.delete_users");
    }

    /**
     * View User Edit Page
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function editUser(Request $request):mixed
    {
        // return response
        return Response::send(
            $this->userService->editUser($request)
        );
    }

    /**
     * Suspend User
     * @param string $uid
     * @return mixed
     */
    public function suspendUser(string $uid): mixed
    {
        // return response
        return Response::send(
            $this->userService->suspendUser($uid)
        );
    }

    /**
     * Active User
     * @param string $uid
     * @return mixed
     */
    public function activeUser(string $uid): mixed
    {
        // return response
        return Response::send(
            $this->userService->activeUser($uid)
        );
    }

    /**
     * Delete User
     * @param string $uid
     * @return mixed
     */
    public function deleteUser(string $uid): mixed
    {
        // return response
        return Response::send(
            $this->userService->deleteUser($uid)
        );
    }

    /**
     * Force Delete User
     * @param string $uid
     * @return mixed
     */
    public function forceDeleteUser(string $uid): mixed
    {
        // return response
        return Response::send(
            $this->userService->forceDeleteUser($uid)
        );
    }

    /**
     * View User Wallet List Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function userWalletListPage(Request $request) : View|JsonResponse
    {
        if(IS_API_REQUEST){
            $wallets = Wallet::with(['user','address']);
            return DataTables::of($wallets)
            ->addColumn("user", function($wallet){
                return view('admin.withdrawal.components.name', [ "user" => $wallet->user ]);
            })
            ->editColumn("balance", function($wallet){
                return "$wallet->balance $wallet->coin";
            })
            ->addColumn("address", function($wallet){
                return $wallet->address?->address;
            })
            ->editColumn("updated_at", function($wallet){
                return date("Y-m-d H:i:s",strtotime($wallet->updated_at));
            })
            ->rawColumns(['user','type'])
            ->make(true);
        }
        return ViewFactory::make('admin.users.wallet_list');
    }
}
