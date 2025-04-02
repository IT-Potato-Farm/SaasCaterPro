<style>
    

    .preview-container {
        margin-top: 5px;
        font-weight: bold;
        color: #3b82f6;
    }

    @keyframes spin {
    to { transform: rotate(360deg); }
}

.loading-spinner {
    width: 16px;
    height: 16px;
    border: 2px solid rgba(59, 130, 246, 0.3);
    border-top: 2px solid #3b82f6;
    border-radius: 50%;
    animation: spin 0.6s linear infinite;
}
</style>

<script>
    
    let optionTypeExists = false; // global flag for duplicate check

    function addFoodItemOption() {
        Swal.fire({
            title: '<span class="text-2xl font-bold text-gray-800">Add Food Item Option</span>',
            html: `
                <form id="addFoodItemOptionForm" class="grid grid-cols-1 gap-6" enctype="multipart/form-data">
                    <!-- Package Dropdown -->
                    <div>
                        <label for="packageSelect" class="block text-sm font-medium text-gray-700">Select Package</label>
                        <select name="package_id" id="packageSelect" required class="w-full border rounded p-2">
                            <option value="">Choose a Package</option>
                            @foreach ($packages as $package)
                                <option value="{{ $package->id }}">{{ $package->name }}</option>
                            @endforeach
                        </select>
                        <div id="package_id-error" class="error-message"></div>
                    </div>
                    
                    <!-- Package Item Dropdown -->
                    <div>
                        <label for="foodItemSelect" class="block text-sm font-medium text-gray-700">Select Package Item</label>
                        <select name="package_food_item_id" id="foodItemSelect" required class="w-full border rounded p-2">
                            <option value="">Choose a Package Item</option>
                            <!-- Options will be dynamically populated based on the selected package -->
                        </select>
                        <div id="package_food_item_id-error" class="error-message"></div>
                    </div>
                    
                    <!-- Option Type with Live Preview & Duplicate Check -->
                    <div class="relative">
                        <label for="optionType" class="block text-sm font-medium text-gray-700">Option Type</label>
                        <div class="relative w-full">
                            <input type="text" id="optionType" name="type" required class="w-full border rounded p-2 pr-10">
                            <span id="loadingSpinner" class="loading-spinner hidden absolute right-2 top-1/2 -translate-y-1/2"></span>
                        </div>
                        <div id="type-error" class="error-message text-red-500 text-sm mt-1 font-bold"></div>
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="optionDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="optionDescription" name="description" class="w-full border rounded p-2" placeholder="(Optional)"></textarea>
                        <div id="description-error" class="error-message"></div>
                    </div>
                    
                    <!-- Image Upload with Preview -->
                    <div>
                        <label for="optionImage" class="block text-sm font-medium text-gray-700">Upload Image</label>
                        <input type="file" id="optionImage" name="image" accept="image/*" class="w-full border rounded p-2">
                        <div id="image-error" class="error-message"></div>
                        <img id="optionImagePreview" src="#" alt="Image Preview" style="display:none; max-height:300px; margin-top:10px;" class="rounded border border-dashed border-gray-300">
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Add Option',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#ef4444',
            didOpen: () => {
                const packageSelect = document.getElementById('packageSelect');
                const foodItemSelect = document.getElementById('foodItemSelect');

                // When package is selected, populate package items.
                packageSelect.addEventListener('change', function() {
                    const packageId = this.value;
                    foodItemSelect.innerHTML = '<option value="">Choose a Package Item</option>';
                    if (packageId && packageItemsMapping[packageId]) {
                        packageItemsMapping[packageId].forEach(item => {
                            const option = document.createElement('option');
                            option.value = item.id;
                            option.textContent = item.name;
                            foodItemSelect.appendChild(option);
                        });
                    }
                });

                const typeInput = document.getElementById('optionType');
                const loadingSpinner = document.getElementById('loadingSpinner');
                typeInput.addEventListener('input', async function() {
                    const optionType = this.value.trim();
                    const packageFoodItemId = foodItemSelect.value;
                    if (optionType !== "" && packageFoodItemId !== "") {
                        loadingSpinner.style.display = "inline-block";
                        let response = await fetch(
                            `/check-option-type?package_food_item_id=${packageFoodItemId}&type=${optionType}`
                            );
                        let data = await response.json();
                        if (!data.available) {
                            document.getElementById('type-error').textContent =
                                'This option type already exists for the selected package item.';
                            optionTypeExists = true;
                        } else {
                            document.getElementById('type-error').textContent = '';
                            optionTypeExists = false;
                        }
                        loadingSpinner.style.display = "none";
                    }
                });

                // Optional: Add image preview handler for optionImage
                const optionImageInput = document.getElementById('optionImage');
                optionImageInput.addEventListener('change', function() {
                    const file = this.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            document.getElementById('optionImagePreview').src = e.target.result;
                            document.getElementById('optionImagePreview').style.display =
                                'block';
                        }
                        reader.readAsDataURL(file);
                    }
                });
            },
            preConfirm: async () => {
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                let hasErrors = false;

                // Validate Package selection.
                const packageSelect = document.getElementById('packageSelect');
                if (!packageSelect.value) {
                    document.getElementById('package_id-error').textContent = 'Please select a package.';
                    hasErrors = true;
                }

                // Validate Package Item selection.
                const foodItemSelect = document.getElementById('foodItemSelect');
                if (!foodItemSelect.value) {
                    document.getElementById('package_food_item_id-error').textContent =
                        'Please select a package item.';
                    hasErrors = true;
                }

                // Validate Option Type.
                const typeInput = document.getElementById('optionType');
                if (!typeInput.value.trim()) {
                    document.getElementById('type-error').textContent = 'Option type is required.';
                    hasErrors = true;
                }

                if (optionTypeExists) {
                    document.getElementById('type-error').textContent = 'This option type already exists.';
                    hasErrors = true;
                }

                if (hasErrors) return false;

                const form = document.getElementById('addFoodItemOptionForm');
                const formData = new FormData(form);

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
