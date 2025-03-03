{{-- <script>
    function showMenuModal() {
        Swal.fire({
            title: `<h3 class="text-2xl font-semibold text-gray-200">
                        SET A - ₱3,500 (for 10 pax)
                    </h3>`,
            html: `
                <div class="flex gap-6 p-4">
                    <div class="w-1/2">
                        <img src="{{ asset('images/food1.jpg') }}" class="w-full rounded-lg">
                    </div>
                    <div class="w-1/2 text-left">
                        <ul class="list-disc list-inside text-gray-300 space-y-1">
                            <li>1 Appetizer: Garlic Bread</li>
                            <li>1 Main Course: Paella Singaporean Chili Crabs</li>
                            <li>1 Side Dish: Buttered Vegetables</li>
                            <li>1 Dessert: Leche Flan</li>
                            <li>1 Beverage: Iced Tea</li>
                        </ul>
                        <button onclick="addToCart()" class="mt-6 text-white bg-blue-600 hover:bg-blue-700 font-medium rounded-lg px-8 py-3.5">
                            Add to cart
                        </button>
                    </div>
                </div>
            `,
            background: '#1F2937', // (Tailwind bg-gray-800)
            color: '#E5E7EB', //  (Tailwind text-gray-300)
            showCloseButton: true,
            showConfirmButton: false,
            customClass: {
                popup: 'custom-swal-popup',
                title: 'custom-swal-title'
            }
        });
    }

    function addToCart() {
        Swal.fire({
            icon: 'success',
            title: '<span class="text-gray-200">Added to Cart!</span>',
            text: 'SET A has been added to your cart.',
            timer: 2000,
            showConfirmButton: false,
            background: '#1F2937',
            color: '#E5E7EB'
        });
    }
</script>

<style>
    .custom-swal-popup {
        width: 700px !important;
        max-width: 90%;
        border-radius: 10px;
        box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
    }

    .custom-swal-title {
        color: #E5E7EB !important; /* Light gray title */
    }
</style> --}}
