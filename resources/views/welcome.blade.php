{{-- <!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Food sharing app</title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

        <!-- Scripts -->
        @vite(['resources/css/app.css', 'resources/js/app.js'])
    
        <style>
    body {
        background-color: white; /* Change background color */
    }

    nav {
        width: 100%;
        background-color: #f8f9fa; /* Light gray background for the navbar */
        padding: 10px 0;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        position: fixed; /* Fixed at the top */
        top: 0;
        left: 0;
        z-index: 1000;
    }

    .nav-container {
        max-width: 1200px;
        margin: 0 auto;
        display: flex;
        justify-content: space-between;
        align-items: center;
        padding: 0 1rem; /* Corrected unit */
    }

    .nav-logo {
        font-size: 24px;
        font-weight: bold;
        color: #333;
    }

    .nav-items {
        list-style: none;
        display: flex;
        align-items: center;
        margin: 0;
        padding: 0;
    }

    .nav-item {
        margin-left: 20px;
    }

    .nav-link {
        text-decoration: none;
        color: #333;
        font-size: 16px;
        display: flex; /* Add flex display */
        align-items: center; /* Align items to center */
        height: 100%; /* Set height to fill the parent */
    }
</style>

    </head>
    <body class="antialiased">
        <nav>
            <div class="nav-container">
                <!-- Logo -->
                <div class="nav-logo">Laravel</div>
        
                <!-- Navigation Items -->
                <ul class="nav-items">
                    <li class="nav-item"><a href="#" class="nav-link">Home</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">About</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Services</a></li>
                    <li class="nav-item"><a href="#" class="nav-link">Contact</a></li>
                    
                    <!-- Livewire Component for Authentication Links -->
                    @if (Route::has('login'))
                        <li class="nav-item">
                            <livewire:welcome.navigation />
                        </li>
                    @endif
                </ul>
            </div>
        </nav>
        
        <!-- Main Content -->
        <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-white-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
            <!-- Content goes here -->
        </div>
        
        </div>
    </body>
</html> --}}
<!-- Section: Design Block -->
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

    <body >
<section class="mb-40">
      <!-- Navbar -->
      <nav
        class="relative flex w-full items-center justify-between bg-white py-2 shadow-sm shadow-neutral-700/10 dark:bg-neutral-800 dark:shadow-black/30 lg:flex-wrap lg:justify-start"
        data-te-navbar-ref>
        <!-- Container wrapper -->
        <div class="flex w-full flex-wrap items-center justify-between px-6">
          <div class="flex items-center">
            <!-- Toggle button -->
            <button
              class="block border-0 bg-transparent py-2 pr-2.5 text-neutral-500 hover:no-underline hover:shadow-none focus:no-underline focus:shadow-none focus:outline-none focus:ring-0 dark:text-neutral-200 lg:hidden"
              type="button" data-te-collapse-init data-te-target="#navbarSupportedContentY"
              aria-controls="navbarSupportedContentY" aria-expanded="false" aria-label="Toggle navigation">
              <span class="[&>svg]:w-7">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" fill="currentColor" class="h-7 w-7">
                  <path fill-rule="evenodd"
                    d="M3 6.75A.75.75 0 013.75 6h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 6.75zM3 12a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75A.75.75 0 013 12zm0 5.25a.75.75 0 01.75-.75h16.5a.75.75 0 010 1.5H3.75a.75.75 0 01-.75-.75z"
                    clip-rule="evenodd" />
                </svg>
              </span>
            </button>
    
            <!-- Navbar Brand -->
            <a class="text-primary dark:text-primary-400" href="#!">
              <span class="[&>svg]:ml-2 [&>svg]:mr-3 [&>svg]:h-6 [&>svg]:w-6 [&>svg]:lg:ml-0">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5"
                  stroke="currentColor">
                  <path stroke-linecap="round" stroke-linejoin="round"
                    d="M9.813 15.904L9 18.75l-.813-2.846a4.5 4.5 0 00-3.09-3.09L2.25 12l2.846-.813a4.5 4.5 0 003.09-3.09L9 5.25l.813 2.846a4.5 4.5 0 003.09 3.09L15.75 12l-2.846.813a4.5 4.5 0 00-3.09 3.09zM18.259 8.715L18 9.75l-.259-1.035a3.375 3.375 0 00-2.455-2.456L14.25 6l1.036-.259a3.375 3.375 0 002.455-2.456L18 2.25l.259 1.035a3.375 3.375 0 002.456 2.456L21.75 6l-1.035.259a3.375 3.375 0 00-2.456 2.456zM16.894 20.567L16.5 21.75l-.394-1.183a2.25 2.25 0 00-1.423-1.423L13.5 18.75l1.183-.394a2.25 2.25 0 001.423-1.423l.394-1.183.394 1.183a2.25 2.25 0 001.423 1.423l1.183.394-1.183.394a2.25 2.25 0 00-1.423 1.423z" />
                </svg>
              </span>
            </a>
          </div>
    
          <!-- Collapsible wrapper -->
          <div class="!visible hidden flex-grow basis-[100%] items-center lg:!flex lg:basis-auto"
            id="navbarSupportedContentY" data-te-collapse-item>
            <!-- Left links -->
            <ul class="mr-auto lg:flex lg:flex-row" data-te-navbar-nav-ref>
              <li data-te-nav-item-ref>
                <a class="block py-2 pr-2 text-neutral-500 transition duration-150 ease-in-out hover:text-neutral-600 focus:text-neutral-600 disabled:text-black/30 dark:text-neutral-200 dark:hover:text-neutral-300 dark:focus:text-neutral-300 dark:disabled:text-white/30 lg:px-2 [&.active]:text-black/80 dark:[&.active]:text-white/80"
                  href="#!" data-te-nav-link-ref data-te-ripple-init data-te-ripple-color="light"
                  disabled>Dashboard</a>
              </li>
              <li data-te-nav-item-ref>
                <a class="block py-2 pr-2 text-neutral-500 transition duration-150 ease-in-out hover:text-neutral-600 focus:text-neutral-600 disabled:text-black/30 dark:text-neutral-200 dark:hover:text-neutral-300 dark:focus:text-neutral-300 dark:disabled:text-white/30 lg:px-2 [&.active]:text-black/80 dark:[&.active]:text-white/80"
                  href="#!" data-te-nav-link-ref data-te-ripple-init data-te-ripple-color="light">Team</a>
              </li>
              <li class="mb-2 lg:mb-0" data-te-nav-item-ref>
                <a class="block py-2 pr-2 text-neutral-500 transition duration-150 ease-in-out hover:text-neutral-600 focus:text-neutral-600 disabled:text-black/30 dark:text-neutral-200 dark:hover:text-neutral-300 dark:focus:text-neutral-300 dark:disabled:text-white/30 lg:px-2 [&.active]:text-black/80 dark:[&.active]:text-white/80"
                  href="#!" data-te-nav-link-ref data-te-ripple-init data-te-ripple-color="light">Projects</a>
              </li>
            </ul>
            <!-- Left links -->
          </div>
          <!-- Collapsible wrapper -->
    
          <!-- Right elements -->
          <div class="my-1 flex items-center lg:my-0 lg:ml-auto">
            @auth
                <!-- Logout Form -->
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button type="submit" class="mr-2 inline-block rounded px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-black bg-red-600 hover:bg-red-700 focus:outline-none focus:ring-0 dark:bg-red-500 dark:hover:bg-red-600">
                        Logout
                    </button>
                </form>
            @else
                <!-- Login Link -->
                <a href="{{ route('login') }}" class="mr-2 inline-block bg-violet-500 rounded px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-primary transition duration-150 ease-in-out hover:text-primary-600 focus:text-primary-600 dark:text-primary-400 dark:hover:text-primary-500">
                    Login
                </a>
                <!-- Signup Link -->
                @if (Route::has('register'))
                <a href="{{ route('register') }}" class="inline-block bg-teal-500 rounded px-6 pt-2.5 pb-2 text-xs font-medium uppercase leading-normal text-black bg-white border border-solid border-black hover:bg-gray-300 focus:outline-none focus:ring-0">
                  Sign up for free
              </a>
              
                @endif
            @endauth
        </div>
          <!-- Right elements -->
        </div>
        <!-- Container wrapper -->
      </nav>
      <!-- Navbar -->
    
      <!-- SVG Background -->
      <span class="[&>svg]:absolute [&>svg]:-z-10 [&>svg]:hidden [&>svg]:h-[560px] [&>svg]:w-full [&>svg]:lg:block">
        <svg data-name="Layer 1" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none"
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
        <svg data-name="Layer 2" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320" preserveAspectRatio="none"
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
      <!-- SVG Background -->
    
      <!-- Jumbotron -->
      <div class="px-6 py-12 text-center md:px-12 lg:my-12 lg:text-left">
        <div class="w-100 mx-auto sm:max-w-2xl md:max-w-3xl lg:max-w-5xl xl:max-w-7xl">
          <div class="grid items-center gap-12 lg:grid-cols-2">
            <div class="mt-12 lg:mt-0">
              <h1 class="mb-16 text-5xl font-bold tracking-tight md:text-6xl xl:text-7xl">
                The best offer <br /><span class="text-primary">for your business</span>
              </h1>
              {{-- <a class="mb-2 inline-block rounded bg-primary px-12 pt-4 pb-3.5 text-sm font-medium uppercase leading-normal text-white shadow-[0_4px_9px_-4px_#3b71ca] transition duration-150 ease-in-out hover:bg-primary-600 hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:bg-primary-600 focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] focus:outline-none focus:ring-0 active:bg-primary-700 active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.3),0_4px_18px_0_rgba(59,113,202,0.2)] dark:shadow-[0_4px_9px_-4px_rgba(59,113,202,0.5)] dark:hover:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:focus:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] dark:active:shadow-[0_8px_9px_-4px_rgba(59,113,202,0.2),0_4px_18px_0_rgba(59,113,202,0.1)] md:mr-2 md:mb-0"
                data-te-ripple-init data-te-ripple-color="light" href="#!" role="button">Get started</a>
              <a class="inline-block rounded px-12 pt-4 pb-3.5 text-sm font-medium uppercase leading-normal text-primary transition duration-150 ease-in-out hover:bg-neutral-500 hover:bg-opacity-10 hover:text-primary-600 focus:text-primary-600 focus:outline-none focus:ring-0 active:text-primary-700 dark:hover:bg-neutral-700 dark:hover:bg-opacity-60"
                data-te-ripple-init data-te-ripple-color="light" href="#!" role="button">Learn more</a> --}}
                <a  href="{{ route('register') }}" class="mb-2 inline-block rounded bg-blue-500 px-12 pt-4 pb-3.5 text-sm font-medium uppercase leading-normal text-white ..."
   href="#!" role="button">Get started</a>
<a class="mb-2 inline-block rounded bg-green-700 px-12 pt-4 pb-3.5 text-sm font-medium uppercase leading-normal text-white ..."
   href="#!" role="button">Learn more</a>

            </div>
            <div class="mb-12 lg:mb-0">
              <img src="https://tecdn.b-cdn.net/img/new/standard/city/017.jpg"
                class="w-full rounded-lg shadow-lg dark:shadow-black/20" alt="" />
            </div>
          </div>
        </div>
      </div>
      <!-- Jumbotron -->
    </section>
    <!-- Navbar -->
  
    
    <div class="relative sm:flex sm:justify-center sm:items-center min-h-screen bg-dots-darker bg-center bg-white-100 dark:bg-dots-lighter dark:bg-gray-900 selection:bg-red-500 selection:text-white">
        <!-- Content goes here -->
    </div>
    
    </div>
    @livewireScriptConfig
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/2.2.1/flowbite.min.js"></script>

</body>
</html> 