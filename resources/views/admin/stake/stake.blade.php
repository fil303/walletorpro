@extends('layout.app', [ 'open_staking_menu' => true, 'menu' => 'staking', 'sub_menu' => 'staking_plan' ])

@section('title', __('Stake Management'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Stake Plan Management') }}</h2>
                <a href="{{ route('createStakePage') }}" class="btn btn-primary">{{ __('Create Stakeing Plan') }}</a>
            </div>

            <div class="overflow-x-auto">
                <table id="table" class="table">
                    <thead>
                        <tr>
                            <th>Coin</th>
                            <th>Minimum</th>
                            <th>Maximum</th>
                            <th>Durations & Interest</th>
                            <th>Status</th>
                            <th>Date</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>

@endsection
@section('downjs')
    <script>
        let table = new DataTable("#table", {
            processing: true,
            serverSide: true,
            paging: true,
            searching: true,
            ordering: true,
            select: false,
            bDestroy: true,
            order: [0, 'asc'],
            responsive: true,
            autoWidth: false,
            language: {
                "decimal": "",
                "emptyTable": "{{ __('No data available in table') }}",
                "info": "{{ __('Showing') }} _START_ to _END_ of _TOTAL_ {{ __('entries') }}",
                "infoEmpty": "{{ __('Showing') }} 0 to 0 of 0 {{ __('entries') }}",
                "infoFiltered": "({{ __('filtered from') }} _MAX_ {{ __('total entries') }})",
                "infoPostFix": "",
                "thousands": ",",
                "lengthMenu": "{{ __('Show') }} _MENU_ {{ __('entries') }}",
                "loadingRecords": "{{ __('Loading...') }}",
                "processing": "",
                "search": "{{ __('Search') }}:",
                "zeroRecords": "{{ __('No matching records found') }}",
                "paginate": {
                    "first": "{{ __('First') }}",
                    "last": "{{ __('Last') }}",
                    "next": "{{ __('Next') }} &#8250;",
                    "previous": "&#8249; {{ __('Previous') }}"
                },
                "aria": {
                    "sortAscending": ": activate to sort column ascending",
                    "sortDescending": ": activate to sort column descending"
                }
            },
            columns: [{
                    "data": "coin"
                },
                {
                    "data": "min"
                },
                {
                    "data": "max"
                },
                {
                    "data": "duration"
                },
                {
                    "data": "status"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "action",
                    "orderable": false
                }
            ]
        });

        function changeStatusStakePlan(id) {
            $.post(
                '{{ route('changeStatusStakePlan') }}', {
                    _token: '{{ csrf_token() }}',
                    id: id
                },
                (response) => {
                    if (response.status) {
                        Notiflix.Notify.success(response.message);
                    } else {
                        Notiflix.Notify.failure(response.message);
                    }
                }
            )
        }
    </script>
@endsection
