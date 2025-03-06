<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<<body class="bg-gray-100">
    <div class="flex h-screen">
        <!-- Sidebar -->
        <aside class="w-64 bg-gray-900 text-white px-6 shadow-lg">
            <h2 class="text-2xl font-bold mb-6 text-center">User Dashboard</h2>
            <ul class="space-y-4">
                <li>
                    <a href="#" class="block py-2 px-4 rounded-lg bg-gray-800 hover:bg-gray-700 transition">
                        Home
                    </a>
                </li>
                <li>
                    <a href="#" class="block py-2 px-4 rounded-lg bg-blue-600 hover:bg-blue-500 transition">
                        My Orders
                    </a>
                </li>
            </ul>
        </aside>

        <div class="flex-1 flex flex-col">
            <nav class="bg-white p-4 shadow-md flex justify-between items-center border-b">
                <h2 class="text-xl font-bold text-gray-700">Jimmuel's Order</h2>
            </nav>

            <div class="p-6">
                <!-- Breadcrumbs -->
                <nav class="mb-6">
                    <ol class="flex items-center space-x-2 text-gray-600 text-sm">
                        <li>
                            <a href="{{route('landing')}}" class="hover:underline hover:text-blue-600">Home</a>
                        </li>
                        <li>/</li>
                        <li>
                            <a href="{{route('userdashboard')}}" class="hover:underline hover:text-blue-600">My Orders</a>
                        </li>
                        <li>/</li>
                        <li class="text-gray-800 font-medium">Order #12345</li>
                    </ol>
                </nav>

                <!-- progress bar-->
                <h3 class="text-2xl font-bold mb-6 text-gray-800">Order Status</h3>
                <div class="flex items-center space-x-6">
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 rounded-full bg-green-500 border-2 border-green-700"></div>
                        <span class="text-lg font-medium text-gray-700">Order Placed</span>
                    </div>
                    <span class="text-xl text-gray-500">&rarr;</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 rounded-full bg-gray-300 border-2 border-gray-400"></div>
                        <span class="text-lg font-medium text-gray-500">Processing</span>
                    </div>
                    <span class="text-xl text-gray-500">&rarr;</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 rounded-full bg-gray-300 border-2 border-gray-400"></div>
                        <span class="text-lg font-medium text-gray-500">Waiting</span>
                    </div>
                    <span class="text-xl text-gray-500">&rarr;</span>
                    <div class="flex items-center space-x-2">
                        <div class="w-6 h-6 rounded-full bg-gray-300 border-2 border-gray-400"></div>
                        <span class="text-lg font-medium text-gray-500">Paid</span>
                    </div>
                </div>

                <!--  Details -->
                <div class="mt-12 bg-white p-6 shadow-lg rounded-xl border border-gray-200">
                    <h3 class="text-xl font-bold mb-4 text-gray-800">Package Details</h3>
                    <div class="grid grid-cols-3 border-b pb-3 font-semibold text-gray-600">
                        <div>Package Name</div>
                        <div>Date Availed</div>
                        <div>Price</div>
                    </div>
                    <div class="grid grid-cols-3 pt-3 text-gray-700 text-lg font-medium">
                        <div>Set A</div>
                        <div>March 6, 2025</div>
                        <div class="text-green-600">₱16,800</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</body>
</html>