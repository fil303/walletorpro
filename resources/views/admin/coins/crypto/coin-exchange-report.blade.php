@extends('layout.app', [ "menu" => "coin_purchase_report" ])

@section('title', __('Stake Report'))

@section('content')

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">{{ __('Coin Exchange Report') }}</h2>

            <div class="overflow-x-auto">
                <table id="table" class="table">
                    <thead>
                        <tr>
                            <th>{{ __('User') }}</th>
                            <th>{{ __('From') }}</th>
                            <th>{{ __('To') }}</th>
                            <th>{{ __('Rate') }}</th>
                            <th>{{ __('Fees') }}</th>
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
                { "data": "from" },
                { "data": "to" },
                { "data": "rate" },
                { "data": "fees" },
                { "data": "created_at" },
            ]
        });
    </script>
@endsection
