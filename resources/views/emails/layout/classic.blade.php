<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $app->app_title ?? 'App Name' }} - @yield('title', '')</title>
    <link rel="stylesheet" href="{{ asset_bind('assets/style.css') }}" />
</head>
<body>
    <div class="p-2">
        {{-- <div class="max-w-lg mx-auto bg-base-200 rounded-lg shadow-md overflow-hidden"> --}}
            <!-- Header -->
            <div class="bg-primary p-4 text-center">
            <img src="{{ asset_bind($app->app_logo ?? '') }}" loading="lazy" height="200px" width="250px" alt="Company Logo" class="mx-auto mb-2">
            <h1 class="text-primary-content text-xl font-semibold">
                @yield('header')
            </h1>
            </div>

            <!-- body -->
            <div class="p-2">
                @yield('content')
            </div>

            <!-- Footer -->
            <div class="bg-base-300 p-4 text-center text-base-content text-sm">
                <p>{{ $app->app_footer_text ?? '' }}</p>
            </div>
        {{-- </div> --}}
    </div>
</body>
</html>
