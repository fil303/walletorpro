@extends('layout.app')

@section('title', __('Two-Factor Authentication'))

@section('content')

    <div class="card bg-base-100">
        <div class="card-body">
            <div class="flex justify-between">
                <h2 class="card-title">{{ __('Password Reset') }}</h2>
                <a href="{{ route('userProfile') }}" class="btn">
                    <svg class="lucide lucide-undo-2 h-6 w-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                        viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                        stroke-linejoin="round">
                        <path d="M9 14 4 9l5-5" />
                        <path d="M4 9h10.5a5.5 5.5 0 0 1 5.5 5.5a5.5 5.5 0 0 1-5.5 5.5H11" />
                    </svg>
                    {{ __("Button") }}
                </a>
            </div>
            <div class="rounded-lg bg-base-500 shadow-sm">
                <div class="flex flex-col space-y-1.5 p-6">
                    <h3 class="tracking-tight text-2xl font-bold">{{ __('Two-Factor Authentication') }}</h3>
                    <p class="text-sm text-muted-foreground">{{ __('Secure your account with 2FA') }}</p>
                </div>
                <div class="p-6 pt-0 space-y-6">
                    <div class="flex items-center justify-between p-4 bg-base-100 rounded-lg">
                        <div class="flex items-center space-x-4"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-qr-code w-8 h-8 text-blue-500">
                                <rect width="5" height="5" x="3" y="3" rx="1"></rect>
                                <rect width="5" height="5" x="16" y="3" rx="1"></rect>
                                <rect width="5" height="5" x="3" y="16" rx="1"></rect>
                                <path d="M21 16h-3a2 2 0 0 0-2 2v3"></path>
                                <path d="M21 21v.01"></path>
                                <path d="M12 7v3a2 2 0 0 1-2 2H7"></path>
                                <path d="M3 12h.01"></path>
                                <path d="M12 3h.01"></path>
                                <path d="M12 16v.01"></path>
                                <path d="M16 12h1"></path>
                                <path d="M21 12v.01"></path>
                                <path d="M12 21v-1"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold">Google Authenticator</h3>
                                <p class="text-sm text-gray-500">Use Google Authenticator app</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if ($user->google_2fa ?? false)
                                <span class="text-sm text-primary">{{ __('Enabled') }}</span>
                            @else
                                <span class="text-sm text-red-500">{{ __('Disabled') }}</span>
                            @endif
                            {!! view('admin.components.toggle', [
                                'items' => ['onchange' => 'openModal(this)', 'data-for' => 'google'],
                                'selected' => $user->google_2fa ?? false,
                            ]) !!}
                        </div>
                    </div>
                    @if(false)
                    <div class="flex items-center justify-between p-4 bg-base-100 rounded-lg">
                        <div class="flex items-center space-x-4"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round" class="lucide lucide-mail w-8 h-8 text-blue-500">
                                <rect width="20" height="16" x="2" y="4" rx="2"></rect>
                                <path d="m22 7-8.97 5.7a1.94 1.94 0 0 1-2.06 0L2 7"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold">Email Authentication</h3>
                                <p class="text-sm text-gray-500">Receive codes via email</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if ($user->email_2fa ?? false)
                                <span class="text-sm text-primary">{{ __('Enabled') }}</span>
                            @else
                                <span class="text-sm text-red-500">{{ __('Disabled') }}</span>
                            @endif
                            {!! view('admin.components.toggle', [
                                'items' => ['onchange' => 'openModal(this)', 'data-for' => 'email'],
                                'selected' => $user->email_2fa ?? false,
                            ]) !!}
                        </div>
                    </div>
                    <div class="flex items-center justify-between p-4 bg-base-100 rounded-lg">
                        <div class="flex items-center space-x-4"><svg xmlns="http://www.w3.org/2000/svg" width="24"
                                height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round"
                                class="lucide lucide-smartphone w-8 h-8 text-blue-500">
                                <rect width="14" height="20" x="5" y="2" rx="2" ry="2"></rect>
                                <path d="M12 18h.01"></path>
                            </svg>
                            <div>
                                <h3 class="font-semibold">SMS Authentication</h3>
                                <p class="text-sm text-gray-500">Receive codes via SMS</p>
                            </div>
                        </div>
                        <div class="flex items-center space-x-2">
                            @if ($user->phone_2fa ?? false)
                                <span class="text-sm text-primary">{{ __('Enabled') }}</span>
                            @else
                                <span class="text-sm text-red-500">{{ __('Disabled') }}</span>
                            @endif
                            {!! view('admin.components.toggle', [
                                'items' => ['onchange' => 'openModal(this)', 'data-for' => 'phone'],
                                'selected' => $user->phone_2fa ?? false,
                            ]) !!}
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {{-- // Google Authentication --}}
    <div class="modal" role="dialog" id="google2fa">
        <div class="modal-box">
            <div class="modal-action">
                <a href="#" onclick="closeModal()"
                    class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</a>
            </div>
            <div class="rounded-lg bg-card text-card-foreground shadow-sm w-full max-w-md mx-auto">
                <div class="flex flex-col text-center space-y-1.5 p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">
                        {{ __('Set up Two-Factor Authentication') }}</h3>
                    <p class="text-sm text-muted-foreground">{{ __('Scan the QR code with your authenticator app') }}</p>
                </div>

                <div class="flex flex-col items-center space-y-4">
                    @if (!($user->google_2fa ?? false))
                        {{-- src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&amp;data=otpauth://totp/Example:alice@google.com?secret=JBSWY3DPEHPK3PXP&amp;issuer=Example" --}}
                        <img src="https://api.qrserver.com/v1/create-qr-code/?size=150x150&amp;data={{ $qrcode ?? '' }}"
                            alt="QR Code" class="w-40 h-40">
                        <p class="text-sm">{{ __('Secret Key') }}: <span
                                class="font-mono">{{ $google2fa_secret ?? __('Not Found') }}</span></p>
                    @endif
                    <form action="{{ route('twoFactorSetup') }}" method="post" class="w-full space-y-4">
                        @csrf
                        <input type="hidden" name="type" value="google" />
                        <input type="hidden" name="secretKey" value="{{ $google2fa_secret ?? '' }}" />
                        <label for="form-control">
                            <input type="text" name="code" class="input input-rounded bg-base-300 w-full"
                                placeholder="{{ __('Enter 6-digit PIN') }}" maxlength="6" value="">
                        </label>
                        <button class="btn btn-primary w-full" type="submit">
                            {{ __('Verify and Enable 2FA') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>

    {{-- // Email Authentication --}}
    <dialog id="email_auth" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button onclick="closeModal()" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <div class="rounded-lg bg-card text-card-foreground shadow-sm w-full max-w-md mx-auto">
                <div class="flex flex-col text-center space-y-1.5 p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">
                        {{ __('Set up Two-Factor Authentication') }}</h3>
                    <p class="text-sm text-muted-foreground">{{ __('Scan the QR code with your authenticator app') }}</p>
                </div>

                <div class="flex flex-col items-center space-y-4">
                    <form action="{{ route('twoFactorSetup') }}" method="post" class="w-full space-y-4">
                        @csrf
                        <input type="hidden" name="type" value="email" />
                        <label for="form-control">
                            <input type="text" name="code" class="input input-rounded bg-base-300 w-full"
                                placeholder="Enter 6-digit PIN" maxlength="6" value="">
                        </label>
                        <button class="btn btn-primary w-full" type="submit">
                            {{ __('Verify and Enable 2FA') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </dialog>

    {{-- // Phone SMS Authentication --}}
    <dialog id="phone_auth" class="modal">
        <div class="modal-box">
            <form method="dialog">
                <button onclick="closeModal()" class="btn btn-sm btn-circle btn-ghost absolute right-2 top-2">✕</button>
            </form>
            <div class="rounded-lg bg-card text-card-foreground shadow-sm w-full max-w-md mx-auto">
                <div class="flex flex-col text-center space-y-1.5 p-6">
                    <h3 class="text-2xl font-semibold leading-none tracking-tight">
                        {{ __('Set up Two-Factor Authentication') }}</h3>
                    <p class="text-sm text-muted-foreground">{{ __('Scan the QR code with your authenticator app') }}</p>
                </div>

                <div class="flex flex-col items-center space-y-4">
                    <form action="{{ route('twoFactorSetup') }}" method="post" class="w-full space-y-4">
                        @csrf
                        <input type="hidden" name="type" value="phone" />
                        <label for="form-control">
                            <input type="text" name="code" class="input input-rounded bg-base-300 w-full"
                                placeholder="Enter 6-digit PIN" maxlength="6" value="">
                        </label>
                        <button class="btn btn-primary w-full" type="submit">
                            {{ __('Verify and Enable 2FA') }}
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </dialog>

@endsection
@section('downjs')
    <script>
        let currentSelectedToggle = null;

        function openModal(toggle) {
            currentSelectedToggle = toggle;
            let forModal = toggle.dataset.for;

            if (forModal == "google") window.location.href = "#google2fa" //google_auth.showModal();
            if (forModal == "email") email_auth.showModal();
            if (forModal == "phone") phone_auth.showModal();
        }

        function closeModal() {
            currentSelectedToggle.checked = !currentSelectedToggle.checked;
        }
    </script>
@endsection
