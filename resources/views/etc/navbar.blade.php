<div class="navbar bg-primary" data-theme="pastel">
    <div class="navbar-start">
        <div class="dropdown">
            <label tabindex="0" class="btn btn-ghost btn-circle" data-drawer-target="drawer-navigation"
                data-drawer-show="drawer-navigation" aria-controls="drawer-navigation">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                    stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h7" />
                </svg>
            </label>
            {{-- sidebar start --}}
            <div id="drawer-navigation"
                class="fixed top-0 left-0 z-40 w-64 h-screen p-4 overflow-y-auto transition-transform -translate-x-full bg-primary"
                tabindex="-1" aria-labelledby="drawer-navigation-label">
                <h5 id="drawer-navigation-label" class="text-base font-semibold text-gray-500 uppercase">Menu</h5>
                <button type="button" data-drawer-hide="drawer-navigation" aria-controls="drawer-navigation"
                    class="text-gray-400 bg-transparent hover:bg-gray-200 hover:text-gray-900 rounded-lg text-sm p-1.5 absolute top-2.5 right-2.5 inline-flex items-center">
                    <svg aria-hidden="true" class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"
                        xmlns="http://www.w3.org/2000/svg">
                        <path fill-rule="evenodd"
                            d="M4.293 4.293a1 1 0 011.414 0L10 8.586l4.293-4.293a1 1 0 111.414 1.414L11.414 10l4.293 4.293a1 1 0 01-1.414 1.414L10 11.414l-4.293 4.293a1 1 0 01-1.414-1.414L8.586 10 4.293 5.707a1 1 0 010-1.414z"
                            clip-rule="evenodd"></path>
                    </svg>
                    <span class="sr-only">Close menu</span>
                </button>
                <div class="py-4 overflow-y-auto">
                    <ul class="mb-10 mt-5">
                        <a class="btn btn-ghost normal-case text-2xl text-base-100">Akuna Indonesia</a>
                        <a class="btn btn-ghost normal-case text-xl text-base-100">ethnobotany</a>
                    </ul>
                    <ul class="space-y-2 font-medium">
                        @auth
                            @if (auth()->user()->role == 'admin')
                                <li>
                                    <a href="#"
                                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                                        <svg class="w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 22 21">
                                            <path
                                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                                            <path
                                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                                        </svg>
                                        <span class="ml-3">Dashboard</span>
                                    </a>
                                </li>
                                <li>
                                    <a href="#"
                                        class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                                        <svg class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900"
                                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                            viewBox="0 0 18 20">
                                            <path
                                                d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                                        </svg>
                                        <span class="flex-1 ml-3 whitespace-nowrap">Products</span>
                                    </a>
                                </li>
                            @endif
                        @else
                            <li>
                                <a href="#"
                                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                                    <i
                                        class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 fa-solid fa-house"></i>
                                    <span class="ml-3">Home</span>
                                </a>
                            </li>
                            <li>
                                <a href="#"
                                    class="flex items-center p-2 text-gray-900 rounded-lg hover:bg-gray-100 group">
                                    <i class="flex-shrink-0 w-5 h-5 text-gray-500 transition duration-75 dark:text-gray-400 group-hover:text-gray-900 fa-solid fa-bag-shopping"></i>
                                    <span class="flex-1 ml-3 whitespace-nowrap">Products</span>
                                </a>
                            </li>
                        @endauth
                    </ul>
                </div>
            </div>
        </div>
        {{-- sidebar end --}}
    </div>
    <div class="navbar-center">
        <a class="btn btn-ghost normal-case text-xl space-x-4">
            <img src="{{ asset('logo.png') }}" alt="logo-navbar" width="32" height="32">
            Akuna Indonesia
        </a>
    </div>
    <div class="navbar-end mr-5">
        <div class="flex items-center">
            <div class="flex items-center ml-3">
                <div>
                    <button type="button"
                        class="flex text-sm bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300 dark:focus:ring-gray-600"
                        aria-expanded="false" data-dropdown-toggle="dropdown-user">
                        <span class="sr-only">Open user menu</span>
                        <img class="w-8 h-8 rounded-full"
                            src="https://flowbite.com/docs/images/people/profile-picture-5.jpg" alt="user photo">
                    </button>
                </div>
                <div class="z-50 hidden text-base list-none bg-white divide-y divide-gray-100 rounded shadow dark:bg-gray-700 dark:divide-gray-600"
                    id="dropdown-user">
                    @auth
                        <div class="px-4 py-3" role="none">
                            <p class="text-sm text-gray-900 dark:text-white" role="none">
                                {{ auth()->user()->name }}
                            </p>
                            <p class="text-sm font-medium text-gray-900 truncate dark:text-gray-300" role="none">
                                {{ auth()->user()->email }}
                            </p>
                        </div>
                    @endauth
                    <ul class="py-1" role="none">
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                role="menuitem">Dashboard</a>
                        </li>
                        <li>
                            <a href="#"
                                class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                role="menuitem">Settings</a>
                        </li>
                        <li>
                            @guest
                                <a href="login"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">Sign in</a>
                            @else
                                <a href="logout"
                                    class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100 dark:text-gray-300 dark:hover:bg-gray-600 dark:hover:text-white"
                                    role="menuitem">Sign out</a>
                            @endguest
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div>
