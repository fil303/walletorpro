@extends('layout.app')
@section('title', __('Admin Dashboard'))

@section('content')
<div class="container mx-auto p-6 space-y-8">

    <!-- Top Summary Cards (10 Key Metrics) -->
    <div class="grid sm:block grid-cols-4 md:grid-cols-3 gap-6">
        <div class="card bg-{{ $metric['color'] }} text-white shadow-lg p-4">
            <div class="flex justify-between items-start">
                <div>
                    <h2 class="text-sm font-semibold">{{ $metric['label'] }}</h2>
                    <p class="text-2xl font-bold">{{ $metric['value'] }}</p>
                </div>
                <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">

                    </svg>
                </div>
            </div>
            <div class="flex justify-end mt-4">
                <a href="#" class="btn btn-xs btn-ghost text-white hover:bg-white/20">{{ __('View More') }} →</a>
            </div>
        </div>
    </div>

    <!-- Transaction & User Overview Charts -->
    <div class="grid sm:block grid-cols-2 md:grid-cols-1 gap-6">
        <div class="card bg-base-100 shadow-lg p-6">
            <h2 class="card-title">{{ __('Monthly Transactions') }}</h2>
            <canvas id="transactionChart" class="h-64"></canvas>
        </div>
        <div class="card bg-base-100 shadow-lg p-6">
            <h2 class="card-title">{{ __('User Growth & Activity') }}</h2>
            <canvas id="userChart" class="h-64"></canvas>
        </div>
        <div class="card bg-base-100 shadow-lg p-6">
            <h2 class="card-title">{{ __('Coin Purchase Analytics') }}</h2>
            <canvas id="coinPurchaseChart" class="h-64"></canvas>
        </div>
        <div class="card bg-base-100 shadow-lg p-6">
            <h2 class="card-title">{{ __('Ticket System Status') }}</h2>
            <canvas id="ticketChart" class="h-48"></canvas>
        </div>
    </div>

    <!-- Recent User Transactions Table -->
    <div class="card bg-base-100 shadow-lg p-4 mt-6">
        <h2 class="card-title">{{ __('Recent Transactions') }}</h2>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>{{ __('Date') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Coin') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Type') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($transactions ?? [] as $transaction)
                    <tr>
                        <td>{{ $transaction->date }}</td>
                        <td>{{ $transaction->user }}</td>
                        <td>{{ $transaction->coin }}</td>
                        <td>{{ $transaction->amount }}</td>
                        <td>{{ ucfirst($transaction->status) }}</td>
                        <td>{{ ucfirst($transaction->type) }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Withdrawal Requests Table -->
    <div class="card bg-base-100 shadow-lg p-4 mt-4">
        <h2 class="card-title">{{ __('Pending Withdrawal Requests') }}</h2>
        <div class="overflow-x-auto">
            <table class="table w-full">
                <thead>
                    <tr>
                        <th>{{ __('Request Date') }}</th>
                        <th>{{ __('User') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Method') }}</th>
                        <th>{{ __('Status') }}</th>
                        <th>{{ __('Actions') }}</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($withdrawalRequests ?? [] as $request)
                    <tr>
                        <td>{{ $request->date }}</td>
                        <td>{{ $request->user }}</td>
                        <td>{{ $request->amount }}</td>
                        <td>{{ $request->method }}</td>
                        <td><span class="badge bg-warning">{{ __('Pending') }}</span></td>
                        <td>
                            <button class="btn btn-xs btn-success">{{ __('Approve') }}</button>
                            <button class="btn btn-xs btn-error">{{ __('Reject') }}</button>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Ticket System Table -->
    <div class="card bg-base-100 shadow-lg p-4 mt-4">
        <h2 class="card-title">{{ __('Ticket Support System') }}</h2>
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
                    @foreach ($tickets ?? [] as $ticket)
                    <tr>
                        <td>#{{ $ticket->id }}</td>
                        <td>{{ $ticket->user }}</td>
                        <td>{{ $ticket->subject }}</td>
                        <td><span class="badge bg-{{ $ticket->statusColor }}">{{ ucfirst($ticket->status) }}</span></td>
                        <td>{{ $ticket->lastUpdated }}</td>
                        <td><a href="{{ route('tickets.view', $ticket->id) }}" class="btn btn-xs btn-primary">{{ __('View') }}</a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
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
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                datasets: [
                    { label: "Deposits", data: [50, 70, 60, 90, 100, 80], borderColor: "#34d399" },
                    { label: "Withdrawals", data: [30, 60, 45, 80, 70, 65], borderColor: "#f87171" }
                ]
            },
            options: { responsive: true, maintainAspectRatio: true }
        });

        // User Growth & Activity Chart
        const userChart = new Chart(document.getElementById('userChart'), {
            type: 'bar',
            data: {
                labels: ["Jan", "Feb", "Mar", "Apr", "May", "Jun"],
                datasets: [
                    { label: "New Users", data: [20, 40, 50, 80, 90, 110], backgroundColor: "#60a5fa" },
                    { label: "Active Users", data: [15, 30, 35, 65, 75, 95], backgroundColor: "#fbbf24" }
                ]
            },
            options: { responsive: true, maintainAspectRatio: true }
        });

        // Coin Purchase Chart
        const coinPurchaseChart = new Chart(document.getElementById('coinPurchaseChart'), {
            type: 'bar',
            data: {
                labels: ["BTC", "ETH", "USDT", "BNB", "XRP", "SOL"],
                datasets: [{
                    label: "Purchase Volume",
                    data: [45, 59, 80, 35, 28, 48],
                    backgroundColor: [
                        '#F7931A', // BTC
                        '#627EEA', // ETH
                        '#26A17B', // USDT
                        '#F3BA2F', // BNB
                        '#23292F', // XRP
                        '#DC1FFF'  // SOL
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
                labels: ["Pending", "Answered", "Closed"],
                datasets: [{
                    data: [30, 20, 50],
                    backgroundColor: ["#fcd34d", "#4ade80", "#f87171"]
                }]
            },
            options: { responsive: true, maintainAspectRatio: true }
        });
    });
</script>
@endsection
