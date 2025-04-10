<aside id="sidebar" class="bg-gray-800 text-white w-64 transition-all duration-300">
    <div class="p-4 flex justify-between items-center">
        <span id="sidebar-title" class="text-xl font-bold">Admin Panel</span>
        <button id="toggle-sidebar" class="text-white focus:outline-none hover:cursor-pointer">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M11 19l-7-7 7-7m8 14l-7-7 7-7" />
            </svg>
        </button>
    </div>

    <nav class="mt-4">
        <ul class="space-y-2">
            <li>
                <a href="{{ route('admin.finaldashboard') }}"
                    class="flex items-center p-3 hover:bg-gray-700 rounded-md {{ Request::routeIs('admin.finaldashboard') ? 'bg-gray-900' : '' }}">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                    </svg>
                    <span class="menu-text">Dashboard</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.categorydashboard') }}"
                    class="flex items-center p-3 hover:bg-gray-700 rounded-md {{ Request::routeIs('admin.categorydashboard') ? 'bg-gray-900' : '' }}">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M4 6h16M4 12h16M4 18h16" />
                    </svg>
                    <span class="menu-text">Categories</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.products') }}"
                    class="flex items-center p-3 hover:bg-gray-700 rounded-md {{ Request::routeIs('admin.products') ? 'bg-gray-900' : '' }}">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="menu-text">Products</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.packages') }}"
                    class="flex items-center p-3 hover:bg-gray-700 rounded-md {{ Request::routeIs('admin.packages') ? 'bg-gray-900' : '' }}">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="menu-text">Packages</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.utilities') }}"
                    class="flex items-center p-3 hover:bg-gray-700 rounded-md {{ Request::routeIs('admin.utilities') ? 'bg-gray-900' : '' }}">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                    </svg>
                    <span class="menu-text">Utilities</span>
                </a>
            </li>
            <li>
                <a href="{{ route('admin.bookings') }}"
                    class="flex items-center p-3 hover:bg-gray-700 rounded-md {{ Request::routeIs('admin.bookings') ? 'bg-gray-900' : '' }}">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <span class="menu-text">Bookings</span>
                </a>
            </li>
            <li class="reports-menu">
                <a href="#" 
                   class="flex items-center p-3 hover:bg-gray-700 rounded-md {{ Request::routeIs('admin.reports*') ? 'bg-gray-900' : '' }}"
                   onclick="toggleSubmenu(event)">
                    <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 8h2a2 2 0 012 2v10a2 2 0 01-2 2H5a2 2 0 01-2-2V10a2 2 0 012-2h2M9 14h6M9 18h6M9 10h6" />
                    </svg>
                    <span class="menu-text">Reports</span>
                    <svg class="w-4 h-4 ml-auto transform transition-transform duration-200" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                    </svg>
                </a>
                
                <!-- Submenu for Reports with classes for initial hidden state -->
                <ul class="sub-menu pl-4 space-y-2 transition-all duration-300 ease-in-out max-h-0 overflow-hidden">
                    <li>
                        <a href="{{ route('admin.reports', ['type' => 'bookings']) }}" class="block p-3 pl-10 hover:bg-gray-600 rounded-md {{ Request::input('type') == 'bookings' ? 'bg-gray-700' : '' }}">
                            Bookings Report
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports.customer', ['type' => 'customers']) }}" class="block p-3 pl-10 hover:bg-gray-600 rounded-md {{ Request::input('type') == 'customers' ? 'bg-gray-700' : '' }}">
                            Customer Report
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('admin.reports', ['type' => 'penalties']) }}" class="block p-3 pl-10 hover:bg-gray-600 rounded-md {{ Request::input('type') == 'penalties' ? 'bg-gray-700' : '' }}">
                            Penalties Report
                        </a>
                    </li>
                </ul>
            </li>
            
            

            <li>
                <a href="{{ route('admin.allusers') }}"
                    class="flex items-center p-3 hover:bg-gray-700 rounded-md {{ Request::routeIs('admin.allusers') ? 'bg-gray-900' : '' }}">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M5.121 17.804A13.937 13.937 0 0112 15c2.21 0 4.29.562 6.121 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                    </svg>
                    <span class="menu-text">Users</span>
                </a>
            </li>
            <li>
                <a href="#" onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                    class="flex items-center p-3 hover:bg-gray-700 rounded-md">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 mr-3" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1m0-10V5m0 6H3" />
                    </svg>
                    <span class="menu-text">Logout</span>
                </a>
                <form id="logout-form" action="{{ route('logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </li>
        </ul>
    </nav>
</aside>

{{-- JS FUNCTION FOR COLLAPSING SIDENAV --}}
<script>
    // REPORTS DROPDOWN EXTENDING
    function toggleSubmenu(event) {
    event.preventDefault();
    const parentLi = event.currentTarget.parentElement;
    const submenu = parentLi.querySelector('.sub-menu');
    const arrow = event.currentTarget.querySelector('svg:last-child');
    
    if (submenu.classList.contains('max-h-0')) {
        // Show submenu
        submenu.classList.remove('max-h-0');
        submenu.classList.add('max-h-48'); // Adjust this value based on your submenu size
        arrow.classList.add('rotate-180');
    } else {
        // Hide submenu
        submenu.classList.remove('max-h-48');
        submenu.classList.add('max-h-0');
        arrow.classList.remove('rotate-180');
    }
}

// Check if this menu should be expanded based on current route
document.addEventListener('DOMContentLoaded', function() {
    const currentPath = window.location.pathname;
    if (currentPath.includes('/admin/reports')) {
        const reportsMenu = document.querySelector('.reports-menu');
        const submenu = reportsMenu.querySelector('.sub-menu');
        const arrow = reportsMenu.querySelector('a svg:last-child');
        
        submenu.classList.remove('max-h-0');
        submenu.classList.add('max-h-48');
        arrow.classList.add('rotate-180');
    }
});

    // sidebarr
    document.addEventListener('DOMContentLoaded', function() {
        const sidebar = document.getElementById('sidebar');
        const toggleButton = document.getElementById('toggle-sidebar');
        const sidebarTitle = document.getElementById('sidebar-title');
        const menuTexts = document.querySelectorAll('.menu-text');
        let isCollapsed = false;

        toggleButton.addEventListener('click', function() {
            isCollapsed = !isCollapsed;

            if (isCollapsed) {
                // collapse sidebar
                sidebar.classList.remove('w-64');
                sidebar.classList.add('w-16');
                sidebarTitle.classList.add('hidden');

                // change toggle button icon to expand
                toggleButton.innerHTML =
                    '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 5l7 7-7 7M5 5l7 7-7 7" /></svg>';

                // Hide text, show only icons
                menuTexts.forEach(text => {
                    text.classList.add('hidden');
                });
            } else {
                // Expand 
                sidebar.classList.remove('w-16');
                sidebar.classList.add('w-64');
                sidebarTitle.classList.remove('hidden');

                // change toggle button icon to collapse
                toggleButton.innerHTML =
                    '<svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 19l-7-7 7-7m8 14l-7-7 7-7" /></svg>';

                // Show text again
                menuTexts.forEach(text => {
                    text.classList.remove('hidden');
                });
            }
        });
    });
</script>
