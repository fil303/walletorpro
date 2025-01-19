@extends('layout.app', [ "menu" => "coin_order_report" ])

@section('title', __('Stake Report'))

@section('content')

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">{{ __('Coin Purchase Report') }}</h2>

            <div class="overflow-x-auto">
                <table id="table" class="table">
                    <thead>
                        <tr>
                            <th>{{ __("User") }}</th>
                            <th>{{ __('Coin') }}</th>
                            <th>{{ __('Rate') }}</th>
                            <th>{{ __('Amount') }}</th>
                            <th>{{ __('Fees') }}</th>
                            <th>{{ __('Paid') }}</th>
                            <th>{{ __('Payment By') }}</th>
                            <th>{{ __('Transaction ID') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Date') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('downjs')
    <script>
        let table = new DataTable("#table", {
            ...dataTableOption,
            columns: [
                { "data": "user" },
                { "data": "coin" },
                { "data": "rate" },
                { "data": "amount" },
                { "data": "fees" },
                { "data": "paid" },
                { "data": "paymentBy" },
                { "data": "transaction_id" },
                { "data": "status" },
                { "data": "created_at" },
            ]
        });
    </script>
@endsection