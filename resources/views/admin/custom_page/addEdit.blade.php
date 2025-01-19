@extends('layout.app', [ 'open_landing_menu' => true, 'menu' => 'landing', 'sub_menu' => 'custom_page' ])
@section('title', __('Custom Page FAQ'))
@section('head')
    <link rel="stylesheet" href="{{ asset_bind('assets/summernote/summernote-lite.min.css') }}" />
    <style>
        .note-editor {
           background-color: white;
        }
    </style>
@endsection

@use(App\Enums\FaqPages)

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Custom Page') }}</h2>
                <a href="{{ route('customPage') }}" class="btn">
                    <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 14 4 9l5-5" />
                        <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                    </svg>
                    {{ __("Button") }}
                </a>
            </div>
            <form action="{{ route('customPageSave') }}" method="post">
                @csrf
                @isset($item)
                    <input type="hidden" name="id" value="{{ $item->id ?? '' }}">
                @endisset
                <div class="grid sm:block">
                    <div class="grid grid-cols-2 gap-1 sm:block sm:w-full mr-1  overflow-hidden">

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">
                                    {{ __('Name') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="name" type="text" value="{{ $item->name ?? old('name') }}"
                                class="input input-bordered" />
                        </label>
                        
                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">
                                    {{ __('Title') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="title" type="text" value="{{ $item->title ?? old('title') }}"
                                class="input input-bordered" />
                        </label>

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">
                                    {{ __('Status') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <select name="status" class="select select-bordered">
                                {!! App\Enums\Status::renderOption($item->status?->value ?? 0) !!}
                            </select>
                        </label>

                        <label class="form-control p-1 col-span-2">
                            <div class="label">
                                <span class="label-text">
                                    {{ __('Content') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <textarea id="summernote_content" name="content_body">{{ $item->content ?? '' }}</textarea>
                        </label>

                        {{-- form button --}}
                        <label class="form-control p-1">
                            <button type="submit" class="btn btn-success w-full d-inline ">{{ isset($item) ? __('Update') : __("Save") }}</button>
                        </label>
                        <label class="form-control p-1">
                            <a href="{{ route('customPage') }}" class="btn btn-error w-full">{{ __('Back To Page List') }}</a>
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('downjs')
    <script src="{{ asset_bind('assets/summernote/summernote-lite.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService

                .boot();
        });

        $('#summernote_content').summernote({
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['fontsize', ['fontsize']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link','picture']],
                ['view', ['fullscreen', 'help']]
            ]
        });
    </script>
@endsection
