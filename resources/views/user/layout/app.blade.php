<!DOCTYPE html>
<html lang="en" data-theme="pastel">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link
        href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500;1,600;1,700;1,800;1,900&display=swap"
        rel="stylesheet">
    <link rel="stylesheet" href="{{ asset_bind('assets/style.css') }}" />
    <link rel="stylesheet" href="https://cdn.datatables.net/1.13.7/css/jquery.dataTables.css" />

    <!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.0.0/animate.compat.css" /> -->
    <!-- <link rel="stylesheet" href="https://cdn.jsdelivr.net/gh/AdrianVillamayor/Wizard-JS@1.9.9/styles/css/main.css"> -->
    <link rel="stylesheet" href="{{ asset_bind('assets/filePond/filePond.css') }}" />
    <link rel="stylesheet" href="{{ asset_bind('assets/filePond/preview.css') }}" />
    <title>App Name - @yield('title', __('this is init title'))</title>
    @yield('head')
</head>

<body class="text-sm">
    <div class="spinner fixed content-center bg-base-200 h-full w-full z-50">
        <div class="mx-auto w-10">
            <span class="loader4dot"></span>
        </div>
    </div>
    <section class="flex flex-row h-full overflow-hidden">
        <div class="sm:hidden sm:absolute sm:top-15 sm:z-50 sm:left-0 h-full " id="sidebar_toggle">
            @include('user.layout.sidebar')
        </div>
        <div class="w-full">
            <div class="h-full">
                <div class="flex flex-col h-screen overflow-y-auto bg-base-200">
                    <!-- dark theme -->
                    <div class="container h-full">
                        <div class="mt-[60px]">
                            @include('user.layout.header')
                        </div>
                        <!-- <css-doodle use="var(--rule)"  class="fixed t-0 h-full w-full"> </css-doodle> -->
                        <div class="w-[97%] mx-auto container_height">
                            @yield('content')
                        </div>
                        @include('user.layout.footer')
                    </div>
                </div>
            </div>
        </div>
    </section>


    <!-- <section class="fixed max-w-2xl p-4 mx-auto bg-white border border-gray-200 md:gap-x-4 left-12 bottom-16 dark:bg-gray-900 md:flex md:items-center dark:border-gray-700 rounded-2xl">
      <div class="flex items-center gap-x-4">
          <span class="inline-flex p-2 text-blue-500 rounded-lg shrink-0 dark:bg-gray-800 bg-blue-100/80">
              <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M17.9803 8.5468C17.5123 8.69458 17.0197 8.7931 16.5271 8.7931C14.2118 8.76847 12.3399 6.89655 12.3153 4.58128C12.3153 4.13793 12.3892 3.69458 12.537 3.27586C11.9951 2.68473 11.6995 1.92118 11.6995 1.13301C11.6995 0.812808 11.7488 0.492611 11.8473 0.172414C11.2315 0.0738918 10.6158 0 10 0C4.48276 0 0 4.48276 0 10C0 15.5172 4.48276 20 10 20C15.5172 20 20 15.5172 20 10C20 9.77833 20 9.55665 19.9754 9.33498C19.2611 9.26108 18.5468 8.99015 17.9803 8.5468ZM4.58128 7.31527C6.30542 7.31527 6.30542 10.0246 4.58128 10.0246C2.85714 10.0246 2.61084 7.31527 4.58128 7.31527ZM6.05912 15.7635C4.08867 15.7635 4.08867 12.8079 6.05912 12.8079C8.02956 12.8079 8.02956 15.7635 6.05912 15.7635ZM9.01478 1.33005C10.7389 1.33005 10.7389 4.28571 9.01478 4.28571C7.29064 4.28571 7.04434 1.33005 9.01478 1.33005ZM10.2463 8.84237C11.7241 8.84237 11.7241 10.8128 10.2463 10.8128C8.76848 10.8128 9.01478 8.84237 10.2463 8.84237ZM11.9704 16.9458C10.4926 16.9458 10.4926 14.9754 11.9704 14.9754C13.4483 14.9754 13.202 16.9458 11.9704 16.9458ZM16.6503 13.1034C15.4187 13.1034 15.4187 11.133 16.6503 11.133C17.8818 11.133 17.8818 13.1034 16.6503 13.1034Z" fill="currentColor"/>
              </svg>
          </span>
  
          <p class="text-sm text-gray-600 dark:text-gray-300">We use cookies to ensure that we give you the best experience on our website. <a href="#" class="text-blue-500 hover:underline">Read cookies policies</a>. </p>
      </div>
      
      <div class="flex items-center mt-6 gap-x-4 shrink-0 lg:mt-0">
          <button class="w-1/2 text-xs text-gray-800 underline transition-colors duration-300 md:w-auto dark:text-white dark:hover:text-gray-400 hover:text-gray-600 focus:outline-none">
              Cookie Setting
          </button>
  
          <button class=" text-xs w-1/2 md:w-auto font-medium bg-gray-800 rounded-lg hover:bg-gray-700 text-white px-4 py-2.5 duration-300 transition-colors focus:outline-none">
              Accept All Cookies
          </button>
      </div>
  </section> -->
    @yield('upjs')
    <!-- <script src="{{ asset_bind('assets/datatable.js') }}"></script> -->
    <script>
        // localStorage.theme === 'dark' || 
        // (
        //     !('theme' in localStorage) && 
        //     window.matchMedia('(prefers-color-scheme: dark)').matches
        // )
        if(localStorage.themeName){
            document.documentElement.dataset.theme = localStorage.themeName;
        }
        
        if (localStorage.themeName == "night") document.getElementById("dark_mode_button").classList.toggle("hidden");
        else document.getElementById("light_mode_button").classList.toggle("hidden");

        function changeTheme(e) {
            let theme = e.dataset.themeName;
            document.documentElement.dataset.theme = theme;
            localStorage.themeName = theme;

            document.getElementById("dark_mode_button").classList.toggle("hidden");
            document.getElementById("light_mode_button").classList.toggle("hidden")
        }

        // header button
        const sidebarToggleButton = document.getElementById("sidebar_toggle_button");
        const sidebarToggleElement = document.getElementById("sidebar_toggle");
        const sidebarToggleButtonOn = document.getElementById("sidebar_toggle_button_on");
        const sidebarToggleButtonOff = document.getElementById("sidebar_toggle_button_off");
        const headerElement = document.getElementsByTagName("header")[0];

        // in sidebar button
        const sidebarButton = document.getElementById("sidebar_button");
        const sidebarButtonOff = document.getElementById("sidebar_button_off");

        sidebarButton.addEventListener("click", () => {
            const smMediaQuery = window.matchMedia('(min-width: 640px)').matches;

            if (!smMediaQuery) {
                if (sidebarToggleElement.classList.contains("hidden"))
                    sidebarToggleElement.classList.remove("hidden");

                sidebarToggleElement.classList.toggle("sm:hidden");
            } else {
                sidebarToggleElement.classList.toggle("hidden");
            }

            headerElement.classList.toggle("header_width");
            headerElement.classList.toggle("w-full");

            sidebarToggleButtonOn.classList.toggle("hidden");
            sidebarToggleButtonOff.classList.toggle("hidden");
        });
        sidebarToggleButton.addEventListener("click", () => {
            const smMediaQuery = window.matchMedia('(min-width: 640px)').matches;

            if (!smMediaQuery) {
                if (sidebarToggleElement.classList.contains("hidden"))
                    sidebarToggleElement.classList.remove("hidden");

                sidebarToggleElement.classList.toggle("sm:hidden");
            } else {
                sidebarToggleElement.classList.toggle("hidden");
            }

            headerElement.classList.toggle("header_width");
            headerElement.classList.toggle("w-full");

            sidebarToggleButtonOn.classList.toggle("hidden");
            sidebarToggleButtonOff.classList.toggle("hidden");
        });
    </script>
    <script src="{{ asset_bind('assets/css-doodle.js') }}"></script>
    <script src="{{ asset_bind('assets/flowbite.js') }}"></script>

    @yield('js')
    @includeWhen(Auth::check() && Auth::user()->role?->isUser(), 'user.layout.js_const')
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
        @if (Session::has('success'))
            console.log("{{ Session::get('success') }}");
            Notiflix.Notify.success("{{ Session::remove('success') }}",{ID: 'MKA',timeout: 3000,clickToClose: true,showOnlyTheLastOne: true});
        @endif
        @if (Session::has('error'))
            console.log("{{ Session::get('error') }}");
            Notiflix.Notify.failure("{{ Session::remove('error') }}",{ID: 'MKA',timeout: 3000,clickToClose: true,showOnlyTheLastOne: true});
        @endif
    </script>
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
