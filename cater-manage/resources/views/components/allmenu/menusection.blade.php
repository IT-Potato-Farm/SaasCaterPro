<script src="{{ asset('js/cart.js') }}"></script>

<nav class="holder">
    <div class="items flex justify-center gap-20 py-4 my-2 bg-red-100 text-sm font-normal">
        <a href="#" class="filter-link active" data-category="all">Show All</a>
        @foreach ($categories as $category)
            <a href="#" class="filter-link" data-category="{{ $category->id }}">{{ $category->name }}</a>
        @endforeach
    </div>
</nav>

<div class="container mx-auto px-4">
    {{-- Packages Section --}}
    @if($packages->count())
    <div class="mt-10">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="packages-container">
            
            @foreach ($packages as $package)
            <div class="package-item bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 flex flex-col h-full hover:shadow-xl transition-shadow duration-300"
                data-category="{{ $package->category_id }}">
                
                <!-- Package Image -->
                <div class="h-48 overflow-hidden rounded-t-lg">
                    <img class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                        src="{{ asset('packagePics/' . $package->image) }}"
                        alt="{{ $package->name }}" loading="lazy">
                </div>

                <!-- Package Details -->
                <div class="p-4 flex-grow">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">{{ $package->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 mb-3">{{ $package->description }}</p>
                </div>

                <!-- Add to Cart Button -->
                <div class="p-4 pt-0 mt-auto">
                    <button type="button" onclick="addToCart({{ $package->id }}, 'package')"
                        class="w-full bg-blue-600 hover:bg-blue-700 dark:bg-blue-500 dark:hover:bg-blue-600 text-white font-medium py-2.5 px-5 rounded-lg transition-colors duration-200 focus:ring-2 focus:ring-blue-300 focus:outline-none">
                        Add to Cart
                    </button>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- Menu Items Section --}}
    @if($menuItems->count())
    <div class="mt-10">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="menu-container">
            
            @foreach ($menuItems as $item)
            <div class="menu-item bg-white border border-gray-200 rounded-lg shadow-lg dark:bg-gray-800 dark:border-gray-700 flex flex-col h-full hover:shadow-xl transition-shadow duration-300"
                data-category="{{ $item->category_id }}">
                
                <!-- Menu Item Image -->
                <div class="h-48 overflow-hidden rounded-t-lg">
                    <img class="w-full h-full object-cover hover:scale-105 transition-transform duration-300"
                        src="{{ asset('ItemsStored/' . $item->image) }}"
                        alt="{{ $item->name }}" loading="lazy">
                </div>

                <!-- Menu Item Details -->
                <div class="p-4 flex-grow">
                    <h3 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-2">{{ $item->name }}</h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm line-clamp-3 mb-3">{{ $item->description }}</p>
                </div>
                
                {{-- incre and decre --}}
                {{-- <div class="px-4 pb-4">
                    <div class="flex items-center justify-between bg-gray-50 dark:bg-gray-700 rounded-lg p-2">
                        <button type="button" onclick="decrementQuantity(this)"
                            class="quantity-btn flex items-center justify-center h-8 w-8 rounded-full bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 font-bold transition-colors duration-200">
                            -
                        </button>
                        <span id="quantity"
                            class="quantity text-lg font-semibold text-gray-800 dark:text-gray-100 min-w-[2rem] text-center">0</span>
                        <button type="button" onclick="incrementQuantity(this)"
                            class="quantity-btn flex items-center justify-center h-8 w-8 rounded-full bg-gray-100 dark:bg-gray-600 hover:bg-gray-200 dark:hover:bg-gray-500 text-gray-700 dark:text-gray-200 font-bold transition-colors duration-200">
                            +
                        </button>
                    </div>
                </div> --}}

                <!-- Add to Cart for menu items -->
                <div class="p-4 pt-0 mt-auto">
                    <button id="allmenubtn" type="button" onclick="addToCart({{ $item->id }})"
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
    document.addEventListener('DOMContentLoaded', function() {
        const filterLinks = document.querySelectorAll('.filter-link');
        const packageItems = document.querySelectorAll('.package-item');
        const menuItems = document.querySelectorAll('.menu-item');
        const emptyMessage = document.getElementById('empty');

        filterLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                filterLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');

                const selectedCategory = this.dataset.category;
                let visibleCount = 0;

                // Handle packages
                packageItems.forEach(item => {
                    const itemCategory = item.dataset.category;
                    if (selectedCategory === 'all' || itemCategory === selectedCategory) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // Handle menu items
                menuItems.forEach(item => {
                    const itemCategory = item.dataset.category;
                    if (selectedCategory === 'all' || itemCategory === selectedCategory) {
                        item.style.display = 'flex';
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                
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