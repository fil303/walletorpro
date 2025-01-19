@extends('layout.app', [ 'open_report_menu' => true, 'menu' => 'report', 'sub_menu' => 'purchase' ])

@section('title', __('Deposit Report'))

@section('content')

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">{{ __('Coin Purchase Report') }}</h2>
            <div class="response_data_coin_purchase">
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
                .paginationService("coinPurchaseTable")
                .setBeforeResponse(top_table)
                .setAfterResponse(bottom_table)
                .setUtility(false)
                .setResourcesPath('{{ route("coinPurchaseReportPage") }}')
                .setPage({{ isset($page) ? $page : 1 }})
                .renderAt(".response_data_coin_purchase")
                .exit()

                .boot();
        });
    </script>
@endsection
