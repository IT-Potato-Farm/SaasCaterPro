<script src="{{ asset('js/addPackageToCart.js') }}"></script>


<nav class="holder">
    <div class="items flex justify-center gap-20 py-4 my-2 bg-red-100 text-sm font-normal">
        <a href="#" class="filter-link active" data-category="all">Show All</a>
        <a href="#" class="filter-link" data-category="packages">Packages</a>
        @foreach ($categories as $category)
            <a href="#" class="filter-link" data-category="{{ $category->id }}">{{ $category->name }}</a>
        @endforeach
    </div>
    
</nav>

<div class="container mx-auto px-4">
    {{-- Packages Section --}}

    @if ($packages->isNotEmpty())
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-8 mt-8">
            @foreach ($packages as $package)
                <div
                    class="group bg-white dark:bg-gray-800 rounded-xl shadow-lg hover:shadow-2xl transition-shadow duration-300 border border-gray-100 dark:border-gray-700 overflow-hidden transform hover:-translate-y-2 transition-transform">
                    <div class="relative h-56">
                        <img src="{{ asset('storage/packagepics/' . $package->image) }}" alt="{{ $package->name }}"
                            class="w-full h-full object-fill transition-transform duration-300 group-hover:scale-105" />
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-gray-900 p-4">
                            <h3 class="text-2xl font-bold text-white">{{ $package->name }}</h3>
                        </div>
                    </div>

                    <div class="p-6 flex flex-col h-full">
                        <div class="flex-grow">
                            <p class="text-gray-600 dark:text-gray-300 mb-4 line-clamp-3">
                                {{ $package->description }}
                            </p>

                            <div class="space-y-3 mb-6">
                                <div
                                    class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Price per
                                        Pax</span>
                                    <span class="text-lg font-bold text-blue-600 dark:text-blue-400">
                                        ₱{{ number_format($package->price_per_person, 2) }}
                                    </span>
                                </div>

                                <div
                                    class="flex items-center justify-between p-3 bg-gray-50 dark:bg-gray-700 rounded-lg">
                                    <span class="text-sm font-medium text-gray-600 dark:text-gray-300">Minimum
                                        Pax</span>
                                    <span class="text-lg font-bold text-purple-600 dark:text-purple-400">
                                        {{ $package->min_pax }}
                                    </span>
                                </div>
                            </div>
                            <button type="button" onclick="openItem({{ $package->id }})"
                                class="mt-4 w-full bg-gradient-to-r from-blue-600 to-purple-600 hover:from-blue-700 hover:to-purple-700 text-white font-semibold py-3 px-6 rounded-lg transition-all duration-300 transform hover:scale-[1.02]">
                                Show More Details
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="text-center py-12">
            <div class="inline-flex flex-col items-center">
                <svg class="w-24 h-24 text-gray-400 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
                </svg>
                <h3 class="text-xl font-semibold text-gray-500 dark:text-gray-400">
                    No available packages at the moment
                </h3>
                <p class="text-gray-500 dark:text-gray-400 mt-2">
                    Check back later for new packages!
                </p>
            </div>
        </div>
    @endif
    {{-- Menu Items Section --}} @if ($menuItems->count())
        <div class="mt-10">
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="menu-container">
                @foreach ($menuItems as $item)
                    <div class="menu-item bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 flex flex-col h-full hover:shadow-xl transition-shadow duration-300"
                        data-category="{{ $item->category_id }}">

                        <!-- Menu Item Image -->
                        <div class="h-48 overflow-hidden rounded-t-lg">
                            <img class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                                src="{{ asset('storage/party_traypics/' . $item->image) }}" alt="{{ $item->name }}"
                                loading="lazy">
                        </div>

                        <!-- Menu Item Details -->
                        <div class="p-4 flex-grow">
                            <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">{{ $item->name }}
                            </h3>
                            <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 mb-3">
                                {{ $item->description }}</p>

                            <p
                                class="text-sm font-semibold 
                                {{ $item->status == 'available' ? 'text-green-500' : 'text-red-500' }}">
                                {{ ucfirst($item->status) }}
                            </p>

                            @php
                                $pricingTiers = $item->pricing; // assuming pricing is cast to array in the MenuItem model
                            @endphp
                            @if (is_array($pricingTiers) && count($pricingTiers) > 1)
                                <div class="mb-3">
                                    <label for="variant-{{ $item->id }}"
                                        class="block text-sm font-medium text-gray-200">Select Pax Range:</label>
                                    <select name="variant" id="variant-{{ $item->id }}"
                                        class="mt-1 block w-full p-2 border border-gray-300 rounded">
                                        @foreach ($pricingTiers as $variant => $price)
                                            <option value="{{ $variant }}">{{ $variant }}
                                                (₱{{ number_format($price, 2) }})
                                            </option>
                                        @endforeach
                                    </select>
                                </div>
                            @endif
                        </div>

                        <!-- Add to Cart for Menu Items -->
                        <div class="p-4 pt-0 mt-auto">
                            <button type="button" onclick="addToCart({{ $item->id }})"
                                class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-medium py-2.5 px-5 rounded-lg transition-colors duration-200 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                                Add to Cart
                            </button>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    {{-- Empty State --}}
    @if ($menuItems->isEmpty() && $packages->isEmpty())
        <div class="text-center mt-20 text-lg font-bold text-gray-700">
            No items available.
        </div>
    @endif

    <!-- Filtered Empty Message -->
    <div id="empty" class="hidden text-center mt-10 text-lg font-bold text-gray-700">
        No items available in this category.
    </div>
</div>















<script>
   document.addEventListener('DOMContentLoaded', function () {
    const filterLinks = document.querySelectorAll('.filter-link');
    const menuItems = document.querySelectorAll('.menu-item');
    const packageContainer = document.querySelector('.grid.grid-cols-1.sm\\:grid-cols-2.lg\\:grid-cols-3.gap-8.mt-8');
    const menuContainer = document.getElementById('menu-container');
    const emptyMessage = document.getElementById('empty');

    filterLinks.forEach(link => {
        link.addEventListener('click', function (e) {
            e.preventDefault();
            filterLinks.forEach(l => l.classList.remove('active'));
            this.classList.add('active');

            const selectedCategory = this.dataset.category;
            let visibleCount = 0;

            // Handle packages visibility
            if (packageContainer) {
                if (selectedCategory === 'all' || selectedCategory === 'packages') {
                    packageContainer.style.display = 'grid';
                    visibleCount += packageContainer.querySelectorAll('.group').length;
                } else {
                    packageContainer.style.display = 'none';
                }
            }

            // Handle menu items visibility
            if (menuContainer) {
                if (selectedCategory === 'packages') {
                    menuContainer.style.display = 'none';
                } else {
                    menuContainer.style.display = 'grid';
                    
                    // Filter menu items by category
                    menuItems.forEach(item => {
                        const itemCategory = item.dataset.category;
                        if (selectedCategory === 'all' || itemCategory === selectedCategory) {
                            item.style.display = 'flex';
                            visibleCount++;
                        } else {
                            item.style.display = 'none';
                        }
                    });
                }
            }

            // Show/hide empty message
            emptyMessage.classList.toggle('hidden', visibleCount > 0);
        });
    });
});
</script>

<style>
    .filter-link {
        cursor: pointer;
        transition: color 0.3s ease;
        padding: 8px 12px;
        border-radius: 4px;
    }

    .filter-link.active {
        background-color: #ef4444;
        color: white;
        font-weight: 500;
    }

    .filter-link:not(.active):hover {
        color: #ef4444;
    }

    .line-clamp-3 {
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
</style>
