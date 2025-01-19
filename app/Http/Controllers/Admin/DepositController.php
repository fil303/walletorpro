<?php

namespace App\Http\Controllers\Admin;

use App\Models\Deposit;
use Illuminate\Http\Request;
use App\Enums\TransactionType;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Support\Facades\View as ViewFactory;

class DepositController extends Controller
{
    public function __construct(){}

    /**
     * Get Deposit Report Page
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function depositPage(): View|JsonResponse
    {
        if(IS_API_REQUEST){
            $deposits = Deposit::with('user');
            return DataTables::of($deposits)
            ->addColumn("user", function($deposit){
                return view('admin.withdrawal.components.name', [ "user" => $deposit->user ]);
            })
            ->editColumn("amount", function($deposit){
                return "$deposit->amount $deposit->coin";
            })
            ->editColumn("type", function($deposit){
                return match ($deposit->type) {
                    TransactionType::INTERNAL => '<span class="badge badge-success">'._t("Internal").'</span>',
                    TransactionType::EXTERNAL => '<span class="badge badge-warning">'._t("External").'</span>',
                    default => '<span class="badge badge-error">'._t("Unknown").'</span>',
                };
            })
            ->editColumn("created_at", function($deposit){
                return date("Y-m-d H:i:s",strtotime($deposit->created_at));
            })
            ->rawColumns(['user','type'])
            ->make(true);
        }
        return ViewFactory::make("admin.deposit.index");
    }
}
