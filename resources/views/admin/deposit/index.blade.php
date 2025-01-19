@extends('layout.app', [ "menu" => "deposit_report" ])

@section('title', __('Deposit History'))

@section('content')
    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">{{ __('Deposit History') }}</h2>
            <div class="tab-contents mt-6">
                <!-- Deposit Table -->
                <div id="deposit" class="active">
                    <div class="overflow-x-auto">
                        <table id="depositTable" class="table w-full">
                            <thead>
                                <tr>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Type') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    <th>{{ __('Amount') }}</th>
                                    <th>{{ __('Transition Hash') }}</th>
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
                .dataTableService('depositTable')
                .setNodeSeletor('#depositTable')
                .setCongif({
                    ...dataTableOption,
                    columns: [{
                            data: 'user'
                        },
                        {
                            data: 'type'
                        },
                        {
                            data: 'from_address'
                        },
                        {
                            data: 'amount'
                        },
                        {
                            data: 'trx'
                        },
                        {
                            data: 'created_at'
                        },
                    ]
                })
                .exit()

                .boot();
        });
    </script>

@endsection
