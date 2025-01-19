@extends('layout.app', [ 'open_user_menu' => true, 'menu' => 'user_management', 'sub_menu' => 'user_wallet_list' ])

@section('title', __('User Wallet List'))

@section('content')
    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">{{ __('User Wallet List') }}</h2>
            <div class="tab-contents mt-6">
                <!-- User Wallet Table -->
                <div id="deposit" class="active">
                    <div class="overflow-x-auto">
                        <table id="depositTable" class="table w-full">
                            <thead>
                                <tr>
                                    <th>{{ __('User') }}</th>
                                    <th>{{ __('Coin') }}</th>
                                    <th>{{ __('Address') }}</th>
                                    <th>{{ __('Balance') }}</th>
                                    <th>{{ __('Last Update') }}</th>
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
                            data: 'user',
                            searchable: true
                        },
                        {
                            data: 'coin',
                            searchable: true
                        },
                        {
                            data: 'address',
                            searchable: true
                        },
                        {
                            data: 'balance',
                            searchable: true
                        },
                        {
                            data: 'updated_at',
                            searchable: true
                        },
                    ]
                })
                .exit()

                .boot();
        });
    </script>

@endsection
