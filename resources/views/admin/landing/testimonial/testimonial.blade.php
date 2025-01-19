@extends('layout.app', [ 'open_landing_menu' => true, 'menu' => 'landing', 'sub_menu' => 'testimonial' ])

@section('title', __('Landing Testimonial Management'))

@section('content')

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Landing Testimonial Management') }}</h2>
                <a href="{{ route('landingTestimonial') }}" class="btn btn-primary ">{{ __('Add New Testimonial') }}</a>
            </div>

            <div class="overflow-x-auto">
                <table id="testimonialTable" class="table">
                    <thead>
                        <tr>
                            <th>{{ __("Image") }}</th>
                            <th>{{ __("Name") }}</th>
                            <th>{{ __("feedback") }}</th>
                            <th>{{ __("Status") }}</th>
                            <th>{{ __("Date") }}</th>
                            <th>{{ __("Action") }}</th>
                        </tr>
                    </thead>
                </table>
            </div>
        </div>
    </div>
@endsection
@section('downjs')
    <script>
        let table = new DataTable("#testimonialTable", {
            ...dataTableOption,
            columns: [
                { "data": "image" },
                { "data": "name" },
                { "data": "feedback" },
                { "data": "status" },
                { "data": "created_at" },
                { "data": "action" },
            ]
        });

        function updateStatus(id) {
            $.get(
                '{{ route("landingTestimonialStatus") }}/' + id,
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
