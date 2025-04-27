@php
    use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="en">


<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Search results for {{ $query }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/partyTrayCart.js') }}"></script>
    {{-- <script src="{{ asset('js/addPackageToCart.js') }}"></script> --}}
    <script src="{{ asset('js/addPackageToCart.js') }}?v={{ filemtime(public_path('js/addPackageToCart.js')) }}"></script>

</head>

<body>
    <x-customer.navbar />
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h2 class="text-xl font-semibold mb-4">Search Results for "{{ $query }}"</h2>

        @if ($menuItems->isEmpty() && $packages->isEmpty())
            <p class="text-gray-600">No results found.</p>
        @endif

        @if ($menuItems->isNotEmpty())
            <h3 class="text-lg font-semibold mt-4">Party Trays</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
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
                                                (₱{{ number_format($price, 2) }})</option>
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
        @endif

        {{-- FOR PACKAGE SEARCHED --}}
        @if ($packages->isNotEmpty())
            <h3 class="text-lg font-semibold mt-6">Packages</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                @foreach ($packages as $package)
                    @php
                        $itemsWithOptions = [];

                        foreach ($package->packageItems as $packageItem) {
                            foreach ($packageItem->options as $option) {
                                $itemOption = $option->itemOption;
                                if ($itemOption) {
                                    // Organizing options by item
                                    $itemsWithOptions[$packageItem->item->name][] = $itemOption;
                                }
                            }
                        }
                    @endphp
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


                    {{-- ----------------------- --}}
                    {{-- DISPLAY NA AGAD INFO NG PACKAGE  --}}
                    {{-- <div class="bg-white p-4 shadow rounded">
                        <img src="{{ asset('storage/packagePics/' . $package->image) }}" alt="{{ $package->name }}"
                            class="w-full h-40 object-cover rounded mb-2">
                        <h4 class="font-bold text-lg">{{ $package->name }}</h4>
                        <p class="text-sm text-gray-700">{{ $package->description }}</p>
                        <p class="text-sm text-gray-500 mt-1">₱{{ number_format($package->price_per_person, 2) }}
                            /person</p>
                        <p class="text-sm text-gray-500">Min pax: {{ $package->min_pax }}</p>

                        <!-- Options: Grouped by Item -->
                        <form id="packageSelectionForm">
                            @foreach ($itemsWithOptions as $itemName => $options)
                                <div class="mt-4">
                                    <span class="font-semibold">{{ $itemName }}:</span>
                                    <div class="space-y-2 mt-2">
                                        @foreach ($options as $option)
                                            <label class="inline-flex items-center space-x-2">
                                                <input type="checkbox" name="food_item_{{ $option->item_id }}[]"
                                                    value="{{ $option->id }}" data-type="{{ $option->type }}"
                                                    class="form-checkbox">
                                                <span class="text-sm">{{ $option->type }}</span>
                                            </label>
                                        @endforeach
                                    </div>
                                </div>
                            @endforeach

                            <!-- Add to Cart Button -->
                            <div class="mt-4">
                                <button type="button" onclick="addSelectedPackageToCart({{ $package->id }}, event)"
                                    class="w-full bg-indigo-600 text-white py-2 px-4 rounded hover:bg-indigo-700 transition">
                                    Add to Cart
                                </button>
                            </div>
                        </form>
                    </div> --}}

                @endforeach
            </div>
        @endif
    </div>
</body>

</html>
