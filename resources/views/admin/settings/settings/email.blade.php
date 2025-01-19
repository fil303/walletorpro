@extends('layout.app', [ 'menu' => 'setting' ])

@section('title', __('Email Setting'))
@use('App\Enums\Smtp_encryption')
@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('SMTP Email Configuration') }}</h2>
                <a href="{{ route('settingPage') }}" class="btn">
                    <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 14 4 9l5-5" />
                        <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                    </svg>
                    {{ __("Button") }}
                </a>
            </div>
            <!-- SMTP Configuration Form -->
            <form action="{{ route('emailSettingSave') }}" method="post" class="grid sm:block grid-cols-2 gap-4">@csrf

                <!-- SMTP Host -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">
                            Host
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input name="email_host" value="{{ $app->email_host ?? '' }}" type="text"
                            placeholder="smtp.yourmailserver.com" class="input input-bordered w-full" />
                    </div>
                </div>

                <!-- SMTP Port -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">
                            Port
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input name="email_port" value="{{ $app->email_port ?? '' }}" type="number" placeholder="587"
                            class="input input-bordered w-full" />
                    </div>
                </div>

                <!-- SMTP Username -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">
                            Username
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input name="email_username" value="{{ $app->email_username ?? '' }}" type="text"
                            placeholder="youremail@example.com" class="input input-bordered w-full" />
                    </div>
                </div>

                <!-- SMTP Password -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">
                            Password
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input name="email_password" value="{{ $app->email_password ?? '' }}" type="password"
                            placeholder="Enter your password" class="input input-bordered w-full" />
                    </div>
                </div>

                <!-- Encryption Type -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">
                            Encryption Type
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <select name="email_encryption" class="select select-bordered w-full">
                        {!! Smtp_encryption::renderOption($app->email_encryption ?? '') !!}
                    </select>
                </div>

                <!-- Sender Email -->
                <div class="form-control">
                    <label class="label">
                        <span class="label-text">
                            Sender Email
                            <span class="text-error">*</span>
                        </span>
                    </label>
                    <div class="relative">
                        <input name="email_from" value="{{ $app->email_from ?? '' }}" type="email"
                            placeholder="noreply@example.com" class="input input-bordered w-full" />
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="col-span-2 mt-6">
                    <button class="btn btn-primary w-full">Save Configuration</button>
                </div>
            </form>
        </div>
    </div>

    <div class="card bg-base-100">
        <div class="card-body">
            <h2 class="card-title">{{ __('Test Email') }}</h2>
            <!-- SMTP Test Email Send -->
            <form action="{{ route('emailTest') }}" method="post" class="grid sm:block grid-cols-2 gap-4">@csrf
                <!-- Send Test Email -->
                <div class="form-control mt-4 md:col-span-2">
                    <label class="label">
                        <span class="label-text">Test Email</span>
                    </label>
                    <div class="relative">
                        <input type="email" name="email" placeholder="your-email@example.com"
                            class="input input-bordered w-full" />
                    </div>
                </div>

                <!-- Action Buttons -->
                <div class="col-span-2 mt-6 grid grid-cols-2 gap-2 items-center">
                    <button class="btn btn-secondary w-full">Send Test Email</button>
                </div>
            </form>
        </div>
    </div>

@endsection
