@extends('layout.app', [ 'open_report_menu' => true, 'menu' => 'report', 'sub_menu' => 'withdrawal' ])

@section('title', __('Withdrawal Requests'))

@section('content')


    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">{{ __('Withdrawal Report') }}</h2>

            <div class="tabs tabs-boxed p-2">
                <a class="tab tab-active" data-tab="pending">Pending</a>
                <a class="tab" data-tab="confirmed">Confirmed</a>
                <a class="tab" data-tab="rejected">Rejected</a>
            </div>

            <div class="tab-contents mt-6">
                <!-- Pending Withdrawals Table -->
                <div id="pending" class="active">
                    <div class="overflow-x-auto">
                        <div class="response_table_pending_withdrawal">
                            <div class="text-center">{{ __('No Data Available') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Confirmed Withdrawals Table -->
                <div id="confirmed" class="hidden">
                    <div class="overflow-x-auto">
                        <div class="response_table_complete_withdrawal">
                            <div class="text-center">{{ __('No Data Available') }}</div>
                        </div>
                    </div>
                </div>

                <!-- Rejected Withdrawals Table -->
                <div id="rejected" class="hidden">
                    <div class="overflow-x-auto">
                        <div class="response_table_reject_withdrawal">
                            <div class="text-center">{{ __('No Data Available') }}</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('downjs')
    <script>

        let top_table_pending = `
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Address') }}</th>
                        <th>{{ __('Coin') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Date') }}</th>
                    </tr>
                    </thead>
                    <tbody>
        `;

        let bottom_table_pending = `
                    </tbody>
                </table>
            </div>
        `;

        let top_table_complete = `
            <div class="overflow-x-auto">
                <table class="table">
                    <thead>
                    <tr>
                        <th>{{ __('Type') }}</th>
                        <th>{{ __('Address') }}</th>
                        <th>{{ __('Coin') }}</th>
                        <th>{{ __('Amount') }}</th>
                        <th>{{ __('Transaction Hash') }}</th>
                        <th>{{ __('Date') }}</th>
                    </tr>
                    </thead>
                    <tbody>
        `;

        let bottom_table_complete = `
                    </tbody>
                </table>
            </div>
        `;


        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService

                // Pagination Response Pending Table
                .newInstance()
                .paginationService("pending_withdrawal")
                .setBeforeResponse(top_table_pending)
                .setAfterResponse(bottom_table_pending)
                .setUtility(false)
                .setResourcesPath('{{ route('withdrawalPendingReport') }}')
                .setPage({{ isset($page) ? $page : 1 }})
                .renderAt(".response_table_pending_withdrawal")
                .exit()

                // Pagination Response Complete Table
                .newInstance()
                .paginationService("complete_withdrawal")
                .setBeforeResponse(top_table_complete)
                .setAfterResponse(bottom_table_complete)
                .setUtility(false)
                .setResourcesPath('{{ route('withdrawalCompleteReport') }}')
                .setPage({{ isset($page) ? $page : 1 }})
                .renderAt(".response_table_complete_withdrawal")
                .exit()
                
                // Pagination Response Reject Table
                .newInstance()
                .paginationService("reject_withdrawal")
                .setBeforeResponse(top_table_complete)
                .setAfterResponse(bottom_table_complete)
                .setUtility(false)
                .setResourcesPath('{{ route('withdrawalRejectReport') }}')
                .setPage({{ isset($page) ? $page : 1 }})
                .renderAt(".response_table_reject_withdrawal")
                .exit()

                .boot();
        });


        const tabs = document.querySelectorAll('.tab');
        const tabContents = document.querySelectorAll('.tab-contents > div');

        tabs.forEach(tab => {
            tab.addEventListener('click', () => {
                const target = tab.dataset.tab;

                // Update active tab
                tabs.forEach(t => t.classList.remove('tab-active'));
                tab.classList.add('tab-active');

                // Show/hide content
                tabContents.forEach(content => {
                    content.classList.add('hidden');
                    if (content.id === target) {
                        content.classList.remove('hidden');
                    }
                });
            });
        });
    </script>

@endsection
