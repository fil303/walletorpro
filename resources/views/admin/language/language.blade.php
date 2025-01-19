@extends('layout.app')

@section('title', __('Language Management'))

@section('content')

    <h2 class="card-title">{{ __('Language Management') }}</h2>
    <div class="divider"></div>

    <a href="{{ route('addEditLanguagePage') }}" class="btn btn-primary w-1/6">{{ __('Add Language') }}</a>
    <div class="overflow-x-auto">
        <table id="table" class="table">
            <!-- head -->
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Code</th>
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
                    "data": "status",
                    "orderable": false
                },
                {
                    "data": "action",
                    "orderable": false
                }
            ]
        });

        function updateLanguageStatus(id) {
            $.post(
                '{{ route('updateLanguageStatus') }}' + id, {
                    _token: '{{ csrf_token() }}',
                    uid: id
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
