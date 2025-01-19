    <!-- SIDEBAR -->
    <aside id="sidebar" class="sm:hidden sm:absolute sm:top-15 sm:z-50 sm:left-0 min-w-[200px] bg-base-100 p-1 h-screen z-10 overflow-y-auto">
        <!-- Sidebar Logo & Toggle Button -->
        <div class="flex items-center justify-between p-4 text-white">
            <img src="{{ asset_bind($app->app_logo ?? '') }}" loading="lazy" class="h-[50px] m:w-[100px] m:h-[50px] m:w-[250px]" alt="App Logo">
            <button onclick="smSidebarToggle()" @click="openSidebar = !openSidebar" class="btn btn-ghost hidden sm:!block ">
                <svg class="lucide text-primary lucide-circle-chevron-left swap-on" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m14 16-4-4 4-4"/></svg>
            </button>
        </div>

        <!-- Sidebar Menu -->
        <nav class=" pl-1 space-y-2" x-data="{ selected: '{{ $menu ?? "null" }}', sub_selected: '{{ $sub_menu ?? "null" }}' }">
            <!-- Dashboard -->
            <a href="{{ route('userDashboard') }}" :class="{'bg-accent base-content ': selected === 'dashboard'}" class="block flex space-x-2 p-2 hover:bg-base-400 rounded-md active:bg-primary active:text-white">
                <svg class="lucide text-primary lucide-chart-pie w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12c.552 0 1.005-.449.95-.998a10 10 0 0 0-8.953-8.951c-.55-.055-.998.398-.998.95v8a1 1 0 0 0 1 1z"/><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/>
                </svg>
                <span> {{__("Dashboard")}} </span>
            </a>

            <!-- My Wallets -->
            <a href="{{ route('cryptoWalletPage') }}" :class="{'bg-accent base-content ': selected === 'wallet'}" class="block flex space-x-2 p-2 hover:bg-base-400 rounded-md active:bg-primary active:text-white">
                <svg class="lucide text-primary lucide-wallet w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/>
                    <path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/>
                </svg>
                <span> {{__("My Wallets")}} </span>
            </a>

            <!-- Coin Purchase -->
            <a href="{{ route('coinBuyPage') }}" :class="{'bg-accent base-content ': selected === 'coin_purchase'}" class="block flex space-x-2 p-2 hover:bg-base-400 rounded-md active:bg-primary active:text-white">
                <svg class="lucide text-primary lucide-store w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="m2 7 4.41-4.41A2 2 0 0 1 7.83 2h8.34a2 2 0 0 1 1.42.59L22 7"/>
                    <path d="M4 12v8a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2v-8"/><path d="M15 22v-4a2 2 0 0 0-2-2h-2a2 2 0 0 0-2 2v4"/>
                    <path d="M2 7h20"/><path d="M22 7v3a2 2 0 0 1-2 2a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 16 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 12 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 8 12a2.7 2.7 0 0 1-1.59-.63.7.7 0 0 0-.82 0A2.7 2.7 0 0 1 4 12a2 2 0 0 1-2-2V7"/>
                </svg>
                <span> {{__("Coin Purchase")}} </span>
            </a>

            <!-- Exchange Coin -->
            <a href="{{ route('exchangePage') }}" :class="{'bg-accent base-content ': selected === 'exchange'}" class="block flex space-x-2 p-2 hover:bg-base-400 rounded-md active:bg-primary active:text-white">
                <svg class="lucide text-primary lucide-arrow-down-up w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" >
                    <path d="m3 16 4 4 4-4"/><path d="M7 20V4"/>
                    <path d="m21 8-4-4-4 4"/><path d="M17 4v16"/>
                </svg>
                <span> {{__("Exchange Coin")}} </span>
            </a>

            <!-- Staking -->
            <a href="{{ route('stakingHistoryPage') }}" :class="{'bg-accent base-content ': selected === 'staking'}" class="block flex space-x-2 p-2 hover:bg-base-400 rounded-md active:bg-primary active:text-white">
                <svg class="lucide text-primary lucide-hand-coins w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17"/><path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/>
                    <path d="m2 16 6 6"/><circle cx="16" cy="9" r="2.9"/><circle cx="6" cy="5" r="3"/></svg>
                <span> {{__("Staking")}} </span>
            </a>

            <!-- Report -->
            <div x-data="{ open: {{ $open_report_menu ?? 'false'}} }" class="relative">
                <a href="#" @click="open = !open; selected = 'report'" :class="{'bg-accent base-content text-white': selected === 'report'}" class="block p-2 hover:bg-gray-300 rounded-md flex space-x-2 items-center">
                    <svg class="lucide text-primary lucide-file-text w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
                        <path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>
                    </svg>
                    <span>
                        {{__("Report")}}
                        {{-- <span class="badge badge-error absolute top-2 right-10">5</span> --}}
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform absolute right-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </a>
                <ul x-show="open" x-transition class="pl-4 mt-2 space-y-1">
                    <li><a href="{{ route('depositReportPage') }}" href="#" @click="sub_selected = 'deposit'" :class="{'bg-accent base-content text-white': sub_selected === 'deposit'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Deposit") }}</a></li>
                    <li><a href="{{ route('withdrawalReportPage') }}" href="#" @click="sub_selected = 'withdrawal'" :class="{'bg-accent base-content text-white': sub_selected === 'withdrawal'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Withdrawal") }}</a></li>
                    <li><a href="{{ route('coinPurchaseReportPage') }}" href="#" @click="sub_selected = 'purchase'" :class="{'bg-accent base-content text-white': sub_selected === 'purchase'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Coin Purchase") }}</a></li>
                    <li><a href="{{ route('coinExchangeReportPage') }}" href="#" @click="sub_selected = 'exchange'" :class="{'bg-accent base-content text-white': sub_selected === 'exchange'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Coin Exchange") }}</a></li>
                    <li><a href="{{ route('coinStakingReportPage') }}" href="#" @click="sub_selected = 'staking'" :class="{'bg-accent base-content text-white': sub_selected === 'staking'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Coin Staking") }}</a></li>
                </ul>
            </div>

            <!-- Setting -->
            <a href="{{ route('userProfile') }}" class="block flex space-x-2 p-2 hover:bg-base-400 rounded-md active:bg-primary active:text-white">
                <svg class="lucide text-primary lucide-ticket-check w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12.22 2h-.44a2 2 0 0 0-2 2v.18a2 2 0 0 1-1 1.73l-.43.25a2 2 0 0 1-2 0l-.15-.08a2 2 0 0 0-2.73.73l-.22.38a2 2 0 0 0 .73 2.73l.15.1a2 2 0 0 1 1 1.72v.51a2 2 0 0 1-1 1.74l-.15.09a2 2 0 0 0-.73 2.73l.22.38a2 2 0 0 0 2.73.73l.15-.08a2 2 0 0 1 2 0l.43.25a2 2 0 0 1 1 1.73V20a2 2 0 0 0 2 2h.44a2 2 0 0 0 2-2v-.18a2 2 0 0 1 1-1.73l.43-.25a2 2 0 0 1 2 0l.15.08a2 2 0 0 0 2.73-.73l.22-.39a2 2 0 0 0-.73-2.73l-.15-.08a2 2 0 0 1-1-1.74v-.5a2 2 0 0 1 1-1.74l.15-.09a2 2 0 0 0 .73-2.73l-.22-.38a2 2 0 0 0-2.73-.73l-.15.08a2 2 0 0 1-2 0l-.43-.25a2 2 0 0 1-1-1.73V4a2 2 0 0 0-2-2z"/>
                    <circle cx="12" cy="12" r="3"/>
                </svg>
                <span> {{__("Profile Setting")}} </span>
            </a>

            <!-- Get Support -->
            <a href="{{ route('supportPage') }}" :class="{'bg-accent base-content ': selected === 'support'}" class="block flex space-x-2 p-2 hover:bg-base-400 rounded-md active:bg-primary active:text-white">
                <svg class="lucide text-primary lucide-hand-heart w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 14h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 16"/><path d="m7 20 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/><path d="m2 15 6 6"/>
                    <path d="M19.5 8.5c.7-.7 1.5-1.6 1.5-2.7A2.73 2.73 0 0 0 16 4a2.78 2.78 0 0 0-5 1.8c0 1.2.8 2 1.5 2.8L16 12Z"/>
                </svg>
                <span> {{__("Get Support")}} </span>
            </a>

            <!-- Logout -->
            <a href="{{ route('logout') }}" class="block flex space-x-2 p-2 hover:bg-base-400 rounded-md active:bg-primary active:text-white">
                <svg class="lucide text-primary lucide-log-out w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"/><polyline points="16 17 21 12 16 7"/>
                    <line x1="21" x2="9" y1="12" y2="12"/>
                </svg>
                <span> {{__("Logout")}} </span>
            </a>
        </nav>
    </aside>