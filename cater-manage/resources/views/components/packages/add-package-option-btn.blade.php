<style>
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function addFoodItemOption() {
        Swal.fire({
            title: '<span class="text-2xl font-bold text-gray-800">Add Food Item Option</span>',
            html: `
                <form id="addFoodItemOptionForm" class="grid grid-cols-1 gap-6" enctype="multipart/form-data">
                    <!-- Package Item Dropdown -->
                    <div>
                        <label for="foodItemSelect" class="block text-sm font-medium text-gray-700">Select Package Item</label>
                        <select name="package_food_item_id" id="foodItemSelect" required class="w-full border rounded p-2">
                            <option value="">Choose a Package Item</option>
                            @foreach ($packageItems as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <div id="package_food_item_id-error" class="error-message"></div>
                    </div>
                    
                    <!-- Option Type -->
                    <div>
                        <label for="optionType" class="block text-sm font-medium text-gray-700">Variant Type</label>
                        <input type="text" id="optionType" name="type" required class="w-full border rounded p-2">
                        <div id="type-error" class="error-message"></div>
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="optionDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="optionDescription" name="description" class="w-full border rounded p-2"></textarea>
                        <div id="description-error" class="error-message"></div>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Add Option',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#ef4444',
            preConfirm: () => {
                // Clear previous error messages
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                const form = document.getElementById('addFoodItemOptionForm');
                const formData = new FormData(form);
                // Debugging: log all form data keys and values
                for (let key of formData.keys()) {
                    console.log(key, formData.get(key));
                }
                let hasErrors = false;

                // Validate Package Item selection
                const foodItemSelect = document.getElementById('foodItemSelect');
                if (!foodItemSelect.value) {
                    document.getElementById('package_food_item_id-error').textContent =
                        'Please select a package item.';
                    hasErrors = true;
                }

                // Validate Option Type
                const typeInput = document.getElementById('optionType');
                if (!typeInput.value.trim()) {
                    document.getElementById('type-error').textContent = 'Option type is required.';
                    hasErrors = true;
                }

                if (hasErrors) return false;

                return fetch("{{ route('package_food_item_options.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: formData
                    })
                    .then(response => {
                        if (!response.ok) {
                            return response.json().then(data => {
                                if (data.errors) {
                                    Object.entries(data.errors).forEach(([field, messages]) => {
                                        const errorEl = document.getElementById(
                                            `${field}-error`);
                                        if (errorEl) {
                                            errorEl.textContent = messages[0];
                                        }
                                    });
                                }
                                throw new Error(data.message || 'An error occurred.');
                            });
                        }
                        return response.json();
                    })
                    .catch(error => {
                        Swal.showValidationMessage(`Request failed: ${error}`);
                        return false;
                    });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Food Item Option Added!',
                    text: 'The food item option has been successfully created.',
                    timer: 2000
                }).then(() => location.reload());
            }
        });
    }
</script>

<button onclick="addFoodItemOption()" class="px-2 py-1 bg-cyan-200 rounded mt-2 hover:cursor-pointer">
    Add a Food Item Option here
</button>
