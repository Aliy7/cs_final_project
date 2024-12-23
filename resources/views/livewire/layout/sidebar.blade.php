<div class="main-container">
    <nav class="fixed top-0 z-50 w-full bg-slate-800	border-b border-gray-200 dark:bg-gray-800 dark:border-gray-700">
        <div class="px-3 py-3 lg:px-5 lg:pl-3">
            <div class="flex items-center justify-between">
                <div class="flex items-center justify-start rtl:justify-end">
                    <button data-drawer-target="logo-sidebar" data-drawer-toggle="logo-sidebar"
                        aria-controls="logo-sidebar" type="button"
                        class="inline-flex items-center p-2 text-sm text-gray-500 rounded-lg sm:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200">
                        <span class="sr-only">Open sidebar</span>
                        <svg class="w-6 h-6" aria-hidden="true" fill="currentColor" viewBox="0 0 20 20"
                            xmlns="http://www.w3.org/2000/svg">
                            <path clip-rule="evenodd" fill-rule="evenodd"
                                d="M2 4.75A.75.75 0 012.75 4h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 4.75zm0 10.5a.75.75 0 01.75-.75h7.5a.75.75 0 010 1.5h-7.5a.75.75 0 01-.75-.75zM2 10a.75.75 0 01.75-.75h14.5a.75.75 0 010 1.5H2.75A.75.75 0 012 10z">
                            </path>
                        </svg>
                    </button>
                    <a href="{{ route('dashboard') }}" class="flex ms-2 md:me-24">
                        <span class="logo-text">FoodSharing</span>
                    </a>
                </div>
                <div class="flex items-center">
                    <div class="flex items-center ms-3">
                        <div>

                            <button type="button"
                                class="flex text-sm font-bold bg-gray-800 rounded-full focus:ring-4 focus:ring-gray-300"
                                aria-expanded="false" data-dropdown-toggle="dropdown-user">
                                <span class="sr-only">Open user menu</span>
                                <svg class="w-8 h-8 text-white dark:text-white" aria-hidden="true"
                                    xmlns="http://www.w3.org/2000/svg" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd"
                                        d="M12 20a8 8 0 0 1-5-1.8v-.6c0-1.8 1.5-3.3 3.3-3.3h3.4c1.8 0 3.3 1.5 3.3 3.3v.6a8 8 0 0 1-5 1.8ZM2 12a10 10 0 1 1 10 10A10 10 0 0 1 2 12Zm10-5a3.3 3.3 0 0 0-3.3 3.3c0 1.7 1.5 3.2 3.3 3.2 1.8 0 3.3-1.5 3.3-3.3C15.3 8.6 13.8 7 12 7Z"
                                        clip-rule="evenodd" />
                                </svg>
                            </button>
                        </div>
                        <div class="z-50 hidden my-4 text-base list-none bg-white divide-y divide-gray-100 rounded shadow"
                            id="dropdown-user">

                            <div class="px-4 py-3" role="none">
                                @if (Auth::check())
                                    <p class="text-sm font-bold text-black" role="none">
                                        {{ Auth::user()->name }}
                                    </p>
                                    <p class="text-sm font-bold text-black truncate" role="none">
                                        {{ Auth::user()->email }}
                                    </p>
                                @else
                                    <p class="text-sm text-gray-900" role="none">
                                        Guest
                                    </p>
                                @endif
                            </div>

                            <ul class="py-1" role="none">

                                <li>
                                    <a href="{{ route('dashboard') }}"
                                        class="block px-4 py-2 text-sm font-bold text-black hover:bg-gray-100"
                                        role="menuitem">Dashboard</a>
                                </li>

                                <li>
                                    @if (auth()->check())
                                        <a href="{{ route('profile.showProfile', ['profileId' => auth()->user()->id]) }}"
                                            class="block px-4 py-2 text-sm font-bold text-black hover:bg-gray-100"
                                            role="menuitem">Profile</a>
                                    @else
                                        <a href="{{ route('login') }}"
                                            class="block px-4 py-2 text-sm font-bold text-black hover:bg-gray-100"
                                            role="menuitem">Login</a>
                                    @endif
                                </li>



                                <li>
                                    <form method="POST" action="{{ route('logout') }}">
                                        @csrf
                                        <button type="submit"
                                            class="flex items-center p-2 font-bold text-black rounded-lg hover:bg-gray-100 group">
                                            <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M17 16l4-4m0 0l-4-4m4 4H9m11 0a9 9 0 11-9 9 9 9 0 0111-9z">
                                                </path>
                                            </svg>
                                            <span>Log Out</span>
                                        </button>
                                    </form>
                                </li>



                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>

    <aside id="logo-sidebar"
        class="fixed top-0 left-0 z-40 w-50 h-screen pt-20 transition-transform -translate-x-full bg-slate-800	 border-r border-gray-200 sm:translate-x-0 dark:bg-gray-800 dark:border-gray-700"
        aria-label="Sidebar">

        <div class="h-full px-3 pb-4 overflow-y-autobg-slate-800	text-white ">
            <ul class="space-y-2 font-medium">
                <li>
                    <a href="{{ route('dashboard') }}"
                        class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500 group">
                        <svg class="w-5 h-5 text-white transition duration-75 group-hover:text-bg-teal-200	"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Dashboard</span>
                    </a>
                </li>

                <li>

                    @if (auth()->user() && auth()->user()->hasRole('admin'))
                        <a href="{{ route('foodlisting') }}"
                            class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500 group">
                            <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 group-hover:text-teal-200"
                                aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                                viewBox="0 0 18 18">
                                <path
                                    d="M6.143 0H1.857A1.857 1.857 0 0 0 0 1.857v4.286C0 7.169.831 8 1.857 8h4.286A1.857 1.857 0 0 0 8 6.143V1.857A1.857 1.857 0 0 0 6.143 0Zm10 0h-4.286A1.857 1.857 0 0 0 10 1.857v4.286C10 7.169 10.831 8 11.857 8h4.286A1.857 1.857 0 0 0 18 6.143V1.857A1.857 1.857 0 0 0 16.143 0Zm-10 10H1.857A1.857 1.857 0 0 0 0 11.857v4.286C0 17.169.831 18 1.857 18h4.286A1.857 1.857 0 0 0 8 16.143v-4.286A1.857 1.857 0 0 0 6.143 10Zm10 0h-4.286A1.857 1.857 0 0 0 10 11.857v4.286c0 1.026.831 1.857 1.857 1.857h4.286A1.857 1.857 0 0 0 18 16.143v-4.286A1.857 1.857 0 0 0 16.143 10Z" />
                            </svg>
                            <span class="flex-1 ms-3 whitespace-nowrap">Create Listing</span>
                        </a>
                    @endif

                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 group-hover:text-teal-200"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path
                                d="m17.418 3.623-.018-.008a6.713 6.713 0 0 0-2.4-.569V2h1a1 1 0 1 0 0-2h-2a1 1 0 0 0-1 1v2H9.89A6.977 6.977 0 0 1 12 8v5h-2V8A5 5 0 1 0 0 8v6a1 1 0 0 0 1 1h8v4a1 1 0 0 0 1 1h2a1 1 0 0 0 1-1v-4h6a1 1 0 0 0 1-1V8a5 5 0 0 0-2.582-4.377ZM6 12H4a1 1 0 0 1 0-2h2a1 1 0 0 1 0 2Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Inbox</span>
                        <span
                            class="inline-flex items-center justify-center w-3 h-3 p-3 ms-3 text-sm font-medium text-blue-800 bg-blue-100 rounded-full">3</span>
                    </a>
                </li>
                <li>
                    <button type="button"
                        class="flex items-center w-full p-2 text-base text-white transition duration-75 rounded-lg group hover:bg-blue-400 dark:text-white dark:hover:bg-gray-700"
                        aria-controls="dropdown-example" data-collapse-toggle="dropdown-example">
                        <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 group-hover:text-gray-900 dark:text-gray-400 dark:group-hover:text-white"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 18 21">
                            <path
                                d="M15 12a1 1 0 0 0 .962-.726l2-7A1 1 0 0 0 17 3H3.77L3.175.745A1 1 0 0 0 2.208 0H1a1 1 0 0 0 0 2h.438l.6 2.255v.019l2 7 .746 2.986A3 3 0 1 0 9 17a2.966 2.966 0 0 0-.184-1h2.368c-.118.32-.18.659-.184 1a3 3 0 1 0 3-3H6.78l-.5-2H15Z" />
                        </svg>
                        <span class="flex-1 ms-3 text-left rtl:text-right whitespace-nowrap">Admin Control </span>
                        <svg class="w-3 h-3" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 10 6">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2" d="m1 1 4 4 4-4" />
                        </svg>
                    </button>
                    <ul id="dropdown-example" class="hidden py-2 space-y-2">

                        @if (auth()->user() && auth()->user()->hasRole('admin'))
                            <li>
                                <a href="{{ route('helpPage-createContent') }}"
                                    class="flex items-center w-full p-2 text-red-900  font-extrabold transition duration-75 rounded-lg pl-11 group hover:bg-gray-100 dark:text-white dark:hover:bg-gray-700">Create
                                    FAQ</a>
                            </li>
                        @endif

                    </ul>
                </li>
                <li>
                    <a
                        href= "{{ route('show-application') }}"class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 group-hover:text-teal-200"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 18 20">
                            <path
                                d="M17 5.923A1 1 0 0 0 16 5h-3V4a4 4 0 1 0-8 0v1H2a1 1 0 0 0-1 .923L.086 17.846A2 2 0 0 0 2.08 20h13.84a2 2 0 0 0 1.994-2.153L17 5.923ZM7 9a1 1 0 0 1-2 0V7h2v2Zm0-5a2 2 0 1 1 4 0v1H7V4Zm6 5a1 1 0 1 1-2 0V7h2v2Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Applications</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('profile.profile-updating') }}"
                        class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 group-hover:text-teal-200"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                            viewBox="0 0 18 16">
                            <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round"
                                stroke-width="2"
                                d="M1 8h11m0 0L8 4m4 4-4 4m4-11h3a2 2 0 0 1 2 2v10a2 2 0 0 1-2 2h-3" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Update Profile</span>
                    </a>
                </li>
                <li>
                    <a href="{{ route('reservations') }}"
                        class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500 group">
                        <svg class="w-5 h-5 text-white transition duration-75 group-hover:text-bg-teal-200"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 22 21">
                            <path
                                d="M16.975 11H10V4.025a1 1 0 0 0-1.066-.998 8.5 8.5 0 1 0 9.039 9.039.999.999 0 0 0-1-1.066h.002Z" />
                            <path
                                d="M12.5 0c-.157 0-.311.01-.565.027A1 1 0 0 0 11 1.02V10h8.975a1 1 0 0 0 1-.935c.013-.188.028-.374.028-.565A8.51 8.51 0 0 0 12.5 0Z" />
                        </svg>
                        <span class="ms-3">Reservations</span>
                    </a>
                </li>

                <li>
                    @if (auth()->user() && auth()->user()->hasRole('admin'))
                        <a href="{{ route('sendEmail') }}"
                            class="flex items-center p-2 text-white rounded-lg hover:bg-blue-500 group">
                            <svg class="w-6 h-6 text-white dark:text-white" aria-hidden="true"
                                xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-width="2"
                                    d="m3.5 5.5 7.9 6c.4.3.8.3 1.2 0l7.9-6M4 19h16c.6 0 1-.4 1-1V6c0-.6-.4-1-1-1H4a1 1 0 0 0-1 1v12c0 .6.4 1 1 1Z" />
                            </svg>
                            <span class="ms-3">Send Email</span>
                        </a>
                    @endif

                </li>

                <li>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit"
                            class="flex items-center p-2 white0 rounded-lg hover:bg-blue-500 group">
                            <!-- Logout Icon -->
                            <svg class="mr-2 w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                xmlns="http://www.w3.org/2000/svg">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M17 16l4-4m0 0l-4-4m4 4H9m11 0a9 9 0 11-9 9 9 9 0 0111-9z"></path>
                            </svg>
                            <span>Log Out</span>
                        </button>
                    </form>
                </li>
                <li>
                    <a href="#" class="flex items-center p-2 text-whiterounded-lg hover:bg-blue-500 group">
                        <svg class="flex-shrink-0 w-5 h-5 text-white transition duration-75 group-hover:text-teal-200"
                            aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="currentColor"
                            viewBox="0 0 20 20">
                            <path d="M5 5V.13a2.96 2.96 0 0 0-1.293.749L.879 3.707A2.96 2.96 0 0 0 .13 5H5Z" />
                            <path
                                d="M6.737 11.061a2.961 2.961 0 0 1 .81-1.515l6.117-6.116A4.839 4.839 0 0 1 16 2.141V2a1.97 1.97 0 0 0-1.933-2H7v5a2 2 0 0 1-2 2H0v11a1.969 1.969 0 0 0 1.933 2h12.134A1.97 1.97 0 0 0 16 18v-3.093l-1.546 1.546c-.413.413-.94.695-1.513.81l-3.4.679a2.947 2.947 0 0 1-1.85-.227 2.96 2.96 0 0 1-1.635-3.257l.681-3.397Z" />
                            <path
                                d="M8.961 16a.93.93 0 0 0 .189-.019l3.4-.679a.961.961 0 0 0 .49-.263l6.118-6.117a2.884 2.884 0 0 0-4.079-4.078l-6.117 6.117a.96.96 0 0 0-.263.491l-.679 3.4A.961.961 0 0 0 8.961 16Zm7.477-9.8a.958.958 0 0 1 .68-.281.961.961 0 0 1 .682 1.644l-.315.315-1.36-1.36.313-.318Zm-5.911 5.911 4.236-4.236 1.359 1.359-4.236 4.237-1.7.339.341-1.699Z" />
                        </svg>
                        <span class="flex-1 ms-3 whitespace-nowrap">Sign Up</span>
                    </a>
                </li>
            </ul>
        </div>
    </aside>
</div>
</div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('logo-sidebar');
        const mainContainer = document.querySelector('.main-container');
        const dashboardContent = document.querySelector('.dashboard-content');
        const footer = document.querySelector('footer');

        function adjustLayoutForWindowSize() {
            if (window.innerWidth >= 1025) {
                sidebar.classList.add('sidebar-visible');
                mainContainer.classList.add('expanded');
                dashboardContent.style.left = '240px';
                dashboardContent.style.right = '0px';


            } else {
                sidebar.classList.remove('sidebar-visible');
                mainContainer.classList.remove('expanded');
                dashboardContent.style.left = '0';
                footer.style.height = '100px';
            }
        }

        function adjustLogoSize() {
            var logo = document.querySelector('.logo-text');
            if (window.innerWidth < 768) {
                logo.style.fontSize = '1.5rem'; 
            } else if (window.innerWidth < 480) {
                logo.style.fontSize = '1.25rem'; 
            } else {
                logo.style.fontSize = '2.4rem'; 
            }
        }

        adjustLayoutForWindowSize();
        adjustLogoSize();

        window.addEventListener('resize', function() {
            adjustLayoutForWindowSize();
            adjustLogoSize();
        });
    });
</script>
