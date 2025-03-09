<!DOCTYPE html>
<html lang="en" x-data="{ isSidebarOpen: true, activeScreen: 'dashboard' }">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://unpkg.com/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    
    <style>
        [x-cloak] { display: none !important; }
        @keyframes slide-in {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes slide-out {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(150%);
            }
        }

        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }

        .animate-slide-out {
            animation: slide-out 0.3s ease-in;
        }
    </style>
</head>

<body class="bg-gray-100" x-data="{ isSidebarOpen: true }">
    <div class="flex h-screen">
        {{-- sidebar --}}
        <aside class="bg-gray-800 text-white transition-all duration-300 ease-in-out"
            :class="isSidebarOpen ? 'w-64' : 'w-16'">
            <div class="p-4 flex justify-between items-center">
                <span x-show="isSidebarOpen" class="text-xl font-bold">Admin Panel</span>
                <button @click="isSidebarOpen = !isSidebarOpen" class="hover:bg-gray-700 p-2 rounded">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M13 5l7 7-7 7M5 5l7 7-7 7" />
                    </svg>
                </button>
            </div>

            <nav class="mt-4">
                <ul class="space-y-2">
                    <li>
                        <a href="#" :class="{ 'bg-gray-700': activeScreen === 'dashboard' }"
                            class="flex items-center p-3 hover:bg-gray-700" @click.prevent="activeScreen = 'dashboard'">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                            </svg>
                            <span x-show="isSidebarOpen">Dashboard</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" :class="{ 'bg-gray-700': activeScreen === 'categories' }"
                            class="flex items-center p-3 hover:bg-gray-700"
                            @click.prevent="activeScreen = 'categories'">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M4 6h16M4 12h16M4 18h16" />
                            </svg>
                            <span x-show="isSidebarOpen">Categories</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" :class="{ 'bg-gray-700': activeScreen === 'products' }"
                            class="flex items-center p-3 hover:bg-gray-700" @click.prevent="activeScreen = 'products'">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span x-show="isSidebarOpen">Products</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" :class="{ 'bg-gray-700': activeScreen === 'packages' }"
                            class="flex items-center p-3 hover:bg-gray-700" @click.prevent="activeScreen = 'packages'">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M16 11V7a4 4 0 00-8 0v4M5 9h14l1 12H4L5 9z" />
                            </svg>
                            <span x-show="isSidebarOpen">Packages</span>
                        </a>
                    </li>
                    
                    <li>
                        <a href="#" :class="{ 'bg-gray-700': activeScreen === 'bookings' }"
                            class="flex items-center p-3 hover:bg-gray-700" @click.prevent="activeScreen = 'bookings'">
                            <svg class="w-6 h-6 mr-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span x-show="isSidebarOpen">Bookings</span>
                        </a>
                    </li>
                    <li>
                        <a href="#" :class="{ 'bg-gray-700': activeScreen === 'users' }"
                            class="flex items-center p-3 hover:bg-gray-700" @click.prevent="activeScreen = 'users'">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M5.121 17.804A13.937 13.937 0 0112 15c2.21 0 4.29.562 6.121 1.804M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                            </svg>
                            <span x-show="isSidebarOpen">Users</span>
                        </a>
                    </li>
                    <li>
                        <a href="{{ route('landing') }}" :class="bg-gray-700"
                            class="flex items-center p-3 hover:bg-gray-700">
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 mr-3" fill="none"
                                viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M3 9.75L12 3l9 6.75M4.5 10.5V21h15V10.5M9 21V15h6v6" />
                            </svg>
                            <span x-show="isSidebarOpen">Home</span>
                        </a>
                    </li>
                </ul>
            </nav>
        </aside>


        {{-- main content ng page --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <x-dashboard.header />
                <!-- conditional -->
                <div x-show="activeScreen === 'dashboard'" x-cloak>
                   
                    <x-dashboard.first-section />
                </div>

                <div x-show="activeScreen === 'products'" x-cloak>
                    <div class="mt-5">
                        
                        
                        <x-items.item-button />

                    </div>
                    
                    <x-dashboard.products />
                </div>

                <div x-show="activeScreen === 'packages'" x-cloak>
                    <x-packages.addbtn />
                    <x-dashboard.packages />
                    <x-packages.add-package-item />
                    <x-packages.view-items-package  />
                </div>
                <div x-show="activeScreen === 'categories'" x-cloak>
                    <x-category.category-button />
                    <x-dashboard.categories />
                </div>

                <div x-show="activeScreen === 'bookings'" x-cloak>
                    <x-dashboard.calendar />
                    <x-dashboard.bookings />
                </div>

                <div x-show="activeScreen === 'users'" x-cloak>
                    <x-dashboard.users />
                </div>
            </main>
        </div>
    </div>








    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#f0fdfa',
                iconColor: '#06b6d4',
                color: '#164e63',
                timerProgressBar: true,
                showClass: {
                    popup: 'swal2-show animate-slide-in'
                },
                hideClass: {
                    popup: 'swal2-hide animate-slide-out'
                }
            });
        </script>
    @endif

    
</body>

</html>
