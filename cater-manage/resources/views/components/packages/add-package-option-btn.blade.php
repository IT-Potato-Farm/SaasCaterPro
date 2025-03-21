<style>
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
        font-weight: bold;
    }
    .preview-container {
        margin-top: 5px;
        font-weight: bold;
        color: #3b82f6;
    }
    .loading-spinner {
        display: inline-block;
        width: 16px;
        height: 16px;
        border: 2px solid rgba(59, 130, 246, 0.3);
        border-top: 2px solid #3b82f6;
        border-radius: 50%;
        animation: spin 0.6s linear infinite;
        margin-left: 8px;
    }
    @keyframes spin {
        to { transform: rotate(360deg); }
    }
</style>


<script>
    function addFoodItemOption() {
        let optionTypeExists = false; 

        Swal.fire({
            title: '<span class="text-2xl font-bold text-gray-800">Add Food Item Option</span>',
            html: `
                <form id="addFoodItemOptionForm" class="grid grid-cols-1 gap-6" enctype="multipart/form-data">
                    <!-- Package Item Dropdown -->
                    <div>
                        <label for="foodItemSelect" class="block text-sm font-medium text-gray-700">Select Package Item</label>
                        <select name="package_food_item_id" id="foodItemSelect" required class="w-full border rounded p-2">
                            <option value="">Choose a Package Item</option>
                            @foreach($packageItems as $item)
                                <option value="{{ $item->id }}">{{ $item->name }}</option>
                            @endforeach
                        </select>
                        <div id="package_food_item_id-error" class="error-message"></div>
                    </div>
                    
                    <!-- Option Type with Live Preview & Duplicate Check -->
                    <div>
                        <label for="optionType" class="block text-sm font-medium text-gray-700">Option Type</label>
                        <input type="text" id="optionType" name="type" required class="w-full border rounded p-2">
                        <div id="type-error" class="error-message"></div>
                        
                        <span id="loadingSpinner" class="loading-spinner" style="display: none;"></span>
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
                const typeInput = document.getElementById('optionType');
                const foodItemSelect = document.getElementById('foodItemSelect');
                const livePreview = document.getElementById('livePreview');
                const loadingSpinner = document.getElementById('loadingSpinner');

                // Live Preview
                // typeInput.addEventListener('input', function() {
                //     livePreview.textContent = `Live Preview: ${this.value}`;
                // });

                // Real-time Duplicate Check
                typeInput.addEventListener('input', async function() {
                    const optionType = this.value.trim();
                    const packageFoodItemId = foodItemSelect.value;

                    if (optionType !== "" && packageFoodItemId !== "") {
                        loadingSpinner.style.display = "inline-block";

                        let response = await fetch(`/check-option-type?package_food_item_id=${packageFoodItemId}&type=${optionType}`);
                        let data = await response.json();

                        if (!data.available) {
                            document.getElementById('type-error').textContent = 'This option type already exists for the selected package item.';
                            optionTypeExists = true; // Prevent submission
                        } else {
                            document.getElementById('type-error').textContent = '';
                            optionTypeExists = false; // Allow submission
                        }

                        loadingSpinner.style.display = "none";
                    }
                });
            },
            preConfirm: async () => {
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                let hasErrors = false;
                
                // Validate Package Item selection
                const foodItemSelect = document.getElementById('foodItemSelect');
                if (!foodItemSelect.value) {
                    document.getElementById('package_food_item_id-error').textContent = 'Please select a package item.';
                    hasErrors = true;
                }
                
                // Validate Option Type
                const typeInput = document.getElementById('optionType');
                if (!typeInput.value.trim()) {
                    document.getElementById('type-error').textContent = 'Option type is required.';
                    hasErrors = true;
                }

                // Block submission if the option type already exists
                if (optionTypeExists) {
                    document.getElementById('type-error').textContent = 'This option type already exists.';
                    return false; // Stop 
                }

                if (hasErrors) return false;

                // Proceed with form submission with successs
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
                                        const errorEl = document.getElementById(`${field}-error`);
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
