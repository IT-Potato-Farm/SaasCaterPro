<style>
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<script>
    // Store form data globally to persist between modal transitions
    let storedItemFormData = {
        name: '',
        description: '',
        category_id: '',
        options: [] // Store selected option IDs
    };

    function addItem(restoreValues = false) {
        console.log('addItem called, restoreValues:', restoreValues, 'Data:', JSON.stringify(storedItemFormData)); // Debug log

        // --- Define validateName HERE, accessible by both didOpen and preConfirm ---
        async function validateName(inputElement, errorElement) {
            // Add checks to ensure elements exist before using them
            if (!inputElement || !errorElement) {
                 console.error("validateName called without valid input or error element.");
                 return; // Exit if elements are missing
            }
            const nameValue = inputElement.value.trim();
            errorElement.textContent = ''; // Clear previous error
            inputElement.dataset.valid = "true"; // Assume valid initially

            if (nameValue.length > 0) {
                try {
                    const response = await fetch("{{ route('items.checkName') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // More robust CSRF token retrieval
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({ name: nameValue })
                    });

                    if (!response.ok) {
                         // Try to get error details from response body if possible
                         let errorMsg = `HTTP error! status: ${response.status}`;
                         try {
                             const errorData = await response.json();
                             errorMsg = errorData.message || JSON.stringify(errorData);
                         } catch (e) { /* Ignore if response body is not JSON */ }
                        throw new Error(errorMsg);
                    }

                    const data = await response.json();
                    if (data.exists) {
                        errorElement.textContent = 'This item name is already taken.';
                        inputElement.dataset.valid = "false"; // Mark as invalid
                    } else {
                         // Explicitly clear error on success if needed, though it's done at the start
                         // errorElement.textContent = '';
                         inputElement.dataset.valid = "true";
                    }
                } catch (error) {
                    console.error("Error checking name:", error);
                    errorElement.textContent = 'Error checking name availability.'; // Inform user
                    inputElement.dataset.valid = "false"; // Mark invalid on error
                }
            } else {
                // If the field is empty, it's not "taken", but might be required later in preConfirm
                inputElement.dataset.valid = "true"; // Reset validity state
                // No error message needed here as 'required' validation is separate
            }
        }
        // --- End validateName definition ---


        Swal.fire({
            title: '<span class="text-xl font-semibold text-gray-800">Add Ulam Item</span>',
            html: `
            <form id="addItemForm" class="space-y-6 p-6 bg-white rounded-lg shadow-md">
            <!-- Item Name -->
            <div>
                <label for="swal-name" class="block text-sm font-medium text-gray-700 mb-2">Item Name</label>
                <input type="text" id="swal-name" name="name" required
                    class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                <div id="name-error" class="mt-1 text-xs text-red-500 error-message"></div>
            </div>

            <!-- Description -->
            <div>
                <label for="swal-description" class="block text-sm font-medium text-gray-700 mb-2">Description <span class="text-gray-400 font-normal">(Optional)</span></label>
                <textarea id="swal-description" name="description" rows="4"
                    class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-colors"></textarea>
                <div id="description-error" class="mt-1 text-xs text-red-500 error-message"></div>
            </div>

           <div>
                <label for="swal-category" class="block text-sm font-medium text-gray-700 mb-2">Tags</label>
                <select id="swal-category" name="category_id" required
                    class="w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md">
                    <option value="" disabled selected>Select a Tag</option>
                    {{-- Categories will be loaded via JS --}}
                </select>
                <div id="category_id-error" class="mt-1 text-xs text-red-500 error-message"></div>
            </div>

            <!-- Options -->
            <div>
                <label for="swal-options" class="block text-sm font-medium text-gray-700 mb-1">Link Options to this Item <span class="text-gray-400 font-normal">(Optional)</span></label>
                <button type="button" id="add-new-option-btn" onclick="saveAndAddItemOption()" class="text-blue-600 text-sm hover:underline cursor-pointer mb-2 block">+ Add New Option</button>
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
                popup: 'rounded-lg max-w-md mx-4',
                confirmButton: 'px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm',
                cancelButton: 'px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium border border-gray-300 rounded-md shadow-sm'
            },
            width: 'auto',
            backdrop: 'rgba(0, 0, 0, 0.4)',
            didOpen: () => {
                const popup = Swal.getPopup();
                const categorySelect = popup.querySelector('#swal-category');
                const optionsSelect = popup.querySelector('#swal-options');
                const nameInput = popup.querySelector('#swal-name');
                const descriptionTextarea = popup.querySelector('#swal-description');
                const nameError = popup.querySelector('#name-error');

                let categoryLoadingPromise = null;
                let optionLoadingPromise = null;

                // Fetch and Populate Categories
                categoryLoadingPromise = fetch('/item-categories')
                    .then(response => {
                        if (!response.ok) throw new Error('Network response was not ok for categories');
                        return response.json();
                     })
                    .then(categories => {
                        categorySelect.innerHTML = '<option value="" disabled>Select a Tag</option>';
                        categories.forEach(cat => {
                            const option = new Option(cat.name, cat.id);
                            categorySelect.appendChild(option);
                        });
                        console.log('Categories loaded.');
                    }).catch(error => {
                        console.error('Error loading categories:', error);
                        categorySelect.innerHTML = '<option value="">Error loading tags</option>';
                    });

                // Initialize Select2
                categoryLoadingPromise.finally(() => {
                    $(categorySelect).select2({
                        placeholder: 'Select a Tag',
                        allowClear: true,
                        width: '100%',
                        dropdownParent: $(popup)
                    });

                    $(optionsSelect).select2({
                        placeholder: 'Select Options (after choosing a tag)',
                        width: '100%',
                        dropdownParent: $(popup)
                    });
                    console.log('Select2 Initialized');

                    // Category Change Handler
                    $(categorySelect).on('change', function() {
                        const categoryId = $(this).val();
                        console.log('Category changed to:', categoryId);
                        if (categoryId) {
                            optionLoadingPromise = loadOptionsForCategory(categoryId);
                            optionLoadingPromise?.then(() => { // Use optional chaining for safety
                                if (restoreValues && storedItemFormData.category_id === categoryId && storedItemFormData.options.length > 0) {
                                    console.log('Restoring options - options loaded, setting selection:', storedItemFormData.options);
                                    $(optionsSelect).val(storedItemFormData.options).trigger('change');
                                }
                            }).catch(err => console.error("Error during option loading/restoration:", err));
                        } else {
                            $(optionsSelect).empty().trigger('change');
                            optionLoadingPromise = Promise.resolve();
                        }
                    });

                    // Restore values
                    if (restoreValues) {
                        console.log('Starting restoration process...');
                        if (nameInput) nameInput.value = storedItemFormData.name || '';
                        if (descriptionTextarea) descriptionTextarea.value = storedItemFormData.description || '';

                        if (storedItemFormData.category_id) {
                            console.log('Restoring category:', storedItemFormData.category_id);
                            $(categorySelect).val(storedItemFormData.category_id).trigger('change'); // This triggers the 'change' handler above
                        } else {
                             $(optionsSelect).val([]).trigger('change');
                             console.log('No category to restore, cleared options.');
                             $(categorySelect).val("").trigger('change'); // Ensure placeholder shows if no category
                        }

                        // Trigger initial validation if restoring a name
                        if (nameInput && nameInput.value) {
                           validateName(nameInput, nameError); // CALL THE MOVED FUNCTION
                        }
                    } else {
                         $(categorySelect).val("").trigger('change'); // Ensure placeholder shows on fresh open
                    }

                });

                // Name input listener
                if(nameInput) {
                    // Use debouncing to avoid excessive checks on every keystroke (optional but good practice)
                    let debounceTimer;
                    nameInput.addEventListener('input', () => {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(() => {
                            validateName(nameInput, nameError); // CALL THE MOVED FUNCTION
                        }, 300); // Wait 300ms after user stops typing
                    });
                }

            }, // End didOpen
            preConfirm: async () => {
                console.log('preConfirm triggered');
                const popup = Swal.getPopup();
                popup.querySelectorAll('.error-message').forEach(el => el.textContent = ''); // Clear previous errors

                const form = popup.querySelector('#addItemForm');
                const formData = new FormData(form);
                let hasErrors = false;

                const nameInput = popup.querySelector('#swal-name');
                const categorySelect = popup.querySelector('#swal-category');
                const optionsSelect = popup.querySelector('#swal-options');
                const nameError = popup.querySelector('#name-error');
                const categoryError = popup.querySelector('#category_id-error');
                const optionsError = popup.querySelector('#options-error');

                const categoryValue = $(categorySelect).val();
                const selectedOptions = $(optionsSelect).val() || [];

                // --- Validation ---
                // 1. Validate Name (Required check + uniqueness check)
                if (!nameInput.value.trim()) {
                    nameError.textContent = 'Item name is required.';
                    hasErrors = true;
                    nameInput.dataset.valid = "false"; // Mark as invalid if empty
                } else {
                     // Only run async check if name is not empty
                    await validateName(nameInput, nameError); // CALL THE MOVED FUNCTION & wait for it
                    if (nameInput.dataset.valid === "false") {
                        // Error message should already be set by validateName
                        hasErrors = true;
                    }
                }


                // 2. Validate Category (Required check)
                if (!categoryValue) {
                    categoryError.textContent = 'Tag is required.';
                    hasErrors = true;
                }

                // 3. Validate Options (Required *if* category has options available)
                 const optionsAvailable = optionsSelect.options.length > 0 && !optionsSelect.options[0]?.disabled; // Check if first option isn't a placeholder/disabled message
                 if (categoryValue && optionsAvailable && selectedOptions.length === 0) {
                    optionsError.textContent = 'Please select at least one option for the chosen tag, or choose a tag with no options.';
                    hasErrors = true;
                }
                // --- End Validation ---


                // Prepare FormData only if no errors so far
                if (!hasErrors) {
                     formData.delete('options[]'); // Clear existing
                     selectedOptions.forEach(optionId => formData.append('options[]', optionId));
                     formData.set('category_id', categoryValue || '');
                }

                console.log('Validation check. Has Errors:', hasErrors);
                if (hasErrors) {
                    Swal.showValidationMessage(`Please fix the errors above.`);
                    return false; // Prevent modal from closing
                }

                // If validation passes, proceed with fetch
                 console.log('Submitting form data...');
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }


                return fetch("{{ route('items.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                             "Accept": "application/json" // Important for Laravel validation errors
                        },
                        body: formData
                    })
                    .then(async response => {
                        if (!response.ok) {
                            const data = await response.json();
                            console.error("Server Error:", data);
                             if (data.errors) {
                                Object.entries(data.errors).forEach(([field, messages]) => {
                                    const errorField = field.split('.')[0];
                                    const errorEl = popup.querySelector(`#${errorField}-error`);
                                    console.log(`Looking for error element #${errorField}-error`);
                                    if (errorEl) {
                                        errorEl.textContent = messages[0];
                                        console.log(`Error set for ${errorField}: ${messages[0]}`);
                                    } else {
                                        console.log(`Error element for ${errorField} not found.`);
                                    }
                                });
                            }
                            throw new Error(data.message || 'Validation failed.');
                        }
                        return response.json();
                    })
                     .catch(error => {
                        console.error("Fetch catch:", error);
                         Swal.showValidationMessage(`Request failed: ${error.message}`);
                         return false; // Prevent closing on fetch error
                    });
            } // End preConfirm
        }).then((result) => {
            if (result.isConfirmed) {
                console.log('Item Added Successfully', result.value);
                storedItemFormData = { name: '', description: '', category_id: '', options: [] }; // Clear stored data
                Swal.fire({
                    icon: 'success',
                    title: 'Item Added!',
                    text: 'The item has been successfully created.',
                    timer: 2000,
                    showConfirmButton: false
                }).then(() => location.reload());
            } else if (result.dismiss === Swal.DismissReason.cancel) {
                 console.log('Add Item modal cancelled.');
                 // Decide if you want to clear stored data on cancel
                 // storedItemFormData = { name: '', description: '', category_id: '', options: [] };
            }
        });
    }

    // Function to save form values before navigating to add option
    function saveAndAddItemOption() {
        console.log('saveAndAddItemOption called');
        const popup = Swal.getPopup(); // Get current Swal modal
        if (!popup) {
            console.error('Could not find active Swal modal to save from.');
            return;
        }

        const nameInput = popup.querySelector('#swal-name');
        const descriptionTextarea = popup.querySelector('#swal-description');
        const categorySelect = $(popup.querySelector('#swal-category'));
        const optionsSelect = $(popup.querySelector('#swal-options'));

        storedItemFormData = {
            name: nameInput ? nameInput.value : '',
            description: descriptionTextarea ? descriptionTextarea.value : '',
            category_id: categorySelect.val() || '',
            options: optionsSelect.val() || []
        };

        console.log('Saved form data:', JSON.stringify(storedItemFormData));

        Swal.close();
        setTimeout(() => {
             addItemOption();
        }, 150); // Timeout helps prevent modal transition issues
    }

    function addItemOption() {
        console.log('addItemOption called');

         // --- Define validateType HERE (similar scope fix as validateName) ---
         async function validateType(inputElement, errorElement) {
            if (!inputElement || !errorElement) return;
            const typeValue = inputElement.value.trim();
            errorElement.textContent = '';
            inputElement.dataset.valid = "true";

            if (typeValue.length > 0) {
                try {
                    const response = await fetch("{{ route('itemOptions.checkType') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                            "Content-Type": "application/json",
                            "Accept": "application/json"
                        },
                        body: JSON.stringify({ type: typeValue })
                    });
                    if (!response.ok) {
                         let errorMsg = `HTTP error! status: ${response.status}`;
                         try { const errorData = await response.json(); errorMsg = errorData.message || JSON.stringify(errorData); } catch(e){}
                         throw new Error(errorMsg);
                     }

                    const data = await response.json();
                    if (data.exists) {
                        errorElement.textContent = 'This item option type is already taken.';
                        inputElement.dataset.valid = "false";
                    }
                } catch (error) {
                    console.error("Error checking type:", error);
                    errorElement.textContent = 'Error checking type availability.';
                    inputElement.dataset.valid = "false";
                }
            } else {
                 inputElement.dataset.valid = "true"; // Empty is not "taken"
            }
        }
         // --- End validateType definition ---


        Swal.fire({
            title: '<span class="text-xl font-semibold text-gray-800">Add Item Option</span>',
            html: `
            <form id="addItemOptionForm" class="space-y-4 p-4">
                <!-- Image Upload & Preview -->
                <div class="flex flex-col items-center space-y-3">
                    <div id="imagePreviewContainer" class="hidden w-full mb-2">
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
                    <div id="image-error" class="text-xs text-red-500 error-message w-full text-center"></div>
                </div>

                <!-- Type -->
                <div>
                    <label for="swal-type" class="block text-sm font-medium text-gray-700 mb-1">Type</label>
                    <input type="text" id="swal-type" name="type" required
                        class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                    <div id="type-error" class="mt-1 text-xs text-red-500 error-message"></div>
                </div>

                <!-- Description -->
                <div>
                    <label for="swal-option-description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-gray-400 font-normal">(Optional)</span></label>
                    <textarea id="swal-option-description" name="description" rows="3"
                        class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"></textarea>
                    <div id="description-error" class="mt-1 text-xs text-red-500 error-message"></div> {{-- ID adjusted --}}
                </div>
             </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Add Option',
            cancelButtonText: 'Back to Add Item',
            focusConfirm: false,
            customClass: {
                popup: 'rounded-lg max-w-md mx-4',
                confirmButton: 'px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm',
                cancelButton: 'px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium border border-gray-300 rounded-md shadow-sm mr-2'
            },
            width: 'auto',
            backdrop: 'rgba(0, 0, 0, 0.4)',
            didOpen: () => {
                const popup = Swal.getPopup();
                const typeInput = popup.querySelector('#swal-type');
                const typeError = popup.querySelector('#type-error');

                 // Attach listener using the moved function
                 if(typeInput) {
                     let debounceTimer;
                     typeInput.addEventListener('input', () => {
                        clearTimeout(debounceTimer);
                        debounceTimer = setTimeout(() => {
                            validateType(typeInput, typeError); // Call the moved function
                        }, 300);
                    });
                 }
            },
            preConfirm: async () => {
                 console.log('preConfirm for Add Option triggered');
                const popup = Swal.getPopup();
                popup.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                const form = popup.querySelector('#addItemOptionForm');
                const formData = new FormData(form);
                let hasErrors = false;

                const typeInput = popup.querySelector('#swal-type');
                const typeError = popup.querySelector('#type-error');

                 // Validate Type (Required + Uniqueness)
                if (!typeInput.value.trim()) {
                    typeError.textContent = 'Type is required.';
                    hasErrors = true;
                    typeInput.dataset.valid = "false";
                } else {
                     await validateType(typeInput, typeError); // Call the moved function
                     if (typeInput.dataset.valid === "false") {
                         hasErrors = true;
                     }
                 }

                if (hasErrors) {
                    Swal.showValidationMessage(`Please fix the errors above.`);
                    return false;
                 }

                console.log('Submitting Add Option form...');
                 for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }

                return fetch("{{ route('itemOptions.store') }}", {
                        method: "POST",
                        headers: {
                             "X-CSRF-TOKEN": document.querySelector('meta[name="csrf-token"]').getAttribute('content'),
                             "Accept": "application/json"
                        },
                        body: formData
                    })
                     .then(async response => {
                         if (!response.ok) {
                            const data = await response.json();
                             console.error("Server Error (Add Option):", data);
                             if (data.errors) {
                                Object.entries(data.errors).forEach(([field, messages]) => {
                                    const errorEl = popup.querySelector(`#${field}-error`);
                                    if (errorEl) {
                                        errorEl.textContent = messages[0];
                                    }
                                });
                            }
                             throw new Error(data.message || 'Validation failed.');
                        }
                        return response.json();
                    })
                    .catch(error => {
                         console.error("Fetch catch (Add Option):", error);
                         Swal.showValidationMessage(`Request failed: ${error.message}`);
                         return false;
                    });
            }
        }).then((result) => {
             if (result.isConfirmed) {
                 console.log('Item Option Added Successfully', result.value);
                 Swal.fire({
                     icon: 'success',
                     title: 'Item Option Added!',
                     text: 'The new option is available. Returning to add item form.', // Adjusted text
                     timer: 2500,
                     showConfirmButton: false
                 }).then(() => {
                     addItem(true); // Reopen Add Item modal, restoring values
                 });
             } else if (result.dismiss === Swal.DismissReason.cancel) {
                 console.log('Add Item Option cancelled, returning to Add Item modal.');
                 addItem(true); // Reopen Add Item modal, restoring values
             }
        });
    }

    // Modified to return the fetch promise
    function loadOptionsForCategory(categoryId) {
        const popup = Swal.getPopup();
        if (!popup) return Promise.reject("No active modal for options.");

        const optionsSelect = popup.querySelector('#swal-options');
        if (!optionsSelect) return Promise.reject("Options select not found.");

        const $optionsSelect = $(optionsSelect);

        $optionsSelect.empty().append(new Option('Loading options...', '')).prop('disabled', true).trigger('change');
        console.log(`Fetching options for category ID: ${categoryId}`);

        return fetch(`/api/item-options?category=${categoryId}`)
            .then(response => {
                if (!response.ok) throw new Error(`Failed to load options (status: ${response.status})`);
                return response.json();
            })
            .then(data => {
                console.log(`Received options for category ${categoryId}:`, data);
                $optionsSelect.empty().prop('disabled', false);

                if (data.length === 0) {
                    const noOptions = new Option('No options available for this tag', '', false, false);
                    noOptions.disabled = true;
                    $optionsSelect.append(noOptions);
                    console.log('No options found.');
                } else {
                    data.forEach(option => {
                        const optionText = option.type ? `${option.type}` : `Option ID ${option.id}`;
                        const newOption = new Option(optionText, option.id, false, false);
                        $optionsSelect.append(newOption);
                    });
                     console.log(`Populated ${data.length} options.`);
                }

                $optionsSelect.trigger('change'); // Refresh Select2
                 return data; // Resolve promise with data
            })
            .catch(error => {
                console.error('Error loading options:', error);
                $optionsSelect.empty()
                    .append(new Option('Error loading options', ''))
                    .prop('disabled', true)
                    .trigger('change');
                 throw error; // Re-throw error
            });
    }


    function previewAddImage(event) {
        const input = event.target;
        const form = input.closest('form'); // Find the parent form
        if (!form) return;

        const previewContainer = form.querySelector('#imagePreviewContainer');
        const previewImage = form.querySelector('#imagePreview');
        const errorDiv = form.querySelector('#image-error');

        if (!previewContainer || !previewImage || !errorDiv) return; // Ensure all elements exist

        errorDiv.textContent = ''; // Clear previous error

        if (input.files && input.files[0]) {
            const file = input.files[0];
            if (file.size > 5 * 1024 * 1024) { // 5MB limit
                 errorDiv.textContent = 'Image size should not exceed 5MB.';
                 input.value = '';
                 previewContainer.classList.add('hidden');
                 return;
            }
            if (!file.type.startsWith('image/')) {
                errorDiv.textContent = 'Please select a valid image file.';
                input.value = '';
                previewContainer.classList.add('hidden');
                return;
            }

            const reader = new FileReader();
            reader.onload = function(e) {
                previewImage.src = e.target.result;
                previewContainer.classList.remove('hidden');
            }
             reader.onerror = function() {
                 errorDiv.textContent = 'Error reading image file.';
                 previewContainer.classList.add('hidden');
             }
            reader.readAsDataURL(file);
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
