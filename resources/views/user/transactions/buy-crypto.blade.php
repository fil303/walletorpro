@extends('layout.app')

@section('title', __('Crypto Buy Transactions'))

@section('content')

    <h2 class="card-title">{{ __('Crypto Buy Transactions') }}</h2>
    <div class="divider"></div>

    <div class="response_data_coin">
        <div class="text-center">{{ __('No Data Available') }}</div>
    </div>

@endsection
@section('downjs')
    <script>
        let top_table = `
        
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('Spend') }}</th>
                        <th>{{ __('Receive') }}</th>
                        <th>{{ __('Fees') }}</th>
                        <th>{{ __('Rate') }}</th>
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
                .paginationService("pagination1")
                .setBeforeResponse(top_table)
                .setAfterResponse(bottom_table)
                .setResourcesPath('{{ route('cryptoTransactions') }}')
                .setPage({{ isset($page) ? $page : 1 }})
                .renderAt(".response_data_coin")
                .exit()

                .boot();
        });
    </script>
@endsection
