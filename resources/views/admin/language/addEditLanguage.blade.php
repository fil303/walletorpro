@extends('layout.app')

@section('title', __('Add New User'))

@section('content')

    <h2 class="card-title">{{ __('Add New Language') }}</h2>
    <div class="divider"></div>
    <form action="{{ route('saveLanguage') }}" method="post">
        @csrf
        @isset($item)
            <input type="hidden" name="uid" value="{{ $item->uid ?? '' }}">
        @endisset
        <div class="grid sm:block">
            <div class="grid grid-cols-2 gap-1 sm:block sm:w-full mr-1  overflow-hidden">

                <label class="form-control p-1">
                    <div class="label">
                        <span class="label-text">{{ __('Name') }}</span>
                    </div>
                    <input name="name" type="text" value="{{ $item->name ?? old('name') }}"
                        placeholder="{{ __('Ex: English') }}" class="input input-bordered" />
                </label>

                <label class="form-control p-1">
                    <div class="label">
                        <span class="label-text">{{ __('Code') }}</span>
                    </div>
                    <input name="code" type="text" value="{{ $item->code ?? old('code') }}"
                        placeholder="{{ __('Ex: en') }}" class="input input-bordered" />
                </label>

                <label class="form-control p-1">
                    <div class="label">
                        <span class="label-text">{{ __('Status') }}</span>
                    </div>
                    <select name="status" class="select select-bordered">
                        {!! App\Enums\Status::renderOption($item->status ?? 0) !!}
                    </select>
                </label>
            </div>
        </div>


        <div class="card-actions justify-center mt-2">
            <button type="submit" class="btn btn-success w-3/5">{{ __('Update') }}</button>
        </div>
    </form>

@endsection

@section('downjs')
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService

                .boot();
        });
    </script>
@endsection
