<div id="menuModal" class="hidden fixed inset-0 flex items-center justify-center backdrop-blur-xs z-50">
    <div class="relative p-4 w-full max-w-4xl bg-white bg-opacity-90 rounded-lg shadow-lg dark:bg-gray-700 dark:bg-opacity-90">

        
        <div class="flex justify-between p-4 border-b dark:border-gray-600">
            <h3 class="text-2xl font-semibold text-gray-900 dark:text-white">
                SET A - ₱3,500 (for 10 pax)
            </h3>
            <button onclick="closeModal()" class="text-gray-400 hover:bg-gray-200 rounded-lg w-8 h-8 dark:hover:bg-gray-600 flex justify-center items-center cursor-pointer">
                <svg class="w-4 h-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 14 14">
                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M1 1l6 6m0 0l6 6m-6-6l6-6m-6 6L1 13"/>
                </svg>
            </button>
        </div>

        <!-- Modal description -->
        <div class="flex gap-6 p-4">
            <div class="w-1/2">
                <img src="{{ asset('images/food1.jpg') }}" class="w-full rounded-lg">
            </div>
            <div class="w-1/2">
                <ul class="list-disc list-inside text-gray-700 dark:text-white space-y-1">
                    <li>1 Appetizer: Garlic Bread</li>
                    <li>1 Main Course: Paella Singaporean Chili Crabs</li>
                    <li>1 Side Dish: Buttered Vegetables</li>
                    <li>1 Dessert: Leche Flan</li>
                    <li>1 Beverage: Iced Tea</li>
                </ul>
                <button class="mt-6 text-white bg-blue-700 hover:bg-blue-800 font-medium rounded-lg px-8 py-3.5">
                    Add to cart
                </button>
            </div>
        </div>
    </div>
</div>

<script>
    function openModal() {
        document.getElementById("menuModal").classList.remove("hidden");
    }

    function closeModal() {
        document.getElementById("menuModal").classList.add("hidden");
    }
</script>
