<!-- x-dashboard.side-nav component -->
<div class="bg-gray-800 text-white w-64 space-y-6 py-7 px-2 absolute inset-y-0 left-0 transform -translate-x-full md:relative md:translate-x-0 transition duration-200 ease-in-out z-30"
    id="sidebar">
    <!-- Close button - visible on mobile only -->
    <div class="flex items-center justify-between px-4 md:hidden">

        <button id="closeSidebarBtn" class="text-white focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Logo -->
    <div class="px-4 ">
        <a href="{{ route('admin.finaldashboard') }}" class="flex items-center space-x-2">

            <span class="text-xl font-bold">ADMIN PANEL</span>
        </a>
    </div>

    <!-- Navigation - Using content from your complex side-nav -->
    <nav class="flex flex-col space-y-2 px-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.finaldashboard') }}"
            class="flex items-center space-x-2 py-2 px-4 rounded {{ Request::routeIs('admin.finaldashboard') ? 'bg-gray-700 text-blue-400' : 'hover:bg-gray-700' }} transition duration-200">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>
        <a href="{{ route('admin.reports') }}"
            class="flex items-center space-x-2 py-2 px-4 rounded {{ Request::routeIs('admin.reports') ? 'bg-gray-700 text-blue-400' : 'hover:bg-gray-700' }} transition duration-200">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard2</span>
        </a>

        <!-- CMS Dropdown -->
        <div class="relative">
            <button onclick="toggleDropdown('cmsDropdown')"
                class="w-full flex items-center justify-between py-2 px-4 rounded hover:bg-gray-700 transition duration-200">
                <div class="flex items-center space-x-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.21 0 4.29.562 6.121 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>CMS</span>
                </div>
                <svg id="cmsArrow" class="w-4 h-4 transform transition-transform duration-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <ul id="cmsDropdown" class="ml-8 mt-1 space-y-1 hidden">
                {{-- <li><a href="" class="block py-2 px-4 text-sm rounded hover:bg-gray-700">Navigation</a></li> --}}
                <li><a href="{{ route('admin.hero.index') }}"
                        class="block py-2 px-4 text-sm rounded hover:bg-gray-700">Hero Section</a></li>
                <li><a href="{{ route('admin.whychoose.index') }}"
                        class="block py-2 px-4 text-sm rounded hover:bg-gray-700">Why Choose Us</a></li>
                <li><a href="{{ route('admin.aboutus.index') }}"
                        class="block py-2 px-4 text-sm rounded hover:bg-gray-700">About Us</a></li>
                <li><a href="{{ route('admin.footer.index') }}"
                        class="block py-2 px-4 text-sm rounded hover:bg-gray-700">Footer</a></li>
                <li><a href="{{ route('admin.privacy.index') }}"
                        class="block py-2 px-4 text-sm rounded hover:bg-gray-700">Privacy & Policy</a></li>
            </ul>
        </div>

        <!-- Categories -->
        <a href="{{ route('admin.categorydashboard') }}"
            class="flex items-center space-x-2 py-2 px-4 rounded {{ Request::routeIs('admin.categorydashboard') ? 'bg-gray-700 text-blue-400' : 'hover:bg-gray-700' }} transition duration-200">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <span>Categories</span>
        </a>

        <!-- Party Trays -->
        <a href="{{ route('admin.products') }}"
            class="flex items-center space-x-2 py-2 px-4 rounded {{ Request::routeIs('admin.products') ? 'bg-gray-700 text-blue-400' : 'hover:bg-gray-700' }} transition duration-200">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 18h16M4 18a8 8 0 0116 0M4 18h16M12 4v4m0 0a4 4 0 00-4 4h8a4 4 0 00-4-4z" />
            </svg>
            <span>Party Trays</span>
        </a>

        <!-- Packages -->
        <a href="{{ route('admin.packages') }}"
            class="flex items-center space-x-2 py-2 px-4 rounded {{ Request::routeIs('admin.packages') ? 'bg-gray-700 text-blue-400' : 'hover:bg-gray-700' }} transition duration-200">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 12V7a2 2 0 00-2-2H6a2 2 0 00-2 2v5m16 0l-8 5-8-5m16 0l-8-5-8 5" />
            </svg>
            <span>Packages</span>
        </a>
        <a href="{{ route('admin.utilities') }}"
            class="flex items-center space-x-2 py-2 px-4 rounded {{ Request::routeIs('admin.utilities') ? 'bg-gray-700 text-blue-400' : 'hover:bg-gray-700' }} transition duration-200">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h18M4 6h16v4H4V6zm0 8h4v4H4v-4zm6 0h4v4h-4v-4zm6 0h4v4h-4v-4z" />
            </svg>
            <span>Utilities</span>
        </a>

        <!-- Bookings -->
        <a href="{{ route('admin.bookings') }}"
            class="flex items-center space-x-2 py-2 px-4 rounded {{ Request::routeIs('admin.bookings') ? 'bg-gray-700 text-blue-400' : 'hover:bg-gray-700' }} transition duration-200">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>Bookings</span>
        </a>
        <a href="{{ route('admin.settingdashboard') }}"
            class="flex items-center space-x-2 py-2 px-4 rounded {{ Request::routeIs('admin.settingdashboard') ? 'bg-gray-700 text-blue-400' : 'hover:bg-gray-700' }} transition duration-200">
            <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>Adjust Service Time</span>
        </a>

        <!-- Reports Dropdown -->
        <div class="relative">
            <button onclick="toggleDropdown('reportsDropdown')"
                class="w-full flex items-center justify-between py-2 px-4 rounded hover:bg-gray-700 transition duration-200">
                <div class="flex items-center space-x-2">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"
                        xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8h2a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10a2 2 0 012-2h2M9 14h6M9 18h6M9 10h6" />
                    </svg>
                    <span>Reports</span>
                </div>
                <svg id="reportsArrow" class="w-4 h-4 transform transition-transform duration-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <ul id="reportsDropdown" class="ml-8 mt-1 space-y-1 hidden">
                <li><a href="{{ route('reports.orders.print', ['type' => 'bookings']) }}"
                        class="block py-2 px-4 text-sm rounded hover:bg-gray-700">Orders Report</a></li>
                <li><a href="{{ route('admin.reports.customer', ['type' => 'customers']) }}"
                        class="block py-2 px-4 text-sm rounded hover:bg-gray-700">Customer Report</a></li>
                <li><a href="{{ route('admin.reports', ['type' => 'penalties']) }}"
                        class="block py-2 px-4 text-sm rounded hover:bg-gray-700">Penalties Report</a></li>
            </ul>
        </div>

        <!-- Users -->
        <a href="{{ route('admin.allusers') }}"
            class="flex items-center space-x-2 py-2 px-4 rounded {{ Request::routeIs('admin.allusers') ? 'bg-gray-700 text-blue-400' : 'hover:bg-gray-700' }} transition duration-200">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span>Users</span>
        </a>
    </nav>

    <!-- User profile -->
    <div class="border-t border-gray-700 pt-4 mt-4 px-4">
        <div class="flex items-center space-x-3">
            <div class="bg-gray-600 rounded-full h-10 w-10 flex items-center justify-center">
                <span class="text-lg font-medium">U</span>
            </div>
            <div>
                @auth
                    @if (Auth::user()->role === 'admin')
                        <p class="text-sm font-medium">Admin: {{ Auth::user()->first_name }}</p>
                    @endif
                @endauth

                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button
                        class="text-xs text-gray-400 hover:text-white hover:cursor-pointer transition duration-200">
                        Logout
                    </button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Mobile overlay and toggle -->
<div class="md:hidden">
    <div class="fixed inset-0 bg-gray-900 opacity-50 z-20 hidden" id="sidebarOverlay"></div>

    <button id="openSidebarBtn"
        class="fixed top-4 left-4 z-20 bg-gray-800 text-white p-2 rounded-md focus:outline-none">
        <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"
            xmlns="http://www.w3.org/2000/svg">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"></path>
        </svg>
    </button>
</div>

<script>
    // Mobile sidebar toggle
    const sidebar = document.getElementById('sidebar');
    const sidebarOverlay = document.getElementById('sidebarOverlay');
    const openSidebarBtn = document.getElementById('openSidebarBtn');
    const closeSidebarBtn = document.getElementById('closeSidebarBtn');

    function openSidebar() {
        sidebar.classList.remove('-translate-x-full');
        sidebarOverlay.classList.remove('hidden');
    }

    function closeSidebar() {
        sidebar.classList.add('-translate-x-full');
        sidebarOverlay.classList.add('hidden');
    }

    function toggleDropdown(id) {
        const dropdown = document.getElementById(id);
        const arrow = document.getElementById(id.replace('Dropdown', 'Arrow'));
        if (dropdown.classList.contains('hidden')) {
            dropdown.classList.remove('hidden');
            arrow.classList.add('rotate-180');
        } else {
            dropdown.classList.add('hidden');
            arrow.classList.remove('rotate-180');
        }
    }

    openSidebarBtn.addEventListener('click', openSidebar);
    closeSidebarBtn.addEventListener('click', closeSidebar);
    sidebarOverlay.addEventListener('click', closeSidebar);

    // Close sidebar on window resize if screen becomes larger
    window.addEventListener('resize', () => {
        if (window.innerWidth >= 768) {
            sidebar.classList.remove('-translate-x-full');
            sidebarOverlay.classList.add('hidden');
        } else {
            sidebar.classList.add('-translate-x-full');
        }
    });

    // Initialize dropdown states based on current route
    document.addEventListener('DOMContentLoaded', () => {
        if (window.location.pathname.includes('/admin/reports')) {
            toggleDropdown('reportsDropdown');
        }
        if (window.location.pathname.includes('/cms')) {
            toggleDropdown('cmsDropdown');
        }
    });
</script>
