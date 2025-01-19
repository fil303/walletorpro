@extends('layout.app', [ 'open_report_menu' => true, 'menu' => 'report', 'sub_menu' => 'staking' ])

@section('title', __('Deposit Report'))

@section('content')

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">{{ __('Coin Staking Report') }}</h2>
            <div class="response_data_coin_staking">
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
                    <th>{{ __('Amount') }}</th>
                    <th>{{ __('Interest | Percent') }}</th>
                    <th>{{ __('Total Return') }}</th>
                    <th>{{ __('Start Date') }}</th>
                    <th>{{ __('End Date') }}</th>
                    <th>{{ __('Status') }}</th>
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
                .paginationService("coinStakingTable")
                .setBeforeResponse(top_table)
                .setAfterResponse(bottom_table)
                .setUtility(false)
                .setResourcesPath('{{ route("coinStakingReportPage") }}')
                .setPage({{ isset($page) ? $page : 1 }})
                .renderAt(".response_data_coin_staking")
                .exit()

                .boot();
        });
    </script>
@endsection
