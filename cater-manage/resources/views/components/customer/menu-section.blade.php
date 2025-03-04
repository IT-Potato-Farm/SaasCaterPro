<script>
    
    function openItem(id) {
        console.log("Fetching menu details for ID:", id);

        Swal.fire({
            title: 'Loading...',
            html: '<div class="flex justify-center"><div class="animate-spin rounded-full h-12 w-12 border-t-2 border-b-2 border-gray-400"></div></div>',
            showConfirmButton: false,
            showCloseButton: false,
            allowOutsideClick: false,
            customClass: {
                popup: 'rounded-none shadow-lg'
            }
        });

        fetch(`/menu-details/${id}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! Status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log("Menu Data:", data);

                if (!Array.isArray(data.items)) {
                    throw new Error("Invalid menu items format.");
                }

                let itemsString = data.items.join(', ');

                Swal.fire({
                    html: `
                        <div class="flex flex-col md:flex-row w-full">
                            <!--img lefft side-->
                            <div class="w-full md:w-1/2 bg-gray-100 p-6 flex items-center justify-center">
                                <img src="${data.image}" class="max-h-64 object-contain" alt="${data.name}">
                            </div>
                            
                            <!-- product details -->
                            <div class="w-full md:w-1/2 p-6">
                                
                                <h2 class="text-xl font-normal text-gray-800 mb-1">${data.name}</h2>
                                
                                <!-- Price -->
                                <p class="text-lg font-normal text-gray-800 mb-3">₱${data.price}</p>
                                
                                <!-- Description -->
                                <p class="text-sm text-gray-600 mb-4">${data.description}</p>
                                
                                <div class="mt-2 mb-5 text-sm text-gray-500">
                                    <p>Category: ${data.category}</p>
                                </div>
                                <!-- quantity and add to cart btn -->
                                <div class="flex items-center">
                                    <div class="flex items-center border border-gray-300 mr-2">
                                        <button onclick="decrementQuantity()" class="px-3 py-1 bg-white text-gray-600 hover:bg-gray-100">-</button>
                                        <input type="text" id="quantity" value="0" class="w-10 text-center border-none focus:outline-none" readonly>
                                        <button onclick="incrementQuantity()" class="px-3 py-1 bg-white text-gray-600 hover:bg-gray-100">+</button>
                                    </div>
                                    <button onclick="addToCart(${id})" class="bg-red-400 hover:bg-red-500 text-white font-normal py-2 px-4 flex-grow">
                                        ADD TO CART
                                    </button>
                                </div>
                                
                                
                                
                            </div>
                        </div>
                    `,
                    showCloseButton: true,
                    showConfirmButton: false,
                    customClass: {
                        popup: 'rounded-none shadow-xl max-w-4xl m-0 p-0',
                        htmlContainer: 'p-0 m-0'
                    },
                    buttonsStyling: false,
                    width: 'auto'
                });
            })
            .catch(error => {
                console.error("Error fetching menu details:", error);
                Swal.fire({
                    title: "Error",
                    text: "Failed to fetch menu details. Please try again.",
                    icon: "error",
                    confirmButtonText: 'Try Again',
                    customClass: {
                        confirmButton: 'bg-red-400 hover:bg-red-500 text-white font-normal py-2 px-6'
                    },
                    buttonsStyling: false
                });
            });
    }

    

    function addToCart(id) {
        const quantityInput = document.getElementById('quantity');
        let quantity = parseInt(quantityInput.value, 10);
        if (quantity <= 0) {
            Swal.fire({
                icon: 'error',
                title: 'Oops...',
                text: 'Please select at least 1 item!',
                showConfirmButton: false,
                timer: 1500
            });
            return;
        }
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: `${quantity} item(s) added to cart`,
            showConfirmButton: false,
            timer: 1500,
            toast: true,
            customClass: {
                popup: 'rounded-none shadow-xl'
            }
        });

        console.log(`Adding ${quantity} of item ${id} to cart`);
        quantityInput.value = "0";
    }

    function decrementQuantity() {
        const input = document.getElementById('quantity');
        const value = parseInt(input.value, 10);
        if (value > 0) {
            input.value = value - 1;
        }
    }

    function incrementQuantity() {
        const input = document.getElementById('quantity');
        const value = parseInt(input.value, 10);
        input.value = value + 1;
    }
</script>



<section id="menu" class="menu-section py-12 min-h-screen">
    <h2 class="text-center font-bold text-4xl md:text-5xl lg:text-6xl mt-2 px-4">MENU</h2>

    <div class="container mx-auto px-4">
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6 mt-8">
            @foreach ($packages as $package)
                <div
                    class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col h-full">
                    <a href="#">
                        <img class="w-full h-48 object-cover rounded-t-lg"
                            src="{{ asset('ItemsStored/' . $package->image) }}" alt="{{ $package->name }}" />
                    </a>
                    <div class="p-4 flex-grow flex flex-col">
                        <p class="font-extrabold text-gray-700 dark:text-gray-400">
                            {{ $package->name }}
                        </p>
                        <p class="mt-2 text-gray-700 dark:text-gray-400 flex-grow">
                            {{ $package->description }}
                        </p>
                        <p class="mt-2 text-gray-700 dark:text-gray-400 font-medium">
                            Price: ₱{{ $package->price }}
                        </p>
                        <div class="mt-4 flex justify-center">
                            <button type="button"
                                class="menu-detail-btn w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 transition-colors duration-200"
                                onclick="openItem({{ $package->id }})">
                                Show Details
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="flex justify-center mt-8">
        <a href="{{ url('/all-menus') }}"
            class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-6 py-2.5 inline-flex items-center transition-colors duration-200 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Show All Menus
        </a>
    </div>
</section>
