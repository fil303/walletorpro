@extends('auth.master')

@section('title', __('Register'))

@section('head')
    <link rel="stylesheet" href="{{ asset_bind('assets/tomSelect/tom-select.css') }}" />
@endsection

@section('content')

    {!! view('user.components.bg_rn_shap_style') !!}
    {{-- {!! include(public_path('assets/svg/animated/bg_rn_shap.svg')) !!} --}}
    <div  class="bg-base-200 min-h-screen flex items-center justify-center p-4" >

        <!-- Register Card -->
        <div class="card sm:w-[99%] w-[40%] bg-base-100 shadow-xl ">
            <div class="card-body">
            <div class="text-center">
                <img class="mx-auto" loading="lazy" src="{{ asset_bind($app->app_logo ?? '') }}" height="50px" width="250px" alt="App Logo">
                <h2 class="text-center text-2xl font-bold">{{ __("Register Account") }}</h2>
                <p>{{ __("Enter your details to get account") }}</p>
            </div>
            
            <form action="{{ route('register') }}" method="post" class="space-y-4">@csrf
                <!-- First Name Input -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">
                            {{__("First Name")}}
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input name="first_name" type="text" class="input input-bordered w-full " />
                    </div>
                    <!-- Error Message -->
                    @error('first_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Last Name Input -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">
                            {{__("Last Name")}}
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input name="last_name" type="text" class="input input-bordered w-full " />
                    </div>
                    <!-- Error Message -->
                    @error('last_name')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Username Input -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">
                            {{__("Username")}}
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input name="username" type="text" class="input input-bordered w-full " />
                    </div>
                    <!-- Error Message -->
                    @error('username')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Input -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">
                            {{__("Email")}}
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input name="email" type="email" class="input input-bordered w-full " />
                    </div>
                    <!-- Error Message -->
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Country Select -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">
                            {{__("Country")}}
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <select id="country_select" name="country" class="select select-bordered" 
                        autocomplete="off"  >
                        {!! countries_option(ucwords($user->country ?? '')) !!}
                    </select>
                </div>
                
                <!-- Phone Input -->
                <div class="form-control w-full">
                    <label class="label">
                        <span class="label-text">
                            {{__("Phone")}}
                        </span>
                    </label>
                    <label class="input input-bordered flex items-center gap-2">
                        <span data-bind="text" bind-with="dial_code">+880</span>
                        <input name="phone" type="text" class="grow bg-inherit"  />
                    </label>
                    <!-- Error Message -->
                    @error('phone')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password Input -->
                <div class="form-control w-full mt-4">
                    <label class="label">
                        <span class="label-text">
                            {{__("Password")}}
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input name="password" type="password" placeholder="Enter your password" class="input input-bordered w-full " />
                    </div>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- Confirm Password Input -->
                <div class="form-control w-full mt-4">
                    <label class="label">
                        <span class="label-text">{{__("Confirm Password")}}</span>
                    </label>
                    <div class="relative">
                        <input name="password_confirmation" type="password" placeholder="Enter your password" class="input input-bordered w-full " />
                    </div>
                </div>

                <!-- Register Button -->
                <div class="form-control mt-6">
                    <button type="submit" class="btn btn-success  w-full">{{__("Register")}}</button>
                </div>
            </form>

            <!-- Register Link -->
            <p class="text-center mt-4">
                {{__("Already have an account?")}}
                <a href="{{ route('loginPage') }}" class="link link-primary">{{__("Login")}}</a>
            </p>
            </div>
        </div>
    </div>

@endsection

@section('downjs')
    <script src="{{ asset_bind('assets/tomSelect/tom-select.min.js') }}"></script>
    <script>
        $(document).ready(function () {
            let tomSelectCountry = new TomSelect("#country_select",{
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                controlInput: '<input class="form-control input input-bordered" />'
            });

            tomSelectCountry.on('change', (value)=> {
                let codes = document.registerStorage.get("countries_dial_code");
                document.bind.bindTo('dial_code', codes[value] || "");
            });
        });

         document.addEventListener("DOMContentLoaded",() => {
            let service = document.siteProviderService

                // Storage
                .newInstance()
                .storeService("registerStorage")
                .exit()

            .boot();

            document.registerStorage.put(
                "countries_dial_code",
                JSON.parse('{!! json_encode(countries_dial_code()) !!}')
            );
        });
    </script>
@endsection