@extends('layout.app', [ "menu" => "dashboard" ])
@section('title', __('Admin Dashboard'))

@section('content')
<div class="container mx-auto p-6 space-y-8">

    <!-- Top Summary Cards -->
    <div class="card bg-base-100">
        <div class="card-body">
            @include('user.dashboard.summary_cards')
        </div>
    </div>

    <!-- Transaction & User Overview Charts -->
    <div class="grid sm:block grid-cols-2 md:grid-cols-1 gap-6">
        <div class="card bg-base-100 col-span-2 shadow-lg p-6 sm:mb-6">
            <h2 class="card-title">{{ __('Monthly Transactions In USD') }}</h2>
            <canvas id="transactionChart" class="h-64"></canvas>
        </div>
        <div class="card bg-base-100 shadow-lg p-6 sm:mb-6">
            <h2 class="card-title">{{ __('Coin Purchase Analytics') }}</h2>
            <canvas id="coinPurchaseChart" class="h-64"></canvas>
        </div>
        <div class="card bg-base-100 shadow-lg p-6 sm:mb-6">
            <h2 class="card-title">{{ __('Ticket System Status') }}</h2>
            <canvas id="ticketChart" class="h-48"></canvas>
        </div>
    </div>

    <!-- Recent User Deposit Data -->
    @if (isset($deposit_reports[0]))
        <div class="card bg-base-100 shadow-lg p-4 mt-6">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Recent Deposits') }}</h2>
                <a href="#" class="btn btn-xs hover:bg-white/20">{{ __('View More') }} →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>{{ __('Date') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Coin') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Type') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($deposit_reports ?? [] as $deposit)
                        <tr>
                            <td>{{ date('M d, Y, h:i A', strtotime($deposit->created_at ?? '')) }}</td>
                            <td>{{ $deposit->user->email }}</td>
                            <td>{{ $deposit->coin }}</td>
                            <td>{{ print_coin($deposit->amount, $deposit->coin_table->print_decimal ?? 8) }}</td>
                            <td>{{ ucfirst($deposit->type->getTypeName()) }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Withdrawal Requests Table -->
    @if (isset($pending_withdrawal_reports[0]))
        <div class="card bg-base-100 shadow-lg p-4 mt-4">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Pending Withdrawal Requests') }}</h2>
                <a href="#" class="btn btn-xs hover:bg-white/20">{{ __('View More') }} →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>{{ __('Request Date') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('To Address') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Type') }}</th>
                            <th>{{ __('Status') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pending_withdrawal_reports ?? [] as $withdrawal)
                        <tr>
                            <td>{{ date('M d, Y, h:i A', strtotime($withdrawal->created_at ?? '')) }}</td>
                            <td>{{ $withdrawal->user->email }}</td>
                            <td>{{ $withdrawal->to_address }}</td>
                            <td>{{ print_coin($withdrawal->amount, $withdrawal->coin_table->print_decimal ?? 8) }}</td>
                            <td>{{ $withdrawal->type->getTypeName() }}</td>
                            <td><span class="badge bg-warning">{{ __('Pending') }}</span></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif

    <!-- Ticket System Table -->
    @if (isset($pending_ticket_reports[0]))
        <div class="card bg-base-100 shadow-lg p-4 mt-4">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Pending Support Tickets') }}</h2>
                <a href="#" class="btn btn-xs hover:bg-white/20">{{ __('View More') }} →</a>
            </div>
            <div class="overflow-x-auto">
                <table class="table w-full">
                    <thead>
                        <tr>
                            <th>{{ __('Ticket ID') }}</th>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('Subject') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Last Updated') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($pending_ticket_reports ?? [] as $ticket)
                        <tr>
                            <td>#{{ $ticket->ticket }}</td>
                            <td>{{ $ticket->user->email }}</td>
                            <td>{{ $ticket->subject }}</td>
                            <td><span class="badge bg-warning">{{ __("Pending") }}</span></td>
                            <td>{{ date('M d, Y, h:i A', strtotime($ticket->updated_at ?? '')) }}</td>
                            <td><a href="#" class="btn btn-xs btn-primary">{{ __('View') }}</a></td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    @endif
</div>
@endsection

@section('downjs')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    document.addEventListener("DOMContentLoaded", function() {
        // Monthly Transactions Chart
        const transactionChart = new Chart(document.getElementById('transactionChart'), {
            type: 'line',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [
                    { label: "{{ __('Deposits') }}",    data: [{{ $monthly_deposits ?? 0 }}], borderColor: "#34d399" },
                    { label: "{{ __('Withdrawals') }}", data: [{{ $monthly_withdrawals ?? 0 }}], borderColor: "#f87171" }
                ]
            },
            options: { responsive: true, maintainAspectRatio: true }
        });

        // User Growth & Activity Chart
        const userChart = new Chart(document.getElementById('userChart'), {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun", "Jul", "Aug", "Sep", "Oct", "Nov", "Dec"],
                datasets: [
                    { label: "New Users", data: [{{ $monthly_new_users ?? 0 }}], backgroundColor: "#60a5fa" },
                    { label: "Active Users", data: [{{ $monthly_active_users ?? 0 }}], backgroundColor: "#fbbf24" }
                ]
            },
            options: { responsive: true, maintainAspectRatio: true }
        });

        // Coin Purchase Chart
        const coinPurchaseChart = new Chart(document.getElementById('coinPurchaseChart'), {
            type: 'bar',
            data: {
                labels: ['{!! $top_sold_coins ?? "BTC, USDT, ETH, DOGE" !!}'],
                datasets: [{
                    label: "{{ __('Purchase Volume') }}",
                    data: [{{ $top_sold_coins_amount ?? "10,0,0,0" }}],
                    backgroundColor: [
                        '#F7931A',
                        '#627EEA',
                        '#26A17B',
                        '#F3BA2F',
                        '#23292F',
                        '#DC1FFF'
                    ]
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: true,
                scales: {
                    y: {
                        beginAtZero: true,
                        title: {
                            display: true,
                            text: 'Volume'
                        }
                    }
                },
                plugins: {
                    legend: {
                        display: true,
                        position: 'top'
                    },
                    title: {
                        display: false
                    }
                }
            }
        });

        // Ticket System Status Chart
        const ticketChart = new Chart(document.getElementById('ticketChart'), {
            type: 'doughnut',
            data: {
                labels: ['{{__("Pending")}}', '{{__("Open")}}', '{{__("Closed")}}'],
                datasets: [{
                    data: [{{ $ticketChartData ?? '0,0,0' }}],
                    backgroundColor: ["#fcd34d", "#4ade80", "#f87171"]
                }]
            },
            options: { responsive: true, maintainAspectRatio: true }
        });
    });
</script>
@endsection
