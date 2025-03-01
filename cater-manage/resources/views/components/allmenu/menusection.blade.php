<div class="container mx-auto px-4">
    <h2 class="text-center font-bold text-6xl mt-20">ALL MENU</h2>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mt-10">
        @foreach($menuItems as $item)
            <div class="bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700 flex flex-col h-full">
                <div class="h-48 overflow-hidden">
                    <img class="w-full h-full object-cover rounded-t-lg" src="{{ asset('ItemsStored/' . $item->image) }}" alt="{{ $item->name }}" />
                </div>
                
                <div class="p-4 flex-grow">
                    <p class="font-extrabold text-gray-700 dark:text-gray-400">{{ $item->name }}</p>
                    <p class="mt-2 font-normal text-gray-700 dark:text-gray-400">{{ $item->description }}</p>
                </div>

                <div class="p-4 mt-auto">
                    <button type="button" class="w-full text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-5 py-2.5 dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800 cursor-pointer">
                        Add Order
                    </button>
                </div>
            </div>
        @endforeach
    </div>
</div>