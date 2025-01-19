<div class="grid sm:block grid-cols-3 md:grid-cols-2 gap-6">

    {{-- Total Coins --}}
    <div class="card bg-gradient-to-r to-primary from-accent text-white shadow-lg p-4 sm:mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-sm font-semibold">{{ __("Total Coins") }}</h2>
                <p class="text-2xl font-bold">{{ print_coin($total_coins ?? 0) }} USD</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 lucide lucide-bitcoin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <line x1="12" x2="12" y1="2" y2="22"/><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"/>
                </svg>
            </div>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('coinsPage') }}" class="btn btn-xs btn-ghost text-white hover:bg-white/20">{{ __('View More') }} →</a>
        </div>
    </div>

    {{-- Total Deposit --}}
    <div class="card bg-gradient-to-r to-primary from-accent text-white shadow-lg p-4 sm:mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-sm font-semibold">{{ __("Total Deposit") }}</h2>
                <p class="text-2xl font-bold">{{ print_coin($total_deposit ?? 0) }} USD</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 lucide lucide-bitcoin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M19 5c-1.5 0-2.8 1.4-3 2-3.5-1.5-11-.3-11 5 0 1.8 0 3 2 4.5V20h4v-2h3v2h4v-4c1-.5 1.7-1 2-2h2v-4h-2c0-1-.5-1.5-1-2V5z"/><path d="M2 9v1c0 1.1.9 2 2 2h1"/><path d="M16 11h.01"/>
                </svg>
            </div>
        </div>
        <div class="flex justify-end">
            <a href="#" class="btn btn-xs btn-ghost text-white hover:bg-white/20">{{ __('View More') }} →</a>
        </div>
    </div>

    {{-- Complete Withdrawal --}}
    <div class="card bg-gradient-to-r to-primary from-accent text-white shadow-lg p-4 sm:mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-sm font-semibold">{{ __("Complete Withdrawal") }}</h2>
                <p class="text-2xl font-bold">{{ print_coin($success_withdraw ?? 0) }} USD</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 lucide lucide-bitcoin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M12 2a10 10 0 0 1 7.38 16.75"/><path d="m16 12-4-4-4 4"/><path d="M12 16V8"/><path d="M2.5 8.875a10 10 0 0 0-.5 3"/><path d="M2.83 16a10 10 0 0 0 2.43 3.4"/><path d="M4.636 5.235a10 10 0 0 1 .891-.857"/><path d="M8.644 21.42a10 10 0 0 0 7.631-.38"/>
                </svg>
            </div>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('withdrawalConfirmList') }}" class="btn btn-xs btn-ghost text-white hover:bg-white/20">{{ __('View More') }} →</a>
        </div>
    </div>
   
    {{-- Pending Tickets --}}
    <div class="card bg-gradient-to-r to-primary from-accent text-white shadow-lg p-4 sm:mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-sm font-semibold">{{ __("Pending Tickets") }}</h2>
                <p class="text-2xl font-bold">{{ $pending_ticket ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 lucide lucide-bitcoin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M2 9a3 3 0 0 1 0 6v2a2 2 0 0 0 2 2h16a2 2 0 0 0 2-2v-2a3 3 0 0 1 0-6V7a2 2 0 0 0-2-2H4a2 2 0 0 0-2 2Z"/><path d="M13 5v2"/><path d="M13 17v2"/><path d="M13 11v2"/>
                </svg>
            </div>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('adminTicketsPending') }}" class="btn btn-xs btn-ghost text-white hover:bg-white/20">{{ __('View More') }} →</a>
        </div>
    </div>

    {{-- Coin Purchase --}}
    <div class="card bg-gradient-to-r to-primary from-accent text-white shadow-lg p-4 sm:mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-sm font-semibold">{{ __("Coin Purchase Order") }}</h2>
                <p class="text-2xl font-bold">{{ print_coin($coin_purchase ?? 0) }} USD</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 lucide lucide-bitcoin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11.767 19.089c4.924.868 6.14-6.025 1.216-6.894m-1.216 6.894L5.86 18.047m5.908 1.042-.347 1.97m1.563-8.864c4.924.869 6.14-6.025 1.215-6.893m-1.215 6.893-3.94-.694m5.155-6.2L8.29 4.26m5.908 1.042.348-1.97M7.48 20.364l3.126-17.727"/>
                </svg>
            </div>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('coinPurchaseReport') }}" class="btn btn-xs btn-ghost text-white hover:bg-white/20">{{ __('View More') }} →</a>
        </div>
    </div>
    


    {{-- Active Staking --}}
    <div class="card bg-gradient-to-r to-primary from-accent text-white shadow-lg p-4 sm:mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-sm font-semibold">{{ __("Active Staking") }}</h2>
                <p class="text-2xl font-bold">{{ $active_staking ?? 0 }}</p>
            </div>
            <div class="w-10 h-10 rounded-full bg-white/10 flex items-center justify-center">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 lucide lucide-bitcoin" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                    <path d="M11 15h2a2 2 0 1 0 0-4h-3c-.6 0-1.1.2-1.4.6L3 17"/><path d="m7 21 1.6-1.4c.3-.4.8-.6 1.4-.6h4c1.1 0 2.1-.4 2.8-1.2l4.6-4.4a2 2 0 0 0-2.75-2.91l-4.2 3.9"/><path d="m2 16 6 6"/><circle cx="16" cy="9" r="2.9"/><circle cx="6" cy="5" r="3"/>
                </svg>
            </div>
        </div>
        <div class="flex justify-end">
            <a href="{{ route('stakeReportPage') }}" class="btn btn-xs btn-ghost text-white hover:bg-white/20">{{ __('View More') }} →</a>
        </div>
    </div>

</div>