<meta name="csrf-token" content="{{ csrf_token() }}">

@php
    $navbar = \App\Models\NavbarSetting::first();
    $cartCount = 0;
    if (Auth::check()) {
        if (Auth::user()->cart) {
            $cartCount = Auth::user()->cart->items->sum('quantity');
        }
    } else {
        $cart = session()->get('cart', ['items' => []]);
        $cartCount = collect($cart['items'])->sum('quantity');
    }
@endphp

<nav class="border-gray-200 bg-gray-900">
    <div class="max-w-screen-xl flex flex-wrap items-center justify-between mx-auto p-4 sm:px-6">
        <!-- Logo and Brand -->
        <a href="{{ route('landing') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            @if ($navbar && $navbar->logo)
                <img src="{{ asset('storage/' . $navbar->logo) }}" class="h-8 sm:h-10" alt="Logo" />
            @else
                <img src="{{ asset('images/saaslogo.png') }}" class="h-8 sm:h-10" alt="Default Logo" />
            @endif
            <span class="text-xl sm:text-2xl font-semibold whitespace-nowrap text-white hover:text-amber-300 transition-colors">
                {{ $navbar->title ?? 'SaasCaterPro' }}
            </span>
        </a>
        {{-- <a href="{{ route('landing') }}" class="flex items-center space-x-3 rtl:space-x-reverse">
            <img src="{{ asset('images/saaslogo.png') }}" class="h-8 sm:h-10" alt="Saas Logo" />
            <span class="text-xl sm:text-2xl font-semibold whitespace-nowrap text-white hover:text-amber-300 transition-colors">SaasCaterPro</span>
        </a> --}}

        <!-- Centered Search Bar (Desktop) -->
        <div class="hidden md:flex flex-1 justify-center px-4">
            <form action="{{ route('search') }}" method="GET" class="w-full max-w-md">
                <div class="relative flex">
                    <input type="text" name="query" placeholder="Search meals..."
                           class="flex-grow py-2 px-3 rounded-l-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-300"
                           value="{{ request('query') }}">
                    <button type="submit" class="bg-amber-400 hover:bg-amber-500 rounded-r-lg p-2 transition-colors">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>
        </div>

        <!-- Desktop Cart and User (hidden on mobile) -->
        <div class="hidden md:flex items-center space-x-4">
            <!-- Cart -->
            <a href="{{ route('cart.index') }}" class="relative flex items-center space-x-1 text-black bg-white hover:bg-amber-300 font-medium rounded-lg text-sm px-3 py-2 transition-colors">
                <span>Cart</span>
                <svg class="w-5 h-5 text-black" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                    <path d="M351.9 329.506H206.81l-3.072-12.56H368.16l26.63-116.019-217.23-26.04-9.952-58.09h-50.4v21.946h31.894l35.233 191.246a32.927 32.927 0 1 0 36.363 21.462h100.244a32.825 32.825 0 1 0 30.957-21.945zM181.427 197.45l186.51 22.358-17.258 75.195H198.917z"/>
                </svg>
                <span id="cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                    {{ $cartCount }}
                </span>
            </a>

            <!-- User Dropdown -->
            @auth
                <div class="relative">
                    <button onclick="toggleDropdown()"
                            class="flex items-center space-x-1 text-black bg-white hover:bg-amber-300 font-medium rounded-lg text-sm px-3 py-2 transition-colors">
                        <span>Hello, {{ auth()->user()->first_name }}</span>
                        <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 10.939l3.71-3.71a.75.75 0 111.06 1.06l-4.24 4.24a.75.75 0 01-1.06 0L5.21 8.27a.75.75 0 01.02-1.06z" clip-rule="evenodd"/>
                        </svg>
                    </button>

                    <!-- Dropdown Menu -->
                    <div id="accountDropdown" class="hidden absolute right-0 mt-2 w-48 bg-white rounded shadow-lg z-50">
                        @if (Auth::check() && Auth::user()->role === 'admin')
                            <a href="{{ route('admin.reports') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition-colors">
                                Dashboard
                            </a>
                        @endif
                        <a href="{{ route('userdashboard') }}" class="block px-4 py-2 text-gray-800 hover:bg-gray-100 transition-colors">
                            My Account
                        </a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-gray-800 hover:bg-gray-100 transition-colors">
                                Logout
                            </button>
                        </form>
                    </div>
                </div>
            @else
                <a href="{{ route('login') }}" class="text-black bg-white hover:bg-amber-300 font-medium rounded-lg text-sm px-3 py-2 transition-colors">
                    Login
                </a>
            @endauth
        </div>

        <!-- Mobile Cart Icon (always visible) -->
        <div class="md:hidden flex items-center space-x-4">
            <a href="{{ route('cart.index') }}" class="relative flex items-center text-white hover:text-amber-300">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 512 512" fill="currentColor">
                    <path d="M351.9 329.506H206.81l-3.072-12.56H368.16l26.63-116.019-217.23-26.04-9.952-58.09h-50.4v21.946h31.894l35.233 191.246a32.927 32.927 0 1 0 36.363 21.462h100.244a32.825 32.825 0 1 0 30.957-21.945zM181.427 197.45l186.51 22.358-17.258 75.195H198.917z"/>
                </svg>
                <span id="mobile-cart-count" class="absolute -top-2 -right-2 bg-red-500 text-white text-xs font-bold px-1.5 py-0.5 rounded-full">
                    {{ $cartCount }}
                </span>
            </a>
            
            <!-- Mobile Menu Button -->
            <button data-collapse-toggle="mobile-menu" type="button" 
                    class="inline-flex items-center p-2 w-10 h-10 justify-center text-sm rounded-lg focus:outline-none text-gray-400 hover:bg-gray-700">
                <span class="sr-only">Open main menu</span>
                <svg class="w-5 h-5" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 17 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1h15M1 7h15M1 13h15"/>
                </svg>
            </button>
        </div>
    </div>

    <!-- Mobile Menu Content -->
    <div class="hidden w-full md:hidden bg-gray-800" id="mobile-menu">
        <div class="px-4 py-2">
            <!-- Mobile Search -->
            <form action="{{ route('search') }}" method="GET" class="mb-4">
                <div class="flex">
                    <input type="text" name="query" placeholder="Search meals..."
                           class="flex-1 py-2 px-3 rounded-l-lg text-sm focus:outline-none focus:ring-2 focus:ring-amber-300"
                           value="{{ request('query') }}">
                    <button type="submit" class="bg-amber-400 hover:bg-amber-500 rounded-r-lg p-2">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-900" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                        </svg>
                    </button>
                </div>
            </form>

            <!-- Mobile Navigation Links -->
            <ul class="space-y-2">
                <li>
                    <a href="{{ route('landing') }}" class="block py-2 px-3 text-white rounded hover:bg-gray-700 transition-colors">
                        Home
                    </a>
                </li>
                <li>
                    <a href="#" onclick="scrollToSection('menu')" class="block py-2 px-3 text-white rounded hover:bg-gray-700 transition-colors">
                        Menu
                    </a>
                </li>
                <li>
                    <a href="#" onclick="scrollToSection('aboutus')" class="block py-2 px-3 text-white rounded hover:bg-gray-700 transition-colors">
                        About Us
                    </a>
                </li>
                
                <!-- Mobile Login/Account -->
                @auth
                    <li>
                        <a href="{{ route('userdashboard') }}" class="block py-2 px-3 text-white rounded hover:bg-gray-700 transition-colors">
                            My Account
                        </a>
                    </li>
                    @if (Auth::user()->role === 'admin')
                        <li>
                            <a href="{{ route('admin.reports') }}" class="block py-2 px-3 text-white rounded hover:bg-gray-700 transition-colors">
                                Dashboard
                            </a>
                        </li>
                    @endif
                    <li>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit" class="w-full text-left py-2 px-3 text-white rounded hover:bg-gray-700 transition-colors">
                                Logout
                            </button>
                        </form>
                    </li>
                @else
                    <li>
                        <a href="{{ route('login') }}" class="block py-2 px-3 text-white rounded hover:bg-gray-700 transition-colors">
                            Login
                        </a>
                    </li>
                @endauth
            </ul>
        </div>
    </div>
</nav>

<script>
    function toggleDropdown() {
        document.getElementById('accountDropdown').classList.toggle('hidden');
    }

    function scrollToSection(id) {
        const element = document.getElementById(id);
        if (element) {
            element.scrollIntoView({ behavior: 'smooth' });
        }
    }

    document.addEventListener('DOMContentLoaded', function() {
        setInterval(function() {
            $.ajax({
                url: "{{ route('cart.count') }}",
                type: 'GET',
                success: function(response) {
                    const cartCountElement = document.getElementById('cart-count');
                    const mobileCartCountElement = document.getElementById('mobile-cart-count');
                    
                    if (cartCountElement) cartCountElement.innerText = response.count;
                    if (mobileCartCountElement) mobileCartCountElement.innerText = response.count;
                },
                error: function(xhr) {
                    console.error("Error fetching cart count:", xhr.responseText);
                }
            });
        }, 2000);
    });
</script>