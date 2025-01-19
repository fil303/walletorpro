@extends('layout.app', [ 'menu' => 'setting' ])

@section('title', __('Email Setting'))

@section('content')
    <style>
        /* Custom hover effect for the cards */
        .card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }
    </style>
    <div class="bg-base-200">

        <!-- Page Container -->
        <div class="container mx-auto p-8">
            <h1 class="text-3xl font-bold mb-6 text-center">Settings Dashboard</h1>

            <!-- Content Section -->
            <div class="grid sm:block lg:grid-cols-2 grid-cols-3 gap-6" id="general-settings">

                <!-- General Settings Cards -->
                <div class="card bg-base-100 shadow-xl mb-2">
                    <div class="card-body">
                        <div class="flex items-center mb-4">
                            <svg class="lucide lucide-settings w-6 h-6 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/>
                                <circle cx="12" cy="12" r="3"/>
                            </svg>
                            <h2 class="card-title ml-4">General Settings</h2>
                        </div>
                        <p>Configure general settings such as site name, description, and more.</p>
                        <a href="{{ route('basicSettingPage') }}" class="btn btn-primary mt-4">Configure General</a>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl mb-2">
                    <div class="card-body">
                        <div class="flex items-center mb-4">
                            <svg class="lucide lucide-mails w-6 h-6 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="16" height="13" x="6" y="4" rx="2"/>
                                <path d="m22 7-7.1 3.78c-.57.3-1.23.3-1.8 0L6 7"/><path d="M2 8v11c0 1.1.9 2 2 2h14"/>
                            </svg>
                            <h2 class="card-title ml-4">Email Settings</h2>
                        </div>
                        <p>Manage your email configurations and templates for notifications.</p>
                        <a href="{{ route('emailSettingPage') }}" class="btn btn-primary mt-4">Configure Email</a>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl mb-2">
                    <div class="card-body">
                        <div class="flex items-center mb-4">
                            <svg class="lucide lucide-message-circle-more w-6 h-6 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M7.9 20A9 9 0 1 0 4 16.1L2 22Z"/>
                                <path d="M8 12h.01"/><path d="M12 12h.01"/><path d="M16 12h.01"/>
                            </svg>
                            <h2 class="card-title ml-4">SMS Settings</h2>
                        </div>
                        <p>Configure SMS notifications and gateways for user interaction.</p>
                        <a href="{{ route('smsSettingPage') }}" class="btn btn-primary mt-4">Configure SMS</a>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl mb-2">
                    <div class="card-body">
                        <div class="flex items-center mb-4">
                            <svg class="lucide lucide-bitcoin w-6 h-6 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M11.767 19.089c4.924.868 6.14-6.025 1.216-6.894m-1.216 6.894L5.86 18.047m5.908 1.042-.347 1.97m1.563-8.864c4.924.869 6.14-6.025 1.215-6.893m-1.215 6.893-3.94-.694m5.155-6.2L8.29 4.26m5.908 1.042.348-1.97M7.48 20.364l3.126-17.727"/>
                            </svg>
                            <h2 class="card-title ml-4">{{__('Coin Provider')}}</h2>
                        </div>
                        <p>Manage configurations for cryptocurrency providers and services integrated into your platform.</p>
                        <a href="{{ route('coinProviderPage') }}" class="btn btn-primary mt-4">Configure {{__('Coin Provider')}}</a>
                    </div>
                </div>

                <!-- Appearance Settings Cards -->
                <div class="card bg-base-100 shadow-xl mb-2">
                    <div class="card-body">
                        <div class="flex items-center mb-4">
                            <svg class="lucide lucide-palette w-6 h-6 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <circle cx="13.5" cy="6.5" r=".5" fill="currentColor"/><circle cx="17.5" cy="10.5" r=".5" fill="currentColor"/><circle cx="8.5" cy="7.5" r=".5" fill="currentColor"/><circle cx="6.5" cy="12.5" r=".5" fill="currentColor"/>
                                <path d="M12 2C6.5 2 2 6.5 2 12s4.5 10 10 10c.926 0 1.648-.746 1.648-1.688 0-.437-.18-.835-.437-1.125-.29-.289-.438-.652-.438-1.125a1.64 1.64 0 0 1 1.668-1.668h1.996c3.051 0 5.555-2.503 5.555-5.554C21.965 6.012 17.461 2 12 2z"/>
                            </svg>
                            <h2 class="card-title ml-4">Theme Settings</h2>
                        </div>
                        <p>Customize the theme and colors of your site.</p>
                        <a href="{{ route('themeSettingPage') }}" class="btn btn-primary mt-4">Configure Theme</a>
                    </div>
                </div>

                <div class="card bg-base-100 shadow-xl mb-2">
                    <div class="card-body">
                        <div class="flex items-center mb-4">
                            <svg class="lucide lucide-image w-6 h-6 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <rect width="18" height="18" x="3" y="3" rx="2" ry="2"/>
                                <circle cx="9" cy="9" r="2"/><path d="m21 15-3.086-3.086a2 2 0 0 0-2.828 0L6 21"/>
                            </svg>
                            <h2 class="card-title ml-4">Logo & Favicon</h2>
                        </div>
                        <p>Update your site’s logo and favicon for branding.</p>
                        <a href="{{ route('logoSettingPage') }}" class="btn btn-primary mt-4">Upload Logo</a>
                    </div>
                </div>

                {{-- <div class="card bg-base-100 shadow-xl mb-2">
                    <div class="card-body">
                        <div class="flex items-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M6 18v-6a6 6 0 1112 0v6" />
                            </svg>
                            <h2 class="card-title ml-4">Maintenance Mode</h2>
                        </div>
                        <p>Enable or disable maintenance mode to take your site offline temporarily.</p>
                        <a href="{{ route('maintenanceSettingPage') }}" class="btn btn-primary mt-4">Enable
                            Maintenance</a>
                    </div>
                </div> --}}

                {{-- <div class="card bg-base-100 shadow-xl mb-2">
                    <div class="card-body">
                        <div class="flex items-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v8m0-4H8m4 0h4" />
                            </svg>
                            <h2 class="card-title ml-4">SEO Setting</h2>
                        </div>
                        <p>Manage your GDPR cookie consent banner settings.</p>
                        <a href="{{ route('seoSettingPage') }}" class="btn btn-primary mt-4">Configure GDPR</a>
                    </div>
                </div> --}}

                {{-- <div class="card bg-base-100 shadow-xl mb-2">
                    <div class="card-body">
                        <div class="flex items-center mb-4">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-primary" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M12 8v8m0-4H8m4 0h4" />
                            </svg>
                            <h2 class="card-title ml-4">GDPR Cookie</h2>
                        </div>
                        <p>Manage your GDPR cookie consent banner settings.</p>
                        <a href="{{ route('gdprSettingPage') }}" class="btn btn-primary mt-4">Configure GDPR</a>
                    </div>
                </div> --}}

                <div class="card bg-base-100 shadow-xl mb-2">
                    <div class="card-body">
                        <div class="flex items-center mb-4">
                            <svg class="lucide lucide-bot w-6 h-6 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M12 8V4H8"/><rect width="16" height="12" x="4" y="8" rx="2"/><path d="M2 14h2"/>
                                <path d="M20 14h2"/><path d="M15 13v2"/><path d="M9 13v2"/>
                            </svg>
                            <h2 class="card-title ml-4">Re-Captcha Setting</h2>
                        </div>
                        <p>Configure Google ReCAPTCHA settings to enhance your site's security against bots and spam.</p>
                        <a href="{{ route('captchaSettingPage') }}" class="btn btn-primary mt-4">Configure Re-Captcha</a>
                    </div>
                </div>
            </div>
        </div>

    </div>




@endsection
