<header class="fixed top-0 header_width sm:w-full shadow z-10 bg-base-100">
    <nav class="border-gray-200 px-4 lg:px-6 py-2.5">
        <div class="flex flex-wrap justify-between items-center">
            <div class="">
              <button id="sidebar_toggle_button" type="button" class="inline-flex items-center p-2 ml-1 text-sm rounded-lg focus:outline-none focus:ring-2" >
                  <span class="sr-only"></span>
                  <svg id="sidebar_toggle_button_on" class="hidden w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M3 5a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 10a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1zM3 15a1 1 0 011-1h12a1 1 0 110 2H4a1 1 0 01-1-1z" clip-rule="evenodd"></path></svg>
                  <svg id="sidebar_toggle_button_off" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20" xmlns="http://www.w3.org/2000/svg"><path fill-rule="evenodd" d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z" clip-rule="evenodd"></path></svg>
              </button>
            </div>
            <div class="sm:hidden"></div>

            <div class="sm:hidden"></div>
            <div class="flex items-center relative">
                <ul class="flex items-center space-x-6 mr-6">
                    <li>
                      <a class="text-gray-200 hover:text-gray-300" href="#">
                        <svg class="h-5 w-5" viewbox="0 0 18 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M15 0H3C2.20435 0 1.44129 0.316071 0.87868 0.87868C0.316071 1.44129 0 2.20435 0 3V14C0 14.7956 0.316071 15.5587 0.87868 16.1213C1.44129 16.6839 2.20435 17 3 17H5.59L8.29 19.71C8.38344 19.8027 8.49426 19.876 8.61609 19.9258C8.73793 19.9755 8.86839 20.0008 9 20C9.23834 20 9.46886 19.9149 9.65 19.76L12.87 17H15C15.7956 17 16.5587 16.6839 17.1213 16.1213C17.6839 15.5587 18 14.7956 18 14V3C18 2.20435 17.6839 1.44129 17.1213 0.87868C16.5587 0.316071 15.7956 0 15 0ZM16 14C16 14.2652 15.8946 14.5196 15.7071 14.7071C15.5196 14.8946 15.2652 15 15 15H12.5C12.2617 15 12.0311 15.0851 11.85 15.24L9.05 17.64L6.71 15.29C6.61656 15.1973 6.50574 15.124 6.38391 15.0742C6.26207 15.0245 6.13161 14.9992 6 15H3C2.73478 15 2.48043 14.8946 2.29289 14.7071C2.10536 14.5196 2 14.2652 2 14V3C2 2.73478 2.10536 2.48043 2.29289 2.29289C2.48043 2.10536 2.73478 2 3 2H15C15.2652 2 15.5196 2.10536 15.7071 2.29289C15.8946 2.48043 16 2.73478 16 3V14Z" fill="currentColor"></path>
                        </svg>
                      </a>
                    </li>
                    <li>
                      <a class="text-gray-200 hover:text-gray-300" href="#">
                        <svg class="h-5 w-5" viewbox="0 0 16 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M14 11.18V8C13.9986 6.58312 13.4958 5.21247 12.5806 4.13077C11.6655 3.04908 10.3971 2.32615 9 2.09V1C9 0.734784 8.89464 0.48043 8.70711 0.292893C8.51957 0.105357 8.26522 0 8 0C7.73478 0 7.48043 0.105357 7.29289 0.292893C7.10536 0.48043 7 0.734784 7 1V2.09C5.60294 2.32615 4.33452 3.04908 3.41939 4.13077C2.50425 5.21247 2.00144 6.58312 2 8V11.18C1.41645 11.3863 0.910998 11.7681 0.552938 12.2729C0.194879 12.7778 0.00173951 13.3811 0 14V16C0 16.2652 0.105357 16.5196 0.292893 16.7071C0.48043 16.8946 0.734784 17 1 17H4.14C4.37028 17.8474 4.873 18.5954 5.5706 19.1287C6.26819 19.6621 7.1219 19.951 8 19.951C8.8781 19.951 9.73181 19.6621 10.4294 19.1287C11.127 18.5954 11.6297 17.8474 11.86 17H15C15.2652 17 15.5196 16.8946 15.7071 16.7071C15.8946 16.5196 16 16.2652 16 16V14C15.9983 13.3811 15.8051 12.7778 15.4471 12.2729C15.089 11.7681 14.5835 11.3863 14 11.18ZM4 8C4 6.93913 4.42143 5.92172 5.17157 5.17157C5.92172 4.42143 6.93913 4 8 4C9.06087 4 10.0783 4.42143 10.8284 5.17157C11.5786 5.92172 12 6.93913 12 8V11H4V8ZM8 18C7.65097 17.9979 7.30857 17.9045 7.00683 17.7291C6.70509 17.5536 6.45451 17.3023 6.28 17H9.72C9.54549 17.3023 9.29491 17.5536 8.99317 17.7291C8.69143 17.9045 8.34903 17.9979 8 18ZM14 15H2V14C2 13.7348 2.10536 13.4804 2.29289 13.2929C2.48043 13.1054 2.73478 13 3 13H13C13.2652 13 13.5196 13.1054 13.7071 13.2929C13.8946 13.4804 14 13.7348 14 14V15Z" fill="currentColor"></path>
                        </svg>
                      </a>
                    </li>
                </ul>
                <button type="button"  id="profile_dropdown_button" data-dropdown-toggle="profile_dropdown" data-dropdown-placement="bottom-start" class="flex items-center ">
                  <div class="mr-3">
                    <p class="text-sm">Thomas Brown</p>
                    <p class="text-sm text-gray-500">Developer</p>
                  </div>
                  <div class="mr-2">
                    <img class="w-10 h-10 rounded-full object-cover object-right" src="https://images.unsplash.com/photo-1568602471122-7832951cc4c5?ixlib=rb-1.2.1&ixid=MnwxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8&auto=format&fit=crop&w=1050&q=80" alt="">
                  </div>
                </button>
                <div  id="profile_dropdown"  class="z-50 hidden absolute top-10 right-10 w-full max-w-sm rounded-lg bg-white p-3 drop-shadow-xl divide-y divide-gray-200" >
                    <div aria-label="header" class="flex space-x-4 items-center p-4">
                    <div aria-label="avatar" class="flex mr-auto items-center space-x-4">
                        <img
                        src="https://avatars.githubusercontent.com/u/499550?v=4"
                        alt="avatar Evan You"
                        class="w-16 h-16 shrink-0 rounded-full"
                        />
                        <div class="space-y-2 flex flex-col flex-1 truncate">
                        <div class="font-medium relative text-xl leading-tight text-gray-900">
                            <span class="flex">
                            <span class="truncate relative pr-8">
                                Evan You Israfil Hossain
                                <span
                                aria-label="verified"
                                class="absolute top-1/2 -translate-y-1/2 right-0 inline-block rounded-full"
                                >
                                <svg
                                    xmlns="http://www.w3.org/2000/svg"
                                    aria-hidden="true"
                                    class="w-6 h-6 ml-1 text-cyan-400"
                                    width="24"
                                    height="24"
                                    viewBox="0 0 24 24"
                                    stroke-width="2"
                                    stroke="currentColor"
                                    fill="none"
                                    stroke-linecap="round"
                                    stroke-linejoin="round"
                                >
                                    <path stroke="none" d="M0 0h24v24H0z" fill="none"></path>
                                    <path
                                    d="M12.01 2.011a3.2 3.2 0 0 1 2.113 .797l.154 .145l.698 .698a1.2 1.2 0 0 0 .71 .341l.135 .008h1a3.2 3.2 0 0 1 3.195 3.018l.005 .182v1c0 .27 .092 .533 .258 .743l.09 .1l.697 .698a3.2 3.2 0 0 1 .147 4.382l-.145 .154l-.698 .698a1.2 1.2 0 0 0 -.341 .71l-.008 .135v1a3.2 3.2 0 0 1 -3.018 3.195l-.182 .005h-1a1.2 1.2 0 0 0 -.743 .258l-.1 .09l-.698 .697a3.2 3.2 0 0 1 -4.382 .147l-.154 -.145l-.698 -.698a1.2 1.2 0 0 0 -.71 -.341l-.135 -.008h-1a3.2 3.2 0 0 1 -3.195 -3.018l-.005 -.182v-1a1.2 1.2 0 0 0 -.258 -.743l-.09 -.1l-.697 -.698a3.2 3.2 0 0 1 -.147 -4.382l.145 -.154l.698 -.698a1.2 1.2 0 0 0 .341 -.71l.008 -.135v-1l.005 -.182a3.2 3.2 0 0 1 3.013 -3.013l.182 -.005h1a1.2 1.2 0 0 0 .743 -.258l.1 -.09l.698 -.697a3.2 3.2 0 0 1 2.269 -.944zm3.697 7.282a1 1 0 0 0 -1.414 0l-3.293 3.292l-1.293 -1.292l-.094 -.083a1 1 0 0 0 -1.32 1.497l2 2l.094 .083a1 1 0 0 0 1.32 -.083l4 -4l.083 -.094a1 1 0 0 0 -.083 -1.32z"
                                    stroke-width="0"
                                    fill="currentColor"
                                    ></path>
                                </svg>
                                </span>
                            </span>
                            </span>
                        </div>
                        <p class="font-normal text-base leading-tight text-gray-500 truncate">
                            evanyou@gmail.com
                        </p>
                        </div>
                    </div>
                    </div>
                    <div aria-label="navigation" class="py-2">
                    <nav class="grid gap-1">
                        <a
                          href="{{ route('userProfile') }}"
                          class="flex items-center leading-6 space-x-3 py-3 px-4 w-full text-lg text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md"
                        >
                          <img src="{{ asset_bind('assets/svg/account.svg') }}" alt="" srcset="">
                          <span>{{ __("Profile") }}</span>
                        </a>
                        <a
                          href="#"
                          class="flex items-center leading-6 space-x-3 py-3 px-4 w-full text-lg text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md"
                        >
                          <img src="{{ asset_bind('assets/svg/integrations.svg') }}" alt="" srcset="">
                          <span>Integrations</span>
                        </a>
                        <a
                          id="light_mode_button"
                          href="#"
                          class="hidden flex items-center leading-6 space-x-3 py-3 px-4 w-full text-lg text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md"
                          onclick="localStorage.theme = 'light', window.location.reload();"
                        >
                          <span class="icon-[line-md--sun-rising-filled-loop]" style="width: 24px; height: 24px; color: #f9f06b;"></span>
                          <span>{{ __("Light Mode") }}</span>
                        </a>
                        <a
                          id="dark_mode_button"
                          href="#"
                          class="hidden flex items-center leading-6 space-x-3 py-3 px-4 w-full text-lg text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md"
                          onclick="localStorage.theme = 'dark', window.location.reload();"
                        >
                          <span class="icon-[line-md--sunny-filled-loop-to-moon-filled-loop-transition]" style="width: 24; height:24; color: #77767b;"></span>
                          <span>{{ __("Dark Mode") }}</span>
                        </a>
                        <a
                          href="#"
                          class="flex items-center leading-6 space-x-3 py-3 px-4 w-full text-lg text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md"
                        >
                          <img src="{{ asset_bind('assets/svg/settings.svg') }}" alt="" srcset="">
                          <span>Settings</span>
                        </a>
                        <a
                          href="#"
                          class="flex items-center leading-6 space-x-3 py-3 px-4 w-full text-lg text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md"
                        >
                          <img src="{{ asset_bind('assets/svg/guide.svg') }}" alt="" srcset="">
                          <span>Guide</span>
                        </a>
                        <a
                          href="#"
                          class="flex items-center leading-6 space-x-3 py-3 px-4 w-full text-lg text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md"
                        >
                          <img src="{{ asset_bind('assets/svg/helper_center.svg') }}" alt="" srcset="">
                          <span>Helper Center</span>
                        </a>
                    </nav>
                    </div>
                    <div aria-label="footer" class="pt-2">
                    <button
                        type="button"
                        class="flex items-center space-x-3 py-3 px-4 w-full leading-6 text-lg text-gray-600 focus:outline-none hover:bg-gray-100 rounded-md"
                        onclick="window.location.href = '{{ route('logout') }}'"
                    >
                        <img src="{{ asset_bind('assets/svg/logout.svg') }}" alt="" srcset="">
                        <span>Logout</span>
                    </button>
                    </div>
                </div>
              </div>
        </div>
    </nav>
</header>