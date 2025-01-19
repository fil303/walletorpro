@extends('layout.app', [ "menu" => "withdrawal_report" ])

@section('title', __('Withdrawal Requests'))

@section('content')


    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">{{ __('Withdrawal History') }}</h2>

            <div class="tabs tabs-boxed">
                <a class="tab tab-active" data-tab="pending">Pending</a>
                <a class="tab" data-tab="confirmed">Confirmed</a>
                <a class="tab" data-tab="rejected">Rejected</a>
            </div>

            <div class="tab-contents mt-6">
                <!-- Pending Withdrawals Table -->
                <div id="pending" class="active">
                    <div class="overflow-x-auto">
                        <table id="pendingTable" class="table w-full">
                            <thead>
                                <tr>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Date') }}</th>
                                    <th>{{ __('Action') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- Confirmed Withdrawals Table -->
                <div id="confirmed" class="hidden">
                    <div class="overflow-x-auto">
                        <table id="confirmedTable" class="table w-full">
                            <thead>
                                <tr>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Date') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>

                <!-- Rejected Withdrawals Table -->
                <div id="rejected" class="hidden">
                    <div class="overflow-x-auto">
                        <table id="rejectedTable" class="table w-full">
                            <thead>
                                <tr>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Status') }}</th>
                                    <th>{{ __('Date') }}</th>
                                </tr>
                            </thead>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


@endsection
@section('downjs')



    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService
                // DataTable
                .newInstance()
                .dataTableService('pendingTable')
                .setNodeSeletor('#pendingTable')
                .setCongif({
                    ...dataTableOption,
                    ajax: '{{ route('withdrawalPendingList') }}',
                    columns: [{
                            data: 'user'
                        },
                        {
                            data: 'type'
                        },
                        {
                            data: 'to_address'
                        },
                        {
                            data: 'amount'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'created_at'
                        },
                        {
                            data: 'action'
                        }
                    ]
                })
                .exit()

                .newInstance()
                .dataTableService('confirmedTable')
                .setNodeSeletor('#confirmedTable')
                .setCongif({
                    ...dataTableOption,
                    ajax: '{{ route('withdrawalConfirmList') }}',
                    columns: [{
                            data: 'user'
                        },
                        {
                            data: 'type'
                        },
                        {
                            data: 'to_address'
                        },
                        {
                            data: 'amount'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'created_at'
                        },
                    ]
                })
                .exit()

                .newInstance()
                .dataTableService('rejectedTable')
                .setNodeSeletor('#rejectedTable')
                .setCongif({
                    ...dataTableOption,
                    ajax: '{{ route('withdrawalRejectList') }}',
                    columns: [{
                            data: 'user'
                        },
                        {
                            data: 'type'
                        },
                        {
                            data: 'to_address'
                        },
                        {
                            data: 'amount'
                        },
                        {
                            data: 'status'
                        },
                        {
                            data: 'created_at'
                        },
                    ]
                })
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
