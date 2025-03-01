<nav class="holder">
    <div class="items flex justify-center gap-20 py-4 my-2 bg-red-100 text-sm font-normal">
        <a href="#" class="filter-link active" data-category="all">Show All</a>
        @foreach ($categories as $category)
            <a href="#" class="filter-link" data-category="{{ $category->id }}">{{ $category->name }}</a>
        @endforeach
    </div>
</nav>

<div class="container mx-auto px-4">
    <h2 class="text-center font-bold text-6xl">ALL MENU</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-10" id="menu-container">
        @foreach ($menuItems as $item)
            <div class="menu-item bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col h-full"
                data-category="{{ $item->category_id }}">
                <div class="h-48 overflow-hidden">
                    <img class="w-full h-full object-cover rounded-t-lg"
                        src="{{ asset('ItemsStored/' . $item->image) }}" alt="{{ $item->name }}" />
                </div>

                <div class="p-4 flex-grow">
                    <p class="font-extrabold text-gray-700 dark:text-gray-400">{{ $item->name }}</p>
                    <p class="mt-2 font-normal text-gray-700 dark:text-gray-400">{{ $item->description }}</p>
                </div>

                <div class="p-4 mt-auto">
                    <button type="button"
                        class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">
                        Add Order
                    </button>
                </div>
            </div>
        @endforeach
    </div>

    {{-- if empty yung category --}}
    <div id="empty" class="hidden text-center mt-10 text-lg font-bold text-gray-700">
        No items available in this category.
    </div>
</div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const filterLinks = document.querySelectorAll('.filter-link');
        const menuItems = document.querySelectorAll('.menu-item');
        const emptyMessage = document.getElementById('empty');

        filterLinks.forEach(link => {
            link.addEventListener('click', function(e) {
                e.preventDefault();
                filterLinks.forEach(l => l.classList.remove('active'));
                this.classList.add('active');//  active class sa clicked link

                
                const selectedCategory = this.dataset.category; // kukunin nya ung selected category
                let visibleCount = 0;

                // filtering
                menuItems.forEach(item => {
                    const itemCategory = item.dataset.category;
                    if (selectedCategory === 'all' || itemCategory === selectedCategory) {
                        item.style.display = 'flex'; 
                        visibleCount++;
                    } else {
                        item.style.display = 'none';
                    }
                });

                // display ng message if wla
                if (visibleCount === 0) {
                    emptyMessage.classList.remove('hidden');
                } else {
                    emptyMessage.classList.add('hidden');
                }
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
</style>
