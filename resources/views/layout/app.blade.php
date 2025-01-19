<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="{{ asset_bind($app->app_fav ?? '') }}">
    <link rel="stylesheet" href="{{ asset_bind('assets/poppins.css') }}" />
    <link rel="stylesheet" href="{{ asset_bind('assets/style.css') }}" />
    <link rel="stylesheet" href="{{ asset_bind('assets/datatable/dataTables.css') }}" />
    <link rel="stylesheet" href="{{ asset_bind('assets/filePond/filePond.css') }}" />
    <link rel="stylesheet" href="{{ asset_bind('assets/filePond/preview.css') }}" />
    <script src="{{ asset_bind('assets/alpine.js') }}" defer></script>
    <title>{{ $app->app_title ?? 'App Name' }} - @yield('title', __('this is init title'))</title>
    @yield('head')
</head>
<body>
    <div class="spinner fixed content-center bg-base-200 h-full w-full z-50">
        <div class="mx-auto w-10">
            <span class="loader4dot"></span>
        </div>
    </div>
    <div class="flex flex-row h-full overflow-hidden">
        @includeWhen(Auth::check() && Auth::user()->role?->isAdmin(), 'layout.admin_sidebar')
        @includeWhen(Auth::check() && Auth::user()->role?->isUser() , 'layout.user_sidebar')

        <div class="w-full h-screen h-full">
            @include('layout.header')
            <!-- Main Content -->
            <main class="p-4 h-min-screen h-full bg-base-300 overflow-y-auto pb-36">
                @yield('content')
            </main>
            <!-- Footer -->
            <footer class="bg-base-100 w-full p-5 text-base-content border-t border-gray-300 z-20 fixed bottom-0">
                <div class="text-center ml-[-20%]">
                    {{ $app->app_footer_text ?? '' }}
                </div>
            </footer>
        </div>
    </div>

    @yield('upjs')
    <script src="{{ asset_bind('assets/base.js') }}"></script>
    @yield('js')
    @include('layout.js_const')
    <script src="{{ asset_bind('assets/filePond/preview.js') }}"></script>
    <script src="{{ asset_bind('assets/filePond/filePond.js') }}"></script>
    <!-- <script src="{{ asset_bind('assets/wizard.min.js') }}"></script> -->
    <script src="{{ asset_bind('assets/jquery.js') }}"></script>
    <!-- DataTable -->
    <script src="{{ asset_bind('assets/datatable/pdfmake.min.js') }}"></script>
    <script src="{{ asset_bind('assets/datatable/vfs_fonts.js') }}"></script>
    <script src="{{ asset_bind('assets/datatable/jquery.dataTables.min.js') }}"></script>
    <!-- This script for notification ( Toster ) -->
    <script src="{{ asset_bind('assets/toster/notiflix-notify-aio-3.2.6.min.js') }}"></script>
    <script src="{{ asset_bind('assets/toster/notiflix-report-aio-3.2.6.min.js') }}"></script>
    <script src="{{ asset_bind('assets/toster/notiflix-confirm-aio-3.2.6.min.js') }}"></script>
    <!--<script src="{{ asset_bind('assets/toster/notiflix-loading-aio-3.2.6.min.js') }}"></script> -->
    <script src="{{ asset_bind('assets/toster/notiflix-block-aio-3.2.6.min.js') }}"></script>

    <script>
        document.documentElement.dataset.theme = '{{ $app->theme ?? "corporate" }}';

        @if (Session::has('success'))
            console.log("{{ Session::get('success') }}");
            Notiflix.Notify.success("{{ Session::remove('success') }}",{ID: 'MKA',timeout: 3000,clickToClose: true,showOnlyTheLastOne: true});
        @endif
        @if (Session::has('error'))
            console.log("{{ Session::get('error') }}");
            Notiflix.Notify.failure("{{ Session::remove('error') }}",{ID: 'MKA',timeout: 3000,clickToClose: true,showOnlyTheLastOne: true});
        @endif

        {!! Vite::content('resources/js/app.js') !!}
    </script>
    @yield('downjs')
</body>
</html>
