@extends('layout.app')

@section('title', __('Currency Management'))

@section('content')

    <h2 class="card-title">{{ __('Currency Management') }}</h2>
    <div class="divider"></div>

    <div class="overflow-x-auto">
        <table id="table" class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
                    <th>Symbol</th>
                    <th>Rate</th>
                    <th>Status</th>
                    <th>Actions</th>
                </tr>
            </thead>
        </table>
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
                    "data": "name"
                },
                {
                    "data": "code"
                },
                {
                    "data": "symbol"
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
        });

        function updateCurrencyStatus(code) {
            $.post(
                '{{ route('updateCurrencyStatus') }}' + code, {
                    _token: '{{ csrf_token() }}',
                    code: code
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
