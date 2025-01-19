    <!-- Header -->
    <header class="bg-base-100 shadow-md sticky top-0 z-20 flex justify-between items-center p-1">
        <div class="flex items-center">
            <button id="sidebarToggle">
                <label  class="btn btn-circle swap swap-rotate">
                    <!-- this hidden checkbox controls the state -->
                    <input type="checkbox" />

                    <!-- hamburger icon -->
                    <svg id="sidebarToggleOnSvg"
                        class="fill-current" xmlns="http://www.w3.org/2000/svg" width="25" height="25" viewBox="0 0 512 512">
                        <path d="M64,384H448V341.33H64Zm0-106.67H448V234.67H64ZM64,128v42.67H448V128Z" />
                    </svg>
                </label>
            </button>
        </div>

        <!-- User & Notifications -->
        <div class="flex items-center">
            <ul class="flex items-center space-x-6 mr-6">
                @if(false)
                <li>
                    <a class="text-gray-200 hover:text-gray-300" href="#">
                        <svg class="h-5 w-5" viewbox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M15 0H3C2.20435 0 1.44129 0.316071 0.87868 0.87868C0.316071 1.44129 0 2.20435 0 3V14C0 14.7956 0.316071 15.5587 0.87868 16.1213C1.44129 16.6839 2.20435 17 3 17H5.59L8.29 19.71C8.38344 19.8027 8.49426 19.876 8.61609 19.9258C8.73793 19.9755 8.86839 20.0008 9 20C9.23834 20 9.46886 19.9149 9.65 19.76L12.87 17H15C15.7956 17 16.5587 16.6839 17.1213 16.1213C17.6839 15.5587 18 14.7956 18 14V3C18 2.20435 17.6839 1.44129 17.1213 0.87868C16.5587 0.316071 15.7956 0 15 0ZM16 14C16 14.2652 15.8946 14.5196 15.7071 14.7071C15.5196 14.8946 15.2652 15 15 15H12.5C12.2617 15 12.0311 15.0851 11.85 15.24L9.05 17.64L6.71 15.29C6.61656 15.1973 6.50574 15.124 6.38391 15.0742C6.26207 15.0245 6.13161 14.9992 6 15H3C2.73478 15 2.48043 14.8946 2.29289 14.7071C2.10536 14.5196 2 14.2652 2 14V3C2 2.73478 2.10536 2.48043 2.29289 2.29289C2.48043 2.10536 2.73478 2 3 2H15C15.2652 2 15.5196 2.10536 15.7071 2.29289C15.8946 2.48043 16 2.73478 16 3V14Z"
                                fill="currentColor"></path>
                        </svg>
                    </a>
                </li>
                <li>
                    <a class="text-gray-200 hover:text-gray-300" href="#">
                        <svg class="h-5 w-5" viewbox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path
                                d="M14 11.18V8C13.9986 6.58312 13.4958 5.21247 12.5806 4.13077C11.6655 3.04908 10.3971 2.32615 9 2.09V1C9 0.734784 8.89464 0.48043 8.70711 0.292893C8.51957 0.105357 8.26522 0 8 0C7.73478 0 7.48043 0.105357 7.29289 0.292893C7.10536 0.48043 7 0.734784 7 1V2.09C5.60294 2.32615 4.33452 3.04908 3.41939 4.13077C2.50425 5.21247 2.00144 6.58312 2 8V11.18C1.41645 11.3863 0.910998 11.7681 0.552938 12.2729C0.194879 12.7778 0.00173951 13.3811 0 14V16C0 16.2652 0.105357 16.5196 0.292893 16.7071C0.48043 16.8946 0.734784 17 1 17H4.14C4.37028 17.8474 4.873 18.5954 5.5706 19.1287C6.26819 19.6621 7.1219 19.951 8 19.951C8.8781 19.951 9.73181 19.6621 10.4294 19.1287C11.127 18.5954 11.6297 17.8474 11.86 17H15C15.2652 17 15.5196 16.8946 15.7071 16.7071C15.8946 16.5196 16 16.2652 16 16V14C15.9983 13.3811 15.8051 12.7778 15.4471 12.2729C15.089 11.7681 14.5835 11.3863 14 11.18ZM4 8C4 6.93913 4.42143 5.92172 5.17157 5.17157C5.92172 4.42143 6.93913 4 8 4C9.06087 4 10.0783 4.42143 10.8284 5.17157C11.5786 5.92172 12 6.93913 12 8V11H4V8ZM8 18C7.65097 17.9979 7.30857 17.9045 7.00683 17.7291C6.70509 17.5536 6.45451 17.3023 6.28 17H9.72C9.54549 17.3023 9.29491 17.5536 8.99317 17.7291C8.69143 17.9045 8.34903 17.9979 8 18ZM14 15H2V14C2 13.7348 2.10536 13.4804 2.29289 13.2929C2.48043 13.1054 2.73478 13 3 13H13C13.2652 13 13.5196 13.1054 13.7071 13.2929C13.8946 13.4804 14 13.7348 14 14V15Z"
                                fill="currentColor"></path>
                        </svg>
                    </a>
                </li>
                @endif
            </ul>
            <!-- User Profile -->
            <div class="dropdown dropdown-end">
                <button type="button" id="profile_dropdown_button" data-dropdown-toggle="profile_dropdown"
                    data-dropdown-placement="bottom-start" class="flex items-center ">
                    <div class="mr-2">
                        <img class="w-10 h-10 rounded-full object-cover object-right" loading="lazy" src="{{ auth()->user()->getImage() ?? '' }}" alt="">
                    </div>
                    <div class="mr-3">
                        <p class="text-sm font-bold">{{ auth()->user()->name ?? '' }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->username ?? '' }}</p>
                    </div>
                </button>
                <div class="dropdown-content bg-base-100 p-4 shadow-lg rounded-box w-64">
                    <div class="flex items-center space-x-2">
                        <img src="{{ auth()->user()->getImage() ?? '' }}" loading="lazy" class="w-10 rounded-full" alt="{{ auth()->user()->name }}">
                        <div>
                        <p class="font-bold">{{ auth()->user()->name ?? '' }}</p>
                        <p class="text-sm text-gray-500">{{ auth()->user()->email ?? '' }}</p>
                        </div>
                    </div>
                    <ul class="menu mt-3">
                        @if(auth()->user()->role->isUser())
                            <li><a href="{{ route('userProfile') }}">{{__("Profile")}}</a></li>
                        @endif
                        @if(auth()->user()->role->isAdmin())
                            <li><a href="{{ route('adminProfilePage') }}">{{__("Profile")}}</a></li>
                        @endif
                        <li><a class="bg-error" href="#" onclick="window.location.href = '{{ route('logout') }}'">{{__("Logout")}}</a></li>
                    </ul>
                </div>
            </div>
        </div>
    </header>