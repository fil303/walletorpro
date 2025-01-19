@extends('layout.app', [ 'menu' => 'payment' ])

@section('title', __('Automated Gateway'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">{{ __('Automated Gateway') }}</h2>

            <div class="overflow-x-auto">
                <table id="table" class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>{{ __('Gateway') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
                        </tr>
                    </thead>
                </table>
            </div>


@endsection
@section('downjs')
    <script>
        function updateGatewayStatus(uid) {

            $.post(
                '{{ route('updateGatewayStatus') }}', {
                    _token: '{{ csrf_token() }}',
                    uid: uid
                },
                (response) => {
                    if (response.status) {
                        Notiflix.Notify.success(response.message);
                    } else {
                        Notiflix.Notify.failure(response.message);
                    }
                }
            );

        }

        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService
                // DataTable
                .newInstance()
                .dataTableService("table")
                .setCongif({
                    ...dataTableOption,
                    order: [0, 'asc'],
                    columns: [{
                            "data": "gateway"
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
    </script>
@endsection
