@extends('layout.app', [ 'menu' => 'setting' ])

@section('title', __('Maintenance Mode'))

@section('content')

    <h2 class="card-title">{{ __('Maintenance Mode') }}</h2>
    <div class="divider"></div>

    <h1 class="text-3xl font-bold text-center mb-10 text-primary">Maintenance Mode Settings</h1>

    <!-- Maintenance Mode Toggle -->
    <div class="card bg-base-100 shadow-md p-6">
        <h2 class="card-title">Enable Maintenance Mode</h2>
        <p class="text-sm text-gray-500 mb-4">Toggle maintenance mode to temporarily take your website offline.</p>
        <label class="label cursor-pointer justify-start">
            <input id="maintenance-toggle" type="checkbox" class="toggle toggle-primary mr-3" onchange="toggleMaintenance()" />
            <span id="maintenance-status" class="text-gray-500">Maintenance mode is OFF</span>
        </label>
    </div>

    <!-- Custom Message -->
    <div class="card bg-base-100 shadow-md p-6 mt-6">
        <h2 class="card-title">Custom Maintenance Message</h2>
        <p class="text-sm text-gray-500">Display a custom message when the site is in maintenance mode.</p>
        <textarea id="custom-message" placeholder="We are currently performing maintenance. Please check back later."
            class="textarea textarea-bordered mt-2 w-full" rows="3"></textarea>
    </div>

    <!-- Bypass Maintenance -->
    <div class="card bg-base-100 shadow-md p-6 mt-6">
        <h2 class="card-title">Allowed IPs and URLs</h2>
        <p class="text-sm text-gray-500 mb-4">Allow specific IP addresses or URLs to bypass maintenance mode.</p>
        <input id="allowed-ips" type="text" placeholder="Enter IPs or URLs (comma separated)"
            class="input input-bordered w-full" />
    </div>

    <!-- Save Button -->
    <div class="mt-10 text-center">
        <button class="btn btn-primary w-full max-w-md" onclick="saveSettings()">Save Maintenance Mode Settings</button>
    </div>





@endsection
@section('downjs')
    <script>
        function toggleMaintenance() {
            const toggle = document.getElementById('maintenance-toggle');
            const status = document.getElementById('maintenance-status');
            if (toggle.checked) {
                status.textContent = 'Maintenance mode is ON';
                status.classList.remove('text-gray-500');
                status.classList.add('text-red-500');
            } else {
                status.textContent = 'Maintenance mode is OFF';
                status.classList.remove('text-red-500');
                status.classList.add('text-gray-500');
            }
        }

        function saveSettings() {
            const isMaintenanceOn = document.getElementById('maintenance-toggle').checked;
            const customMessage = document.getElementById('custom-message').value;
            const allowedIps = document.getElementById('allowed-ips').value;

            console.log({
                isMaintenanceOn,
                customMessage,
                allowedIps
            });

            alert('Maintenance mode settings saved successfully!');
        }
    </script>
@endsection
