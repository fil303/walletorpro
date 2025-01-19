@extends('layout.app', [ 'menu' => 'faq' ])

@section('title', __('FAQ Management'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('FAQ Management') }}</h2>
                <a href="{{ route('addEditFaqPage') }}" class="btn btn-primary ">{{ __('Add FAQ') }}</a>
            </div>

            <div class="overflow-x-auto">
                <table id="table" class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>{{ __('Question') }}</th>
                            <th>{{ __('Answor') }}</th>
                            <th>{{ __('Page') }}</th>
                            <th>{{ __('Language') }}</th>
                            <th>{{ __('Status') }}</th>
                            <th>{{ __('Actions') }}</th>
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
                .dataTableService("faq_table")
                .setCongif({
                    ...dataTableOption,
                    order: [0, 'asc'],
                    columns: [{
                            "data": "question"
                        },
                        {
                            "data": "answer"
                        },
                        {
                            "data": "page"
                        },
                        {
                            "data": "lang"
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


        function updateFaqStatus(id) {
            $.post(
                '{{ route('updateFaqStatus') }}' + id, {
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
