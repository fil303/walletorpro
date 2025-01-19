@extends('layout.app', [ 'open_report_menu' => true, 'menu' => 'report', 'sub_menu' => 'deposit' ])

@section('title', __('Deposit Report'))

@section('content')

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">{{ __('Deposit Report') }}</h2>
            <div class="response_data_coin">
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
                    <th>{{ __('Type') }}</th>
                    <th>{{ __('Address') }}</th>
                    <th>{{ __('Amount') }}</th>
                    <th>{{ __('Transition Hash') }}</th>
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
                .paginationService("depositTable")
                .setBeforeResponse(top_table)
                .setAfterResponse(bottom_table)
                .setUtility(false)
                .setResourcesPath('{{ route('depositReportPage') }}')
                .setPage({{ isset($page) ? $page : 1 }})
                .renderAt(".response_data_coin")
                .exit()

                .boot();
        });
    </script>
@endsection
