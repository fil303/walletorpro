<?php

namespace App\Http\Controllers\User;

use App\Enums\CoinBuyStatus;
use App\Models\Stake;
use App\Models\Deposit;
use App\Models\CoinOrder;
use App\Models\Withdrawal;
use App\Models\CoinExchange;
use Illuminate\Http\Request;
use App\Enums\WithdrawalStatus;
use Illuminate\Http\JsonResponse;
use Illuminate\Contracts\View\View;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\Routing\ResponseFactory;
use Illuminate\Support\Facades\View as ViewFactory;

class ReportController extends Controller
{
    public function __construct(){}

    /**
     * View  Deposit Report Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function depositReportPage(Request $request):View|JsonResponse
    {
        if(IS_API_REQUEST){
            $perPage = (isset($request->per_page) && is_numeric($request->per_page))? $request->per_page: 10;
            $deposits = Deposit::where('user_id', Auth::id())->with('coin_table');
            if(isset($request->coin_id)) $deposits = $deposits->where('id', $request->coin_id);
            $deposits = $deposits->orderByDesc('id')->paginate($perPage)->onEachSide(1);

            $deposits->map(function($deposit){
                $html = view('user.report.components.deposit-row', ['deposit' => $deposit]);

                if ($html instanceof View){
                    $deposit->html = $html->render();
                }
            });

            $factory = app(ResponseFactory::class);
            return $factory->json($deposits);
        }
        return ViewFactory::make("user.report.deposit-report");
    }

    /**
     * View Withdrawal Report Page
     * @return \Illuminate\Contracts\View\View
     */
    public function withdrawalReportPage(): View
    {
        return ViewFactory::make("user.report.withdrawal-report");
    }

    /**
     * View Withdrawal Pending Report Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function withdrawalPendingReport(Request $request): JsonResponse
    {
        $perPage = (isset($request->per_page) && is_numeric($request->per_page))? $request->per_page: 10;
        $withdrawals = Withdrawal::where('user_id', Auth::id())
        ->where('status', WithdrawalStatus::PENDING->value)
        ->orderByDesc('id')->paginate($perPage)->onEachSide(1);

        $withdrawals->map(function($withdrawal){
            $html = view('user.report.components.withdrawal-pending-row', ['withdrawal' => $withdrawal]);

            if ($html instanceof View){
                $withdrawal->html = $html->render();
            }
        });

        $factory = app(ResponseFactory::class);
        return $factory->json($withdrawals);
    }

    /**
     * View Withdrawal Complete Report Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function withdrawalCompleteReport(Request $request): JsonResponse
    {
        $perPage = (isset($request->per_page) && is_numeric($request->per_page))? $request->per_page: 10;
        $withdrawals = Withdrawal::where('user_id', Auth::id())
        ->where('status', WithdrawalStatus::COMPLETED->value)
        ->orderByDesc('id')->paginate($perPage)->onEachSide(1);

        $withdrawals->map(function($withdrawal){
            $html = view('user.report.components.withdrawal-complete-row', ['withdrawal' => $withdrawal]);

            if ($html instanceof View){
                $withdrawal->html = $html->render();
            }
        });

        $factory = app(ResponseFactory::class);
        return $factory->json($withdrawals);
    }

    /**
     * View Withdrawal Reject Report Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function withdrawalRejectReport(Request $request): JsonResponse
    {
        $perPage = (isset($request->per_page) && is_numeric($request->per_page))? $request->per_page: 10;
        $withdrawals = Withdrawal::where('user_id', Auth::id())
        ->where('status', WithdrawalStatus::REJECTED->value)
        ->orderByDesc('id')->paginate($perPage)->onEachSide(1);

        $withdrawals->map(function($withdrawal){
            $html = view('user.report.components.withdrawal-complete-row', ['withdrawal' => $withdrawal]);

            if ($html instanceof View){
                $withdrawal->html = $html->render();
            }
        });

        $factory = app(ResponseFactory::class);
        return $factory->json($withdrawals);
    }

    /**
     * View Coin Purchase Report Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function coinPurchaseReportPage(Request $request): View|JsonResponse
    {
        if(IS_API_REQUEST){
            $perPage = (isset($request->per_page) && is_numeric($request->per_page))? $request->per_page: 10;
            $coinOrders = CoinOrder::where('user_id', Auth::id())
            ->where('status', '<>', CoinBuyStatus::PENDING->value)
            ->where('status', '<>', CoinBuyStatus::CANCELED->value)
            ->with(['payment', 'coin_table'])
            ->orderByDesc('id')
            ->paginate($perPage)->onEachSide(1);

            $coinOrders->map(function($coinOrder){
                $html = view('user.report.components.coin-purchase-row', ['coinOrder' => $coinOrder]);

                if ($html instanceof View){
                    $coinOrder->html = $html->render();
                }
            });

            $factory = app(ResponseFactory::class);
            return $factory->json($coinOrders);
        }
        return ViewFactory::make("user.report.coin-purchase-report");
    }

    /**
     * View Coin Exchange Report Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function coinExchangeReportPage(Request $request): View|JsonResponse
    {
        if(IS_API_REQUEST){
            $perPage = (isset($request->per_page) && is_numeric($request->per_page))? $request->per_page: 15;
            $coinExchanges = CoinExchange::where('user_id', Auth::id())
            ->with(['f_coin', 't_coin'])
            ->orderByDesc('id')->paginate($perPage)
            ->onEachSide(1);

            $coinExchanges->map(function($coinExchange){
                $html = view('user.report.components.coin-exchange-row', ['coinExchange' => $coinExchange]);

                if ($html instanceof View){
                    $coinExchange->html = $html->render();
                }
            });

            $factory = app(ResponseFactory::class);
            return $factory->json($coinExchanges);
        }
        return ViewFactory::make("user.report.coin-exchange-report");
    }

    /**
     * View Coin Staking Report Page
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Contracts\View\View|\Illuminate\Http\JsonResponse
     */
    public function coinStakingReportPage(Request $request): View|JsonResponse
    {
        if(IS_API_REQUEST){
            $perPage = (isset($request->per_page) && is_numeric($request->per_page))? $request->per_page: 10;

            $stakePlan =
            Stake::where('user_id', Auth::id())
                ->when(isset($request->coin),function ($query) use($request) {
                    return $query->where('coin', $request->coin);
                })
                ->when(isset($request->search),function ($query) use($request) {
                    return $query->where(function($q)use($request){
                        return $q->where('amount',   "LIKE", "%$request->search%")
                        ->orWhere('interest', "LIKE", "%$request->search%")
                        ->orWhere('created_at', "LIKE", "%$request->search%")
                        ->orWhere('end_at', "LIKE", "%$request->search%")
                        ->orWhere('status', "LIKE", "%$request->search%");
                    });
                })
                ->orderBy('id', 'DESC')->paginate($perPage)->onEachSide(1);

            $stakePlan->map(function($item){
                $html =  view('user.report.components.coin-staking-row', ['plan' => $item]);
                
                if ($html instanceof View){
                    $item->html = $html->render();
                }
            });

            $factory = app(ResponseFactory::class);
            return $factory->json($stakePlan);
        }
        return ViewFactory::make("user.report.coin-staking-report");
    }
}
