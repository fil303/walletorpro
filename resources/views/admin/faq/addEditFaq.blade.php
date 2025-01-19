@extends('layout.app', [ 'menu' => 'faq' ])
@section('title', __('Add New FAQ'))

@use(App\Enums\FaqPages)

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Add New FAQ') }}</h2>
                <a href="{{ route('faqPage') }}" class="btn">
                    <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 14 4 9l5-5" />
                        <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                    </svg>
                    {{ __("Button") }}
                </a>
            </div>
            <form action="{{ route('saveFaq') }}" method="post">
                @csrf
                @isset($item)
                    <input type="hidden" name="uid" value="{{ $item->uid ?? '' }}">
                @endisset
                <div class="grid sm:block">
                    <div class="grid grid-cols-2 gap-1 sm:block sm:w-full mr-1  overflow-hidden">

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">
                                    {{ __('Question') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="question" type="text" value="{{ $item->question ?? old('question') }}"
                                class="input input-bordered" />
                        </label>

                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">
                                    {{ __('Answer') }}
                                    <span class="text-error">*</span>
                                </span>
                            </div>
                            <input name="answer" type="text" value="{{ $item->answer ?? old('answer') }}"
                                class="input input-bordered" />
                        </label>
                        <label class="form-control p-1">
                            <div class="label">
                                <span class="label-text">{{ __('Page') }}</span>
                            </div>
                            <select name="page" class="select select-bordered" disabled>
                                {!! FaqPages::renderOption($item->page?->value ?? '') !!}
                            </select>
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

                        {{-- form button --}}
                        <label class="form-control p-1">
                            <button type="submit" class="btn btn-success w-full d-inline ">{{ isset($item) ? __('Update') : __("Save") }}</button>
                        </label>
                        <label class="form-control p-1">
                            <a href="{{ route('faqPage') }}" class="btn btn-error w-full">{{ __('Back To FAQ List') }}</a>
                        </label>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection

@section('downjs')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService

                .boot();
        });
    </script>
@endsection
