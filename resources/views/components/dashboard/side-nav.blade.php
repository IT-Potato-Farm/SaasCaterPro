<!-- x-dashboard.side-nav component -->
<div class="bg-white h-screen border-r border-gray-200 w-64 flex flex-col fixed inset-y-0 left-0 transform transition duration-200 ease-in-out z-30 md:relative md:translate-x-0 print:hidden"
    id="sidebar">
    <!-- Mobile close button -->
    <div class="flex items-center justify-between px-4 py-2 md:hidden">
        <button id="closeSidebarBtn" class="text-gray-500 hover:text-gray-700 focus:outline-none">
            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
            </svg>
        </button>
    </div>

    <!-- Logo -->
    <div class="px-6 py-4">
        <a href="{{ route('admin.reports') }}" class="flex items-center space-x-2">
            <span class="text-xl font-bold text-gray-800">ADMIN PANEL</span>
        </a>
    </div>

    <!-- Navigation -->
    <nav class="flex-1 overflow-y-auto px-4 py-2">
        <!-- Dashboard -->
        <a href="{{ route('admin.reports') }}"
            class="flex items-center px-3 py-2 text-sm font-medium rounded-lg mb-1 {{ Request::routeIs('admin.reports') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="h-5 w-5 mr-3 {{ Request::routeIs('admin.reports') ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Dashboard</span>
        </a>

        <!-- CMS Section -->
        <div class="mb-2">
            <button onclick="toggleDropdown('cmsDropdown')"
                class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.21 0 4.29.562 6.121 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span>CMS</span>
                </div>
                <svg id="cmsArrow" class="w-4 h-4 transition-transform duration-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="cmsDropdown" class="pl-10 mt-1 space-y-1 hidden">
                <a href="{{ route('admin.navbar.index') }}"
                    class="block py-2 px-3 text-sm rounded-lg text-gray-600 hover:bg-gray-100">Navbar Section</a>
                <a href="{{ route('admin.hero.index') }}"
                    class="block py-2 px-3 text-sm rounded-lg text-gray-600 hover:bg-gray-100">Hero Section</a>
                <a href="{{ route('admin.whychoose.index') }}"
                    class="block py-2 px-3 text-sm rounded-lg text-gray-600 hover:bg-gray-100">Why Choose Us</a>
                <a href="{{ route('admin.aboutus.index') }}"
                    class="block py-2 px-3 text-sm rounded-lg text-gray-600 hover:bg-gray-100">About Us</a>
                <a href="{{ route('admin.review.index') }}"
                    class="block py-2 px-3 text-sm rounded-lg text-gray-600 hover:bg-gray-100">Reviews</a>
                <a href="{{ route('admin.footer.index') }}"
                    class="block py-2 px-3 text-sm rounded-lg text-gray-600 hover:bg-gray-100">Footer</a>
                <a href="{{ route('admin.privacy.index') }}"
                    class="block py-2 px-3 text-sm rounded-lg text-gray-600 hover:bg-gray-100">Privacy & Policy</a>
            </div>
        </div>

        <!-- Categories -->
        <a href="{{ route('admin.categorydashboard') }}"
            class="flex items-center px-3 py-2 text-sm font-medium rounded-lg mb-1 {{ Request::routeIs('admin.categorydashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="h-5 w-5 mr-3 {{ Request::routeIs('admin.categorydashboard') ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16" />
            </svg>
            <span>Categories</span>
        </a>

        <!-- Party Trays -->
        {{-- <a href="{{ route('admin.products') }}"
            class="flex items-center px-3 py-2 text-sm font-medium rounded-lg mb-1 {{ Request::routeIs('admin.products') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="h-5 w-5 mr-3 {{ Request::routeIs('admin.products') ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M4 18h16M4 18a8 8 0 0116 0M4 18h16M12 4v4m0 0a4 4 0 00-4 4h8a4 4 0 00-4-4z" />
            </svg>
            <span>Party Trays</span>
        </a> --}}

        <!-- Packages -->
        <a href="{{ route('admin.packages') }}"
            class="flex items-center px-3 py-2 text-sm font-medium rounded-lg mb-1 {{ Request::routeIs('admin.packages') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="h-5 w-5 mr-3 {{ Request::routeIs('admin.packages') ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M20 12V7a2 2 0 00-2-2H6a2 2 0 00-2 2v5m16 0l-8 5-8-5m16 0l-8-5-8 5" />
            </svg>
            <span>Package Management</span>
        </a>

        <!-- Utilities -->
        {{-- <a href="{{ route('admin.utilities') }}"
            class="flex items-center px-3 py-2 text-sm font-medium rounded-lg mb-1 {{ Request::routeIs('admin.utilities') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="h-5 w-5 mr-3 {{ Request::routeIs('admin.utilities') ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 10h18M4 6h16v4H4V6zm0 8h4v4H4v-4zm6 0h4v4h-4v-4zm6 0h4v4h-4v-4z" />
            </svg>
            <span>Utilities</span>
        </a> --}}

        <!-- Bookings -->
        <a href="{{ route('admin.bookings') }}"
            class="flex items-center px-3 py-2 text-sm font-medium rounded-lg mb-1 {{ Request::routeIs('admin.bookings') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="h-5 w-5 mr-3 {{ Request::routeIs('admin.bookings') ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
            </svg>
            <span>Bookings</span>
        </a>

        <!-- Service Time Settings -->
        <a href="{{ route('admin.settingdashboard') }}"
            class="flex items-center px-3 py-2 text-sm font-medium rounded-lg mb-1 {{ Request::routeIs('admin.settingdashboard') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="h-5 w-5 mr-3 {{ Request::routeIs('admin.settingdashboard') ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
            </svg>
            <span>Adjust Service Time</span>
        </a>

        <!-- Reports Section -->
        <div class="mb-2">
            <button onclick="toggleDropdown('reportsDropdown')"
                class="w-full flex items-center justify-between px-3 py-2 text-sm font-medium rounded-lg text-gray-700 hover:bg-gray-100">
                <div class="flex items-center">
                    <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8h2a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10a2 2 0 012-2h2M9 14h6M9 18h6M9 10h6" />
                    </svg>
                    <span>Reports</span>
                </div>
                <svg id="reportsArrow" class="w-4 h-4 transition-transform duration-300" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
            <div id="reportsDropdown" class="pl-10 mt-1 space-y-1 hidden">
                <a href="{{ route('reports.orders.print', ['type' => 'bookings']) }}"
                    class="block py-2 px-3 text-sm rounded-lg text-gray-600 hover:bg-gray-100">Orders Report</a>
                <a href="{{ route('admin.reports.customer', ['type' => 'customers']) }}"
                    class="block py-2 px-3 text-sm rounded-lg text-gray-600 hover:bg-gray-100">Customer Report</a>
                <a href="{{ route('admin.reports.penalties', ['type' => 'penalties']) }}"
                    class="block py-2 px-3 text-sm rounded-lg text-gray-600 hover:bg-gray-100">Penalties Report</a>
            </div>
        </div>

        <!-- Users -->
        <a href="{{ route('admin.allusers') }}"
            class="flex items-center px-3 py-2 text-sm font-medium rounded-lg mb-1 {{ Request::routeIs('admin.allusers') ? 'bg-blue-50 text-blue-600' : 'text-gray-700 hover:bg-gray-100' }}">
            <svg class="h-5 w-5 mr-3 {{ Request::routeIs('admin.allusers') ? 'text-blue-500' : 'text-gray-400' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
            </svg>
            <span>Manage Users</span>
        </a>

        <!-- Homepage -->
        {{-- <a href="{{ route('landing') }}"
            class="flex items-center px-3 py-2 text-sm font-medium rounded-lg mb-1 text-gray-700 hover:bg-gray-100">
            <svg class="h-5 w-5 mr-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
            </svg>
            <span>Homepage</span>
        </a> --}}
    </nav>

    <!-- User profile -->
    <div class="border-t border-gray-200 mt-auto p-4">
        <div class="flex items-center space-x-3">
            <div class="bg-blue-100 text-blue-600 rounded-full h-10 w-10 flex items-center justify-center">
                <span class="text-lg font-medium">
                    @auth
                        {{ substr(Auth::user()->first_name, 0, 1) }}
                    @endauth
                </span>
            </div>
            <div>
                @auth
                    @if (Auth::user()->role === 'admin')
                        <p class="text-sm font-medium text-gray-700">Admin: {{ Auth::user()->first_name }}</p>
                    @endif
                @endauth

                <form action="{{ route('logout') }}" method="post">
                    @csrf
                    <button
                        class="text-xs text-gray-500 hover:text-gray-800 hover:cursor-pointer transition duration-200">
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
        class="fixed top-4 left-4 z-20 bg-white text-gray-600 p-2 rounded-md focus:outline-none shadow-md">
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
        // Mobile check
        if (window.innerWidth < 768) {
            sidebar.classList.add('-translate-x-full');
        }

        // Check URL path to set active dropdowns
        if (window.location.pathname.includes('/admin/reports')) {
            toggleDropdown('reportsDropdown');
        }

        // Check for CMS pages
        const cmsRoutes = [
            '/admin/navbar',
            '/admin/hero',
            '/admin/whychoose',
            '/admin/aboutus',
            '/admin/review',
            '/admin/footer',
            '/admin/privacy'
        ];

        if (cmsRoutes.some(route => window.location.pathname.includes(route))) {
            toggleDropdown('cmsDropdown');
        }
    });
</script>
