<?php

namespace App\Http\Controllers\Admin;

use App\Enums\StakingStatus;
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
use App\Models\SupportTicket;
use App\Enums\WithdrawalStatus;
use App\Enums\SupportTicketStatus;
use App\Http\Controllers\Controller;

class DashboardController extends Controller
{
    public function __construct(){}

    /**
     * Get Admin Dashboard Page
     * @return mixed
     */
    public function dashboard(): mixed
    {
        $data['total_users']      = User::where('role', '<>', 1)->count();
        $data['active_users']     = User::where('status', "active")->where('role', '<>', 1)->count();
        $data['total_coins']      = Wallet::join('coins','coins.coin','=','wallets.coin')->selectRaw('sum(wallets.balance * coins.rate) as usd_value')->first()->usd_value ?? 0;
        $data['active_coins']     = Coin::where('status', Status::ENABLE->value)->count();
        $data['total_ticket']     = SupportTicket::count();
        $data['pending_ticket']   = SupportTicket::where('status',  SupportTicketStatus::PENDING->value)->count();
        $data['open_ticket']      = SupportTicket::where('status',  SupportTicketStatus::OPEN->value)->count();
        $data['closed_ticket']    = SupportTicket::where('status',  SupportTicketStatus::CLOSED->value)->count();
        $data['total_exchange']   = CoinExchange::count();
        $data['total_purchase']   = CoinOrder::count();
        $data['pending_withdraw'] = Withdrawal::where('status', WithdrawalStatus::PENDING->value)->count();
        $data['success_withdraw'] = Withdrawal::join('coins','coins.id','=','withdrawals.coin_id')->where('withdrawals.status', WithdrawalStatus::COMPLETED->value)->selectRaw('sum(withdrawals.amount * coins.rate) as usd_value')->first()->usd_value ?? 0;
        $data['total_staking']    = Stake::count();
        $data['active_staking']   = Stake::where('status', StakingStatus::IMMATURE->value)->count();
        $data['total_deposit']    = Deposit::join('coins','coins.id','=','deposits.coin_id')->selectRaw('sum(deposits.amount * coins.rate) as usd_value')->first()->usd_value ?? 0;
        $data['total_earning']    = 0;

        // Monthly deposits with all months
        $months = array_fill(1, 12, 0);
        $data['monthly_deposits'] = Deposit::join('coins', 'coins.coin', '=', 'deposits.coin')
        ->selectRaw('MONTH(deposits.created_at) as month, SUM(deposits.amount * coins.rate) as usd_value')
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

        // Top 10 sold coins
        $data['top_sold_coins'] = CoinOrder::join('coins', 'coins.id', '=', 'coin_orders.coin_id')
            ->selectRaw('coin_orders.coin, SUM(coin_orders.amount * coins.rate) as usd_value')
            ->groupBy('coin_orders.coin')
            ->orderBy('usd_value', 'desc')
            ->limit(10)
            ->get();

        $top_sold_coins = $data['top_sold_coins']->pluck('coin')->toArray();
        $top_sold_coins_amount = $data['top_sold_coins']->pluck('usd_value')->toArray();
        $data['top_sold_coins'] = implode("','", $top_sold_coins);
        $data['top_sold_coins_amount'] = implode(',', $top_sold_coins_amount);


        // Tickets Chart Data
        $ticketChartData[] = SupportTicket::where('status', SupportTicketStatus::PENDING->value)->count();
        $ticketChartData[] = SupportTicket::where('status', SupportTicketStatus::OPEN->value)->count();
        $ticketChartData[] = SupportTicket::where('status', SupportTicketStatus::CLOSED->value)->count();
        $data['ticketChartData'] = implode(',',$ticketChartData);

        $data['deposit_reports'] = Deposit::with('coin_table')->orderByDesc('id')->limit(5)->get();
        $data['pending_withdrawal_reports'] = Withdrawal::with('coin_table')->where('status', WithdrawalStatus::PENDING->value)->orderByDesc('id')->limit(5)->get();
        $data['pending_ticket_reports'] = SupportTicket::where('status', SupportTicketStatus::PENDING->value)->orderByDesc('id')->limit(5)->get();
        return view("admin.dashboard.index", $data);
    }
}
