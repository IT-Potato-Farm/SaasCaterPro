<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</head>

<body class="bg-gray-500  p-5">
    <h1>ADMIN DASHBOARD</h1>

    <h2>Welcome, {{}}</h2>

    <button data-modal-target="categoryModal" data-modal-toggle="categoryModal"
        class="bg-blue-500 text-white px-4 py-2 rounded-lg shadow-md hover:bg-blue-600 transition hover:cursor-pointer">
        Add Category
    </button>

    <!-- Modal -->
    <div id="categoryModal" tabindex="-1" aria-hidden="true"
        class="fixed top-0 left-0 right-0 z-50 hidden w-full p-4 overflow-x-hidden overflow-y-auto md:inset-0 h-[calc(100%-1rem)] max-h-full">

        <div class="relative w-full max-w-md ">
            <!-- Modal Content -->
            <div class="relative bg-white rounded-lg shadow-lg p-6">
                <!-- Modal Header -->
                <div class="flex justify-between items-center border-b pb-2 mb-4">
                    <h3 class="text-xl font-semibold text-gray-900">Add Category</h3>
                    <button type="button"
                        class="text-gray-400 bg-transparent hover:bg-gray-200 rounded-lg text-sm p-1.5 ml-auto inline-flex items-center"
                        data-modal-hide="categoryModal">
                        ✖
                    </button>
                </div>

                <!-- Form -->
                <form action="/add-category" method="POST">
                    @csrf
                    <div class="mb-4">
                        <label for="name" class="block text-sm font-medium text-gray-600">Category Name</label>
                        <input type="text" name="name" id="name" required
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400">
                    </div>

                    <div class="mb-4">
                        <label for="description" class="block text-sm font-medium text-gray-600">Description</label>
                        <textarea name="description" id="description" rows="3"
                            class="w-full px-3 py-2 border rounded-lg focus:ring-2 focus:ring-blue-400"></textarea>
                    </div>

                    <!-- Modal Footer -->
                    <div class="flex justify-end">
                        <button type="button"
                            class="bg-gray-400 text-white px-4 py-2 rounded-lg hover:bg-gray-500 transition"
                            data-modal-hide="categoryModal">
                            Close
                        </button>
                        <button type="submit"
                            class="ml-2 bg-green-500 text-white px-4 py-2 rounded-lg hover:bg-green-600 transition">
                            Add
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>






    <table class="mt-5 border w-full p-5">
        <thead>
            <tr>
                <th>Firstname</th>
                <th>Lastname</th>
                <th>Email</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </tbody>
    </table>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
