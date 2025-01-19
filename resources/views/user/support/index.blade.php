@extends('layout.app', [ "menu" => "support" ])

@section('title', __('Support Center'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex flex-wrap justify-between items-center mt-2">
                <div>
                    <h2 class="card-title">{{ __('Support Center') }}</h2>
                </div>
                <div class="flex justify-between">
                    <div class="mr-2">
                        <a href="{{ route('openNewSupportTicketPage') }}" class="btn btn-primary">{{ __('Open Ticket') }}</a>
                    </div>
                </div>
            </div>

            <div class="response_data_coin">
                <div class="text-center">{{ __('No Support Ticket Data Available') }}</div>
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
                    <th>{{ __('Subject') }}</th>
                    <th>{{ __('Priority') }}</th>
                    <th>{{ __('Status') }}</th>
                    <th>{{ __('Last Preplay') }}</th>
                    <th>{{ __('Created At') }}</th>
                    <th>{{ __('Action') }}</th>
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
                .paginationService("stakeTable")
                .setBeforeResponse(top_table)
                .setAfterResponse(bottom_table)
                .setUtility(false)
                .setResourcesPath('{{ route('supportPage') }}')
                .setPage({{ isset($page) ? $page : 1 }})
                .renderAt(".response_data_coin")
                .exit()

                .boot();
        });
    </script>
@endsection
