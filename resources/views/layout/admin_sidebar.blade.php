    <!-- SIDEBAR -->
    <aside id="sidebar" class="sm:hidden sm:absolute sm:top-15 sm:z-50 sm:left-0 min-w-[200px] bg-base-100 p-1 h-screen z-10 overflow-y-auto">
        <!-- Sidebar Logo & Toggle Button -->
        <div class="flex items-center justify-between p-4 ">
            <img src="{{ asset_bind($app->app_logo ?? '') }}" loading="lazy" class="h-[50px] m:w-[100px] m:h-[50px] m:w-[250px]" alt="App Logo">
            <button onclick="smSidebarToggle()" @click="openSidebar = !openSidebar" class="btn btn-ghost hidden sm:!block ">
                <svg class="lucide text-primary lucide-circle-chevron-left swap-on" xmlns="http://www.w3.org/2000/svg" width="32" height="32" viewBox="0 0 32 32" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="12" cy="12" r="10"/><path d="m14 16-4-4 4-4"/></svg>
            </button>
        </div>

        <!-- Sidebar Menu -->
        <nav class="pl-1 space-y-2" x-data="{ selected: '{{ $menu ?? "null" }}', sub_selected: '{{ $sub_menu ?? "null" }}' }">

            <!-- Dashboard -->
            <a href="{{ route('adminDashboard') }}" @click="selected = 'dashboard'" :class="{'bg-accent base-content': selected === 'dashboard'}" class="block flex space-x-2 p-2 hover:bg-base-400 rounded-md active:bg-primary ">
                <svg class="lucide text-primary lucide-chart-pie w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M21 12c.552 0 1.005-.449.95-.998a10 10 0 0 0-8.953-8.951c-.55-.055-.998.398-.998.95v8a1 1 0 0 0 1 1z"/><path d="M21.21 15.89A10 10 0 1 1 8 2.83"/>
                </svg>
                <span> {{__("Dashboard")}} </span>
            </a>

            <!-- User Management Dropdown -->
            <div x-data="{ open: {{ $open_user_menu ?? 'false' }} }" class="relative">
                <a href="#" @click="open = !open; selected = 'user_management'" :class="{'bg-accent base-content': selected === 'user_management'}" class="block p-2 hover:bg-gray-300 rounded-md flex space-x-2 items-center">
                    <svg class="lucide text-primary lucide-users-round w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M18 21a8 8 0 0 0-16 0"/><circle cx="10" cy="8" r="5"/>
                        <path d="M22 20c0-3.37-2-6.5-4-8a5 5 0 0 0-.45-8.3"/>
                    </svg>
                    <span> {{ __("User Management") }} </span>
                    <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform absolute right-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </a>
                <ul x-show="open" x-transition class="pl-4 mt-2 space-y-1">
                    <li><a href="{{ route('addUserPage') }}" @click="sub_selected = 'add_user'" :class="{'bg-secondary ': sub_selected === 'add_user'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Add User") }}</a></li>
                    <li><a href="{{ route('activeUserList') }}" @click="sub_selected = 'active_user'" :class="{'bg-secondary ': sub_selected === 'active_user'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Active Users") }}</a></li>
                    <li><a href="{{ route('suspendUserList') }}" @click="sub_selected = 'suspend_user'" :class="{'bg-secondary ': sub_selected === 'suspend_user'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Suspend Users") }}</a></li>
                    <li><a href="{{ route('deleteUserList') }}" @click="sub_selected = 'deleted_user'" :class="{'bg-secondary ': sub_selected === 'deleted_user'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Deleted Users") }}</a></li>
                    <li><a href="{{ route('userWalletListPage') }}" @click="sub_selected = 'user_wallet_list'" :class="{'bg-secondary ': sub_selected === 'user_wallet_list'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("User Wallets ") }}</a></li>
                </ul>
            </div>

            <!-- Coins -->
            <a href="{{ route('coinsPage') }}" @click="selected = 'coins'" :class="{'bg-accent base-content': selected === 'coins'}" class="flex space-x-2 block p-2 hover:bg-gray-300 rounded-md">
                <svg class="lucide text-primary lucide-bitcoin w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11.767 19.089c4.924.868 6.14-6.025 1.216-6.894m-1.216 6.894L5.86 18.047m5.908 1.042-.347 1.97m1.563-8.864c4.924.869 6.14-6.025 1.215-6.893m-1.215 6.893-3.94-.694m5.155-6.2L8.29 4.26m5.908 1.042.348-1.97M7.48 20.364l3.126-17.727"/>
                </svg>
                <span> {{__("Coins")}} </span>
            </a>

            <!-- Coin Purchase Report -->
            <a href="{{ route('coinPurchaseReport') }}" @click="selected = 'coin_purchase_report'" :class="{'bg-accent base-content': selected === 'coin_purchase_report'}" class="flex space-x-2 block p-2 hover:bg-gray-300 rounded-md">
                <svg class="lucide text-primary lucide-file-text w-6 h-6" w-6 h-6 xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
                    <path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>
                </svg>
                <span> {{__("Coin Purchase Report")}} </span>
            </a>

            <!-- Coin Exchange Report -->
            <a href="{{ route('coinExchangeReport') }}" @click="selected = 'coin_order_report'" :class="{'bg-accent base-content': selected === 'coin_order_report'}" class="flex space-x-2 block p-2 hover:bg-gray-300 rounded-md">
                <svg class="lucide text-primary lucide-file-text w-6 h-6" w-6 h-6 xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M15 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7Z"/>
                    <path d="M14 2v4a2 2 0 0 0 2 2h4"/><path d="M10 9H8"/><path d="M16 13H8"/><path d="M16 17H8"/>
                </svg>
                <span> {{__("Coin Exchange Report")}} </span>
            </a>

            <!-- Deposit -->
            <a href="{{ route('depositPage') }}" @click="selected = 'deposit_report'" :class="{'bg-accent base-content': selected === 'deposit_report'}" class="flex space-x-2 block p-2 hover:bg-gray-300 rounded-md relative">
                <svg class="lucide text-primary lucide-wallet w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 7V4a1 1 0 0 0-1-1H5a2 2 0 0 0 0 4h15a1 1 0 0 1 1 1v4h-3a2 2 0 0 0 0 4h3a1 1 0 0 0 1-1v-2a1 1 0 0 0-1-1"/><path d="M3 5v14a2 2 0 0 0 2 2h15a1 1 0 0 0 1-1v-4"/>
                </svg>
                <span> {{ __("Deposit" )}} </span>
                {{-- <span class="badge badge-error absolute top-2 right-2">5</span> --}}
            </a>

            <!-- Withdrawal -->
            <a href="{{ route('withdrawalPage') }}" @click="selected = 'withdrawal_report'" :class="{'bg-accent base-content': selected === 'withdrawal_report'}" class="flex space-x-2 block p-2 hover:bg-gray-300 rounded-md">
                <svg class="lucide text-primary lucide-banknote w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="20" height="12" x="2" y="6" rx="2"/>
                    <circle cx="12" cy="12" r="2"/><path d="M6 12h.01M18 12h.01"/>
                </svg>
                <span> {{ __("Withdrawal") }} </span>
            </a>

            <!-- Staking Dropdown -->
            <div x-data="{ open: {{ $open_staking_menu ?? 'false' }} }" class="relative">
                <a href="#" @click="open = !open; selected = 'staking'" :class="{'bg-accent base-content': selected === 'staking'}" class="block p-2 hover:bg-gray-300 rounded-md flex space-x-2 items-center">
                    <svg class="lucide text-primary lucide-hand-coins w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17"/>
                        <path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/>
                        <path d="m2 16 6 6"/>
                        <circle cx="16" cy="9" r="2.9"/>
                        <circle cx="6" cy="5" r="3"/>
                    </svg>
                    <span>
                        {{__("Staking")}}
                        {{-- <span class="badge badge-error absolute top-2 right-10">5</span> --}}
                    </span>
                    <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform absolute right-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </a>
                <ul x-show="open" x-transition class="pl-4 mt-2 space-y-1">
                    <li><a href="{{ route('stakePage') }}" @click="sub_selected = 'staking_plan'" :class="{'bg-accent base-content': sub_selected === 'staking_plan'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Stake Plan") }}</a></li>
                    <li><a href="{{ route('stakeReportPage') }}" href="#" @click="sub_selected = 'staking_report'" :class="{'bg-accent base-content': sub_selected === 'staking_report'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Stake History") }}</a></li>
                </ul>
            </div>

            <!-- Payment Method -->
            <a href="{{ route('autoGatewayList') }}" @click="selected = 'payment'" :class="{'bg-accent base-content': selected === 'payment'}" class="flex space-x-2 block p-2 hover:bg-gray-300 rounded-md">
                <svg class="lucide text-primary lucide-landmark w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="3" x2="21" y1="22" y2="22"/>
                    <line x1="6" x2="6" y1="18" y2="11"/>
                    <line x1="10" x2="10" y1="18" y2="11"/>
                    <line x1="14" x2="14" y1="18" y2="11"/>
                    <line x1="18" x2="18" y1="18" y2="11"/>
                    <polygon points="12 2 20 7 4 7"/></svg>
                <span> {{__("Payment Method")}} </span>
            </a>

            <!-- FAQ -->
            <a href="{{ route('faqPage') }}" @click="selected = 'faq'" :class="{'bg-accent base-content': selected === 'faq'}" class="flex space-x-2 block p-2 hover:bg-gray-300 rounded-md">
                <svg class="lucide text-primary lucide-layout-list w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <rect width="7" height="7" x="3" y="3" rx="1"/>
                    <rect width="7" height="7" x="3" y="14" rx="1"/>
                    <path d="M14 4h7"/>
                    <path d="M14 9h7"/>
                    <path d="M14 15h7"/>
                    <path d="M14 20h7"/>
                </svg>
                <span> {{__("FAQ")}} </span>
            </a>

            <!-- Settings -->
            <a href="{{ route('settingPage') }}" @click="selected = 'setting'" :class="{'bg-accent base-content': selected === 'setting'}" class="flex space-x-2 block p-2 hover:bg-gray-300 rounded-md">
                <svg class="text-primary w-7 h-7" xmlns="http://www.w3.org/2000/svg" aria-hidden="true" width="24" height="24" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" fill="none" stroke-linecap="round" stroke-linejoin="round">
                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                    <path
                    d="M10.325 4.317c.426 -1.756 2.924 -1.756 3.35 0a1.724 1.724 0 0 0 2.573 1.066c1.543 -.94 3.31 .826 2.37 2.37a1.724 1.724 0 0 0 1.065 2.572c1.756 .426 1.756 2.924 0 3.35a1.724 1.724 0 0 0 -1.066 2.573c.94 1.543 -.826 3.31 -2.37 2.37a1.724 1.724 0 0 0 -2.572 1.065c-.426 1.756 -2.924 1.756 -3.35 0a1.724 1.724 0 0 0 -2.573 -1.066c-1.543 .94 -3.31 -.826 -2.37 -2.37a1.724 1.724 0 0 0 -1.065 -2.572c-1.756 -.426 -1.756 -2.924 0 -3.35a1.724 1.724 0 0 0 1.066 -2.573c-.94 -1.543 .826 -3.31 2.37 -2.37c1 .608 2.296 .07 2.572 -1.065z"
                    ></path>
                    <path d="M9 12a3 3 0 1 0 6 0a3 3 0 0 0 -6 0"></path>
                </svg>
                <span> {{__("Settings")}} </span>
            </a>


            <!-- Landing Setting -->
            <div x-data="{ open: {{ $open_landing_menu ?? "false" }} }" class="relative">
                <a href="#" @click="open = !open; selected = 'landing'" :class="{'bg-accent base-content': selected === 'landing'}" class="block p-2 hover:bg-gray-300 rounded-md flex space-x-2 items-center">
                    <svg class="lucide text-primary lucide-tent w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M3.5 21 14 3"/><path d="M20.5 21 10 3"/>
                        <path d="M15.5 21 12 15l-3.5 6"/><path d="M2 21h20"/>
                    </svg>
                    <span> {{__("Landing Setting")}}</span>
                    <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform absolute right-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                        <path d="M6 9l6 6 6-6" />
                    </svg>
                </a>
                <ul x-show="open" x-transition class="pl-4 mt-2 space-y-1">
                    <li><a href="{{ route('landingPageSetting') }}" @click="sub_selected = 'page_setting'" :class="{'bg-accent base-content': sub_selected === 'page_setting'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Landing Page") }}</a></li>
                    <li><a href="{{ route('landingTestimonialsPage') }}" href="#" @click="sub_selected = 'testimonial'" :class="{'bg-accent base-content': sub_selected === 'testimonial'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Testimonial") }}</a></li>
                    <li><a href="{{ route('customPage') }}" href="#" @click="sub_selected = 'custom_page'" :class="{'bg-accent base-content': sub_selected === 'custom_page'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Custom Page") }}</a></li>
                </ul>
            </div>

            <!-- Support Ticket -->
            <div x-data="{ open: {{ $open_support_menu ?? "false" }} }" class="relative">
                <a href="#" @click="open = !open; selected = 'support'" :class="{'bg-accent base-content': selected === 'support'}" class="block p-2 hover:bg-gray-300 rounded-md flex space-x-2 items-center">
                    <svg class="lucide text-primary lucide-tickets w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="m4.5 8 10.58-5.06a1 1 0 0 1 1.342.488L18.5 8"/>
                        <path d="M6 10V8"/>
                        <path d="M6 14v1"/><path d="M6 19v2"/>
                        <rect x="2" y="8" width="20" height="13" rx="2"/>
                    </svg>
                    <span> {{ __("Support Ticket") }} </span>
                    <svg xmlns="http://www.w3.org/2000/svg" :class="{'rotate-180': open}" class="w-4 h-4 transition-transform absolute right-4" viewBox="0 0 24 24" fill="none" stroke="currentColor">
                    <path d="M6 9l6 6 6-6" />
                    </svg>
                </a>
                <ul x-show="open" x-transition class="pl-4 mt-2 space-y-1">
                    <li><a href="{{ route('adminTicketsPending') }}" :class="{'bg-accent base-content': sub_selected === 'pending'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Pending Ticket") }}</a></li>
                    <li><a href="{{ route('adminTicketsClosed') }}" :class="{'bg-accent base-content': sub_selected === 'closed'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Closed Ticket") }}</a></li>
                    <li><a href="{{ route('adminTicketsAnswered') }}" :class="{'bg-accent base-content': sub_selected === 'answered'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("Answered Ticket") }}</a></li>
                    <li><a href="{{ route('adminTicketsIndex') }}" :class="{'bg-accent base-content': sub_selected === 'all'}" class="block p-2 hover:bg-gray-300 rounded-md">{{ __("All Ticket") }}</a></li>
                </ul>
            </div>

            <!-- Clear Cache -->
            <a href="{{ route('clearCache') }}" @click="selected = 'settings'" :class="{'bg-accent base-content': selected === 'settings'}" class="flex space-x-2 block p-2 hover:bg-gray-300 rounded-md">
                <svg class="lucide text-primary lucide-database-zap w-6 h-6" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <ellipse cx="12" cy="5" rx="9" ry="3"/>
                    <path d="M3 5V19A9 3 0 0 0 15 21.84"/><path d="M21 5V8"/><path d="M21 12L18 17H22L19 22"/>
                    <path d="M3 12A9 3 0 0 0 14.59 14.87"/>
                </svg>
                <span> {{__("Clear Cache")}} </span>
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