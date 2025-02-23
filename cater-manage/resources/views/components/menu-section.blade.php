<section id="menu" class="menu-section">
    <h2 class="text-center font-bold text-6xl mt-20">MENU</h2>
    <div class="cardholder flex p-4 mt-5 justify-center gap-8">
        @foreach([1, 2, 3] as $package)
        <div class="max-w-sm bg-white border border-gray-200 rounded-lg shadow-sm dark:bg-gray-800 dark:border-gray-700">
            <a href="#">
                <img class="rounded-t-lg" src="{{ asset('images/food'.$package.'.jpg') }}" alt="Package {{ $package }}" />
            </a>
            <div class="p-4">
                <p class="font-extrabold text-gray-700 dark:text-gray-400">
                    @switch($package)
                        @case(1) Package A - Classic Delight @break
                        @case(2) Package B - Family Feast @break
                        @case(3) Package C - Grand Banquet @break
                    @endswitch
                </p>
                <p class="mt-2 text-gray-700 dark:text-gray-400">
                    @switch($package)
                        @case(1)
                            Includes 1 appetizer, 2 main courses, 1 dessert, and drinks. Perfect for small gatherings.
                        @break
                        @case(2)
                            A balanced meal with 2 appetizers, 3 main courses, 2 desserts, and drinks. Ideal for family celebrations.
                        @break
                        @case(3)
                            A lavish spread featuring 3 appetizers, 4 main courses, 3 desserts, and unlimited drinks. Great for large events.
                        @break
                    @endswitch
                </p>
                <p class="mt-2 text-gray-700 dark:text-gray-400">
                    (Serves {{ $package == 1 ? '5-10' : ($package == 2 ? '10-15' : '20+') }} people)
                </p>
                <button onclick="showMenuModal()" type="button" 
                        class="menu-detail-btn text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 my-4 ml-3"
                        data-package="{{ $package }}">
                    Show Details
                </button>
            </div>
        </div>
        @endforeach
    </div>

    <div class="showallholder flex justify-center mt-3">
        <a href="/testmenuall" class="text-white bg-blue-700 hover:bg-blue-800 focus:ring-4 focus:outline-none focus:ring-blue-300 font-medium rounded-lg text-sm px-8 py-3.5 inline-flex items-center dark:bg-blue-600 dark:hover:bg-blue-700 dark:focus:ring-blue-800">
            Show All
        </a>
    </div>
</section>

