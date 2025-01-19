@extends('layout.app', [ "menu" => "wallet" ])

@section('title', __('My Wallets'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">{{ __('My Wallets') }}</h2>

            <div class="response_data_coin">
                <div class="text-center">{{ __('No Data Available') }}</div>
            </div>
        </div>
    </div>

@endsection
@section('downjs')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService
                // Pagination Response
                .newInstance()
                .paginationService("pagination1")
                .setBeforeResponse('<div class="grid"><div class="grid grid-cols-2 xl:grid-cols-1 gap-1 mr-1">')
                .setAfterResponse('</div></div>')
                .setResourcesPath('{{ route('cryptoWalletPage') }}')
                .setPage({{ isset($page) ? $page : 1 }})
                .renderAt(".response_data_coin")
                .setUtility(false)
                .exit()

                .boot();
        });
    </script>
@endsection
