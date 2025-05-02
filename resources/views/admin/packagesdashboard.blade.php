<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Packages Dashboard</title>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="{{ asset('js/toprightalert.js') }}"></script>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>



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
            showSuccessToast('{{ session('success') }}');
        </script>
    @endif

    @if (session('error'))
        <script>
            showErrorToast('{{ session('error') }}');
        </script>
    @endif

    <div class="flex h-screen bg-gray-50">
        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-6">
                {{-- <x-dashboard.header /> --}}

                <div class="container mx-auto mb-8">




                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-5 gap-4 mb-8">

                        {{-- MENU ITEM BTN ULAM --}}
                        <x-packages.add-package-item-btn :items="$items" :itemOptions="$itemOptions" :categories="$categories" />
                        {{-- ITEM OPTION BTN --}}
                        {{-- <x-items.add-item-option  /> --}}

                        {{-- PACKAGE BTN --}}
                        <x-packages.add-btn :categories="$categories" :items="$items" :utilities="$utilities" />

                        {{-- PARTY TRAY BTN --}}
                        <x-items.item-button :categories="$categories" />

                        {{-- UTIL BTN --}}
                        <x-packages.add-package-utility  :packages="$packages" :utilities="$utilities" :package-utilities="$package_utilities"/>
                    </div>

                    <!-- Item Management Sections in tabs -->
                    <div id="item-management" class="bg-white rounded-xl shadow-sm border border-gray-100 mb-8">
                        <div class="border-b border-gray-100">
                            <nav class="flex" aria-label="Tabs">
                                <button
                                    class=" cursor-pointer px-6 py-4 text-sm font-medium text-blue-600 border-b-2 border-blue-600"
                                    id="items-tab">
                                    Menu Items
                                </button>
                                <button
                                    class="cursor-pointer px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300"
                                    id="options-tab">
                                    Item Options
                                </button>
                                {{-- <button
                                    class="cursor-pointer px-6 py-4 text-sm font-medium text-gray-500 hover:text-gray-700 border-b-2 border-transparent hover:border-gray-300"
                                    id="optionsparty-tab">
                                    Link Options to Ulam
                                </button> --}}
                            </nav>
                        </div>

                        <div class="p-6" id="items-content">
                            <h2 class="text-lg font-semibold text-gray-800">Ulam Management</h2>
                            <x-items.item-list :items="$items" />
                        </div>

                        <div class="p-6 hidden" id="options-content">
                            <x-items.item-options-list :itemOptions="$itemOptions" :categories="$categories"/>
                        </div>



                    </div>

                    <!-- Package Management Section -->
                    <div id="package-management" class=" bg-white rounded-xl shadow-sm p-6 border border-gray-100 mb-8">


                        <!-- Tab Navigation -->
                        <div class="mb-4">
                            <ul class="flex space-x-4 border-b-2">
                                <li class="cursor-pointer text-gray-600 py-2 px-4 hover:text-blue-500" id="tab1-button"
                                    onclick="switchTab(1)">Package</li>
                                <li class="cursor-pointer text-gray-600 py-2 px-4 hover:text-blue-500"
                                    id="tab2-button" onclick="switchTab(2)">Utility</li>
                                <li class="cursor-pointer text-gray-600 py-2 px-4 hover:text-blue-500"
                                    id="tab3-button" onclick="switchTab(3)">Party Tray</li>
                            </ul>
                        </div>

                        <!-- Tab Content -->
                        <div class="tab-content hidden" id="tab1-content">
                            <!-- Package Management Content for Tab 1 -->
                            <h2 class="text-lg font-semibold text-gray-800 text-center">Package Management</h2>
                            {{-- <x-packages.add-btn :categories="$categories" /> --}}
                            <div class="flex justify-center items-center mb-6">


                                <x-dashboard.packages />
                            </div>
                            <div class="space-x-2">
                                <x-packages.link-item-package :packages="$packages" :items="$items" />
                            </div>
                        </div>
                        {{-- UTILITY MANAGEMENT --}}
                        <div class="tab-content hidden " id="tab2-content">
                            <h2 class="text-lg font-semibold text-gray-800">Utility Management</h2>
                            {{-- <x-packages.add-package-utility /> --}}
                            <x-utility.utilitylist :packages="$packages" :utilities="$utilities" :package-utilities="$package_utilities" />
                            {{-- <x-packages.link-util-package :packages="$packages" /> --}}
                        </div>
                        {{-- PARTY TRAY --}}
                        <div class="tab-content hidden" id="tab3-content">
                            <h2 class="text-lg font-semibold text-gray-800">Party Tray Management</h2>
                            {{-- <x-items.item-button :categories="$categories" /> --}}
                            {{-- PARTY TRAY LIST --}}
                            <x-dashboard.products :categories="$categories" :menuItems="$menuItems" />
                        </div>

                    </div>
                </div>
            </main>
        </div>

    </div>

    <script>
        function switchTab(tabNumber) {
            const tabContents = document.querySelectorAll('.tab-content');
            tabContents.forEach(content => content.classList.add('hidden'));

            const tabButtons = document.querySelectorAll('ul li');
            tabButtons.forEach(button => button.classList.remove('text-blue-500', 'border-b-2', 'border-blue-500'));


            document.getElementById(`tab${tabNumber}-content`).classList.remove('hidden');

            const tabButton = document.getElementById(`tab${tabNumber}-button`);
            tabButton.classList.add('text-blue-500', 'border-b-2', 'border-blue-500');
        }


        switchTab(1);

        document.addEventListener('DOMContentLoaded', function() {
            const itemsTab = document.getElementById('items-tab');
            const optionsTab = document.getElementById('options-tab');
            const itemsContent = document.getElementById('items-content');
            const optionsContent = document.getElementById('options-content');

            const itemSelectLinker = document.getElementById('itemSelectLinker');
            // TAB FUNCTIONS
            itemsTab.addEventListener('click', function() {
                itemsTab.classList.add('text-blue-600', 'border-blue-600');
                itemsTab.classList.remove('text-gray-500', 'border-transparent');
                optionsTab.classList.add('text-gray-500', 'border-transparent');
                optionsTab.classList.remove('text-blue-600', 'border-blue-600');

                itemsContent.classList.remove('hidden');
                optionsContent.classList.add('hidden');
            });

            optionsTab.addEventListener('click', function() {
                optionsTab.classList.add('text-blue-600', 'border-blue-600');
                optionsTab.classList.remove('text-gray-500', 'border-transparent');
                itemsTab.classList.add('text-gray-500', 'border-transparent');
                itemsTab.classList.remove('text-blue-600', 'border-blue-600');

                optionsContent.classList.remove('hidden');
                itemsContent.classList.add('hidden');
            });



            if (itemSelectLinker) {
                itemSelectLinker.addEventListener('change', function() {
                    const selectedItemIdLinker = this.value;
                    const itemOptionsSelectLinker = document.getElementById('itemOptionsSelectLinker');

                    // Clear previous disables and reset option text
                    Array.from(itemOptionsSelectLinker.options).forEach(option => {
                        option.disabled = false;
                        option.textContent = option.textContent.replace(" (Already in this Item)",
                            "");
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
                                    if (existingOptionsLinker.includes(parseInt(option
                                            .value))) {
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
