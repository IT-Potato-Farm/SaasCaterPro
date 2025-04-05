<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packages Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#fef2f2',
                iconColor: '#dc2626',
                color: '#7f1d1d',
                timerProgressBar: true,
                showClass: {
                    popup: 'swal2-show animate-slide-in'
                },
                hideClass: {
                    popup: 'swal2-hide animate-slide-out'
                }
            });
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
                <x-packages.add-package-utility />


                {{-- LINK ITEM OPTION TO ITEM (EX. FRIED, BUTTERED -> CHICKEN) --}}
                <div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6">
                    <h2 class="text-xl font-bold mb-4 text-center">Link Item Options to Item</h2>
                
                    <form action="{{ route('items.linkItemOption') }}" method="POST">
                        @csrf
                
                        <!-- Item Dropdown -->
                        <div class="mb-4">
                            <select name="item_id" id="itemSelect" required class="w-full border rounded p-2">
                                <option value="">Select Item</option>
                                @if($items->isEmpty())
                                    <option value="" disabled>No items available</option>
                                @else
                                    @foreach ($items as $item)
                                        <option value="{{ $item->id }}">{{ $item->name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                
                        <!-- Item Option Dropdown -->
                        <div class="mb-4">
                            <label for="itemOptionsSelect" class="block text-sm font-medium text-gray-700">Select Item Options</label>
                            <select name="item_option_ids[]" id="itemOptionsSelect" multiple required class="w-full border rounded p-2">
                                @if($itemOptions->isEmpty())
                                    <option value="" disabled>No item options available</option>
                                @else
                                    @foreach ($itemOptions as $option)
                                        <option value="{{ $option->id }}">
                                            {{ $option->type }} 
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                            <small class="text-gray-500">Hold Ctrl (Windows) or Command (Mac) to select multiple.</small>
                        </div>
                
                        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Link Item Option</button>
                    </form>
                </div>



                <x-dashboard.packages />

                {{-- all items list like chicken, beef, and etc  --}}
                <x-items.item-list />

                {{-- item options --}}
                <x-items.item-options-list />


                



            </main>
        </div>


    </div>
    
    <script>
       document.getElementById('itemSelect').addEventListener('change', function() {
    var itemId = this.value;
    var itemOptionsSelect = document.getElementById('itemOptionsSelect');

    // Clear previous disables and reset option text
    Array.from(itemOptionsSelect.options).forEach(option => {
        option.disabled = false;
        option.textContent = option.textContent.replace(" (Already in this Item)", "");
    });

    if (itemId) {
        // Fetch existing item options for the selected item
        fetch(`/items/${itemId}/existing-options`)
            .then(response => response.json())
            .then(existingOptions => {
                Array.from(itemOptionsSelect.options).forEach(option => {
                    if (existingOptions.includes(parseInt(option.value))) {
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
