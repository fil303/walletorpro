@extends('layout.app')

@section('title', __('User Password Reset'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Password Reset') }}</h2>
                <a href="{{ route('userProfile') }}" class="btn">
                    <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 14 4 9l5-5" />
                        <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                    </svg>
                    {{ __("Button") }}
                </a>
            </div>

            <form action="{{ route('userPasswordReset') }}" method="post">
                @csrf
                <div class="col-span-2">
                    <div class="grid sm:block mx-auto w-3/4">
                        <div class="grid grid-cols-1 gap-1 sm:block sm:w-full mr-1  overflow-hidden">

                            <label class="form-control p-1">
                                <div class="label">
                                    <span class="label-text">{{ __('Current Password') }}</span>
                                </div>
                                <input name="current_password" type="password" class="input input-bordered" autocomplete="off" />
                            </label>
                            <label class="form-control p-1">
                                <div class="label">
                                    <span class="label-text">{{ __('New Password') }}</span>
                                </div>
                                <input name="password" type="password" class="input input-bordered" autocomplete="off" />
                            </label>
                            <label class="form-control p-1">
                                <div class="label">
                                    <span class="label-text">{{ __('Confirm Password') }}</span>
                                </div>
                                <input name="password_confirmation" type="password" class="input input-bordered" autocomplete="off" />
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
        </div>
    </div>

@endsection
@section('downjs')
    <script></script>
@endsection
