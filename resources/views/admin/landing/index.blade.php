@extends('layout.app', [ 'open_landing_menu' => true, 'menu' => 'landing', 'sub_menu' => 'page_setting' ])

@section('title', __('Landing Page Manager'))
@section('head')
    <link rel="stylesheet" href="{{ asset_bind('assets/summernote/summernote-lite.min.css') }}" />
    <style>
        .note-editor {
           background-color: white;
        }
    </style>
@endsection
@section('content')
<div class="grid grid-cols-4 sm:block gap-1" x-data="{ currentTab: '{{ $landing_tab ?? 'colors'}}' }">
    <!-- Left Side Tabs -->
    <div class="sm:mb-2 md:col-span-2 xl:col-span-1">
        <ul class="menu bg-base-200 w-full rounded-box">
            <li>
                <a :class="{ 'active': currentTab === 'colors' }" @click="currentTab = 'colors'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    Landing Color
                </a>
            </li>
            <li>
                <a :class="{ 'active': currentTab === 'hero' }" @click="currentTab = 'hero'">
                    <svg class="lucide lucide-layout-panel-top h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <rect width="18" height="7" x="3" y="3" rx="1"/><rect width="7" height="7" x="3" y="14" rx="1"/><rect width="7" height="7" x="14" y="14" rx="1"/>
                    </svg>
                    Hero Section
                </a>
            </li>
            <li>
                <a :class="{ 'active': currentTab === 'about' }" @click="currentTab = 'about'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    About Section
                </a>
            </li>
            <li>
                <a :class="{ 'active': currentTab === 'how' }" @click="currentTab = 'how'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
                    </svg>
                    How It Works
                </a>
            </li>
            <li>
                <a :class="{ 'active': currentTab === 'service' }" @click="currentTab = 'service'">
                    <svg class="lucide lucide-briefcase h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M16 20V4a2 2 0 0 0-2-2h-4a2 2 0 0 0-2 2v16"/><rect width="20" height="14" x="2" y="6" rx="2"/>
                    </svg>
                    Service
                </a>
            </li>
            <li>
                <a :class="{ 'active': currentTab === 'wallet' }" @click="currentTab = 'wallet'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z" />
                    </svg>
                    Wallet Features
                </a>
            </li>
            <li>
                <a :class="{ 'active': currentTab === 'testimonials' }" @click="currentTab = 'testimonials'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z" />
                    </svg>
                    Testimonials
                </a>
            </li>
            <li>
                <a :class="{ 'active': currentTab === 'faq' }" @click="currentTab = 'faq'">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-primary" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8.228 9c.549-1.165 2.03-2 3.772-2 2.21 0 4 1.343 4 3 0 1.4-1.278 2.575-3.006 2.907-.542.104-.994.54-.994 1.093m0 3h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    FAQ
                </a>
            </li>
            <li>
                <a :class="{ 'active': currentTab === 'social' }" @click="currentTab = 'social'">
                    <svg class="lucide lucide-rss h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 11a9 9 0 0 1 9 9"/><path d="M4 4a16 16 0 0 1 16 16"/><circle cx="5" cy="19" r="1"/>
                    </svg>
                    Social Network
                </a>
            </li>
            <li>
                <a :class="{ 'active': currentTab === 'terms_condition' }" @click="currentTab = 'terms_condition'">
                    <svg class="lucide lucide-book-check h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M4 19.5v-15A2.5 2.5 0 0 1 6.5 2H19a1 1 0 0 1 1 1v18a1 1 0 0 1-1 1H6.5a1 1 0 0 1 0-5H20"/><path d="m9 9.5 2 2 4-4"/>
                    </svg>
                    Terms & Conditions
                </a>
            </li>
            <li>
                <a :class="{ 'active': currentTab === 'privacy_policy' }" @click="currentTab = 'privacy_policy'">
                    <svg class="lucide lucide-siren h-5 w-5 text-primary" xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                        <path d="M7 18v-6a5 5 0 1 1 10 0v6"/><path d="M5 21a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1v-1a2 2 0 0 0-2-2H7a2 2 0 0 0-2 2z"/><path d="M21 12h1"/><path d="M18.5 4.5 18 5"/>
                        <path d="M2 12h1"/><path d="M12 2v1"/><path d="m4.929 4.929.707.707"/><path d="M12 12v6"/>
                    </svg>
                    Privacy Policy
                </a>
            </li>
        </ul>
    </div>

    <!-- Right Side Content -->
    <div class="col-span-3 xl:col-span-3">
        <div class="card bg-base-100">
            <div class="card-body">

                <!-- Color Settings -->
                @include('admin.landing.components.colors')

                <!-- Hero Section Form -->
                @include('admin.landing.components.hero')

                <!-- About Section Form -->
                @include('admin.landing.components.about')

                <!-- How It Works Section Form -->
                @include('admin.landing.components.how')
                
                <!-- Service Section Form -->
                @include('admin.landing.components.service')

                <!-- Wallet Features Section Form -->
                @include('admin.landing.components.wallet')

                <!-- Testimonials Section Form -->
                @include('admin.landing.components.testimonials')

                <!-- FAQ Section Form -->
                @include('admin.landing.components.faq')
                
                <!-- Social Network -->
                @include('admin.landing.components.social_network')
                
                <!-- Terms & Conditions -->
                @include('admin.landing.components.terms_condition')
               
                <!-- Privacy Policy -->
                @include('admin.landing.components.privacy_policy')
            </div>
        </div>
    </div>
</div>
@endsection

@section('downjs')
    <script src="{{ asset_bind('assets/summernote/summernote-lite.min.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", () => {
            let service = document.siteProviderService

                .newInstance()
                .filePondService("heroImage")
                .setCongif(filePondOption)
                .setNodeSeletor('.filePond')
                @if(isset($landing->about_section_image))
                    .setdefaultFile('{{ asset_bind($landing->hero_section_image ?? "") }}')
                @endif
                .exit()

                .newInstance()
                .filePondService("aboutImage")
                .setCongif(filePondOption)
                .setNodeSeletor('.aboutFilePond')
                @if(isset($landing->about_section_image))
                    .setdefaultFile('{{ asset_bind($landing->about_section_image ?? "") }}')
                @endif
                .exit()

                .newInstance()
                .filePondService("aboutImage")
                .setCongif(filePondOption)
                .setNodeSeletor('.serviceFilePond')
                @if(isset($landing->service_section_image))
                    .setdefaultFile('{{ asset_bind($landing->service_section_image ?? "") }}')
                @endif
                .exit()
                
                .newInstance()
                .filePondService("faqImage")
                .setCongif(filePondOption)
                .setNodeSeletor('.faqFilePond')
                @if(isset($landing->service_section_image))
                    .setdefaultFile('{{ asset_bind($landing->faq_section_image ?? "") }}')
                @endif
                .exit()

            .boot();
        });

        document.querySelectorAll('input[type="color"]').forEach(input => {
            input.addEventListener('input', (e) => {
                const hexInput = e.target.nextElementSibling;
                hexInput.value = e.target.value;
            });
        });

        document.querySelectorAll('input[pattern]').forEach(input => {
            input.addEventListener('input', (e) => {
                const colorInput = e.target.previousElementSibling;
                if (e.target.value.match(e.target.pattern)) {
                    colorInput.value = e.target.value;
                }
            });
        });

        $('#summernote_terms_condition').summernote({
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['fontsize', ['fontsize']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link','picture']],
                ['view', ['fullscreen', 'help']]
            ]
        });
        // $('#summernote_terms_condition').summernote('code', '{{ $landing->terms_condition ?? '' }}');
        
        $('#summernote_privacy_policy').summernote({
            tabsize: 2,
            height: 400,
            toolbar: [
                ['style', ['style']],
                ['fontsize', ['fontsize']],
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link','picture']],
                ['view', ['fullscreen', 'help']]
            ]
        });
        // $('#summernote_privacy_policy').summernote('code', '{{ $landing->privacy_policy ?? '' }}');
    </script>
@endsection