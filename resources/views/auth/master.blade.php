<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link rel="icon" type="image/x-icon" href="{{ asset_bind($app->app_fav ?? '') }}">
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset_bind('assets/style.css') }}" />
    <title>App Name - @yield('title', __('this is init title'))</title>
    @yield('head')
</head>
<body>
    <div class="spinner fixed content-center bg-base-200 h-full w-full z-50">
        <div class="mx-auto w-10">
            <span class="loader4dot"></span>
        </div>
    </div>
    @yield('content')
    @yield('js')
    <script src="{{ asset_bind('assets/jquery.js') }}"></script>
    <script src="{{ asset_bind('assets/toster/notiflix-notify-aio-3.2.6.min.js') }}"></script>
    <script src="{{ asset_bind('assets/toster/notiflix-confirm-aio-3.2.6.min.js') }}"></script>
    <script src="{{ asset_bind('assets/toster/notiflix-block-aio-3.2.6.min.js') }}"></script>

    <script>
        @if (Session::has('success'))
            Notiflix.Notify.success("{{ Session::remove('success') }}",{ID: 'MKA',timeout: 3000,clickToClose: true,showOnlyTheLastOne: true});
        @endif
        @if (Session::has('error'))
            Notiflix.Notify.failure("{{ Session::remove('error') }}",{ID: 'MKA',timeout: 3000,clickToClose: true,showOnlyTheLastOne: true});
        @endif
    </script>
    {!! NoCaptcha::renderJs() !!}
    <script>
        "use strict";
        {!! Vite::content('resources/js/app.js') !!}
        
    </script>
    @yield('downjs')
        <script>
        function spinner(turnOn = true){
            if(turnOn){
                if (document.querySelector(".spinner").classList.contains("hidden")){
                    document.querySelector(".spinner").classList.remove("hidden");
                }
            }else{
                if (!document.querySelector(".spinner").classList.contains("hidden")){
                    document.querySelector(".spinner").classList.add("hidden");
                }
            }
        }
        window.addEventListener("load", (event) => {
            spinner(false);
        });
    </script>
</body>

</html>
