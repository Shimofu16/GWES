<nav class="bg-[#c4bcaf] fixed w-full z-20 top-0 start-0">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="https://flowbite.com/" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('assets/images/gwes-logo-wbg.png') }}" class="h-10 rounded-full" alt="Great Wedding Logo" />
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white  lg:hidden">
                GWD
            </span>
            <span class="self-center text-2xl font-semibold whitespace-nowrap dark:text-white hidden lg:block">
                {{ Config::get('app.name') }}
            </span>


        </a>
        <div class="flex md:order-2">
            <button type="button" data-collapse-toggle="navbar-search" aria-controls="navbar-search"
                aria-expanded="false"
                class="md:hidden text-gray-500 dark:text-gray-400 hover:bg-gray-100 dark:hover:bg-gray-700 focus:outline-none focus:ring-4 focus:ring-gray-200 dark:focus:ring-gray-700 rounded-lg text-sm p-2.5 me-1">
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 20 20">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="m19 19-4-4m0-7A7 7 0 1 1 1 8a7 7 0 0 1 14 0Z" />
                </svg>
                <span class="sr-only">Search</span>
            </button>
            <livewire:pages.home.search classes="hidden md:block" />
            <button data-collapse-toggle="navbar-search" type="button"
                class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 text-gray-400 hover:bg-gray-700 focus:ring-gray-600"
                aria-controls="navbar-search" aria-expanded="false">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                    viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M1 1h15M1 7h15M1 13h15" />
                </svg>
            </button>
        </div>
        <div class="items-center justify-between hidden w-full md:flex md:w-auto md:order-1" id="navbar-search">
            <livewire:pages.home.search classes="mt-3 md:hidden" />
            <ul
                class="flex flex-col p-4 md:p-0 mt-4 font-medium  md:space-x-8 rtl:space-x-reverse md:flex-row md:mt-0 ">
                <li>
                    <a href="{{ route('home.index') }}"
                        class="block py-1 px-2  rounded  hover:bg-white hover:text-[#c4bcaf] {{ Route::is('home.index') ? 'bg-white text-[#c4bcaf]' : 'text-white' }}"
                        aria-current="page">Home</a>
                </li>
                <li>
                    <a href="#"
                        class="block py-1 px-2   rounded hover:bg-white hover:text-[#c4bcaf] {{ Route::is('') ? 'bg-white text-[#c4bcaf]' : 'text-white' }}">
                        Supplier
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="block py-1 px-2   rounded hover:bg-white hover:text-[#c4bcaf] {{ Route::is('') ? 'bg-white text-[#c4bcaf]' : 'text-white' }}">
                        Blogs
                    </a>
                </li>
                <li>
                    <a href="#"
                        class="block py-1 px-2   rounded hover:bg-white hover:text-[#c4bcaf] {{ Route::is('') ? 'bg-white text-[#c4bcaf]' : 'text-white' }}">
                        FeedBack
                    </a>
                </li>
            </ul>
        </div>
    </div>
</nav>