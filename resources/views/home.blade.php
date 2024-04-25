<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Food sharing app</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
    <!-- Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    @livewireStyles


<body class="flex flex-col min-h-screen">
    <section class="mb-40">
        <!-- Navbar -->
        <nav class="relative flex w-full items-center justify-between bg-teal-200 py-6 shadow-sm shadow-neutral-700/10 dark:bg-neutral-800 dark:shadow-black/30 lg:flex-wrap lg:justify-start"
            data-te-navbar-ref>
            <!-- Container wrapper -->
            <div class="flex w-full flex-wrap items-center justify-between px-6">
                <div class="flex items-center">
                    <button
                        class="block border-0 bg-transparent py-2 pr-2.5 text-neutral-500 hover:no-underline hover:shadow-none focus:no-underline focus:shadow-none focus:outline-none focus:ring-0 dark:text-neutral-200 lg:hidden"
                        type="button" data-te-collapse-init data-te-target="#navbarSupportedContentY"
                        aria-controls="navbarSupportedContentY" aria-expanded="false" aria-label="Toggle navigation">
                        <span class="[&>svg]:w-7">
                            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor"
                                class="h-7 w-7">
                                <path fill-rule="evenodd"
                                    d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z"
                                    clip-rule="evenodd" />
                            </svg>
                        </span>
                    </button>
                    <a class="text-primary dark:text-primary-400" href="#!">
                        <span class="[&>svg]:ml-2 [&>svg]:mr-3 [&>svg]:h-6 [&>svg]:w-6 [&>svg]:lg:ml-0">
                            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"
                                stroke-width="1.5" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                            </svg>
                        </span>
                    </a>
                </div>
                @auth
                    <div class="!visible hidden flex-grow basis-[100%] items-center lg:!flex lg:basis-auto"
                        id="navbarSupportedContentY" data-te-collapse-item>
                        <!-- Left links -->
                        <ul class="mr-auto lg:flex lg:flex-row" data-te-navbar-nav-ref>
                            <li data-te-nav-item-ref>
                                <a href="{{ route('dashboard') }}"
                                    class="bg-blue-900 block py-2 pr-2 text-neutral-500 transition duration-150 ease-in-out hover:text-neutral-600 focus:text-neutral-600 disabled:text-black/30 dark:text-neutral-200 dark:hover:text-neutral-300 dark:focus:text-neutral-300 dark:disabled:text-white/30 lg:px-2 [&.active]:text-black/80 dark:[&.active]:text-white/80"
                                    data-te-nav-link-ref data-te-ripple-init data-te-ripple-color="light"
                                    disabled>DashBoard</a>
                            </li>
                        </ul>
                    </div>
                @endauth
                <!-- Right elements -->
                <div class="my-1 flex items-center lg:my-0 lg:ml-auto">

                    <div class="flex justify-between items-center hover:underline uppercase mr-4 md:mr-6">
                        <strong
                            class="mr-2 text-2xl font-bold text-black cursor-pointer hover:text-green-700 dark:text-green-400 dark:hover:text-green-500"
                            onclick="location.href='{{ route('showHelp-page') }}'">
                            Help
                        </strong>
                    </div>

                    @auth

                        <form id="logout-form" method="POST" action="{{ route('logout') }}" class="inline">
                            @csrf
                            <div class="flex justify-between items-center hover:underline uppercase mr-4 md:mr-6">

                                <strong
                                    class="mr-2 text-2xl font-bold text-black cursor-pointer hover:text-green-700 dark:text-green-400 dark:hover:text-green-500"
                                    onclick="document.getElementById('logout-form').submit();">
                                    Logout
                                </strong>
                            </div>
                        </form>
                    @else
                        <a href="{{ route('login') }}"
                            class="mr-2 text-2xl font-extrabold uppercase text-primary hover:underline dark:text-primary-400 mr-4 md:mr-6 ">
                            Login
                        </a>
                        <!-- Signup Link -->
                        @if (Route::has('register'))
                            <a href="{{ route('register') }}"
                                class="text-2xl font-extrabold uppercase text-primary hover:underline">
                                Sign up
                            </a>
                        @endif

                    @endauth
                </div>
            </div>
        </nav>

        <!-- SVG Background -->
        <span class="[&>svg]:absolute [&>svg]:-z-10 [&>svg]:hidden [&>svg]:h-[560px] [&>svg]:w-full [&>svg]:lg:block">
            <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"
                preserveAspectRatio="none"
                class="absolute top-[60px] hidden h-[580px] w-full transition-opacity duration-300 dark:opacity-0 lg:block">
                <defs>
                    <linearGradient id="sw-gradient-light" x1="0" x2="0" y1="1" y2="0">
                        <stop stop-color="hsl(209, 92.2%, 92.1%)" offset="0%"></stop>
                        <stop stop-color="hsl(209, 92.2%, 99.1%)" offset="100%"></stop>
                    </linearGradient>
                </defs>
                <path fill="url(#sw-gradient-light)"
                    d="M -0.664 3.46 C -0.664 3.46 405.288 15.475 461.728 21.285 C 601.037 35.625 672.268 76.086 701.056 97.646 C 756.056 138.838 797.267 216.257 857.745 245.156 C 885.704 258.516 980.334 280.547 1048.511 268.826 C 1121.622 256.256 1199.864 226.267 1214.176 220.176 C 1241.273 208.643 1280.201 191.509 1343.494 179.436 C 1434.325 162.111 1439.504 196.099 1439.503 183.204 C 1439.502 161.288 1440 0 1440 0 L 1360 0 C 1280 0 1120 0 960 0 C 800 0 640 0 480 0 C 320 0 160 0 80 0 L 0 0 L -0.664 3.46 Z">
                </path>
            </svg>
            <svg data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"
                preserveAspectRatio="none"
                class="absolute top-[60px] hidden h-[580px] w-full opacity-0 transition-opacity duration-300 dark:opacity-100 lg:block">
                <defs>
                    <linearGradient id="sw-gradient-dark" x1="0" x2="0" y1="1" y2="0">
                        <stop stop-color="hsl(240, 4%, 28%)" offset="0%"></stop>
                        <stop stop-color="hsl(0, 0%, 15%)" offset="100%"></stop>
                    </linearGradient>
                </defs>
                <path fill="url(#sw-gradient-dark)"
                    d="M -0.664 3.46 C -0.664 3.46 405.288 15.475 461.728 21.285 C 601.037 35.625 672.268 76.086 701.056 97.646 C 756.056 138.838 797.267 216.257 857.745 245.156 C 885.704 258.516 980.334 280.547 1048.511 268.826 C 1121.622 256.256 1199.864 226.267 1214.176 220.176 C 1241.273 208.643 1280.201 191.509 1343.494 179.436 C 1434.325 162.111 1439.504 196.099 1439.503 183.204 C 1439.502 161.288 1440 0 1440 0 L 1360 0 C 1280 0 1120 0 960 0 C 800 0 640 0 480 0 C 320 0 160 0 80 0 L 0 0 L -0.664 3.46 Z">
                </path>
            </svg>
        </span>

        <div class="px-6 py-12 text-center md:px-12 lg:my-12 lg:text-left">
            <div class="mx-auto sm:max-w-2xl md:max-w-3xl lg:max-w-5xl xl:max-w-7xl">
                <div class="grid items-center gap-12 lg:grid-cols-2">
                    <div class="mt-12 lg:mt-0">
                        <h1 class="mb-10 text-5xl font-bold tracking-tight md:text-6xl xl:text-5xl">
                            This is Food Sharing Platform <br />
                            <span class="text-primary">Sign Up To Receive Free Food</span>
                        </h1>
                        <a href="{{ route('register') }}"
                            class="mb-2 inline-block rounded bg-blue-500 px-12 pt-4 pb-3.5 text-sm font-medium uppercase leading-normal text-white"
                            role="button">Get started</a>
                        <a href="{{ route('privacy-policy') }}"
                            class="mb-2 inline-block rounded bg-red-500 px-8 pt-4 pb-3.5 text-sm font-medium uppercase leading-normal text-white">See
                            Privacy Policy</a>

                        <div class="flex justify-between items-center">
                            <p class="flex-1 text-2xl font-italic font-bold">
                                If you have any questions, get in touch with us
                                <a href="{{ route('contactUs-email') }}"
                                    class="text-blue-500 hover:text-blue-700">here</a>.
                            </p>
                        </div>

                    </div>
                    <div class="mb-12 lg:mb-0">
                        <img src="https://tecdn.b-cdn.net/img/new/standard/city/017.jpg"
                            class="w-full rounded-lg shadow-lg dark:shadow-black/20" alt="" />
                    </div>
                </div>
            </div>
        </div>

    </section>
    </div>
    <footer class="bg-sky-400 text-white px-4 py-6 w-full fixed inset-x-0 bottom-0">
        <div class="flex flex-wrap justify-between items-center max-w-screen-xl mx-auto">
            <span class=" text-1xl text-black font-extralight">© <span id="year"></span> Food Sharing App. All
                Rights Reserved.</span>
            <ul class="flex flex-wrap items-center mt-3 text-sm">
                <li>
                    <a href="{{ route('privacy-policy') }}"
                        class="hover:underline text-black font-extrabold  mr-4 md:mr-6">Privacy Policy</a>
                </li>
                <li>
                    <a href="{{ route('showHelp-page') }}"
                        class="hover:underline text-black mr-4 md:mr-6 font-extrabold">Help</a>
                </li>
                <li>
                    <a href="{{ route('contactUs-email') }}"
                        class="hover:underline text-black mr-4 md:mr-6 font-extrabold">Contact</a>
                </li>
            </ul>
        </div>
    </footer>
    <script>
        // Set the current year in the footer
        document.getElementById('year').textContent = new Date().getFullYear();
    </script>

    @livewireScriptConfig
    @livewireStyles
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>
</body>

</html>
