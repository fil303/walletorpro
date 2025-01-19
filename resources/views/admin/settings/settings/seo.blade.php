@extends('layout.app', [ 'menu' => 'setting' ])

@section('title', __('Email Setting'))
@section('head')
    <style>
        .mian-seo-div {
            background: linear-gradient(135deg, #f6d365 0%, #fda085 100%);
        }

        .tooltip-content {
            visibility: hidden;
            opacity: 0;
            position: absolute;
            z-index: 10;
            background-color: #111827;
            color: #fff;
            padding: 8px;
            border-radius: 6px;
            transition: opacity 0.2s ease;
        }

        .tooltip:hover .tooltip-content {
            visibility: visible;
            opacity: 1;
        }
    </style>
@endsection
@section('content')

    <h2 class="card-title">{{ __('SEO Configuration') }}</h2>
    <div class="divider"></div>

    <!-- SEO Settings Form -->
    <div class="grid sm:block grid-cols-2 gap-4">

        <!-- Meta Title -->
        <div class="card bg-base-100 shadow-md p-6 sm:mb-2 relative">
            <h2 class="card-title">Meta Title</h2>
            <p class="text-sm text-gray-500">Set the default meta title for your site.</p>
            <div class="tooltip absolute top-0 right-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary cursor-pointer" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10zm-1-9V7h2v6h-2zm0 4h2v2h-2v-2z" />
                </svg>
                <div class="tooltip-content">This will appear in the title bar of browsers and in search engine results.
                </div>
            </div>
            <input type="text" placeholder="Enter Meta Title" class="input input-bordered mt-2 w-full" />
        </div>

        <!-- Meta Description -->
        <div class="card bg-base-100 shadow-md p-6 sm:mb-2 relative">
            <h2 class="card-title">Meta Description</h2>
            <p class="text-sm text-gray-500">Set the default meta description for your site.</p>
            <div class="tooltip absolute top-0 right-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary cursor-pointer" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10zm-1-9V7h2v6h-2zm0 4h2v2h-2v-2z" />
                </svg>
                <div class="tooltip-content">This will appear in search engine snippets and social previews.</div>
            </div>
            <textarea placeholder="Enter Meta Description" class="textarea textarea-bordered mt-2 w-full"></textarea>
        </div>

        <!-- Meta Keywords -->
        <div class="card bg-base-100 shadow-md p-6 sm:mb-2 relative">
            <h2 class="card-title">Meta Keywords</h2>
            <p class="text-sm text-gray-500">Add keywords that describe your site.</p>
            <div class="tooltip absolute top-0 right-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary cursor-pointer" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10zm-1-9V7h2v6h-2zm0 4h2v2h-2v-2z" />
                </svg>
                <div class="tooltip-content">Separate keywords with commas (e.g., "SEO, marketing, web development").</div>
            </div>
            <input type="text" placeholder="Enter Meta Keywords" class="input input-bordered mt-2 w-full" />
        </div>

        <!-- Social Media Image -->
        <div class="card bg-base-100 shadow-md p-6 sm:mb-2 relative">
            <h2 class="card-title">Social Media Preview Image</h2>
            <p class="text-sm text-gray-500">Set a default image for social media link previews.</p>
            <div class="tooltip absolute top-0 right-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary cursor-pointer" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10zm-1-9V7h2v6h-2zm0 4h2v2h-2v-2z" />
                </svg>
                <div class="tooltip-content">This image will be displayed when links to your site are shared on social
                    media.</div>
            </div>
            <input type="file" class="file-input file-input-bordered w-full mt-2" />
        </div>

        <!-- Robots.txt -->
        <div class="card bg-base-100 shadow-md p-6 sm:mb-2 relative">
            <h2 class="card-title">Robots.txt</h2>
            <p class="text-sm text-gray-500">Manage how search engines crawl your site.</p>
            <div class="tooltip absolute top-0 right-2">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 text-primary cursor-pointer" viewBox="0 0 24 24"
                    fill="currentColor">
                    <path
                        d="M12 22c5.523 0 10-4.477 10-10S17.523 2 12 2 2 6.477 2 12s4.477 10 10 10zm-1-9V7h2v6h-2zm0 4h2v2h-2v-2z" />
                </svg>
                <div class="tooltip-content">Specify which parts of your site should not be indexed by search engines.</div>
            </div>
            <textarea placeholder="User-agent: *\nDisallow: /admin" class="textarea textarea-bordered mt-2 w-full"></textarea>
        </div>

        <!-- Sitemap -->
        <div class="card bg-base-100 shadow-md p-6 sm:mb-2">
            <h2 class="card-title">Sitemap XML</h2>
            <p class="text-sm text-gray-500">Manage your site's sitemap for better indexing.</p>
            <button class="btn btn-outline btn-primary mt-2">Generate Sitemap</button>
        </div>

        <!-- Canonical URL -->
        <div class="card bg-base-100 shadow-md p-6 sm:mb-2">
            <h2 class="card-title">Canonical URL</h2>
            <p class="text-sm text-gray-500">Set a canonical URL to avoid duplicate content issues.</p>
            <input type="text" placeholder="https://www.example.com" class="input input-bordered mt-2 w-full" />
        </div>
    </div>

    <!-- Save Button -->
    <div class="mt-10 text-center">
        <button class="btn btn-primary w-full max-w-md">Save SEO Settings</button>
    </div>



@endsection
