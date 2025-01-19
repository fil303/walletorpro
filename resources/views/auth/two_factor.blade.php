@extends('auth.master')

@section('title', __('Exchange Coins'))

@section('content')

    {!! view('user.components.bg_rn_shap_style') !!}
    {{-- {!! include(public_path('assets/svg/animated/bg_rn_shap.svg')) !!} --}}
    <div class="min-h-screen flex justify-center items-center p-4">
        <div class="rounded-lg border shadow-sm w-full max-w-xl h-xl max-h-[400px]">

            <div class="card bg-base-100 shadow-xl p-8">
                <h2 class="text-center text-2xl font-bold mb-6">Two-Factor Authentication</h2>

                <!-- Tabs for 2FA Options -->
                <div class="tabs tabs-boxed mb-6">
                    <a class="tab tab-active" id="google-tab" onclick="showTab('google')">Authenticator</a>
                    <a class="tab hidden" id="email-tab" onclick="showTab('email')">Email</a>
                    <a class="tab hidden" id="phone-tab" onclick="showTab('phone')">Phone</a>
                </div>

                <!-- Google Authenticator Verification -->
                <div id="google-auth" class="">
                    <form action="{{ route('twoFactorVerifyProcess') }}" method="post">@csrf
                        <input type="hidden" name="type" value="google">
                        <p class="mb-4 text-neutral-600">Please enter the 6-digit code from your Google Authenticator app.</p>
                        <div class="form-control w-full relative mb-4">
                            <input name="code" type="text" placeholder="Enter Google Authenticator code" class="input input-bordered w-full pl-10" />
                            <svg class="lucide lucide-square-asterisk w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect width="18" height="18" x="3" y="3" rx="2"/>
                                <path d="M12 8v8"/><path d="m8.5 14 7-4"/><path d="m8.5 10 7 4"/>
                            </svg>
                        </div>
                        <div class="form-control w-full grid grid-cols-1 justify-between">
                            <button class="btn btn-primary w-full" type="submit">Verify</button>
                        </div>
                    </form>
                </div>

                <!-- Email Verification -->
                <div id="email-auth" class=" hidden">
                    <form action="{{ route('twoFactorVerifyProcess') }}" method="post">@csrf
                        <input type="hidden" name="type" value="email">
                        <p class="mb-4 text-neutral-600">Please enter the verification code sent to your email.</p>
                        <div class="form-control w-full relative mb-4">
                            <input name="code" type="text" placeholder="Enter email verification code" class="input input-bordered w-full pl-10" />
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" viewBox="0 0 20 20" fill="currentColor">
                            <path d="M2 5a2 2 0 012-2h12a2 2 0 012 2v10a2 2 0 01-2 2H4a2 2 0 01-2-2V5zm12 0H6v2h8V5z" />
                            </svg>
                        </div>
                        <div class="form-control w-full grid grid-cols-2 gap-2 justify-between">
                            <button class="btn btn-primary" id="send-email" onclick="sendEmailCode()">Send Email Code</button>
                            <button class="btn btn-primary w-full" type="submit">Verify</button>
                        </div>
                    </form>
                </div>

                <!-- Phone Verification -->
                <div id="phone-auth" class=" hidden">
                    <form action="{{ route('twoFactorVerifyProcess') }}" method="post">@csrf
                        <input type="hidden" name="type" value="phone">
                        <p class="mb-4 text-neutral-600">Please enter the verification code sent to your phone.</p>
                        <div class="form-control w-full relative mb-4">
                            <input name="code" type="text" placeholder="Enter phone verification code" class="input input-bordered w-full pl-10" />
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 absolute left-3 top-1/2 transform -translate-y-1/2 text-gray-500" viewBox="0 0 24 24" fill="currentColor">
                            <path d="M17 2H7a2 2 0 00-2 2v16a2 2 0 002 2h10a2 2 0 002-2V4a2 2 0 00-2-2zm0 18H7V4h10v16zM9 5h6v1H9V5z" />
                            </svg>
                        </div>
                        <div class="form-control w-full grid grid-cols-2 gap-2 justify-between">
                            <button class="btn btn-primary" id="send-phone" onclick="sendPhoneCode()">Send Phone Code</button>
                            <button class="btn btn-primary w-full" type="submit">Verify</button>
                        </div>
                    </form>
                </div>

                <!-- Go back option -->
                <p class="text-center mt-4">
                <a href="{{ route('logout') }}" class="link link-primary">{{__("Go back to Login")}}</a>
                </p>
            </div>

        </div>
    </div>

@endsection
@section("downjs")

        <script>
        // Function to show a specific tab and hide others
        function showTab(tabName) {
        // Hide all tab content
        document.getElementById('google-auth').classList.add('hidden');
        document.getElementById('email-auth').classList.add('hidden');
        document.getElementById('phone-auth').classList.add('hidden');

        // Show the selected tab content
        document.getElementById(tabName + '-auth').classList.remove('hidden');

        // Remove 'tab-active' class from all tabs
        document.getElementById('google-tab').classList.remove('tab-active');
        document.getElementById('email-tab').classList.remove('tab-active');
        document.getElementById('phone-tab').classList.remove('tab-active');

        // Add 'tab-active' class to the selected tab
        document.getElementById(tabName + '-tab').classList.add('tab-active');
        }

        // Simulate sending an email code
        function sendEmailCode() {
        document.getElementById('send-email').innerText = "Email Sent"
        document.getElementById('send-email').disabled = true;

        // Enable the Resend button after 60 seconds
        setTimeout(function() {
            document.getElementById('send-email').innerText = "Resend Email"
            document.getElementById('send-email').disabled = false;
        }, 10000); // 60 seconds
        }

        // Simulate sending a phone code
        function sendPhoneCode() {
        document.getElementById('send-phone').innerText = "SMS Sent"
        document.getElementById('send-phone').disabled = true;

        // Enable the Resend button after 60 seconds
        setTimeout(function() {
            document.getElementById('send-phone').innerText = "Resend SMS"
            document.getElementById('send-phone').disabled = false;
        }, 10000); // 60 seconds
        }
    </script>

@endsection
