<div class="bg-white p-4 max-w-sm  flex flex-col items-center justify-center rounded-lg shadow-md mt-5">
    <h2 class="text-xl font-semibold mb-4">Add Category</h2>

    {{-- nagp-point to sa category controller -> pati models  --}}
    <form method="POST" action="{{ route('categories.addCategory') }}">
        @csrf
        <label for="name" class="block text-gray-700 font-medium">Category Name</label>
        <input type="text" id="name" name="name" required
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

        <label for="description" class="block text-gray-700 font-medium">Description</label>
        <textarea id="description" name="description" rows="3"
            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>

        <button type="submit" class="bg-blue-500 text-white px-4 w-full py-2 rounded-lg hover:bg-blue-600 hover:cursor-pointer">
            Save Category
        </button>
    </form>
</div>
