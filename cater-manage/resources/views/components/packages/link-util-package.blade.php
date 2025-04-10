<form action="{{ route('admin.addUtilToPackage') }}" method="POST" class="space-y-6" onsubmit="return validateForm(event)">
    @csrf
    <!-- Package Dropdown -->
    <div class="space-y-2">
        <h1 class="font-bold text-3xl">ASSIGN UTILS TO A PACKAGE</h1>
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

    <!-- Utility Selection -->
    <div class="space-y-2" id="item-options-container" style="display:none;">
        <label for="utilitySelect" class="block text-sm font-semibold text-gray-700 uppercase tracking-wide">Select
            Utilities</label>
        <div id="util-options" class="space-y-2"></div>
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
        Link UTILS to Package
    </button>
</form>

<script>
document.getElementById('packageSelect').addEventListener('change', function () {
    const packageId = this.value;
    const utilOptionsContainer = document.getElementById('util-options');
    const itemOptionsContainer = document.getElementById('item-options-container');

    if (!packageId) {
        utilOptionsContainer.innerHTML = ''; 
        itemOptionsContainer.style.display = 'none';
        return;
    }

    itemOptionsContainer.style.display = 'block';

    fetch(`/get-utilities-for-package?package_id=${packageId}`)
        .then(response => response.json())
        
        .then(data => {
            console.log(data);
            const utilities = data.utilities;
            const linkedUtilities = data.linked_utilities;

            utilOptionsContainer.innerHTML = ''; // Clear existing options

            utilities.forEach(util => {
                const optionLabel = document.createElement('label');
                optionLabel.classList.add('flex', 'items-center', 'space-x-2');

                const optionInput = document.createElement('input');
                optionInput.type = 'checkbox';
                optionInput.name = 'utility_ids[]';
                optionInput.value = util.id;
                optionInput.classList.add('mr-2', 'form-checkbox', 'text-blue-500');

                // If the utility is linked to the package, disable it and mark as checked
                if (linkedUtilities.includes(util.id)) {
                    optionInput.checked = true;
                    optionInput.disabled = true;
                    optionInput.setAttribute('aria-disabled', 'true');

                    const disabledText = document.createElement('span');
                    disabledText.textContent = `${util.name} (already linked to the selected package)`;
                    disabledText.classList.add('text-gray-400', 'italic');

                    optionLabel.appendChild(optionInput);
                    optionLabel.appendChild(disabledText);
                } else {
                    optionLabel.appendChild(optionInput);
                    optionLabel.appendChild(document.createTextNode(util.name));
                }

                utilOptionsContainer.appendChild(optionLabel);
            });
        })
        .catch(error => {
            console.error('Error fetching utilities:', error);
            alert('An error occurred while loading utilities.');
        });
});

</script>
