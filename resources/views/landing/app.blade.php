<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="{{ asset_bind($app->app_fav ?? '') }}">
  <title>{{ $app->app_name ?? 'App Title' }}</title>
  <script src="{{ asset_bind('assets/tailwind.full.min.js') }}"></script>
  <script src="{{ asset_bind('assets/gsap.min.js') }}"></script>
  <script src="{{ asset_bind('assets/alpine.js') }}" defer></script>
  <script src="{{ asset_bind('assets/splide/splide.min.js') }}"></script>
  <link rel="stylesheet" href="{{ asset_bind('assets/splide/splide.min.css') }}" />
  <style>
    :root {
        --primary: {{ $landing->primary_color ?? "#1e40af" }};
        --secondary: {{ $landing->secondary_color ?? "#f97316" }};
        --success: {{ $landing->success_color ?? "#22c55e" }};
        --info: {{ $landing->info_color ?? "#0ea5e9" }};
    }
    html { scroll-behavior: smooth; }
  </style>
</head>
<body class="font-sans w-full overflow-x-hidden p-0 m-0 h-screen">
    @include('landing.header')
    <div class="h-full bg-slate-900">
        @yield('content')
        @include('landing.footer')
    </div>
    {!! NoCaptcha::renderJs() !!}
    <script src="{{ asset_bind('assets/toster/notiflix-notify-aio-3.2.6.min.js') }}"></script>
    <script>
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        mobileMenuButton.addEventListener('click', () => {
            mobileMenu.classList.toggle('hidden');
        });

        // Close mobile menu when clicking outside
        document.addEventListener('click', (e) => {
            if (!mobileMenuButton.contains(e.target) && !mobileMenu.contains(e.target)) {
                mobileMenu.classList.add('hidden');
            }
        });

        // Add shadow on scroll
        window.addEventListener('scroll', () => {
            const header = document.querySelector('header');
            if (window.scrollY > 0) {
                header.classList.add('shadow-lg');
            } else {
                header.classList.remove('shadow-lg');
            }
        });
    </script>

    <script>
        @if (Session::has('success'))
            console.log("{{ Session::get('success') }}");
            Notiflix.Notify.success("{{ Session::remove('success') }}",{ID: 'MKA',timeout: 3000,clickToClose: true,showOnlyTheLastOne: true});
        @endif
        @if (Session::has('error'))
            console.log("{{ Session::get('error') }}");
            Notiflix.Notify.failure("{{ Session::remove('error') }}",{ID: 'MKA',timeout: 3000,clickToClose: true,showOnlyTheLastOne: true});
        @endif
    </script>
    @yield('downjs')
</body>
</html>