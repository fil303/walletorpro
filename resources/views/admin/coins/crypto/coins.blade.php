@extends('layout.app', [ "menu" => "coins" ])

@section('title', __('Coin Management'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Coin Management') }}</h2>
                <a href="{{ route('addCoinPage') }}" class="btn btn-primary">{{ __('Add Crypto') }}</a>
            </div>

            <div class="overflow-x-auto">
                <table id="table" class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>{{ _t('Name') }}</th>
                            <th>{{ _t('Coin') }}</th>
                            <th>{{ _t('Rate') }}</th>
                            <th>{{ _t('Status') }}</th>
                            <th>{{ _t('Actions') }}</th>
                        </tr>
                    </thead>
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
                .dataTableService("crypto_coin_table")
                .setCongif({
                    ...dataTableOption,
                    columns: [{
                            "data": "name"
                        },
                        {
                            "data": "coin"
                        },
                        {
                            "data": "rate"
                        },
                        {
                            "data": "status",
                            "orderable": false
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

        function updateStatus($id) {
            $.post(
                '{{ route('coinStatusUpdate') }}', {
                    _token: '{{ csrf_token() }}',
                    uid: $id
                },
                (response) => {
                    if (response.status) {
                        Notiflix.Notify.success(response.message || '{{ __("Success") }}');
                    } else {
                        Notiflix.Notify.failure(response.message || '{{ __("Failed") }}');
                    }
                }
            )
        }
    </script>
@endsection
