<?php

namespace App\Http\Controllers\Admin;

use Exception;
use App\Models\Wallet;
use App\Models\Withdrawal;
use Illuminate\Http\Request;
use App\Enums\TransactionType;
use App\Enums\WithdrawalStatus;
use App\Facades\ResponseFacade;
use Illuminate\Support\Facades\DB;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Services\WalletService\AppWalletService;
use Illuminate\Support\Facades\View as ViewFactory;
use App\Services\TableActionGeneratorService\WithdrawalHistory\WithdrawalPendingHistoryAction;

class WithdrawalController extends Controller
{
    public function __construct(private AppWalletService $service){}

    /**
     * View Withdrawal Page
     * @return \Illuminate\Contracts\View\View
     */
    public function withdrawalPage(): View{
        return ViewFactory::make("admin.withdrawal.index");
    }

    /**
     * Get Withdrawal Pending List
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function withdrawalPendingList(Request $request): mixed
    {
        $withdrawals = Withdrawal::where('status', WithdrawalStatus::PENDING->value)
        ->with('user')->orderByDesc('id');
        return DataTables::of($withdrawals)
        ->addColumn("user", function($withdrawal){
            return view('admin.withdrawal.components.name', [ "user" => $withdrawal->user ]);
        })
        ->editColumn("amount", function($withdrawal){
            return "$withdrawal->amount $withdrawal->coin";
        })
        ->editColumn("type", function($withdrawal){
            return match ($withdrawal->type) {
                TransactionType::INTERNAL => '<span class="badge badge-success">'._t("Internal").'</span>',
                TransactionType::EXTERNAL => '<span class="badge badge-warning">'._t("External").'</span>',
                default => '<span class="badge badge-error">'._t("Unknown").'</span>',
            };
        })
        ->editColumn("status", function($withdrawal){
            return match ($withdrawal->status) {
                WithdrawalStatus::PENDING => '<span class="badge badge-warning">'._t("Pending").'</span>',
                WithdrawalStatus::COMPLETED => '<span class="badge badge-success">'._t("Completed").'</span>',
                WithdrawalStatus::REJECTED => '<span class="badge badge-error">'._t("Rejected").'</span>',
                default => '<span class="badge badge-error">'._t("Unknown").'</span>',
            };
        })
        ->addColumn("action", function($withdrawal){
            return WithdrawalPendingHistoryAction::getInstance($withdrawal)->button();
        })
        ->rawColumns(['user','type', 'status', 'action'])
        ->make(true);
    }

    /**
     * Get Withdrawal Confirm List
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function withdrawalConfirmList(Request $request): mixed
    {
        $withdrawals = Withdrawal::where('status', WithdrawalStatus::COMPLETED->value)
        ->with('user')->orderByDesc('id');
        return DataTables::of($withdrawals)
        ->addColumn("user", function($withdrawal){
            return view('admin.withdrawal.components.name', [ "user" => $withdrawal->user ]);
        })
        ->editColumn("amount", function($withdrawal){
            return "$withdrawal->amount $withdrawal->coin";
        })
        ->editColumn("type", function($withdrawal){
            return match ($withdrawal->type) {
                TransactionType::INTERNAL => '<span class="badge badge-success">'._t("Internal").'</span>',
                TransactionType::EXTERNAL => '<span class="badge badge-warning">'._t("External").'</span>',
                default => '<span class="badge badge-error">'._t("Unknown").'</span>',
            };
        })
        ->editColumn("status", function($withdrawal){
            return match ($withdrawal->status) {
                WithdrawalStatus::PENDING => '<span class="badge badge-warning">'._t("Pending").'</span>',
                WithdrawalStatus::COMPLETED => '<span class="badge badge-success">'._t("Completed").'</span>',
                WithdrawalStatus::REJECTED => '<span class="badge badge-error">'._t("Rejected").'</span>',
                default => '<span class="badge badge-error">'._t("Unknown").'</span>',
            };
        })
        ->rawColumns(['user','type', 'status'])
        ->make(true);
    }

    /**
     * Get Withdrawal Reject List
     * @param \Illuminate\Http\Request $request
     * @return mixed
     */
    public function withdrawalRejectList(Request $request): mixed
    {
        $withdrawals = Withdrawal::where('status', WithdrawalStatus::REJECTED->value)
        ->with('user')->orderByDesc('id');
        return DataTables::of($withdrawals)
        ->addColumn("user", function($withdrawal){
            return view('admin.withdrawal.components.name', [ "user" => $withdrawal->user ]);
        })
        ->editColumn("amount", function($withdrawal){
            return "$withdrawal->amount $withdrawal->coin";
        })
        ->editColumn("type", function($withdrawal){
            return match ($withdrawal->type) {
                TransactionType::INTERNAL => '<span class="badge badge-success">'._t("Internal").'</span>',
                TransactionType::EXTERNAL => '<span class="badge badge-warning">'._t("External").'</span>',
                default => '<span class="badge badge-error">'._t("Unknown").'</span>',
            };
        })
        ->editColumn("status", function($withdrawal){
            return match ($withdrawal->status) {
                WithdrawalStatus::PENDING => '<span class="badge badge-warning">'._t("Pending").'</span>',
                WithdrawalStatus::COMPLETED => '<span class="badge badge-success">'._t("Completed").'</span>',
                WithdrawalStatus::REJECTED => '<span class="badge badge-error">'._t("Rejected").'</span>',
                default => '<span class="badge badge-error">'._t("Unknown").'</span>',
            };
        })
        ->rawColumns(['user','type', 'status'])
        ->make(true);
    }

    /**
     * Accept Withdrawal
     * @param int $id
     * @return mixed
     */
    public function withdrawalAccept(int $id): mixed
    {
        if(!$withdrawal = Withdrawal::find($id))
            return ResponseFacade::result(failed(_t("Withdrawal request not found")))->send();

        $response = $this->service->withdrawFromWallet($withdrawal);
        return ResponseFacade::result($response)->send();
    }

    /**
     * Reject Withdrawal
     * @param int $id
     * @return mixed
     */
    public function withdrawalReject(int $id): mixed
    {
        if(!$withdrawal = Withdrawal::find($id))
            return ResponseFacade::failed(_t("Withdrawal request not found"))->send();

        if(!$wallet = Wallet::find($withdrawal->wallet_id))
            return ResponseFacade::failed(_t("User wallet not found"))->send();

        try {
            DB::beginTransaction();
            $withdrawal->status = WithdrawalStatus::REJECTED->value;
            if(
                $withdrawal->save() &&
                $wallet->increment("balance", $withdrawal->fees + $withdrawal->amount)
            ){
                DB::commit();
                $response = success(_t("Withdrawal rejected successfully"));
                return ResponseFacade::result($response)->send();
            }
            $response = failed(_t("Withdrawal rejection failed"));
            return ResponseFacade::result($response)->send();
        } catch (Exception $e) {
            DB::rollBack();
            logStore("withdrawalReject", $e->getMessage());
            $response = failed(_t("Withdrawal rejection failed"));
            return ResponseFacade::result($response)->send();
        }
    }
}
