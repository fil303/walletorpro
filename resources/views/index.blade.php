@extends('landing.app')
@section('content')
    <!-- Hero Section -->
    <section class="relative min-h-screen bg-gradient-to-b from-slate-900 to-black">
        <div class="container mx-auto px-8 h-screen">
            <div class="flex min-h-screen items-center">
                <!-- Left Content -->
                <div class="w-full md:w-3/6 space-y-2">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-3 bg-[var(--primary)] bg-opacity-10 rounded-full pl-2 pr-4 py-1">
                        <span class="bg-[var(--secondary)] text-black text-xs font-semibold px-2 py-1 rounded-full">NEW</span>
                        <span class="text-[var(--info)]">{{ $landing->hero_section_badge_text ?? "All-in-One Crypto Solution" }}</span>
                    </div>

                    <!-- Main Content -->
                    <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold text-white leading-tight">
                        {{ $landing->hero_section_heading ?? "Your Digital Wallet for a Smarter Future" }}
                    </h1>

                    <p class="text-base sm:text-lg md:text-xl text-[var(--info)] max-w-xl leading-relaxed">
                        {{ $landing->hero_section_subheading ?? "" }}
                    </p>


                    <!-- CTAs -->
                    <div class="flex flex-col sm:flex-row gap-4">
                        <a href="{{ route('registerPage') }}" class="px-8 py-4 btn bg-[var(--secondary)] text-black font-semibold rounded-lg hover:bg-[var(--info)] transition-colors">
                            {{ $landing->hero_section_cta_text ?? "" }}
                        </a>
                    </div>
                </div>

                <!-- Right Content -->
                <div class="hidden md:block pl-20">
                    <div class="relative">
                        <!-- Main Image -->
                        <div class="relative z-20 bg-opacity-10 p-2 rounded-2xl">
                            <img src="{{ asset_bind($landing->hero_section_image ?? '') }}" height="200px" alt="{{ __('Hero Section Image') }}" class="rounded-xl" >
                        </div>

                        <!-- Background Effects -->
                        <div class="absolute top-1/2 -right-20 w-40 h-40 bg-[var(--secondary)] rounded-full blur-3xl opacity-20"></div>
                        <div class="absolute bottom-20 -left-20 w-40 h-40 bg-[var(--info)] rounded-full blur-3xl opacity-20"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section class="relative py-5 bg-slate-900" id="about">
        <div class="container mx-auto px-6">
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Left Side - Image -->
                <div class="w-full lg:w-1/2">
                    <div class="relative">
                        <!-- Main Image -->
                        <div class="relative z-20 bg-opacity-10 p-2 rounded-2xl">
                            <img src="{{ asset_bind($landing->about_section_image ?? 'assets/img/about-hero.png') }}" 
                                alt="About Us" 
                                class="rounded-xl w-full">
                        </div>
                        
                        <!-- Background Effects -->
                        <div class="absolute top-1/2 -right-20 w-40 h-40 bg-[var(--secondary)] rounded-full blur-3xl opacity-20"></div>
                        <div class="absolute bottom-20 -left-20 w-40 h-40 bg-[var(--info)] rounded-full blur-3xl opacity-20"></div>
                    </div>
                </div>

                <!-- Right Side - Content -->
                <div class="w-full lg:w-1/2 space-y-8">
                    <!-- Badge -->
                    <div class="inline-flex items-center gap-2 bg-[var(--primary)] bg-opacity-10 rounded-full px-4 py-2">
                        <span class="w-2 h-2 rounded-full bg-[var(--secondary)]"></span>
                        <span class="text-[var(--info)]">{{ $landing->about_section_badge_text ?? "About Our Platform" }}</span>
                    </div>

                    <!-- Title & Description -->
                    <div>
                        <h2 class="text-4xl lg:text-5xl font-bold text-white mb-6">
                            {{ $landing->about_section_title ?? "Your Partner in the Crypto Revolution" }}
                        </h2>
                        <p class="text-[var(--info)] text-lg">
                            {{ $landing->about_section_description ?? "" }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Services Section -->
    <section class="relative py-5 bg-slate-900" id="services">
        <div class="container mx-auto px-6">
            <!-- Section Header -->
            <div class="text-center mb-4">
                <div class="inline-flex items-center gap-2 bg-[var(--primary)] bg-opacity-10 rounded-full px-4 py-2 mb-4">
                    <span class="w-2 h-2 rounded-full bg-[var(--secondary)]"></span>
                    <span class="text-[var(--info)]">{{ $landing->service_section_badge_text ?? "Our Services" }}</span>
                </div>
                <h2 class="text-5xl font-bold text-white mb-6">{{ $landing->service_section_title ?? "Comprehensive Crypto Solutions" }}</h2>
                <p class="text-[var(--info)] text-lg max-w-2xl mx-auto">{{ $landing->service_section_description ?? "Explore our range of services designed to meet your cryptocurrency needs" }}</p>
            </div>
            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Left Side - Content -->
                <div class="w-full lg:w-1/2">

                    <!-- Services Grid -->
                    <div class="grid grid-cols-1 gap-2">
                        <!-- Buy & Sell -->
                        <div class="group relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                            <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-4 hover:transform hover:scale-105 transition-all">
                                <div class="w-16 h-16 bg-[var(--secondary)] rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-white ">Purchase Crypto</h3>
                                <p class="text-[var(--info)]">Purchase cryptocurrencies easily with competitive rates and multiple payment options.</p>
                            </div>
                        </div>

                        <!-- Staking -->
                        <div class="group relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                            <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-4 hover:transform hover:scale-105 transition-all">
                                <div class="w-16 h-16 bg-[var(--info)] rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-white ">Staking</h3>
                                <p class="text-[var(--info)]">Earn passive income by staking your crypto assets with competitive APY rates.</p>
                            </div>
                        </div>

                        <!-- Exchange -->
                        <div class="group relative">
                            <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                            <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-4 hover:transform hover:scale-105 transition-all">
                                <div class="w-16 h-16 bg-[var(--success)] rounded-xl flex items-center justify-center">
                                    <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                                    </svg>
                                </div>
                                <h3 class="text-2xl font-bold text-white ">Exchange</h3>
                                <p class="text-[var(--info)]">Swap between different cryptocurrencies instantly with best market rates.</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Right Side - Image -->
                <div class="w-full lg:w-1/2 space-y-8">
                    <div class="relative">
                        <!-- Main Image -->
                        <div class="relative z-20 bg-opacity-10 p-2 rounded-2xl">
                            <img src="{{ asset_bind($landing->service_section_image ?? 'assets/img/about-hero.png') }}" 
                                alt="About Us" 
                                class="rounded-xl w-full">
                        </div>
                        
                        <!-- Background Effects -->
                        <div class="absolute top-1/2 -right-20 w-40 h-40 bg-[var(--secondary)] rounded-full blur-3xl opacity-20"></div>
                        <div class="absolute bottom-20 -left-20 w-40 h-40 bg-[var(--info)] rounded-full blur-3xl opacity-20"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- How It Works Section -->
    <section class="relative py-5 bg-slate-900" id="how-it-works">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-4 text-[var(--primary)]">{{ $landing->how_section_title ?? "How It Works" }}</h2>

            <div class="splide" id="howItWork-slider">
                <div class="splide__track">
                    <div class="splide__list">
                        <!-- Buy & Sell Crypto -->
                        <div class="splide__slide mb-20">
                            <h3 class="text-2xl font-semibold mb-8 text-center text-[var(--primary)]">Buy & Sell Crypto</h3>
                            <div class="relative">
                                <div class="absolute top-1/2 left-0 w-full h-1 bg-[var(--primary)]/10 -translate-y-1/2 hidden lg:block"></div>
                                <div class="grid lg:grid-cols-3 gap-8">
                                    <div class="group relative">
                                        <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                                        <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                                            <div class="w-16 h-16 bg-[var(--secondary)] rounded-xl flex items-center justify-center mb-6">
                                                <span class="text-xl font-bold text-black">01</span>
                                            </div>
                                            <h4 class="text-2xl font-bold text-white mb-4">{{ $landing->how_section_step1_title ?? "Select Coin" }}</h4>
                                            <p class="text-[var(--info)]">{{ $landing->how_section_step1_description ?? "Choose the cryptocurrency you want to buy or sell" }}</p>
                                        </div>
                                    </div>
                                    <div class="group relative">
                                        <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                                        <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                                            <div class="w-16 h-16 bg-[var(--info)] rounded-xl flex items-center justify-center mb-6">
                                                <span class="text-xl font-bold text-white">02</span>
                                            </div>
                                            <h4 class="text-2xl font-bold text-white mb-4">{{ $landing->how_section_step2_title ?? "Enter Amount" }}</h4>
                                            <p class="text-[var(--info)]">{{ $landing->how_section_step2_description ?? "Specify the amount and choose payment method" }}</p>
                                        </div>
                                    </div>
                                    <div class="group relative">
                                        <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                                        <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                                            <div class="w-16 h-16 bg-[var(--success)] rounded-xl flex items-center justify-center mb-6">
                                                <span class="text-xl font-bold text-white">03</span>
                                            </div>
                                            <h4 class="text-2xl font-bold text-white mb-4">{{ $landing->how_section_step3_title ?? "Complete Transaction" }}</h4>
                                            <p class="text-[var(--info)]">{{ $landing->how_section_step3_description ?? "Confirm and receive coins in your wallet" }}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Staking -->
                        <div class="splide__slide mb-20">
                            <h3 class="text-2xl font-semibold mb-8 text-center text-[var(--primary)]">Staking</h3>
                            <div class="relative">
                                <div class="absolute top-1/2 left-0 w-full h-1 bg-[var(--primary)]/10 -translate-y-1/2 hidden lg:block"></div>
                                <div class="grid lg:grid-cols-3 gap-8">
                                    <div class="group relative">
                                        <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                                        <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                                            <div class="w-16 h-16 bg-[var(--secondary)] rounded-xl flex items-center justify-center mb-6">
                                                <span class="text-xl font-bold text-black">01</span>
                                            </div>
                                            <h4 class="text-2xl font-bold text-white mb-4">{{ $landing->how_section_staking_step1_title ?? "Choose Staking Plan"}}</h4>
                                            <p class="text-[var(--info)]">{{ $landing->how_section_staking_step1_description ?? "Select from available coins and durations"}}</p>
                                        </div>
                                    </div>
                                    <div class="group relative">
                                        <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                                        <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                                            <div class="w-16 h-16 bg-[var(--info)] rounded-xl flex items-center justify-center mb-6">
                                                <span class="text-xl font-bold text-white">02</span>
                                            </div>
                                            <h4 class="text-2xl font-bold text-white mb-4">{{ $landing->how_section_staking_step2_title ?? "Lock Period"}}</h4>
                                            <p class="text-[var(--info)]">{{ $landing->how_section_staking_step2_description ?? "Lock your assets for the chosen duration"}}</p>
                                        </div>
                                    </div>
                                    <div class="group relative">
                                        <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                                        <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                                            <div class="w-16 h-16 bg-[var(--success)] rounded-xl flex items-center justify-center mb-6">
                                                <span class="text-xl font-bold text-white">03</span>
                                            </div>
                                            <h4 class="text-2xl font-bold text-white mb-4">{{ $landing->how_section_staking_step3_title ?? "Earn Rewards"}}</h4>
                                            <p class="text-[var(--info)]">{{ $landing->how_section_staking_step3_description ?? "Receive staking rewards after completion"}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Exchange -->
                        <div class="splide__slide mb-20">
                            <h3 class="text-2xl font-semibold mb-8 text-center text-[var(--primary)]">Exchange</h3>
                            <div class="relative">
                                <div class="absolute top-1/2 left-0 w-full h-1 bg-[var(--primary)]/10 -translate-y-1/2 hidden lg:block"></div>
                                <div class="grid lg:grid-cols-3 gap-8">
                                    <div class="group relative">
                                        <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                                        <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                                            <div class="w-16 h-16 bg-[var(--secondary)] rounded-xl flex items-center justify-center mb-6">
                                                <span class="text-xl font-bold text-black">01</span>
                                            </div>
                                            <h4 class="text-2xl font-bold text-white mb-4">{{ $landing->how_section_exchange_step1_title ?? "Select Pairs"}}</h4>
                                            <p class="text-[var(--info)]">{{ $landing->how_section_exchange_step1_description ?? "Choose the cryptocurrencies to exchange"}}</p>
                                        </div>
                                    </div>
                                    <div class="group relative">
                                        <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                                        <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                                            <div class="w-16 h-16 bg-[var(--info)] rounded-xl flex items-center justify-center mb-6">
                                                <span class="text-xl font-bold text-white">02</span>
                                            </div>
                                            <h4 class="text-2xl font-bold text-white mb-4">{{ $landing->how_section_exchange_step2_title ?? "View Rate"}}</h4>
                                            <p class="text-[var(--info)]">{{ $landing->how_section_exchange_step2_description ?? "Check live exchange rates"}}</p>
                                        </div>
                                    </div>
                                    <div class="group relative">
                                        <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                                        <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                                            <div class="w-16 h-16 bg-[var(--success)] rounded-xl flex items-center justify-center mb-6">
                                                <span class="text-xl font-bold text-white">03</span>
                                            </div>
                                            <h4 class="text-2xl font-bold text-white mb-4">{{ $landing->how_section_exchange_step3_title ?? "Confirm Swap"}}</h4>
                                            <p class="text-[var(--info)]">{{ $landing->how_section_exchange_step3_description ?? "Complete the exchange securely"}}</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Personal Wallet Features Section -->
    <section class="relative py-5 bg-slate-900" id="wallet">
        <div class="container mx-auto px-6">
            <h2 class="text-4xl font-bold text-center mb-16 text-[var(--primary)]">{{ $landing->wallet_section_title ?? "Personal Wallet Features"}}</h2>
            <div class="grid md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Unique Addresses -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                    <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                        <div class="w-16 h-16 bg-[var(--secondary)] rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 15a4 4 0 004 4h9a5 5 0 10-.1-9.999 5.002 5.002 0 10-9.78 2.096A4.001 4.001 0 003 15z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">{{ $landing->wallet_section_feature1_title ?? "Unique Addresses"}}</h3>
                        <p class="text-[var(--info)]">{{ $landing->wallet_section_feature1_description ?? "Get individual wallet addresses for each supported cryptocurrency"}}</p>
                    </div>
                </div>

                <!-- Secure Storage -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                    <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                        <div class="w-16 h-16 bg-[var(--info)] rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">{{ $landing->wallet_section_feature2_title ?? "Secure Storage"}}</h3>
                        <p class="text-[var(--info)]">{{ $landing->wallet_section_feature2_description ?? "Your assets are stored in secure, encrypted wallets"}}</p>
                    </div>
                </div>

                <!-- Easy Transfers -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                    <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                        <div class="w-16 h-16 bg-[var(--success)] rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4m0 0l4 4m-4-4l4-4"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">{{ $landing->wallet_section_feature3_title ?? "Easy Transfers"}}</h3>
                        <p class="text-[var(--info)]">{{ $landing->wallet_section_feature3_description ?? "Deposit and withdraw cryptocurrencies with ease"}}</p>
                    </div>
                </div>

                <!-- Multi-Currency Support -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                    <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                        <div class="w-16 h-16 bg-[var(--secondary)] rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-black" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">{{ $landing->wallet_section_feature4_title ?? "Multi-Currency Support"}}</h3>
                        <p class="text-[var(--info)]">{{ $landing->wallet_section_feature4_description ?? "Support for a wide range of cryptocurrencies"}}</p>
                    </div>
                </div>

                <!-- Transaction History -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                    <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                        <div class="w-16 h-16 bg-[var(--info)] rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">{{ $landing->wallet_section_feature5_title ?? "Transaction History"}}</h3>
                        <p class="text-[var(--info)]">{{ $landing->wallet_section_feature5_description ?? "Track all your wallet transactions in one place"}}</p>
                    </div>
                </div>

                <!-- 24/7 Access -->
                <div class="group relative">
                    <div class="absolute inset-0 bg-gradient-to-r from-[var(--secondary)] to-[var(--info)] opacity-0 group-hover:opacity-100 rounded-2xl transition-opacity duration-300"></div>
                    <div class="relative bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 hover:transform hover:scale-105 transition-all">
                        <div class="w-16 h-16 bg-[var(--success)] rounded-xl flex items-center justify-center mb-6">
                            <svg class="w-8 h-8 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                            </svg>
                        </div>
                        <h3 class="text-2xl font-bold text-white mb-4">{{ $landing->wallet_section_feature6_title ?? "24/7 Access"}}</h3>
                        <p class="text-[var(--info)]">{{ $landing->wallet_section_feature6_description ?? "Access your wallet anytime, anywhere"}}</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Testimonials Section -->
    <section class="relative py-5 bg-slate-900" id="testimonials">
        <div class="container mx-auto px-6">
            <!-- Section Header -->
            <div class="text-center mb-20">
                <div class="inline-flex items-center gap-2 bg-[var(--primary)] bg-opacity-10 rounded-full px-4 py-2 mb-4">
                    <span class="w-2 h-2 rounded-full bg-[var(--secondary)]"></span>
                    <span class="text-[var(--info)]">{{ $landing->testimonial_section_badge_text ?? "Client Stories"}}</span>
                </div>
                <h2 class="text-5xl font-bold text-white mb-6">{{ $landing->testimonial_section_title ?? "Our Users Speak for Us" }}</h2>
                <p class="text-[var(--info)] text-lg max-w-2xl mx-auto">{{ $landing->testimonial_section_description ?? "Real experiences from businesses that have transformed their operations with our solutions."}}</p>
            </div>

            <!-- Testimonials Slider -->
            <div class="splide" id="testimonials-slider">
                <div class="splide__track">
                    <div class="splide__list">

                        <!-- Testimonials -->
                        @foreach ($testimonials ?? [] as $testimonial)
                            <div class="splide__slide px-4">
                                <div class="bg-[var(--primary)] bg-opacity-10 rounded-2xl p-8 relative">
                                    <p class="text-[var(--info)] text-lg mb-6">"{{ $testimonial->feedback ?? '' }}"</p>
                                    <div class="flex items-center gap-4">
                                        <img src="{{ $testimonial->getImage() }}" alt="Client" class="w-12 h-12 rounded-full" >
                                        <div>
                                            <h4 class="text-white font-semibold">{{ $testimonial->name ?? "Jone Doe" }}</h4>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

            <!-- Navigation Buttons -->
            <div class="flex justify-center gap-4 mt-12">
                <button class="splide__arrow splide__arrow--prev bg-[var(--primary)] hover:bg-[var(--secondary)] text-white p-4 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </button>
                <button class="splide__arrow splide__arrow--next bg-[var(--primary)] hover:bg-[var(--secondary)] text-white p-4 rounded-full transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                    </svg>
                </button>
            </div>
        </div>
    </section>

    <!-- FAQ Section Section -->
    <section class="relative py-5 bg-slate-900" id="faq">
        <div class="container mx-auto px-6">
            <!-- Section Header -->
            <div class="text-center mb-2">
                <div class="inline-flex items-center gap-2 bg-[var(--primary)] bg-opacity-10 rounded-full px-4 py-2 mb-4">
                    <span class="w-2 h-2 rounded-full bg-[var(--secondary)]"></span>
                    <span class="text-[var(--info)]">{{ $landing->faq_section_badge_text ?? "Got Questions?"}}</span>
                </div>
                <h2 class="text-5xl font-bold text-white mb-6">{{ $landing->faq_section_title ?? "Frequently Asked Questions"  }}</h2>
                <p class="text-[var(--info)] text-lg max-w-2xl mx-auto">{{ $landing->faq_section_description ?? "Find quick answers to common questions about our services and solutions." }}</p>
            </div>

            <div class="flex flex-col lg:flex-row items-center gap-12">
                <!-- Left Side - Image -->
                <div class="w-full lg:w-1/2">
                    <div class="relative">
                        <!-- Main Image -->
                        <div class="relative z-20 bg-opacity-10 p-2 rounded-2xl">
                            <img src="{{ asset_bind($landing->faq_section_image ?? 'assets/img/about-hero.png') }}" 
                                alt="About Us" 
                                class="rounded-xl w-full">
                        </div>
                        
                        <!-- Background Effects -->
                        <div class="absolute top-1/2 -right-20 w-40 h-40 bg-[var(--secondary)] rounded-full blur-3xl opacity-20"></div>
                        <div class="absolute bottom-20 -left-20 w-40 h-40 bg-[var(--info)] rounded-full blur-3xl opacity-20"></div>
                    </div>
                </div>

                <!-- Right Side - Faq -->
                <div class="w-full lg:w-1/2">
                    <!-- FAQ Items -->
                    <div class="max-w-3xl mx-auto space-y-4" x-data="{ selected: 0 }">
                        <!-- FAQ Item -->
                        @foreach ($faqs ?? [] as $faq)
                            <div class="bg-[var(--primary)] bg-opacity-10 rounded-2xl overflow-hidden">
                                <button 
                                    @click="selected = {{ $faq->id ?? 1 }}"
                                    class="flex items-center justify-between w-full p-6 text-left"
                                >
                                    <span class="text-xl font-semibold text-white">{{ $faq->question ?? "" }}</span>
                                    <svg 
                                        class="w-6 h-6 text-[var(--secondary)] transform transition-transform duration-200"
                                        :class="{ 'rotate-180': selected === {{ $faq->id ?? 0 }} }"
                                        fill="none" 
                                        stroke="currentColor" 
                                        viewBox="0 0 24 24"
                                    >
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                                    </svg>
                                </button>
                                <div 
                                    x-show="selected == {{ $faq->id ?? 0 }}"
                                    x-transition:enter="transition ease-out duration-200"
                                    x-transition:enter-start="opacity-0 transform -translate-y-2"
                                    x-transition:enter-end="opacity-100 transform translate-y-0"
                                    x-transition:leave="transition ease-in duration-200"
                                    x-transition:leave-start="opacity-100 transform translate-y-0"
                                    x-transition:leave-end="opacity-0 transform -translate-y-2"
                                    class="p-6 pt-0 text-[var(--info)]"
                                >
                                    {{ $faq->answer ?? "" }}
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>

@endsection
@section('downjs')
    <script>
        // GSAP animations
        gsap.from("header", { duration: 1, y: -100, opacity: 0 });
        gsap.from("#home h1", { duration: 1, x: -100, opacity: 0 });
        gsap.from("#home p", { duration: 1, x: 100, opacity: 0 });
        gsap.from("#home button", { duration: 1, scale: 0.8, opacity: 0 });
        // GSAP Smooth Animations
        gsap.from("#home h1", { y: -50, opacity: 0, duration: 1 });
        gsap.from("#home p", { y: 50, opacity: 0, delay: 0.5, duration: 1 });

        // FAQ Accordion
        document.querySelectorAll("#faq button").forEach((button) => {
            button.addEventListener("click", () => {
            const content = button.nextElementSibling;
            content.classList.toggle("hidden");
            });
        });

        new Splide('#howItWork-slider', {
            type: 'loop',
            perPage: 1,
            gap: '2rem',
            breakpoints: {
                1024: {
                    perPage: 1,
                },
                640: {
                    perPage: 1,
                }
            },
            arrows: true,
            pagination: false,
            autoplay: true,
            interval: 10000,
        }).mount();
      
        new Splide('#testimonials-slider', {
            type: 'loop',
            perPage: 3,
            gap: '1rem',
            breakpoints: {
                1024: {
                    perPage: 2,
                },
                640: {
                    perPage: 1,
                }
            },
            arrows: true,
            pagination: false,
            autoplay: true,
            interval: 10000,
        }).mount();
    </script>
@endsection