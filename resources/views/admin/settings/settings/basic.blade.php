@extends('layout.app', [ 'menu' => 'setting' ])

@section('title', __('Basic Setting'))

@section('content')
    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('General Settings') }}</h2>
                <a href="{{ route('settingPage') }}" class="btn">
                    <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                        stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M9 14 4 9l5-5" />
                        <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                    </svg>
                    {{ __("Button") }}
                </a>
            </div>
            <div class="divider"></div>
            <form action="{{ route('basicSettingSave') }}" method="post">@csrf
                <div class="grid sm:block grid-cols-2 gap-4">
                    <!-- App Title -->
                    <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                        <h2 class="card-title">
                            {{ __("App Title") }}
                            <span class="text-error">*</span>
                        </h2>
                        <p class="text-sm text-gray-500">Set the title for your application.</p>
                        <input name="app_name" value="{{ $app->app_name ?? '' }}" type="text" placeholder="Enter App Title"
                            class="input input-bordered mt-2 w-full" />
                    </div>

                    <!-- Records per Page -->
                    <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                        <h2 class="card-title">
                            {{ __("Records to Display Per Page") }}
                            <span class="text-error">*</span>
                        </h2>
                        <p class="text-sm text-gray-500">Choose the number of records to display per page.</p>
                        <input name="record_per_page" value="{{ $app->record_per_page ?? '' }}" type="number"
                            placeholder="10, 25, 50..." class="input input-bordered mt-2 w-full" />
                    </div>

                    <!-- Timezone -->
                    <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                        <h2 class="card-title">
                            {{ __("Timezone") }}
                            <span class="text-error">*</span>
                        </h2>
                        <p class="text-sm text-gray-500">Set the default timezone for the application.</p>
                        {!! Timezones::create('app_timezone', $app->app_timezone ?? null, [
                            'attr' => [
                                'class' => 'select select-bordered mt-2 w-full',
                            ],
                            'with_regions' => true,
                        ]) !!}
                    </div>

                    <!-- Default Language -->
                    <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                        <h2 class="card-title">
                            {{ __("Default Language") }}
                            <span class="text-error">*</span>
                        </h2>
                        <p class="text-sm text-gray-500">Select the default language for your application.</p>
                        <select name="app_language" class="select select-bordered mt-2 w-full">
                            <option>English</option>
                        </select>
                    </div>

                    <!-- Address -->
                    <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                        <h2 class="card-title">
                            {{ __("Address") }}
                            <span class="text-error">*</span>
                        </h2>
                        <p class="text-sm text-gray-500">Your business or application's address.</p>
                        <input name="app_address" value="{{ $app->app_address ?? '' }}" type="text" placeholder="Enter Address"
                            class="input input-bordered mt-2 w-full" />
                    </div>

                    <!-- Email Address -->
                    <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                        <h2 class="card-title">
                            {{ __("Email Address") }}
                            <span class="text-error">*</span>
                        </h2>
                        <p class="text-sm text-gray-500">Enter your application's contact email address.</p>
                        <input name="app_email" value="{{ $app->app_email ?? '' }}" type="email" placeholder="Enter Email Address"
                            class="input input-bordered mt-2 w-full" />
                    </div>

                    <!-- Phone -->
                    <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                        <h2 class="card-title">
                            {{ __("Phone") }}
                            <span class="text-error">*</span>
                        </h2>
                        <p class="text-sm text-gray-500">Enter your phone number.</p>
                        <input name="app_phone" value="{{ $app->app_phone ?? '' }}" type="tel" placeholder="Enter Phone Number"
                            class="input input-bordered mt-2 w-full" />
                    </div>

                    <!-- Footer Text -->
                    <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                        <h2 class="card-title">
                            {{ __("Footer Text") }}
                            <span class="text-error">*</span>
                        </h2>
                        <p class="text-sm text-gray-500">Set the text for the footer section of the application.</p>
                        <input name="app_footer_text" value="{{ $app->app_footer_text ?? '' }}" type="text"
                            placeholder="Enter Footer Text" class="input input-bordered mt-2 w-full" />
                    </div>
                </div>

                <!-- Toggles Section -->
                @if(false)
                    <div class="col-span-*">
                        <h3 class="text-xl font-bold text-center mb-4">Security & Notifications</h3>
                        <div class="grid sm:block grid-cols-2 gap-4">

                            <!-- User Registration -->
                            <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                                <h2 class="card-title">User Registration</h2>
                                <p class="text-sm text-gray-500">Allow or disallow new user registrations.</p>
                                <label class="cursor-pointer flex items-center mt-2">
                                    {!! view('admin.components.toggle', [
                                        'items' => ['name' => 'app_new_user_registration'],
                                        'selected' => $app->app_new_user_registration ?? '0',
                                    ]) !!}
                                    <span class="ml-2">Enable Registration</span>
                                </label>
                            </div>

                            <!-- Secure Password -->
                            <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                                <h2 class="card-title">Secure Password</h2>
                                <p class="text-sm text-gray-500">Force secure password requirements for users.</p>
                                <label class="cursor-pointer flex items-center mt-2">
                                    {!! view('admin.components.toggle', [
                                        'items' => ['name' => 'app_user_secure_password'],
                                        'selected' => $app->app_user_secure_password ?? '0',
                                    ]) !!}
                                    <span class="ml-2">Enable Secure Password</span>
                                </label>
                            </div>

                            <!-- Agree Policy -->
                            <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                                <h2 class="card-title">Agree Policy</h2>
                                <p class="text-sm text-gray-500">Require users to agree to policy terms.</p>
                                <label class="cursor-pointer flex items-center mt-2">
                                    {!! view('admin.components.toggle', [
                                        'items' => ['name' => 'app_agree_policy'],
                                        'selected' => $app->app_agree_policy ?? '0',
                                    ]) !!}
                                    <span class="ml-2">Enable Agree Policy</span>
                                </label>
                            </div>

                            <!-- Force SSL -->
                            <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                                <h2 class="card-title">Force SSL</h2>
                                <p class="text-sm text-gray-500">Require SSL connections for all users.</p>
                                <label class="cursor-pointer flex items-center mt-2">
                                    {!! view('admin.components.toggle', [
                                        'items' => ['name' => 'app_force_ssl'],
                                        'selected' => $app->app_force_ssl ?? '0',
                                    ]) !!}
                                    <span class="ml-2">Enable Force SSL</span>
                                </label>
                            </div>

                            <!-- Email Verification -->
                            <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                                <h2 class="card-title">Email Verification</h2>
                                <p class="text-sm text-gray-500">Send verification emails to new users.</p>
                                <label class="cursor-pointer flex items-center mt-2">
                                    {!! view('admin.components.toggle', [
                                        'items' => ['name' => 'app_email_verification'],
                                        'selected' => $app->app_email_verification ?? '0',
                                    ]) !!}
                                    <span class="ml-2">Enable Email Verification</span>
                                </label>
                            </div>

                            <!-- Email Notification -->
                            <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                                <h2 class="card-title">Email Notification</h2>
                                <p class="text-sm text-gray-500">Send notification emails for various activities.</p>
                                <label class="cursor-pointer flex items-center mt-2">
                                    {!! view('admin.components.toggle', [
                                        'items' => ['name' => 'app_email_notification'],
                                        'selected' => $app->app_email_notification ?? '0',
                                    ]) !!}
                                    <span class="ml-2">Enable Email Notification</span>
                                </label>
                            </div>

                            <!-- Push Notification -->
                            <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                                <h2 class="card-title">Push Notification</h2>
                                <p class="text-sm text-gray-500">Enable push notifications for user activities.</p>
                                <label class="cursor-pointer flex items-center mt-2">
                                    {!! view('admin.components.toggle', [
                                        'items' => ['name' => 'app_push_notification'],
                                        'selected' => $app->app_push_notification ?? '0',
                                    ]) !!}
                                    <span class="ml-2">Enable Push Notification</span>
                                </label>
                            </div>

                            <!-- KYC Verification -->
                            <div class="card bg-base-100 shadow-md sm:mb-2 p-6">
                                <h2 class="card-title">KYC Verification</h2>
                                <p class="text-sm text-gray-500">Require KYC verification for user accounts.</p>
                                <label class="cursor-pointer flex items-center mt-2">
                                    {!! view('admin.components.toggle', [
                                        'items' => ['name' => 'app_kyc_verification'],
                                        'selected' => $app->app_kyc_verification ?? '0',
                                    ]) !!}
                                    <span class="ml-2">Enable KYC Verification</span>
                                </label>
                            </div>
                        </div>
                    </div>
                @endif

                <!-- Save Button -->
                <div class="mt-10 text-center">
                    <button class="btn btn-primary w-full max-w-md">Save Settings</button>
                </div>
            </form>
        </div>
    </div>

@endsection
@section('downjs')
    <script></script>
@endsection
