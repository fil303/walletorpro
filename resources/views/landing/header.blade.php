    <!-- Navbar -->
    <header class="fixed w-full top-0 z-50 backdrop-blur-lg bg-slate-900/80 border-b border-[var(--primary)] border-opacity-20">
        <div class="max-w-7xl mx-auto">
            <div class="flex items-center justify-between sm:px-6">
                <!-- Logo -->
                <div class="flex-shrink-0">
                    <a href="#" class="flex items-center space-x-2">
                        <img src="{{ asset_bind($app->app_logo ?? '') }}" loading="lazy" height="50px" width="250px" alt="App Logo">
                    </a>
                </div>

                <!-- Desktop Menu -->
                <nav class="hidden md:flex items-center space-x-6">
                    <a href="{{ route('welcomePage') }}" class="text-[var(--info)] hover:text-[var(--secondary)] transition-colors">Home</a>
                    <a href="{{ route('aboutPage') }}" class="text-[var(--info)] hover:text-[var(--secondary)] transition-colors">About</a>

                    <a href="{{ Route::is('contact_us') ? route("welcomePage")."#services" : "#services"}}" class="text-[var(--info)] hover:text-[var(--secondary)] transition-colors">Services</a>
                    <a href="{{ Route::is('contact_us') ? route("welcomePage")."#testimonials" : "#testimonials"}}" class="text-[var(--info)] hover:text-[var(--secondary)] transition-colors">Testimonials</a>
                    <a href="{{ Route::is('contact_us') ? route("welcomePage")."#faq" : "#faq"}}" class="text-[var(--info)] hover:text-[var(--secondary)] transition-colors">FAQ</a>

                    <a href="{{ route('contact_us') }}" class="text-[var(--info)] hover:text-[var(--secondary)] transition-colors">Contact</a>
                </nav>

                <!-- CTA Buttons -->
                <div class="hidden md:flex items-center space-x-4">
                    <a href="{{ route('loginPage') }}" class="px-4 py-2 text-[var(--info)] hover:text-[var(--secondary)] transition-colors">Login</a>
                    <a href="{{ route('registerPage') }}" class="px-4 py-2 bg-[var(--secondary)] text-black rounded-lg hover:bg-[var(--info)] transition-all duration-300">
                        Get Started
                    </a>
                </div>

                <!-- Mobile Menu Button -->
                <div class="flex md:hidden">
                    <button id="mobile-menu-button" class="text-white p-2">
                        <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
                        </svg>
                    </button>
                </div>
            </div>

            <!-- Mobile Menu Panel -->
            <div id="mobile-menu" class="hidden md:hidden">
                <div class="px-4 py-4 space-y-3 bg-slate-900/95">
                    <a href="#home" class="block text-[var(--info)] hover:text-[var(--secondary)] py-2">Home</a>
                    <a href="#about" class="block text-[var(--info)] hover:text-[var(--secondary)] py-2">About</a>
                    <a href="#services" class="block text-[var(--info)] hover:text-[var(--secondary)] py-2">Services</a>
                    <a href="#testimonials" class="block text-[var(--info)] hover:text-[var(--secondary)] py-2">Testimonials</a>
                    <a href="#faq" class="block text-[var(--info)] hover:text-[var(--secondary)] py-2">FAQ</a>
                    <a href="#contact" class="block text-[var(--info)] hover:text-[var(--secondary)] py-2">Contact</a>
                    <div class="pt-4 space-y-3">
                        <a href="#login" class="block text-[var(--info)] hover:text-[var(--secondary)] py-2">Login</a>
                        <a href="#signup" class="block w-full px-4 py-2 bg-[var(--secondary)] text-black text-center rounded-lg hover:bg-[var(--info)]">{{ $landing->hero_section_cta_text ?? "Get Started" }}</a>
                    </div>
                </div>
            </div>
        </div>
    </header>