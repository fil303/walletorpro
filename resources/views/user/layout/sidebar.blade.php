<div class="max-w-2xl mx-auto h-full overflow-hidden bg-base-100">
    <aside class="w-52 h-full" aria-label="Sidebar">
        <div class="px-3 py-4 h-screen overflow-y-auto">
            <div class="flex">
                <div class="sm:hidden">
                    <a href="#" class="flex items-center">
                        <img src="{{ asset($app->app_logo ?? '') }}" class="mr-3 h-40 sm:h-20 w-60 sm:w-40" alt="{{ $app->app_title ?? "App Name" }}" loading="lazy" />
                    </a>
                </div>
                <div class="hidden sm:block">
                    <button id="sidebar_button" type="button" class="inline-flex items-center p-2 ml-1 text-sm rounded-lg focus:outline-none focus:ring-2" >
                        <span class="sr-only"></span>
                        <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                </div>
            </div>
            <div class="divider"></div>
            <ul class="space-y-2">
            <h2
                class="py-3 px-7 flex items-center uppercase font-extrabold -mx-4 mb-1">

                <svg class="w-4 h-5 flex-none hidden" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"
                    fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="5" y1="12" x2="19" y2="12"></line>
                </svg>
                <span>{{ __('Dashboard') }}</span>
            </h2><hr>

            {{-- Dashboard --}}
            <li>
                <a href="{{ route('userDashboard') }}"
                    class="flex items-center p-2 font-normal rounded-lg hover:bg-primary">
                    <svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3">{{ __('Dashboard') }}</span>
                </a>
            </li>

            {{-- Wallet --}}
            <li>
                <a href="{{ route('cryptoWalletPage') }}"
                    class="flex items-center p-2 font-normal rounded-lg hover:bg-primary">
                    <svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3">{{ __('My Wallets') }}</span>
                </a>
            </li>

            {{-- Support --}}
            <li>
                <a href="{{ route('supportPage') }}"
                    class="flex items-center p-2 font-normal rounded-lg hover:bg-primary">
                    <svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3">{{ __('Get Support') }}</span>
                </a>
            </li>

            {{-- Staking --}}
            <li>
                <a href="{{ route('stakingHistoryPage') }}"
                    class="flex items-center p-2 font-normal rounded-lg hover:bg-primary">
                    <svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3">{{ __('Staking') }}</span>
                </a>
            </li>

            {{-- Exchange Coin --}}
            <li>
                <a href="{{ route('exchangePage') }}"
                    class="flex items-center p-2 font-normal rounded-lg hover:bg-primary">
                    <svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-primary-100"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3">{{ __('Exchange Coin') }}</span>
                </a>
            </li>

            {{-- Buy Coin --}}
            <li>
                <a href="{{ route('coinBuyPage') }}"
                    class="flex items-center p-2 font-normal rounded-lg hover:bg-primary">
                    <svg class="w-6 h-6 text-gray-500 transition duration-75 group-hover:text-primary-100"
                        fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                        <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                        <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                    </svg>
                    <span class="ml-3">{{ __('Crypto Purchase') }}</span>
                </a>
            </li>

            {{-- Transactions --}}
            <li>
                <button type="button" class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group hover:bg-primary" aria-controls="transactions_dropdown" data-collapse-toggle="transactions_dropdown">
                    <svg class="flex-shrink-0 w-6 h-6 text-gray-500 transition duration-75 group-hover:text-gray-900" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                    <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ __("Transactions") }}</span>
                    <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                </button>
                <ul id="transactions_dropdown" class="hidden py-2 space-y-2">
                    <li>
                        <a href="{{ route('allTransactions') }}"
                            class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11 hover:bg-secondary">{{ __("All Transactions") }}</a>
                    </li>
                    <li>
                        <a href="{{ route('cryptoTransactions') }}"
                            class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11 hover:bg-secondary">{{ __("Crypto Buy") }}</a>
                    </li>
                </ul>
            </li>
            </ul>
        </div>
    </aside>
</div>