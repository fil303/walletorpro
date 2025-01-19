@extends('auth.master')

@section('title', __('Forgot Password'))

@section('content')
{!! view('user.components.bg_rn_shap_style') !!}
{{-- {!! include(public_path('assets/svg/animated/bg_rn_shap.svg')) !!} --}}
<div class="flex items-center justify-center min-h-screen bg-base-200">
    <div class="card w-full max-w-sm shadow-2xl bg-base-100">
        <div class="card-body">
            <h2 class="card-title text-center text-2xl font-bold mb-4">Forgot Password</h2>
            <p>{{__("To recover your account please provide your email")}}</p>
            <form action="{{ route('forgotPassword') }}" method="post">@csrf
                <!-- Email Input -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">{{__("Email")}}</span>
                    </label>
                    <input type="email" name="email" class="input input-bordered" />
                </div>

                <!-- Send Reset Link Button -->
                <div class="form-control mt-4">
                    <button class="btn btn-primary w-full">{{__("Send Reset Link")}}</button>
                </div>

                <!-- Back to Login Link -->
                <div class="text-center mt-4">
                    <a href="{{ route('loginPage') }}" class="link link-primary">Back to Login</a>
                </div>
            </form>
        </div>
    </div>
</div>


@endsection