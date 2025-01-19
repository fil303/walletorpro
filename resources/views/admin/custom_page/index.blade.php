@extends('layout.app', [ 'open_landing_menu' => true, 'menu' => 'landing', 'sub_menu' => 'custom_page' ])

@section('title', __('Custom Page Management'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Custom Page Management') }}</h2>
                <a href="{{ route('customPageAddEdit') }}" class="btn btn-primary ">{{ __('Add New Page') }}</a>
            </div>

            <div class="overflow-x-auto">
                <table id="table" class="table">
                    <!-- head -->
                    <thead>
                        <tr>
                            <th>{{ __('Name') }}</th>
                            <th>{{ __('Title') }}</th>
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
                .dataTableService("customPageTable")
                .setCongif({
                    ...dataTableOption,
                    order: [0, 'asc'],
                    columns: [
                        {"data": "name"},
                        {"data": "title"},
                        {"data": "status"},
                        {"data": "action"}
                    ]
                })
                .setNodeSeletor('#table')
                .exit()
            .boot();
        });


        function updateStatus(id) {
            $.post(
                '{{ route('customPageStatus') }}/' + id, {
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
