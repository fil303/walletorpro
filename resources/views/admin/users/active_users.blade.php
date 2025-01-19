@extends('layout.app', [ 'open_user_menu' => true, 'menu' => 'user_management', 'sub_menu' => 'active_user' ])

@section('title', __('User Management'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">{{ __('Active Users') }}</h2>
            <div class="overflow-x-auto">
                <table id="table" class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Country') }}</th>
                            <th>{{ __('Verified') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                        </tr>
                    </tbody>
                    <tfoot>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Email') }}</th>
                            <th>{{ __('Country') }}</th>
                            <th>{{ __('Verified') }}</th>
                            <th>{{ __('Action') }}</th>
                        </tr>
                    </tfoot>
                </table>
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
                .dataTableService("active_user_table")
                .setCongif({
                    ...dataTableOption,
                    columns: [{
                            "data": "name"
                        },
                        {
                            "data": "email"
                        },
                        {
                            "data": "country"
                        },
                        {
                            "data": "email_verified_at"
                        },
                        {
                            "data": "action",
                            "orderable": false
                        }
                    ]
                })
                .setNodeSeletor('#table')

                .exit()
                .boot();
        });
    </script>
@endsection
