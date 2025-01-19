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

                {{-- Dashboard --}}
                <li>
                    <a href="{{ route('adminDashboard') }}"
                        class="flex items-center p-2 font-normal rounded-lg">
                        <svg class="w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path d="M2 10a8 8 0 018-8v8h8a8 8 0 11-16 0z"></path>
                            <path d="M12 2.252A8.014 8.014 0 0117.748 8H12V2.252z"></path>
                        </svg>
                        <span class="ml-3">Dashboard</span>
                    </a>
                </li>

                {{-- Staking --}}
                <li>
                    <button type="button" class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group" aria-controls="staking_dropdown" data-collapse-toggle="staking_dropdown">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ __("Staking") }}</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <ul id="staking_dropdown" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('stakePage') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Stake Plan") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('stakeReportPage') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Stake History") }}</a>
                        </li>
                    </ul>
                </li>

                {{-- User Management --}}
                <li>
                    <button type="button" class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group" aria-controls="user_management_dropdown" data-collapse-toggle="user_management_dropdown">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ __("User Management") }}</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <ul id="user_management_dropdown" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('addUserPage') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Add User") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('activeUserList') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Active Users") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('suspendUserList') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Suspend Users") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('deleteUserList') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Deleted Users") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('userWalletListPage') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("User Wallets ") }}</a>
                        </li>
                    </ul>
                </li>

                {{-- Support Ticket --}}
                <li>
                    <button type="button" class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group" aria-controls="support_ticket_dropdown" data-collapse-toggle="support_ticket_dropdown">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ __("Support Ticket") }}</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <ul id="support_ticket_dropdown" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('adminTicketsPending') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Pending Ticket") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('adminTicketsClosed') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Close Ticket") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('adminTicketsAnswered') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Answered Ticket") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('adminTicketsIndex') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("All Ticket") }}</a>
                        </li>
                    </ul>
                </li>

                {{-- Deposit --}}
                <li>
                    <a href="{{ route('depositPage') }}"
                        class="flex items-center p-2 font-normal rounded-lg">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">{{ __("Deposit") }}</span>
                        <span class="inline-flex items-center justify-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
                    </a>
                </li>
                
                {{-- Withdrawal --}}
                <li>
                    <a href="{{ route('withdrawalPage') }}"
                        class="flex items-center p-2 font-normal rounded-lg">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">{{ __("Withdrawal") }}</span>
                        <span class="inline-flex items-center justify-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
                    </a>
                </li>

                {{-- Report --}}
                <li>
                    <button type="button" class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group" aria-controls="support_ticket_dropdown" data-collapse-toggle="support_ticket_dropdown">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ __("Report") }}</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <ul id="support_ticket_dropdown" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('adminTicketsPending') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Pending Ticket") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('adminTicketsClosed') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Close Ticket") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('adminTicketsAnswered') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Answered Ticket") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('adminTicketsIndex') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("All Ticket") }}</a>
                        </li>
                    </ul>
                </li>

                {{-- CMS --}}
                <li>
                    <button type="button" class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group" aria-controls="support_ticket_dropdown" data-collapse-toggle="support_ticket_dropdown">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd" d="M10 9a3 3 0 100-6 3 3 0 000 6zm-7 9a7 7 0 1114 0H3z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>{{ __("CMS") }}</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <ul id="support_ticket_dropdown" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('adminTicketsPending') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Pending Ticket") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('adminTicketsClosed') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Close Ticket") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('adminTicketsAnswered') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Answered Ticket") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('adminTicketsIndex') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("All Ticket") }}</a>
                        </li>
                    </ul>
                </li>

                {{-- Coin --}}
                <li>
                    <a href="{{ route('coinsPage') }}"
                        class="flex items-center p-2 font-normal rounded-lg">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M5 3a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2V5a2 2 0 00-2-2H5zM5 11a2 2 0 00-2 2v2a2 2 0 002 2h2a2 2 0 002-2v-2a2 2 0 00-2-2H5zM11 5a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V5zM11 13a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z">
                            </path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">{{ __("Coins") }}</span>
                        <span class="inline-flex items-center justify-center px-2 ml-3 text-sm font-medium text-gray-800 bg-gray-200 rounded-full dark:bg-gray-700 dark:text-gray-300">Pro</span>
                    </a>
                </li>

                {{-- Payment Method --}}
                <li>
                    <a href="{{ route('autoGatewayList') }}"
                        class="flex items-center p-2 font-normal rounded-lg">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">{{ __("Payment Method")  }}</span>
                    </a>
                </li>

                {{-- FAQ --}}
                <li>
                    <a href="{{ route('faqPage') }}"
                        class="flex items-center p-2 font-normal rounded-lg">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">{{ __("FAQ") }}</span>
                    </a>
                </li>
              
                {{-- GDRP Cookie --}}
                <li>
                    <a href="{{ route('faqPage') }}"
                        class="flex items-center p-2 font-normal rounded-lg">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">{{ __("GDRP Cookie") }}</span>
                    </a>
                </li>
               
                {{-- Server Info --}}
                <li>
                    <a href="{{ route('faqPage') }}"
                        class="flex items-center p-2 font-normal rounded-lg">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">{{ __("Server Info") }}</span>
                    </a>
                </li>

                {{-- Clear Cache --}}
                <li>
                    <a href="{{ route('faqPage') }}"
                        class="flex items-center p-2 font-normal rounded-lg">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">{{ __("Clear Cache") }}</span>
                    </a>
                </li>

                {{-- Coin Provider --}}
                <li>
                    <a href="{{ route('coinPaymentSettingPage') }}"
                        class="flex items-center p-2 font-normal rounded-lg">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Coin Payment</span>
                    </a>
                </li>
                
                {{-- Settings --}}
                <li>
                    <a href="{{ route('settingPage') }}"
                        class="flex items-center p-2 font-normal rounded-lg">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 dark:text-gray-400 group-hover dark:group-hover:text-white"
                            fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg">
                            <path fill-rule="evenodd"
                                d="M3 3a1 1 0 00-1 1v12a1 1 0 102 0V4a1 1 0 00-1-1zm10.293 9.293a1 1 0 001.414 1.414l3-3a1 1 0 000-1.414l-3-3a1 1 0 10-1.414 1.414L14.586 9H7a1 1 0 100 2h7.586l-1.293 1.293z"
                                clip-rule="evenodd"></path>
                        </svg>
                        <span class="flex-1 ml-3 whitespace-nowrap">Settings</span>
                    </a>
                </li>

                {{-- Setting --}}
                <li>
                    <button type="button" class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group" aria-controls="sidebar_item_dropdown_setting" data-collapse-toggle="sidebar_item_dropdown_setting">
                        <svg class="flex-shrink-0 w-6 h-6 transition duration-75 group-hover dark:text-gray-400 dark:group-hover:text-white" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M10 2a4 4 0 00-4 4v1H5a1 1 0 00-.994.89l-1 9A1 1 0 004 18h12a1 1 0 00.994-1.11l-1-9A1 1 0 0015 7h-1V6a4 4 0 00-4-4zm2 5V6a2 2 0 10-4 0v1h4zm-6 3a1 1 0 112 0 1 1 0 01-2 0zm7-1a1 1 0 100 2 1 1 0 000-2z" clip-rule="evenodd"></path></svg>
                        <span class="flex-1 ml-3 text-left whitespace-nowrap" sidebar-toggle-item>Settings</span>
                        <svg sidebar-toggle-item class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
                    </button>
                    <ul id="sidebar_item_dropdown_setting" class="hidden py-2 space-y-2">
                        <li>
                            <a href="{{ route('generalSettingPage') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">General Setting</a>
                        </li>
                        <li>
                            <a href="{{ route('emailSettingPage') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">Email Setting</a>
                        </li>
                        <li>
                            <a href="#"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">Sms Setting</a>
                        </li>
                        <li>
                            <a href="{{ route('languagePage') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Language") }}</a>
                        </li>
                        <li>
                            <a href="{{ route('currencyPage') }}"
                                class="flex items-center w-full p-2 font-normal transition duration-75 rounded-lg group pl-11">{{ __("Currency") }}</a>
                        </li>
                    </ul>
                </li>
            </ul>
        </div>
    </aside>
</div>
