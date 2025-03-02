<nav class="bg-red-600 border-gray-200 dark:bg-gray-900 ">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4">
        <a href="#" class="flex items-center space-x-3">
            <img src="{{ asset('images/saaslogo.png') }}" class="h-12" alt="Saas Logo" />
            <span class="text-2xl font-semibold whitespace-nowrap text-white dark:text-white">SaasCaterPro</span>
        </a>
        <button data-collapse-toggle="navbar-default" type="button"
            class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm text-gray-500 rounded-lg md:hidden hover:bg-gray-100 focus:outline-none focus:ring-2 focus:ring-gray-200 dark:text-gray-400 dark:hover:bg-gray-700 dark:focus:ring-gray-600"
            aria-controls="navbar-default" aria-expanded="false">
            <span class="sr-only">Open main menu</span>
            <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none"
                viewBox="0 0 17 14">
                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M1 1h15M1 7h15M1 13h15" />
            </svg>
        </button>

        <div class="hidden w-full md:block md:w-auto" id="navbar-default">
            <ul
                class="font-medium flex flex-col items-center p-4 md:p-0 mt-4 border border-green-100 rounded-lg bg-red-600 md:flex-row md:space-x-8 rtl:space-x-reverse md:mt-0 md:border-0 md:bg-red-600 dark:bg-gray-800 md:dark:bg-gray-900 dark:border-gray-700">
                <li>
                    <a href="{{ url('/landing') }}"
                        class="block py-2 px-3 text-white rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-amber-300 md:p-0">
                        Home
                    </a>
                </li>
                <li>
                    <a href="#" onclick="scrollToSection('aboutus')"
                        class="block py-2 px-3 text-white rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-amber-300 md:p-0">
                        About Us
                    </a>
                </li>
                <li>
                    <a href="#" onclick="scrollToSection('menu')"
                        class="block py-2 px-3 text-white rounded-sm hover:bg-gray-100 md:hover:bg-transparent md:border-0 md:hover:text-amber-300 md:p-0">
                        Menu
                    </a>
                </li>
                <li>
                    <a href="{{ url('/cart') }}"
                        class="flex items-center space-x-2 text-black bg-white hover:bg-amber-300 font-medium rounded-lg text-sm px-4 py-2.5">
                        Cart
                        <svg class="w-6 h-5 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512"
                            fill="currentColor">
                            <path
                                d="M351.9 329.506H206.81l-3.072-12.56H368.16l26.63-116.019-217.23-26.04-9.952-58.09h-50.4v21.946h31.894l35.233 191.246a32.927 32.927 0 1 0 36.363 21.462h100.244a32.825 32.825 0 1 0 30.957-21.945zM181.427 197.45l186.51 22.358-17.258 75.195H198.917z" />
                        </svg>
                    </a>
                </li>

                {{-- if naka log in yung user eto magd-display --}}
                @auth
                    <li class="relative">
                        <button onclick="toggleDropdown()"
                            class="flex items-center space-x-2 text-black bg-white hover:bg-amber-300 font-medium rounded-lg text-sm px-4 py-2.5">
                            <span>Hello, {{ auth()->user()->first_name }}</span>
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                                <path fill-rule="evenodd"
                                    d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z"
                                    clip-rule="evenodd" />
                            </svg>
                        </button>
                        <!-- dropdown -->
                        <div id="accountDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded shadow z-50">
                            {{-- if admin yung nakalogin mag show to --}}
                            @if (Auth::check() && Auth::user()->role === 'admin')
                                <a href="{{ route('admin.dashboard') }}"
                                    class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
                                    Dashboard
                                </a>
                            @endif
                            
                            <a href="profilepageto" class="block px-4 py-2 text-gray-800 hover:bg-gray-200">
                                My Account
                            </a>
                            <form method="POST" action="{{ route('logout') }}">
                                @csrf
                                <button type="submit"
                                    class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-200">
                                    Logout
                                </button>
                            </form>
                        </div>
                    </li>
                @endauth

                {{-- if de naka log in eto lalabas --}}
                @guest
                    <li>
                        <a href="{{ url('/register') }}"
                            class="text-black bg-white hover:bg-amber-300 font-medium rounded-lg text-sm px-5 py-2.5">
                            Login
                        </a>
                    </li>
                @endguest
            </ul>
        </div>
    </div>
</nav>

<script>
    //dropdown toggle
    function toggleDropdown() {
        document.getElementById('accountDropdown').classList.toggle('hidden');
    }

    function scrollToSection(id) {
        const element = document.getElementById(id);
        if (element) {
            const targetPos = element.getBoundingClientRect().top + window.scrollY;
            const startPos = window.scrollY;
            const distance = targetPos - startPos;
            const duration = 600;
            let startTime = null;

            function easeInOutQuad(t) {
                return t < 0.5 ? 2 * t * t : -1 + (4 - 2 * t) * t;
            }

            function animate(currentTime) {
                if (startTime === null) startTime = currentTime;
                const timeElapsed = currentTime - startTime;
                const progress = Math.min(timeElapsed / duration, 1);
                const easing = easeInOutQuad(progress);
                window.scrollTo(0, startPos + distance * easing);
                if (timeElapsed < duration) {
                    requestAnimationFrame(animate);
                }
            }
            requestAnimationFrame(animate);
        }
    }
</script>
