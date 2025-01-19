@extends('auth.master')

@section('title', __('Exchange Coins'))

@section('content')

    {!! view('user.components.bg_rn_shap_style') !!}
    {{-- {!! include(public_path('assets/svg/animated/bg_rn_shap.svg')) !!} --}}
    <div  class="bg-base-200 min-h-screen flex items-center justify-center p-4">

        <!-- Login Card -->
        <div class="card sm:w-[99%] w-[40%] bg-base-100 shadow-xl ">
            <div class="card-body">
                <div class="text-center">
                    <img class="mx-auto" src="{{ asset_bind($app->app_logo ?? '') }}" loading="lazy" height="50px" width="250px" alt="App Logo">
                    <h2 class="text-2xl font-bold">{{ __("Admin Login") }}</h2>
                    <p>{{ __("Enter your credentials to access your account") }}</p>
                </div>
                <form action="{{ route('login') }}" method="post" class="space-y-4">@csrf
                    <input type="hidden" name="admin" value="admin">

                    <!-- Email Input with SVG Icon -->
                    <div class="form-control w-full">
                        <label class="label">
                        <span class="label-text">{{__("Email")}}</span>
                        </label>
                        <div class="relative">
                        <input name="email" type="email" placeholder="Enter your email" class="input input-bordered w-full pl-10" />
                        <svg class="lucide lucide-at-sign w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                            <circle cx="12" cy="12" r="4"/><path d="M16 8v5a3 3 0 0 0 6 0v-1a10 10 0 1 0-4 8"/>
                        </svg>
                        </div>
                        <!-- Error Message -->
                        @error('email')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Password Input with SVG Icon -->
                    <div class="form-control w-full mt-4">
                        <label class="label">
                        <span class="label-text">{{__("Password")}}</span>
                        </label>
                        <div class="relative">
                        <input name="password" type="password" placeholder="Enter your password" class="input input-bordered w-full pl-10" />
                        <svg class="lucide lucide-square-asterisk w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/>
                            <path d="M12 8v8"/><path d="m8.5 14 7-4"/><path d="m8.5 10 7 4"/>
                        </svg>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>

                    <!-- Remember Me Checkbox -->
                    <div class="form-control mt-4 hidden">
                        <label class="cursor-pointer flex items-center">
                        <input type="checkbox" class="checkbox checkbox-primary" disabled />
                        <span class="label-text ml-2">{{__("Remember me")}}</span>
                        </label>
                    </div>

                    @if($app->app_recaptcha_status ?? '0')
                        <!-- Google reCaptcha V2 Button -->
                        <div class="form-control mt-4">
                            {!! NoCaptcha::display() !!}
                        </div>
                    @endif

                    <!-- Login Button -->
                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-success  w-full">{{__("Login")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
