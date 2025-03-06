<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @keyframes slide-in { from { transform: translateX(100%); } to { transform: translateX(0); } }
        @keyframes slide-out { from { transform: translateX(0); } to { transform: translateX(150%); } }
        .animate-slide-in { animation: slide-in 0.3s ease-out; }
        .animate-slide-out { animation: slide-out 0.3s ease-in; }
    </style>
</head>

<body class="bg-gray-100" x-data="{ isSidebarOpen: true }">
    <div class="flex h-screen">
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

        <!-- Main Content -->
        <div class="flex-1 flex flex-col overflow-hidden">
            <!-- Header -->
            <header class="bg-white shadow-sm">
                <div class="flex items-center justify-between p-4">
                    <div>
                        <h1 class="text-xl font-semibold text-gray-800">ADMIN DASHBOARD</h1>
                        @auth
                            @if (Auth::user()->role === 'admin')
                                <p class="text-sm text-gray-600">Welcome, {{ Auth::user()->first_name }}</p>
                            @endif
                        @endauth
                    </div>
                    <form action="/logout" method="post">
                        @csrf
                        <button class="px-4 py-2 bg-red-500 text-white rounded hover:bg-red-600">
                            Logout
                        </button>
                    </form>
                </div>
            </header>

            <!-- Content Area -->
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <div class="space-y-6">
                    <x-category.category-button />
                    <x-menu.menu-button />
                    <x-items.item-button />
                    
                    <div class="flex space-x-4">
                        <a href="/" class="px-4 py-2 bg-green-300 rounded hover:bg-green-400">Home</a>
                        <a href="/landing" class="px-4 py-2 bg-green-300 rounded hover:bg-green-400">Main Home</a>
                    </div>

                    {{-- Content Sections --}}
                    <x-category.category-list />
                    <x-menu.menu-list />
                    <x-items.item-list />
                </div>
            </main>
        </div>
    </div>

    <!-- Keep your existing SweetAlert script -->
    @if (session('success'))
        <script>
            Swal.fire({ /* ... your existing Swal configuration ... */ });
        </script>
    @endif
</body>
</html>