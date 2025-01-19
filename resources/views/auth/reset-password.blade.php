@extends('auth.master')

@section('title', __('Password Reset'))

@section('content')

    {!! view('user.components.bg_rn_shap_style') !!}
    {{-- {!! include(public_path('assets/svg/animated/bg_rn_shap.svg')) !!} --}}
    <div  class="bg-base-200 min-h-screen flex items-center justify-center p-4" >

        <!-- Password Reset Card -->
        <div class="card sm:w-[99%] w-[40%] bg-base-100 shadow-xl ">
            <div class="card-body">
                <h2 class="card-title text-center text-2xl font-bold">{{ __("Password Reset") }}</h2>
                <p>{{__("Set new password to access your account")}}</p>
                <form action="{{ route('passwordReset') }}" method="post" class="space-y-4">@csrf
                    <input type="hidden" name="email" value="{{ $email ?? '' }}">
                    <input type="hidden" name="password_reset_token" value="{{ $password_reset_token ?? '' }}">

                    <!-- Password Input -->
                    <div class="form-control w-full mt-4">
                        <label class="label">
                            <span class="label-text">{{__("New Password")}}</span>
                        </label>
                        <div class="relative">
                            <input name="password" type="password" placeholder="Enter your password" class="input input-bordered w-full pl-10" />
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3a6 6 0 00-6 6v3H4a1 1 0 00-1 1v6a1 1 0 001 1h16a1 1 0 001-1v-6a1 1 0 00-1-1h-2v-3a6 6 0 00-6-6zm4 9v-3a4 4 0 10-8 0v3h8z" />
                            </svg>
                        </div>
                        @error('password')
                            <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                        @enderror
                    </div>
                    
                    <!-- Confirm Password Input -->
                    <div class="form-control w-full mt-4">
                        <label class="label">
                            <span class="label-text">{{__("Confirm New Password")}}</span>
                        </label>
                        <div class="relative">
                            <input name="password_confirmation" type="password" placeholder="Enter your password" class="input input-bordered w-full pl-10" />
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" viewBox="0 0 24 24" fill="currentColor">
                                <path d="M12 3a6 6 0 00-6 6v3H4a1 1 0 00-1 1v6a1 1 0 001 1h16a1 1 0 001-1v-6a1 1 0 00-1-1h-2v-3a6 6 0 00-6-6zm4 9v-3a4 4 0 10-8 0v3h8z" />
                            </svg>
                        </div>
                    </div>

                    <!-- Submit Button -->
                    <div class="form-control mt-6">
                        <button type="submit" class="btn btn-success  w-full">{{__("Submit")}}</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection