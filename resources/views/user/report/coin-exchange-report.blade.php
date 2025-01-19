@extends('layout.app', [ 'open_report_menu' => true, 'menu' => 'report', 'sub_menu' => 'exchange' ])

@section('title', __('Deposit Report'))

@section('content')

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">{{ __('Coin Exchange Report') }}</h2>
            <div class="response_data_coin_exchange">
                <div class="text-center">{{ __('No Data Available') }}</div>
            </div>
        </div>
    </div>

@endsection
@section('downjs')
    <script>
        let top_table = `
        <div class="overflow-x-auto">
            <table class="table">
                <thead>
                <tr>
                    <th>{{ __('From') }}</th>
                    <th>{{ __('To') }}</th>
                    <th>{{ __('Rate') }}</th>
                    <th>{{ __('Fees') }}</th>
                    <th>{{ __('Date') }}</th>
                </tr>
                </thead>
                <tbody>
    `;

        let bottom_table = `
                </tbody>
            </table>
        </div>
    
    `;

        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService
                // Pagination Response
                .newInstance()
                .paginationService("coinExchangeTable")
                .setBeforeResponse(top_table)
                .setAfterResponse(bottom_table)
                .setUtility(false)
                .setResourcesPath('{{ route("coinExchangeReportPage") }}')
                .setPage({{ isset($page) ? $page : 1 }})
                .renderAt(".response_data_coin_exchange")
                .exit()

                .boot();
        });
    </script>
@endsection
