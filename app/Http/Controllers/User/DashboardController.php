<?php

namespace App\Http\Controllers\User;

use App\Models\Coin;
use App\Models\User;
use App\Enums\Status;
use App\Models\Stake;
use App\Models\Wallet;
use App\Models\Deposit;
use App\Enums\UserStatus;
use App\Models\CoinOrder;
use App\Models\Withdrawal;
use App\Models\CoinExchange;
use Illuminate\Http\Request;
use App\Models\SupportTicket;
use App\Enums\WithdrawalStatus;
use App\Enums\SupportTicketStatus;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class DashboardController extends Controller
{
    public function __construct(){}

    /**
     * View User Dashboard
     * @return mixed
     */
    public function dashboard(): mixed
    {
        $total_coins = Wallet::join('coins','coins.coin','=','wallets.coin')->where('user_id', Auth::id())->selectRaw('sum(wallets.balance * coins.rate) as usd_value')->first()->usd_value ?? 0;
        $total_deposit_coins = Deposit::join('coins','coins.coin','=','deposits.coin')->where('user_id', Auth::id())->selectRaw('sum(deposits.amount * coins.rate) as usd_value')->first()->usd_value ?? 0;
        $total_withdrawal_coins = Withdrawal::join('coins','coins.id','=','withdrawals.coin_id')->where('user_id', Auth::id())->selectRaw('sum(withdrawals.amount * coins.rate) as usd_value')->first()->usd_value ?? 0;
        
        $data['total_coins']      = $total_coins;
        $data['total_deposit']    = $total_deposit_coins;
        $data['success_withdraw'] = $total_withdrawal_coins;
        $data['pending_ticket']   = SupportTicket::where('status',  SupportTicketStatus::PENDING->value)->count();
        $data['active_staking']   = Stake::where('status', Status::ENABLE->value)->where('user_id', Auth::id())->count();
        $data['coin_exchanged']   = CoinExchange::where('user_id', Auth::id())->count();
        $data['coin_purchase']    = CoinOrder::join('coins','coins.id','=','coin_orders.coin_id')->where('user_id', Auth::id())->selectRaw('sum(coin_orders.amount * coins.rate) as usd_value')->first()->usd_value ?? 0;

        // Monthly deposits with all months
        $months = array_fill(1, 12, 0);
        $data['monthly_deposits'] = Deposit::join('coins', 'coins.coin', '=', 'deposits.coin')
        ->selectRaw('MONTH(deposits.created_at) as month, SUM(deposits.amount * coins.rate) as usd_value')
        ->where('deposits.user_id', Auth::id())
        ->whereYear('deposits.created_at', date('Y'))
        ->groupBy('month')
        ->orderBy('month')
        ->get()
        ->pluck('usd_value', 'month')
        ->toArray();

        $data['monthly_deposits'] = array_replace($months, $data['monthly_deposits']);
        $data['monthly_deposits'] = implode(',',$data['monthly_deposits']);

        // Monthly withdrawals with all months 
        $data['monthly_withdrawals'] = Withdrawal::join('coins', 'coins.id', '=', 'withdrawals.coin_id')
            ->selectRaw('MONTH(withdrawals.created_at) as month, SUM(withdrawals.amount * coins.rate) as usd_value')
            ->where('withdrawals.user_id', Auth::id())
            ->whereYear('withdrawals.created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('usd_value', 'month')
            ->toArray();

        $data['monthly_withdrawals'] = array_replace($months, $data['monthly_withdrawals']);
        $data['monthly_withdrawals'] = implode(',',$data['monthly_withdrawals']);

        // 
        $data['monthly_new_users'] = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $data['monthly_new_users'] = array_replace($months, $data['monthly_new_users']);
        $data['monthly_new_users'] = implode(',',$data['monthly_new_users']);

        $data['monthly_active_users'] = User::selectRaw('MONTH(created_at) as month, COUNT(*) as count')
            ->where('status', UserStatus::ACTIVE->value)
            ->whereYear('created_at', date('Y'))
            ->groupBy('month')
            ->orderBy('month')
            ->get()
            ->pluck('count', 'month')
            ->toArray();

        $data['monthly_active_users'] = array_replace($months, $data['monthly_active_users']);
        $data['monthly_active_users'] = implode(',',$data['monthly_active_users']);

        // Add this before existing code
        $data['top_sold_coins'] = CoinOrder::select('coin', DB::raw('COUNT(*) as total_sales'))
            ->where('user_id', Auth::id())
            ->groupBy('coin')
            ->orderBy('total_sales', 'desc')
            ->limit(10)
            ->get();

        $top_sold_coins = $data['top_sold_coins']->pluck('coin')->toArray();
        $top_sold_coins_amount = $data['top_sold_coins']->pluck('total_sales')->toArray();
        $data['top_sold_coins'] = implode("','", $top_sold_coins);
        $data['top_sold_coins_amount'] = implode(',', $top_sold_coins_amount);


        // Tickets Chart Data
        $ticketChartData[] = SupportTicket::where('user_id', Auth::id())->where('status', SupportTicketStatus::PENDING->value)->count();
        $ticketChartData[] = SupportTicket::where('user_id', Auth::id())->where('status', SupportTicketStatus::OPEN->value)->count();
        $ticketChartData[] = SupportTicket::where('user_id', Auth::id())->where('status', SupportTicketStatus::CLOSED->value)->count();
        $data['ticketChartData'] = implode(',',$ticketChartData);

        $data['deposit_reports'] = Deposit::where('user_id', Auth::id())->with('coin_table')->orderByDesc('id')->limit(5)->get();
        $data['pending_withdrawal_reports'] = Withdrawal::where('user_id', Auth::id())->with('coin_table')->where('status', WithdrawalStatus::PENDING->value)->orderByDesc('id')->limit(5)->get();
        $data['pending_ticket_reports'] = SupportTicket::where('user_id', Auth::id())->where('status', SupportTicketStatus::PENDING->value)->orderByDesc('id')->limit(5)->get();
        return view("user.dashboard.index", $data);
    }
}
