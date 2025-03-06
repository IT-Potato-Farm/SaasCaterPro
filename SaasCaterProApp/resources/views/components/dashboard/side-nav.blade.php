<!-- Sidebar -->
<aside class="bg-gray-800 text-white transition-all duration-300 ease-in-out" 
:class="isSidebarOpen ? 'w-64' : 'w-16'">
<div class="p-4 flex justify-between items-center">
<span x-show="isSidebarOpen" class="text-xl font-bold">Admin Panel</span>
<button @click="isSidebarOpen = !isSidebarOpen" class="hover:bg-gray-700 p-2 rounded">
    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
              d="M13 5l7 7-7 7M5 5l7 7-7 7"/>
    </svg>
</button>
</div>

<nav class="mt-4">
<ul class="space-y-2">
    <li>
        <a href="#" class="flex items-center p-3 hover:bg-gray-700">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>
            </svg>
            <span x-show="isSidebarOpen">Dashboard</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-3 hover:bg-gray-700">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z"/>
            </svg>
            <span x-show="isSidebarOpen">Products</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-3 hover:bg-gray-700">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M4 6h16M4 12h16M4 18h16"/>
            </svg>
            <span x-show="isSidebarOpen">Categories</span>
        </a>
    </li>
    <li>
        <a href="#" class="flex items-center p-3 hover:bg-gray-700">
            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" 
                      d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
            </svg>
            <span x-show="isSidebarOpen">Bookings</span>
        </a>
    </li>
</ul>
</nav>
</aside>