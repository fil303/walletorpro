@extends('layout.app', [ 'menu' => 'setting' ])

@section('title', __('Email Setting'))

@section('content')

    <h2 class="card-title">{{ __('SMTP Email Configuration') }}</h2>
    <div class="divider"></div>

    <div class="min-h-screen bg-base-200 flex items-center justify-center p-10">

        <!-- GDPR Cookie Settings Card -->
        <div class="card w-full max-w-4xl bg-white shadow-xl">
            <div class="card-body">
                <h2 class="card-title text-3xl font-bold text-primary mb-6">GDPR Cookie Settings</h2>

                <!-- Enable/Disable Cookie Consent -->
                <div class="form-control mb-6">
                    <label class="cursor-pointer flex items-center">
                        <input type="checkbox" id="enable-consent" class="toggle toggle-primary" checked />
                        <span class="label-text ml-3">Enable Cookie Consent Banner</span>
                    </label>
                </div>

                <!-- Tabs for Different Cookie Types -->
                <div class="tabs mb-6">
                    <a class="tab tab-bordered tab-active" id="tab-necessary" onclick="switchTab('necessary')">Necessary
                        Cookies</a>
                    <a class="tab tab-bordered" id="tab-performance" onclick="switchTab('performance')">Performance
                        Cookies</a>
                    <a class="tab tab-bordered" id="tab-functional" onclick="switchTab('functional')">Functional Cookies</a>
                </div>

                <!-- Cookie Settings Panels -->
                <div id="tab-content">
                    <!-- Necessary Cookies -->
                    <div class="content-necessary">
                        <h3 class="text-xl font-semibold mb-2">Necessary Cookies</h3>
                        <p class="mb-4 text-gray-600">These cookies are essential for the website to function properly. They
                            cannot be disabled.</p>
                        <label class="cursor-pointer flex items-center">
                            <input type="checkbox" class="checkbox checkbox-primary" checked disabled />
                            <span class="label-text ml-3">Enable Necessary Cookies</span>
                        </label>
                    </div>

                    <!-- Performance Cookies -->
                    <div class="content-performance hidden">
                        <h3 class="text-xl font-semibold mb-2">Performance Cookies</h3>
                        <p class="mb-4 text-gray-600">These cookies help us improve the website's performance by collecting
                            anonymous data about usage.</p>
                        <label class="cursor-pointer flex items-center">
                            <input type="checkbox" class="checkbox checkbox-primary" id="performance-cookies" />
                            <span class="label-text ml-3">Enable Performance Cookies</span>
                        </label>
                    </div>

                    <!-- Functional Cookies -->
                    <div class="content-functional hidden">
                        <h3 class="text-xl font-semibold mb-2">Functional Cookies</h3>
                        <p class="mb-4 text-gray-600">These cookies enable additional functionality like remembering your
                            preferences.</p>
                        <label class="cursor-pointer flex items-center">
                            <input type="checkbox" class="checkbox checkbox-primary" id="functional-cookies" />
                            <span class="label-text ml-3">Enable Functional Cookies</span>
                        </label>
                    </div>
                </div>

                <!-- Save and Test Banner -->
                <div class="mt-8 flex justify-between">
                    <button class="btn btn-outline" onclick="resetCookies()">Reset to Default</button>
                    <div>
                        <button class="btn btn-outline mr-2" onclick="showTestBanner()">Test Cookie Banner</button>
                        <button class="btn btn-primary" onclick="saveSettings()">Save Settings</button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Test Cookie Banner -->
        <div id="cookie-banner"
            class="hidden fixed bottom-0 left-0 right-0 bg-gray-800 text-white p-4 flex justify-between items-center">
            <p class="text-sm">We use cookies to ensure you get the best experience on our website. <a href="#"
                    class="underline">Learn more</a></p>
            <button class="btn btn-primary btn-sm" onclick="acceptCookies()">Accept</button>
        </div>

        <script>
            // Switch between cookie types tabs
            function switchTab(tab) {
                document.querySelectorAll('.tabs a').forEach(tabBtn => tabBtn.classList.remove('tab-active'));
                document.querySelectorAll('#tab-content > div').forEach(content => content.classList.add('hidden'));

                document.querySelector(`#tab-${tab}`).classList.add('tab-active');
                document.querySelector(`.content-${tab}`).classList.remove('hidden');
            }

            // Simulate saving settings
            function saveSettings() {
                alert("GDPR Cookie settings saved!");
            }

            // Test cookie banner
            function showTestBanner() {
                const banner = document.getElementById('cookie-banner');
                banner.classList.remove('hidden');
            }

            // Accept cookies and hide the banner
            function acceptCookies() {
                const banner = document.getElementById('cookie-banner');
                banner.classList.add('hidden');
            }

            // Reset cookies to default settings
            function resetCookies() {
                document.getElementById('performance-cookies').checked = false;
                document.getElementById('functional-cookies').checked = false;
                alert("Cookie settings reset to default.");
            }
        </script>

    </div>
@endsection
