@php
    use Illuminate\Support\Str;
@endphp
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Search results for {{ $query }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        async function addSelectedPackageToCart(packageId, event) {
            event.preventDefault();
            const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
            const form = document.getElementById('packageSelectionForm');
            const checkboxes = form.querySelectorAll('input[type="checkbox"]');
            const groups = {};

            // Group checkboxes by food item id.
            checkboxes.forEach(checkbox => {
                const name = checkbox.name; // e.g., "food_item_5[]"
                const match = name.match(/food_item_(\d+)\[\]/);
                if (match) {
                    const foodId = match[1];
                    if (!groups[foodId]) {
                        groups[foodId] = [];
                    }
                    groups[foodId].push(checkbox);
                }
            });

            // Validate that each food item group has at least one option checked.
            for (const foodId in groups) {
                const groupCheckboxes = groups[foodId];
                const checked = Array.from(groupCheckboxes).filter(cb => cb.checked);
                if (checked.length === 0) {
                    Swal.fire({
                        icon: 'error',
                        title: 'Validation Error',
                        text: 'Please select at least one option for every food item.'
                    });
                    return; // Stop submission if any food item has no option selected.
                }
            }

            // If validation passes, collect selected options with a simpler structure (array of IDs).
            const selectedOptions = {};
            checkboxes.forEach(checkbox => {
                if (checkbox.checked) {
                    const foodIdMatch = checkbox.name.match(/food_item_(\d+)/);
                    if (foodIdMatch) {
                        const foodId = foodIdMatch[1];
                        if (!selectedOptions[foodId]) {
                            selectedOptions[foodId] = [];
                        }
                        // Just push the checkbox value (option ID).
                        selectedOptions[foodId].push(checkbox.value);
                    }
                }
            });

            try {
                const response = await fetch('/cart/add', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': csrfToken,
                        'Accept': 'application/json'
                    },
                    body: JSON.stringify({
                        package_id: packageId,
                        quantity: 1,
                        selected_options: selectedOptions // e.g., { "5": [ "1", "3" ] }
                    })
                });

                if (!response.ok) {
                    const errorData = await response.json();
                    throw new Error(errorData.message || 'Something went wrong.');
                }

                const data = await response.json();

                Swal.fire({
                    position: 'top-end',
                    icon: 'success',
                    title: '<span class="text-gray-200">Added to Cart!</span>',
                    text: data.message || 'Package added to your cart.',
                    timer: 2000,
                    showConfirmButton: false,
                    background: '#1F2937',
                    color: '#E5E7EB',
                    toast: true
                });
            } catch (error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: error.message,
                    confirmButtonText: 'OK'
                });
            }
        }
    </script>
</head>

<body>
    <x-customer.navbar />
    <div class="max-w-7xl mx-auto px-4 py-6">
        <h2 class="text-xl font-semibold mb-4">Search Results for "{{ $query }}"</h2>

        @if ($menuItems->isEmpty() && $packages->isEmpty())
            <p class="text-gray-600">No results found.</p>
        @endif

        @if ($menuItems->isNotEmpty())
            <h3 class="text-lg font-semibold mt-4">Menu Items</h3>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4 mt-2">
                @foreach ($menuItems as $item)
                    <div class="bg-white p-4 shadow rounded">
                        <img src="{{ asset('storage/party_traypics/' . $item->image) }}" alt="{{ $item->name }}"
                            class="w-full h-56 object-cover  object-center rounded mb-2">

                        <h4 class="font-bold">{{ $item->name }}</h4>
                        <p>{{ $item->description }}</p>
                        <p class="text-sm text-gray-500">₱{{ number_format($item->price, 2) }}</p>
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
                            <img src="{{ asset('storage/packagePics/' . $package->image) }}" alt="{{ $package->name }}"
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

                    {{-- DISPLAY NA AGAD INFO NG PACKAGE  --}}
                    <div class="bg-white p-4 shadow rounded">
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
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</body>

</html>
