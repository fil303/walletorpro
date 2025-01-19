@extends('layout.app')

@section('title', __('Admin Reset Password'))

@section('content')

    <div class="flex justify-between">
        <h2 class="card-title">{{ __('Reset Password') }}</h2>
        <a href="{{ route('adminProfilePage') }}" class="btn btn-primary ">{{ __('Profile') }}</a>
    </div>
    <div class="divider"></div>
    <form action="{{ route('adminResetPasswordProcess') }}" method="post">
        @csrf
        <div class="col-span-2">
            <div class="grid sm:block mx-auto w-3/4">
                <div class="grid grid-cols-1 gap-1 sm:block sm:w-full mr-1  overflow-hidden">

                    <label class="form-control p-1">
                        <div class="label">
                            <span class="label-text">{{ __('Current Password') }}</span>
                        </div>
                        <input name="current_password" type="password" class="input input-border" autocomplete="off" />
                    </label>
                    <label class="form-control p-1">
                        <div class="label">
                            <span class="label-text">{{ __('New Password') }}</span>
                        </div>
                        <input name="password" type="password" class="input input-border" autocomplete="off" />
                    </label>
                    <label class="form-control p-1">
                        <div class="label">
                            <span class="label-text">{{ __('Confirm Password') }}</span>
                        </div>
                        <input name="password_confirmation" type="password" class="input input-border" autocomplete="off" />
                    </label>
                </div>
            </div>
        </div>

        <div class="grid sm:block mx-auto w-3/4">
            <div class="grid grid-cols-1 gap-1 sm:block sm:w-full mr-1  overflow-hidden">
                {{-- form button --}}
                <label class="form-control p-1">
                    <button type="submit" class="btn btn-success w-full d-inline ">{{ __('Reset Password') }}</button>
                </label>
            </div>
        </div>
    </form>

@endsection

@section('downjs')
    <script></script>
@endsection
