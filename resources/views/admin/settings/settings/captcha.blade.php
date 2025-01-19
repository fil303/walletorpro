@extends('layout.app', [ 'menu' => 'setting' ])

@section('title', __('reCAPTCHA Setting'))

@section('content')

    <!-- SEO Settings Form -->
    <div class="bg-base-200 min-h-screen p-10">
        <!-- Recaptcha Settings Card -->
        <div class="card w-full max-w-4xl mx-auto bg-base-100 shadow-xl">
            <div class="card-body">
                <div class="flex justify-between">
                    <h2 class="card-title">{{ __('reCAPTCHA Configuration') }}</h2>
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

                <form action="{{ route('captchaSettingSave') }}" method="post">@csrf
                    <div class="form-control mt-4">
                        <label class="cursor-pointer flex items-center mt-2">
                            {!! view('admin.components.toggle', [
                                'items' => ['name' => 'app_recaptcha_status'],
                                'selected' => $app->app_recaptcha_status ?? '0',
                            ]) !!}
                            <span class="ml-2">{{ __('Enable reCAPTCHA Feature') }}</span>
                        </label>
                    </div>

                    <!-- Google reCAPTCHA v2 Settings -->
                    <div class="mt-4">
                        <h3 class="text-xl font-semibold">{{ __('Google reCAPTCHA v2 Settings') }}</h3>
                        <div class="form-control mt-2">
                            <label class="label">
                                <span class="label-text">
                                    {{ __('Site Key') }}
                                    <span class="text-error">*</span>
                                </span>
                            </label>
                            <input type="text" name="google_recaptcha_v2_site_key"
                                value="{{ $app->google_recaptcha_v2_site_key ?? '' }}"
                                class="input input-bordered w-full" />
                        </div>
                        <div class="form-control mt-2">
                            <label class="label">
                                <span class="label-text">
                                    {{ __('Secret Key') }}
                                    <span class="text-error">*</span>
                                </span>
                            </label>
                            <input type="text" name="google_recaptcha_v2_secret_key"
                                value="{{ $app->google_recaptcha_v2_secret_key ?? '' }}"
                                class="input input-bordered w-full" />
                        </div>
                        <!-- Save Button -->
                        <div class="form-control mt-6">
                            <button type="submit" class="btn btn-primary w-full">{{ __('Save') }}</button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
