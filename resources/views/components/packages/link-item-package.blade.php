
@props(['items', 'packages'])

<form action="{{ route('admin.addItemToPackage') }}" method="POST" class="space-y-6" onsubmit="return validateForm(event)">
    @csrf
    <!-- Package Dropdown -->
    <div class="space-y-2">
        <h1 class="font-bold text-3xl">ASSIGN ITEMS TO A PACKAGE</h1>
        <label for="packageSelect" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">Select
            Package</label>
        <select name="package_id" id="packageSelect" required
            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200 ease-in-out">
            <option value="" class="text-gray-400">-- Choose a Package --</option>
            @foreach ($packages as $package)
                <option value="{{ $package->id }}" class="text-gray-700">{{ $package->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Item Dropdown -->
    <div class="space-y-2">
        <label for="itemSelect" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">Select
            Food</label>
        <select name="item_id" id="itemSelect" required
            class="w-full px-4 py-3 border-2 border-gray-200 rounded-xl shadow-sm focus:outline-none focus:border-blue-500 focus:ring-1 focus:ring-blue-500 transition-all duration-200 ease-in-out">
            <option value="" class="text-gray-400">-- Choose an Item --</option>
            @foreach ($items as $item)
                <option value="{{ $item->id }}" class="text-gray-700">{{ $item->name }}</option>
            @endforeach
        </select>
    </div>

    <!-- Item Option Selection -->
    <div class="space-y-2" id="item-options-container" style="display:none;">
        <label for="itemOptionSelect" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">Select
            Item Options</label>
        <div id="item-options" class="space-y-2"></div>
        <p class="text-xs text-gray-400 mt-2 flex items-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-4 w-4 mr-1" viewBox="0 0 20 20" fill="currentColor">
                <path fill-rule="evenodd"
                    d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z"
                    clip-rule="evenodd" />
            </svg>
            Hold Ctrl/Cmd to select multiple options
        </p>
    </div>

    <button type="submit"
        class="w-full bg-gradient-to-r from-blue-600 to-blue-500 hover:from-blue-700 hover:to-blue-600 text-white font-semibold py-3 px-6 rounded-xl shadow-md hover:shadow-lg transition-all duration-200 transform hover:-translate-y-0.5 hover:cursor-pointer">
        Link Item to Package
    </button>
</form>


<script>
    const itemSelect = document.getElementById('itemSelect');
    const packageSelect = document.getElementById('packageSelect');
    const optionsContainer = document.getElementById('item-options-container');
    const optionsElement = document.getElementById('item-options');
    const form = document.querySelector('form[action*="addItemToPackage"]');

    

    function loadItemOptions() {
        const itemId = itemSelect.value;
        const packageId = packageSelect.value;

        if (!itemId || !packageId) {
            optionsContainer.style.display = 'none';
            return;
        }

        fetch(`/items/${itemId}/available-options?package_id=${packageId}`)
            .then(response => response.json())
            .then(data => {
                if (data.success) {
                    optionsElement.innerHTML = ''; // Clear existing options

                    data.options.forEach(option => {
                        const optionLabel = document.createElement('label');
                        optionLabel.classList.add('flex', 'items-center', 'space-x-2');

                        const optionInput = document.createElement('input');
                        optionInput.type = 'checkbox';
                        optionInput.name = 'item_option_ids[]';
                        optionInput.value = option.id;
                        optionInput.classList.add('mr-2', 'form-checkbox', 'text-blue-500');

                        if (option.already_linked) {
                            optionInput.disabled = true;
                            optionInput.setAttribute('aria-disabled', 'true');

                            const disabledText = document.createElement('span');
                            disabledText.textContent =
                                `${option.type} (already included in the selected package)`;
                            disabledText.classList.add('text-gray-400', 'italic');

                            optionLabel.appendChild(optionInput);
                            optionLabel.appendChild(disabledText);
                        } else {
                            optionLabel.appendChild(optionInput);
                            optionLabel.appendChild(document.createTextNode(option.type));
                        }

                        optionsElement.appendChild(optionLabel);
                    });

                    optionsContainer.style.display = 'block';
                } else {
                    optionsContainer.style.display = 'none';
                }
            })
            .catch(error => {
                console.error('Error fetching item options:', error);
                alert('An error occurred while loading options.');
                optionsContainer.style.display = 'none';
            });
    }

    // LIVE CHANGES ON DROPDOWN
    itemSelect.addEventListener('change', loadItemOptions);

    // Update options live if package is changed but item is already selected
    packageSelect.addEventListener('change', function() {
        itemSelect.disabled = !this.value;

        if (itemSelect.value) {
            loadItemOptions();
        }
    });

    function validateForm(event) {
        if (optionsContainer.style.display !== 'none') {
            const checkboxes = document.querySelectorAll('input[name="item_option_ids[]"]:not([disabled])');
            
            if (checkboxes.length > 0) {
                const checkedBoxes = Array.from(checkboxes).filter(box => box.checked);
                
                if (checkedBoxes.length === 0) {
                    let errorMsg = document.getElementById('options-error');
                    if (!errorMsg) {
                        errorMsg = document.createElement('p');
                        errorMsg.id = 'options-error';
                        errorMsg.classList.add('text-red-500', 'text-sm', 'mt-1');
                        errorMsg.textContent = 'Please select at least one option.';
                        optionsContainer.appendChild(errorMsg);
                    }
                    
                    optionsContainer.classList.add('border', 'border-red-500', 'p-3', 'rounded');
                    
                    return false;
                }
            }
        }
        return true;
    }

    optionsElement.addEventListener('change', function() {
        const errorMsg = document.getElementById('options-error');
        if (errorMsg) {
            errorMsg.remove();
        }
        
        optionsContainer.classList.remove('border', 'border-red-500', 'p-3', 'rounded');
    });
</script>
