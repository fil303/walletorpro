@extends('layout.app', [ 'menu' => 'setting' ])

@section('title', __('SMS Setting'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('SMS Configuration') }}</h2>
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
            <!-- SMS Service Settings Card -->
            <div class="card-body">
                <!-- Tabs for SMS Providers -->
                <div class="tabs tabs-boxed mb-4 bg-base-300 p-2">
                    <a id="tab-twilio" class="tab tab-active" onclick="openTab('twilio')">Twilio</a>
                    <a id="tab-messagebird" class="hidden tab" onclick="openTab('messagebird')">MessageBird</a>
                    <a id="tab-bulksms" class="hidden tab" onclick="openTab('bulksms')">BulkSMS</a>
                    <a id="tab-vonage" class="hidden tab" onclick="openTab('vonage')">Vonage</a>
                    <a id="tab-sinch" class="hidden tab" onclick="openTab('sinch')">Sinch</a>
                </div>

                <!-- Twilio Settings (First Tab Content) -->
                <div id="content-twilio" class="tab_content hidden">
                    <form action="{{ route('smsTwilioSettingSave') }}" method="post">@csrf
                        <div class="grid sm:block grid-cols-2 gap-4">
                            <!-- Twilio Account SID -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">
                                        {{ __('Twilio Account SID') }}
                                        <span class="text-error">*</span>
                                    </span>
                                </label>
                                <div class="relative">
                                    <input name="sms_twilio_sid" value="{{ $app->sms_twilio_sid ?? '' }}" type="text"
                                        placeholder="Your Twilio Account SID" class="input input-bordered w-full" />
                                </div>
                            </div>

                            <!-- Twilio Auth Token -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">
                                        Twilio Auth Token
                                        <span class="text-error">*</span>
                                    </span>
                                </label>
                                <div class="relative">
                                    <input name="sms_twilio_token" value="{{ $app->sms_twilio_token ?? '' }}" type="text"
                                        placeholder="Your Twilio Auth Token" class="input input-bordered w-full" />
                                </div>
                            </div>

                            <!-- Twilio Sender Phone Number -->
                            <div class="form-control">
                                <label class="label">
                                    <span class="label-text">
                                        Sender Phone Number
                                        <span class="text-error">*</span>
                                    </span>
                                </label>
                                <div class="relative">
                                    <input name="sms_twilio_phone" value="{{ $app->sms_twilio_phone ?? '' }}" type="text"
                                        placeholder="+1234567890" class="input input-bordered w-full" />
                                </div>
                            </div>
                        </div>

                        <!-- Save Settings Button -->
                        <div class="form-control mt-6 col-span-2">
                            <button type="submit" class="btn btn-primary w-full">Save Twilio Settings</button>
                        </div>
                    </form>
                </div>

                <!-- MessageBird Settings (Second Tab Content) -->
                <div id="content-messagebird" class="tab_content hidden">
                    <div class="grid sm:block grid-cols-2 gap-4">
                        <!-- API Key -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">MessageBird API Key</span>
                            </label>
                            <input type="text" placeholder="Your MessageBird API Key" class="input input-bordered w-full" />
                        </div>
                        <!-- Sender Phone Number -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Sender Phone Number</span>
                            </label>
                            <input type="text" placeholder="+1234567890" class="input input-bordered w-full" />
                        </div>
                    </div>
                    <!-- Save Button -->
                    <div class="form-control mt-6 col-span-2">
                        <button class="btn btn-primary w-full">Save MessageBird Settings</button>
                    </div>
                </div>

                <!-- BulkSMS Settings (Third Tab Content) -->
                <div id="content-bulksms" class="tab_content hidden">
                    <div class="grid sm:block grid-cols-2 gap-4">
                        <!-- BulkSMS API Username -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">BulkSMS API Username</span>
                            </label>
                            <input type="text" placeholder="Your BulkSMS Username" class="input input-bordered w-full" />
                        </div>
                        <!-- BulkSMS API Password -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">BulkSMS API Password</span>
                            </label>
                            <input type="password" placeholder="Your BulkSMS Password" class="input input-bordered w-full" />
                        </div>
                    </div>
                    <!-- Save Button -->
                    <div class="form-control mt-6 col-span-2">
                        <button class="btn btn-primary w-full">Save BulkSMS Settings</button>
                    </div>
                </div>

                <!-- Vonage Settings (Fourth Tab Content) -->
                <div id="content-vonage" class="tab_content hidden">
                    <div class="grid sm:block grid-cols-2 gap-4">
                        <!-- API Key -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Vonage API Key</span>
                            </label>
                            <input type="text" placeholder="Your Vonage API Key" class="input input-bordered w-full" />
                        </div>
                        <!-- API Secret -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Vonage API Secret</span>
                            </label>
                            <input type="password" placeholder="Your Vonage API Secret" class="input input-bordered w-full" />
                        </div>
                    </div>
                    <!-- Save Button -->
                    <div class="form-control mt-6 col-span-2">
                        <button class="btn btn-primary w-full">Save Vonage Settings</button>
                    </div>
                </div>

                <!-- Sinch Settings (Fifth Tab Content) -->
                <div id="content-sinch" class="tab_content hidden">
                    <div class="grid sm:block grid-cols-2 gap-4">
                        <!-- API Key -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Sinch API Key</span>
                            </label>
                            <input type="text" placeholder="Your Sinch API Key" class="input input-bordered w-full" />
                        </div>
                        <!-- Sender Phone Number -->
                        <div class="form-control">
                            <label class="label">
                                <span class="label-text">Sender Phone Number</span>
                            </label>
                            <input type="text" placeholder="+1234567890" class="input input-bordered w-full" />
                        </div>
                    </div>
                    <!-- Save Button -->
                    <div class="form-control mt-6 col-span-2">
                        <button class="btn btn-primary w-full">Save Sinch Settings</button>
                    </div>
                </div>

                <!-- Test SMS Sending -->
                <div class="form-control hidden mt-10">
                    <label class="label">
                        <span class="label-text">Send Test SMS</span>
                    </label>
                    <div class="relative">
                        <input type="text" placeholder="Enter your phone number" class="input input-bordered w-full" />
                    </div>
                    <button class="btn btn-success mt-4 w-full">Send Test SMS</button>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('downjs')
    <script>
        function openTab(tabName) {
            // Hide all tab content
            const tabContents = document.querySelectorAll('.tab_content');
            tabContents.forEach(content => {
                content.classList.add('hidden');
                content.classList.remove('tab-active')
            });

            // Remove active class from all tabs
            const tabs = document.querySelectorAll('.tab');
            tabs.forEach(tab => tab.classList.remove('tab-active'));

            // Show the selected tab content
            document.getElementById('content-' + tabName).classList.remove('hidden');
            document.getElementById('content-' + tabName).classList.add('tab-active');

            // Set the clicked tab as active
            document.getElementById('tab-' + tabName).classList.add('tab-active');
        }

        // Initially show the first tab
        document.getElementById('content-twilio').classList.remove('hidden');
        document.getElementById('content-twilio').classList.add('tab-active');
    </script>
@endsection
