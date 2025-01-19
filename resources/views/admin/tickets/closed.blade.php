@extends('layout.app', [ 'open_support_menu' => true, 'menu' => 'support', 'sub_menu' => 'closed' ])

@section('title', __('Pending Tickets'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">{{ __('Closed Tickets') }}</h2>
            <div class="overflow-x-auto">
                <table id="table" class="table">
                    <thead>
                        <tr>
                            <th>{{ __('Subject') }}</th>
                            <th>{{ __('Submitted By') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Priority') }}</th>
                            <th>{{ __('Last Reply') }}</th>
                            <th>{{ __('Action') }}</th>
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
            ...dataTableOption,
            columns: [{
                    "data": "subject"
                },
                {
                    "data": "user"
                },
                {
                    "data": "status"
                },
                {
                    "data": "priority"
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
