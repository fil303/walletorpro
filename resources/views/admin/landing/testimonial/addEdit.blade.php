@extends('layout.app', [ 'open_landing_menu' => true, 'menu' => 'landing', 'sub_menu' => 'testimonial' ])
@use(App\Enums\Status)
@section('title', __('Landing Testimonial'))

@section('content')

    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex justify-between">
                <h3 class="font-bold text-lg mb-4" id="modalTitle">Testimonial</h3>
                <a href="{{ route('landingTestimonialsPage') }}" class="btn">
                    <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 14 4 9l5-5" />
                        <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                    </svg>
                    {{ __("Button") }}
                </a>
            </div>
            <form action="{{ route('landingTestimonialSave') }}" method="post" class="space-y-4" enctype="multipart/form-data">@csrf
                @if(isset($testimonial->id))
                    <input type="hidden" name="id" value="{{ $testimonial->id }}">
                @endif
                
                <div class="form-control">
                    <label class="label">{{__("User Name")}}</label>
                    <input type="text" name="name" value="{{ $testimonial->name ?? '' }}" class="input input-bordered" required>
                </div>

                <div class="form-control">
                    <label class="label">{{__("Feedback Message")}}</label>
                    <textarea name="feedback" class="textarea textarea-bordered" required>{{ $testimonial->feedback ?? '' }}</textarea>
                </div>

                <div class="form-control">
                    <label class="label">{{__("Status")}}</label>
                    <select name="status" id="status" class="select select-bordered">
                       {!! Status::renderOption($testimonial->status ?? 0) !!}
                    </select>
                </div>

                <div class="form-control">
                    <label class="label">{{__("User Image")}}</label>
                    <input name="image" type="file" class="filePond" />
                </div>

                <div class="modal-action">
                    <button type="submit" class="btn btn-primary">{{__("Save")}}</button>
                    <button type="button" class="btn">Cancel</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('downjs')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService

                .newInstance()
                .filePondService("testimonialImage")
                .setCongif(filePondOption)
                .setNodeSeletor('.filePond')
                @if (isset($testimonial->id))
                    .setdefaultFile('{{ $testimonial->getImage() }}')
                @endif
                .exit()

            .boot();
        });
    </script>
@endsection