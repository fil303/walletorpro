@extends('layout.app')

@section('title', __('User Profile'))
@section('head')
    {{-- <link rel="stylesheet" href="{{ asset_bind('assets/select2/select2.min.css') }}" /> --}}
    <link rel="stylesheet" href="{{ asset_bind('assets/tomSelect/tom-select.min.css') }}" />
@endsection

@section('content')
    <div class="card bg-base-100 shadow-xl">
        <div class="min-h-screen bg-base-100 px-4 sm:px-6 lg:px-8">
            <div class="max-w-7xl mx-auto">
                <h2 class="card-title">{{ __('Profile Details') }}</h2>
                <div class="grid grid-cols-3 md:grid-cols-1 gap-8">
                    <div class="rounded-lg  bg-card text-card-foreground shadow-sm p-6">
                        <div class="space-y-6">
                            <div class="flex items-center space-x-4">
                                <span class="relative flex shrink-0 overflow-hidden rounded-full w-24 h-24">
                                    <span class="flex h-full w-full items-center justify-center rounded-full bg-muted">
                                        <img src="{{ $user->getImage() ?? '' }}" loading="lazy" alt="{{ $user->username ?? '' }}">
                                    </span>
                                </span>
                                <div>
                                    <h2 class="text-2xl font-bold">{{ $user->name ?? '' }}</h2>
                                    <p class="text-base-500">{{ $user->email ?? '' }}</p>
                                </div>
                            </div>
                            <div class="space-y-2">
                                <p><span class="font-semibold">{{ _t('Username') }}:</span>
                                    <span>@</span>{{ $user->username ?? '' }}</p>
                                <p><span class="font-semibold">{{ _t('Country') }}:</span>
                                    {{ countries(ucwords($user->country ?? '')) }}</p>
                                <p>
                                    <span class="font-semibold">{{ _t('Phone') }}:</span>
                                    {{ $user->phone_number() ?? '' }}
                                    @if (blank($user->phone_verified_at))
                                        <span><a href="#phone_verification"
                                                class="btn btn-primary btn-sm">{{ __('Verify') }}</a></span>
                                    @else
                                        <span class="btn btn-success btn-sm text-xs">{{ __('Verified') }}</span>
                                    @endif
                                </p>
                            </div>
                            <a href="{{ route('userPasswordResetPage') }}"
                                class="btn btn-primary w-full">{{ __('Password Reset') }}</a>
                            <a href="{{ route('twoFactorSetupPage') }}"
                                class="btn btn-primary w-full">{{ __('Two Factor Setup') }}</a>
                        </div>
                    </div>
                    <div class="rounded-lg col-span-2  bg-card text-card-foreground shadow-sm p-6">
                        <h2>{{ _t('Profile Update') }}</h2>
                        <form action="{{ route('userProfileUpdate') }}" method="post" enctype="multipart/form-data"
                            class="space-y-4">
                            @csrf
                            <div class="grid grid-cols-2 lg:grid-cols-1">
                                <label class="form-control p-1">
                                    <div class="label">
                                        <span class="label-text">{{ __('First Name') }}</span>
                                    </div>
                                    <input name="first_name" value="{{ $user->first_name ?? '' }}" type="text"
                                        name="first_name" class="input input-bordered" autocomplete="off" />
                                </label>
                                <label class="form-control p-1">
                                    <div class="label">
                                        <span class="label-text">{{ __('Last Name') }}</span>
                                    </div>
                                    <input name="last_name" value="{{ $user->last_name ?? '' }}" type="text"
                                        name="last_name" class="input input-bordered" autocomplete="off" />
                                </label>
                                <label class="form-control p-1">
                                    <div class="label">
                                        <span class="label-text">{{ __('Username') }}</span>
                                    </div>
                                    <input name="username" value="{{ $user->username ?? '' }}" type="text"
                                        name="username" class="input input-bordered" autocomplete="off" readonly />
                                </label>
                                <label class="form-control p-1">
                                    <div class="label">
                                        <span class="label-text">{{ __('Email') }}</span>
                                    </div>
                                    <input name="email" value="{{ $user->email ?? '' }}" type="text"
                                        class="input input-bordered" autocomplete="off" readonly />
                                </label>
                                <label class="form-control p-1">
                                    <div class="label">
                                        <span class="label-text">{{ __('Phone') }}</span>
                                    </div>
                                    <label class="input input-bordered flex items-center gap-2">
                                        <span data-bind="text" bind-with="dial_code">+880</span>
                                        <input name="phone" value="{{ $user->phone ?? '' }}" type="text"
                                            class="grow bg-inherit" />
                                    </label>
                                </label>

                                <label class="form-control p-1">
                                    <div class="label">
                                        <span class="label-text">{{ __('Country') }}</span>
                                    </div>
                                    <select id="country_select" name="country" class="select select-bordered"
                                        autocomplete="off">
                                        {!! countries_option(ucwords($user->country ?? '')) !!}
                                    </select>
                                </label>
                                <label class="form-control p-1">
                                    <div class="label">
                                        <span class="label-text">{{ __('Image') }}</span>
                                    </div>
                                    <input name="image" type="file" class="filePond" autocomplete="off" />
                                </label>
                            </div>
                            <button type="submit" class="btn btn-success w-full">{{ __('Update') }}</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" role="dialog" id="phone_verification">
        <div class="modal-box">
            <div class="modal-action mt-0">
                <a href="#" onclick="closeModal()"
                    class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</a>
            </div>
            <div class="card-body">
                <h2 class="card-title text-center text-lg font-semibold text-gray-700">
                    {{ __('Phone Number Verification') }}</h2>

                <form action="{{ route('phoneVerificationProcess') }}" method="post">@csrf
                    <div class="form-control mb-4">
                        <label class="label">
                            <span class="label-text">{{ __('Your Phone Number') }}</span>
                        </label>
                        <input value="{{ $user->phone_number() ?? '' }}" id="phone-number" type="text"
                            class="input input-bordered w-full" readonly />
                    </div>

                    <button id="verify-btn" type="button" class="btn btn-primary w-full">
                        <span id="verify-text">{{ __('Send Verification Code') }}</span>
                        <span id="spinner" class="loading loading-spinner hidden ml-2"></span>
                    </button>

                    <div id="verification-section" class="hidden">
                        <label class="label">
                            <span class="label-text">{{ __('Enter the verification code') }}</span>
                        </label>
                        <input name="code" id="verification-code" type="text" placeholder="Verification code"
                            class="input input-bordered w-full mb-4" />

                        <button type="submit" class="btn btn-primary w-full">{{ __('Verify') }}</button>
                        <button type="button" id="resend-btn" class="btn btn-outline btn-secondary w-full mt-1"
                            disabled>{{ __('Resend Code') }} <span id="countdown" class="ml-2">(60s)</span></button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
@section('downjs')
    {{-- <script src="{{ asset_bind('assets/select2/select2.min.js') }}"></script> --}}
    <script src="{{ asset_bind('assets/tomSelect/tom-select.min.js') }}"></script>
    <script>
        $(document).ready(function() {
            // $("#country_select").select2({
            //     selectionCssClass: 'select select-bordered'
            // });


            let tomSelectCountry = new TomSelect("#country_select", {
                create: true,
                sortField: {
                    field: "text",
                    direction: "asc"
                },
                controlInput: '<input class="form-control input input-bordered" />'
            });

            tomSelectCountry.on('change', (value) => {
                let codes = document.userProfileStorage.get("countries_dial_code");
                document.bind.bindTo('dial_code', codes[value] || "");
            });

        });

        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService

                // Storage
                .newInstance()
                .storeService("userProfileStorage")
                .exit()

                // File Pond
                .newInstance()
                .filePondService("filePond")
                .setCongif(filePondOption)
                .setNodeSeletor('.filePond')
                .exit()

                .boot();

            document.userProfileStorage.put(
                "countries_dial_code",
                JSON.parse('{!! json_encode(countries_dial_code()) !!}')
            );
            @isset($user->country)
                document.bind.bindTo('dial_code', document.userProfileStorage.get("countries_dial_code")[
                    "{{ ucwords($user->country ?? '') }}"] || "");
            @endisset
        });

        // Elements
        const verifyBtn = document.getElementById('verify-btn');
        const verifyText = document.getElementById('verify-text');
        const spinnerr = document.getElementById('spinner');
        const verificationSection = document.getElementById('verification-section');
        const resendBtn = document.getElementById('resend-btn');
        const countdown = document.getElementById('countdown');

        let timer = 60;
        let countdownInterval;

        // Function to start the countdown timer
        function startCountdown() {
            countdownInterval = setInterval(() => {
                timer--;
                countdown.textContent = `(${timer}s)`;

                if (timer <= 0) {
                    clearInterval(countdownInterval);
                    resendBtn.disabled = false;
                    countdown.textContent = '';
                }
            }, 1000);
        }

        // Simulate sending verification code
        verifyBtn.addEventListener('click', () => {
            verifyText.textContent = 'Sending...';
            spinnerr.classList.remove('hidden');
            sendOTPCode();
        });

        function sendOTPCode() {
            $.get('{{ route('sendOTPCode', ['type' => 'phone']) }}', (res) => {

                if (res.status) {
                    spinnerr.classList.add('hidden');
                    verificationSection.classList.remove('hidden');

                    resendBtn.disabled = true;
                    timer = 60;
                    countdown.textContent = `(${timer}s)`;
                    startCountdown();
                    verifyBtn.remove();
                }
            });
        }

        // Handle resend button click
        resendBtn.addEventListener('click', () => {
            sendOTPCode()
        });
    </script>
@endsection
