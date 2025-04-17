<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packages Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/toprightalert.js') }}"></script>
    <script>
        
        let packageItemsMapping = @json($packageItemsGroupedByPackage);
        console.log(packageItemsMapping);

        function confirmDelete(button) {
            Swal.fire({
                title: 'Are you sure you want to delete this package?',
                text: "This action cannot be undone.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonText: 'Yes, delete it!',
                cancelButtonText: 'No, cancel!',
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
            }).then((result) => {
                if (result.isConfirmed) {
                    button.closest('form').submit();
                }
            });
        }
    </script>
</head>

<body>
    


    @if(session('success'))
    <script>
        showSuccessToast('{{ session('success') }}');
    </script>
    @endif
    
    @if(session('error'))
    <script>
        showErrorToast('{{ session('error') }}');
    </script>
    @endif

    <div class="flex h-screen">

        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <x-dashboard.header />
                <x-packages.add-package-item-btn />
                <x-items.add-item-option />

                <x-packages.addbtn />
                <x-packages.add-package-option-btn />
                
                


                



                <x-dashboard.packages />
                <x-packages.link-item-package />
                {{-- link items to package --}}

                
            
                



                {{-- all items list like chicken, beef, and etc  --}}
                <x-items.item-list />

                {{-- item options --}}
                <x-items.item-options-list />


                {{-- LINK ITEM OPTION TO ITEM (EX. FRIED, BUTTERED -> CHICKEN) --}}
                <div class="max-w-2xl mx-auto bg-white shadow-xl rounded-2xl p-8 space-y-8 transition-all duration-300 hover:shadow-2xl">
                    <header class="space-y-4 border-b border-gray-200 pb-6">
                        <h2 class="text-3xl font-extrabold text-center text-gray-900 bg-clip-text">
                            Link Options to Menu Items
                        </h2>
                        <p class="text-center text-gray-500 text-sm">Manage item customization options</p>
                    </header>

                    {{-- LINK OPTIONS FORM --}}
                    <form action="{{ route('items.linkItemOption') }}" method="POST" class="space-y-6">
                        @csrf

                        <!-- Item Dropdown -->
                        <div class="space-y-2">
                            <label for="itemSelect"
                                class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">Select Food</label>
                            <select name="item_id" id="itemSelectLinker" required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm 
                                    focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500
                                    transition-all duration-200 ease-in-out">
                                <option value="" class="text-gray-400">-- Choose an Item --</option>
                                @if ($items->isEmpty())
                                    <option value="" disabled class="text-gray-400">No items available</option>
                                @else
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}" class="text-gray-700">{{ $item->name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <!-- Item Option Dropdown -->
                        <div class="space-y-2">
                            <label for="itemOptionsSelect"
                                class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">
                                Select which item option to add in the items
                            </label>
                            <select name="item_option_ids[]" id="itemOptionsSelectLinker" multiple required
                                class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm 
                                       focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500
                                       transition-all duration-200 ease-in-out h-48">
                                @if ($itemOptions->isEmpty())
                                    <option value="" disabled class="text-gray-400">No options available</option>
                                @else
                                    @foreach ($itemOptions as $option)
                                        <option value="{{ $option->id }}" class="text-gray-700">{{ $option->type }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <p class="text-xs text-gray-400 mt-2 flex items-center">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20"
                                    fill="currentColor">
                                    <path fill-rule="evenodd"
                                        d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                                        clip-rule="evenodd" />
                                </svg>
                                Hold Ctrl/Cmd to select multiple options
                            </p>
                        </div>

                        <button type="submit"
                            class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 
                                   text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg
                                   transition-all duration-200 transform hover:-translate-y-0.5 hover:cursor-pointer">
                            Link Selected Options
                        </button>
                    </form>

                    {{-- LINKED OPTIONS DISPLAY AND UNLINK OPTIONS TO THE ITEMS--}}
                    @if ($items->isNotEmpty())
                        <div class="space-y-6">
                            @foreach ($items as $item)
                                @if ($item->itemOptions->isNotEmpty())
                                    <div
                                        class="bg-blue-50 border-2 border-blue-100 rounded-xl p-6 group hover:border-blue-200 transition-colors duration-200">
                                        <div class="flex items-center justify-between mb-4">
                                            <h3 class="text-lg font-bold text-blue-900">{{ $item->name }}</h3>
                                            <span class="bg-blue-100 text-blue-800 text-sm px-3 py-1 rounded-full">
                                                {{ $item->itemOptions->count() }} linked options
                                            </span>
                                        </div>

                                        <ul class="space-y-3">
                                            @foreach ($item->itemOptions as $option)
                                                <li
                                                    class="flex justify-between items-center bg-white border border-gray-200 rounded-lg px-4 py-3 
                                                          hover:border-blue-200 hover:shadow-sm transition-all duration-200">
                                                    <div class="flex items-center space-x-3">
                                                        <svg xmlns="http://www.w3.org/2000/svg"
                                                            class="h-5 w-5 text-gray-400" viewBox="0 0 20 20"
                                                            fill="currentColor">
                                                            <path fill-rule="evenodd"
                                                                d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z"
                                                                clip-rule="evenodd" />
                                                        </svg>
                                                        <span class="text-gray-700">{{ $option->type }}</span>
                                                    </div>
                                                    <form action="{{ route('items.unlinkItemOption') }}"
                                                        method="POST">
                                                        @csrf
                                                        <input type="hidden" name="item_id"
                                                            value="{{ $item->id }}">
                                                        <input type="hidden" name="item_option_id"
                                                            value="{{ $option->id }}">
                                                        <button type="submit"
                                                            class="text-red-500 hover:text-red-700 hover:cursor-pointer font-medium text-sm 
                                                                   flex items-center space-x-1 transition-colors duration-200">
                                                            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4"
                                                                viewBox="0 0 20 20" fill="currentColor">
                                                                <path fill-rule="evenodd"
                                                                    d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                                    clip-rule="evenodd" />
                                                            </svg>
                                                            <span>Remove</span>
                                                        </button>
                                                    </form>
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                @endif
                            @endforeach
                        </div>
                    @endif
                </div>





            </main>
        </div>


    </div>

    <script>
    
    document.addEventListener('DOMContentLoaded', function() {
    const itemSelectLinker = document.getElementById('itemSelectLinker');
    
    if (itemSelectLinker) {
        itemSelectLinker.addEventListener('change', function() {
            const selectedItemIdLinker= this.value;
            const itemOptionsSelectLinker = document.getElementById('itemOptionsSelectLinker');
            
            // Clear previous disables and reset option text
            Array.from(itemOptionsSelectLinker.options).forEach(option => {
                option.disabled = false;
                option.textContent = option.textContent.replace(" (Already in this Item)", "");
            });
            
            if (selectedItemIdLinker) {
                // Fetch existing item options for the selected item
                fetch(`/items/${selectedItemIdLinker}/existing-options`)
                    .then(response => {
                        if (!response.ok) {
                            throw new Error('Network response was not ok');
                        }
                        return response.json();
                    })
                    .then(existingOptionsLinker => {
                        console.log('Existing options:', existingOptionsLinker);
                        
                        Array.from(itemOptionsSelectLinker.options).forEach(option => {
                            if (existingOptionsLinker.includes(parseInt(option.value))) {
                                option.disabled = true;
                                option.textContent += " (Already in this Item)";
                            }
                        });
                    })
                    .catch(error => {
                        console.error('Error fetching item options:', error);
                    });
            }
        });
    } else {
        console.error('Item select element not found');
    }
});
    </script>









    {{-- <script>
        // When the Item dropdown changes
        document.getElementById('itemSelect').addEventListener('change', function() {
            const itemId = this.value;
            const itemOptionsSelect = document.getElementById('itemOptionsSelect');
    
            // Clear previous options
            itemOptionsSelect.innerHTML = '';
    
            if (itemId) {
                // Generate the route URL using Laravel's route() helper
                const routeUrl = `{{ route('item-options.fetch', ':itemId') }}`.replace(':itemId', itemId);
    
                // Fetch item options based on the selected item
                fetch(routeUrl)
                    .then(response => response.json())
                    .then(data => {
                        // If there are item options, populate the dropdown
                        if (data.options.length > 0) {
                            data.options.forEach(option => {
                                const optionElement = document.createElement('option');
                                optionElement.value = option.id;
                                optionElement.textContent = option.type;
                                itemOptionsSelect.appendChild(optionElement);
                            });
                        } else {
                            // If no options are available for the selected item, show a message
                            const optionElement = document.createElement('option');
                            optionElement.textContent = 'No options available';
                            itemOptionsSelect.appendChild(optionElement);
                        }
                    })
                    .catch(error => {
                        console.error('Error fetching item options:', error);
                    });
            }
        });
    </script> --}}
</body>

</html>
