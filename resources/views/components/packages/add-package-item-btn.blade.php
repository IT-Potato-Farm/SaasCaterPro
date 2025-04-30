<style>
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<script>
    function addItem() {

        Swal.fire({
            title: '<span class="text-xl font-semibold text-gray-800">Add Ulam Item</span>',
            html: `
            <form id="addItemForm" class="space-y-6 p-6 bg-white rounded-lg shadow-md">
            <!-- Item Name -->
            <div>
                <label for="swal-name" class="block text-sm font-medium text-gray-700 mb-2">Item Name</label>
                <input type="text" id="swal-name" name="name" required 
                    class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                <div id="name-error" class="mt-1 text-xs text-red-500"></div>
            </div>

            <!-- Description -->
            <div>
                <label for="swal-description" class="block text-sm font-medium text-gray-700 mb-2">Description <span class="text-gray-400 font-normal">(Optional)</span></label>
                <textarea id="swal-description" name="description" rows="4"
                    class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"></textarea>
                <div id="description-error" class="mt-1 text-xs text-red-500"></div>
            </div>

           <div>
                <label for="swal-category" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                <select id="swal-category" name="category_id" required
                    class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md">
                    <option value="" disabled selected>Select a Tag</option>
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}">{{ $category->name }}</option>
                    @endforeach
                </select>
                <div id="category-error" class="mt-1 text-xs text-red-500"></div>
            </div>
           
           

            <!-- Options -->
            <div>
                <label for="swal-options" class="block text-sm font-medium text-gray-700 mb-1">Link Options to this Item <span class="text-gray-400 font-normal">(Optional)</span></label>
                <button type="button" id="add-new-option" onclick="addItemOption()" class="text-blue-600 text-sm hover:underline cursor-pointer">+ Add New Option</button>
                <select id="swal-options" name="options[]" multiple
                    class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <!-- Options will be populated dynamically -->
                </select>
                <div id="options-error" class="error-message mt-1 text-xs text-red-500"></div>
            </div>
        </form>
        `,
            showCancelButton: true,
            confirmButtonText: 'Add Item',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            customClass: {
                popup: 'rounded-lg max-w-md mx-4', // Responsive width with side margins
                confirmButton: 'px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm',
                cancelButton: 'px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium border border-gray-300 rounded-md shadow-sm'
            },
            width: 'auto', // Auto width for better responsiveness
            backdrop: 'rgba(0, 0, 0, 0.4)',
            didOpen: () => {
                const categorySelect = document.getElementById('swal-category');
                const optionsSelect = document.getElementById('swal-options');

                // Load categories first
                fetch('/item-categories')
                    .then(response => response.json())
                    .then(categories => {
                        categorySelect.innerHTML = '<option value="">Select a Tag</option>';
                        categories.forEach(cat => {
                            const option = new Option(cat.name, cat.id);
                            categorySelect.appendChild(option);
                        });

                        // Initialize select2 after options are populated
                        $(categorySelect).select2({
                            placeholder: 'Select a Tag',
                            allowClear: true,
                            width: '100%',
                            dropdownParent: $('.swal2-popup')
                        });

                        // Initialize select2 for options
                        $(optionsSelect).select2({
                            placeholder: 'Select Options',
                            width: '100%',
                            dropdownParent: $('.swal2-popup')
                        });

                        // Important: Use select2's change event, not the native one
                        $(categorySelect).on('change', function() {
                            const categoryId = $(this).val();
                            if (categoryId) {
                                loadOptionsForCategory(categoryId);
                            } else {
                                // Clear options if no category is selected
                                $(optionsSelect).empty().trigger('change');
                            }
                        });
                    })
                    .catch(error => console.error('Error loading categories:', error));


                

                const nameInput = document.getElementById('swal-name');
                const nameError = document.getElementById('name-error');

                async function validateName() {
                    const nameValue = nameInput.value.trim();

                    if (nameValue.length > 0) {
                        try {
                            const response = await fetch("{{ route('items.checkName') }}", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    name: nameValue
                                })
                            });

                            const data = await response.json();
                            if (data.exists) {
                                nameError.textContent = 'This item name is already taken.';
                                nameInput.dataset.valid = "false"; // Mark as invalid
                            } else {
                                nameError.textContent = '';
                                nameInput.dataset.valid = "true"; // Mark as valid
                            }
                        } catch (error) {
                            console.error("Error checking name:", error);
                        }
                    } else {
                        nameError.textContent = '';
                        nameInput.dataset.valid = "true"; // Default to valid if empty
                    }
                }

                nameInput.addEventListener('input', validateName);
            },
            preConfirm: async () => {
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                const form = document.getElementById('addItemForm');
                const formData = new FormData(form);
                let hasErrors = false;

                const nameInput = document.getElementById('swal-name');
                if (!nameInput.value.trim()) {
                    document.getElementById('name-error').textContent = 'Item name is required.';
                    hasErrors = true;
                }

                // Ensure the name is valid before submitting
                if (nameInput.dataset.valid === "false") {
                    document.getElementById('name-error').textContent = 'This item name is already taken.';
                    hasErrors = true;
                }

                if (hasErrors) return false;

                return fetch("{{ route('items.store') }}", {
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
                    });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Item Added!',
                    text: 'The item has been successfully created.',
                    timer: 2000
                }).then(() => location.reload());
            }
        });
    }

    function loadOptionsForCategory(categoryId) {
        const optionsSelect = document.getElementById('swal-options');

        // Clear existing options first
        $(optionsSelect).empty();

        // Show loading state
        $(optionsSelect).append(new Option('Loading options...', '')).prop('disabled', true);

        // Make AJAX request
        fetch(`/api/item-options?category=${categoryId}`)
            .then(response => {
                if (!response.ok) {
                    throw new Error('Failed to load options');
                }
                return response.json();
            })
            .then(data => {
                // Re-enable and clear the select
                $(optionsSelect).empty().prop('disabled', false);

                // Add the options
                if (data.length === 0) {
                    $(optionsSelect).append(new Option('No options available for this category', '')).prop(
                        'disabled', true);
                } else {
                    data.forEach(option => {
                        const optionText = `${option.type} (${option.category_name})`;  
                        const newOption = new Option(optionText, option.id, false, false);
                        $(optionsSelect).append(newOption);
                    });
                }

                // Refresh Select2
                $(optionsSelect).trigger('change');
            })
            .catch(error => {
                console.error('Error loading options:', error);
                $(optionsSelect).empty()
                    .append(new Option('Error loading options', ''))
                    .prop('disabled', true)
                    .trigger('change');
            });
    }

    
    function addItemOption() {
        Swal.fire({
            title: '<span class="text-xl font-semibold text-gray-800">Add Item Option</span>',
            html: `
        <form id="addItemOptionForm" class="space-y-4">
            <!-- Image Upload & Preview -->
            <div class="flex flex-col items-center space-y-3">
                <div id="imagePreviewContainer" class="hidden w-full">
                    <img id="imagePreview" src="#" alt="Preview" class="mx-auto h-32 w-32 object-contain rounded-lg border border-gray-200">
                </div>
                <label class="w-full">
                    <div class="flex flex-col items-center justify-center py-3 px-4 border-2 border-dashed border-gray-300 rounded-lg cursor-pointer hover:bg-gray-50 transition">
                        <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span class="text-sm text-gray-600 mt-1">Click to upload image</span>
                        <span class="text-xs text-gray-400">(Optional)</span>
                    </div>
                    <input type="file" id="swal-image" name="image" accept="image/*" class="hidden" onchange="previewAddImage(event)">
                </label>
                <div id="image-error" class="text-xs text-red-500"></div>
            </div>

            <!-- Type -->
            <div>
                <label for="swal-type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                <input type="text" id="swal-type" name="type" required 
                    class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                <div id="type-error" class="mt-1 text-xs text-red-500"></div>
            </div>

            <!-- Description -->
            <div>
                <label for="swal-description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-gray-400 font-normal">(Optional)</span></label>
                <textarea id="swal-description" name="description" rows="3"
                    class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"></textarea>
                <div id="description-error" class="mt-1 text-xs text-red-500"></div>
            </div>
            <!-- Link Items -->
                <div>
                    <label for="swal-items" class="block text-sm font-medium text-gray-700 mb-1">Link to Items (optional)</label>
                    <select id="swal-items" name="items[]" multiple
                        class="w-full item-select px-3 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        @foreach ($items as $item)
                            <option value="{{ $item->id }}">{{ $item->name }}</option>
                        @endforeach
                    </select>
                    <div id="items-error" class="mt-1 text-xs text-red-500"></div>
                </div>
                
        </form>
    `,
            showCancelButton: true,
            confirmButtonText: 'Add Option',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            customClass: {
                popup: 'rounded-lg max-w-md mx-4',
                confirmButton: 'px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm',
                cancelButton: 'px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium border border-gray-300 rounded-md shadow-sm'
            },
            width: 'auto',
            backdrop: 'rgba(0, 0, 0, 0.4)',
            didOpen: () => {
                const typeInput = document.getElementById('swal-type');
                const typeError = document.getElementById('type-error');

                async function validateType() {
                    const typeValue = typeInput.value.trim();
                    if (typeValue.length > 0) {
                        try {
                            const response = await fetch("{{ route('itemOptions.checkType') }}", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    type: typeValue
                                })
                            });

                            const data = await response.json();
                            console.log(data);
                            if (data.exists) {
                                typeError.textContent = 'This item option type is already taken.';
                                typeInput.dataset.valid = "false";
                            } else {
                                typeError.textContent = '';
                                typeInput.dataset.valid = "true";
                            }
                        } catch (error) {
                            console.error("Error checking type:", error);
                        }
                    } else {
                        typeError.textContent = '';
                        typeInput.dataset.valid = "true";
                    }
                }

                typeInput.addEventListener('input', validateType);

                
            },
            preConfirm: async () => {
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                const form = document.getElementById('addItemOptionForm');
                const formData = new FormData(form);
                let hasErrors = false;

                const typeInput = document.getElementById('swal-type');
                if (!typeInput.value.trim()) {
                    document.getElementById('type-error').textContent = 'Type is required.';
                    hasErrors = true;
                }

                // Ensure the type is valid before submitting
                if (typeInput.dataset.valid === "false") {
                    document.getElementById('type-error').textContent =
                        'This item option type is already taken.';
                    hasErrors = true;
                }

                if (hasErrors) return false;

                return fetch("{{ route('itemOptions.store') }}", {
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
                    });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: 'Item Option Added!',
                    text: 'The item option has been successfully added.',
                    timer: 2000
                }).then(() => location.reload());
            }
        });
    }

    function previewAddImage(event) {
        const input = event.target;
        const previewContainer = document.getElementById('imagePreviewContainer');
        const previewImage = document.getElementById('imagePreview');

        if (input.files && input.files[0]) {
            const reader = new FileReader();

            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }

            reader.readAsDataURL(input.files[0]);
        } else {
            previewContainer.classList.add('hidden');
        }
    }

</script>

<button onclick="addItem()"
    class="cursor-pointer group bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition-all flex items-center gap-4 hover:border-blue-200 hover:bg-blue-50">
    <div
        class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600 group-hover:bg-blue-200 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
        </svg>
    </div>
    <div class="text-left">
        <h3 class="font-medium text-gray-800 group-hover:text-blue-700">Add Item</h3>
        <p class="text-xs text-gray-500">Create new items</p>
    </div>
</button>
