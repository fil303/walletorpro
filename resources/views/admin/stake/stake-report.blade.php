@extends('layout.app', [ 'open_staking_menu' => true, 'menu' => 'staking', 'sub_menu' => 'staking_report' ])

@section('title', __('Stake Report'))

@section('content')

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h2 class="card-title">{{ __('Coin Staking Report') }}</h2>

            <div class="overflow-x-auto">
                <table id="table" class="table">
                    <thead>
                        <tr>
                            <th>{{__("User") }}</th>
                            <th>{{__("Amount") }}</th>
                            <th>{{__("Interest") }}</th>
                            <th>{{__("Total Return") }}</th>
                            <th>{{__("Start Date") }}</th>
                            <th>{{__("Mature Date") }}</th>
                            <th>{{__("Status") }}</th>
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
                    "data": "user"
                },
                {
                    "data": "amount"
                },
                {
                    "data": "interest"
                },
                {
                    "data": "return"
                },
                {
                    "data": "created_at"
                },
                {
                    "data": "end_at"
                },
                {
                    "data": "status"
                },
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
