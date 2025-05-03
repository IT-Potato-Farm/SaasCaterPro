{{-- ADD PACKAGE BUTTON FOR ADMIN DASHBOARD --}}
@props(['categories', 'items', 'utilities'])
<style>
    .image-preview-container {
        position: relative;
        margin-bottom: 1.5rem;
    }

    .image-preview {
        width: 100%;
        height: 200px;
        object-fit: contain;
        border-radius: 0.5rem;
        border: 2px dashed #e2e8f0;
        background-color: #f8fafc;
        display: none;
    }

    .upload-placeholder {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        padding: 2rem;
        border: 2px dashed #e2e8f0;
        border-radius: 0.5rem;
        background-color: #f8fafc;
        cursor: pointer;
        transition: all 0.2s;
    }

    .upload-placeholder:hover {
        border-color: #cbd5e1;
        background-color: #f1f5f9;
    }

    .error-message {
        color: #ef4444;
        font-size: 0.75rem;
        margin-top: 0.25rem;
    }

    .selection-panel {
        max-height: 200px;
        overflow-y: auto;
        border: 1px solid #e2e8f0;
        border-radius: 0.5rem;
        padding: 0.75rem;
        background-color: white;
    }

    .item-card {
        border: 1px solid #e2e8f0;
        border-radius: 0.375rem;
        padding: 0.75rem;
        margin-bottom: 0.75rem;
        background-color: #f8fafc;
    }

    .options-container {
        margin-top: 0.5rem;
        padding-left: 1.5rem;
        border-left: 2px solid #e2e8f0;
    }

    .utility-grid {
        display: grid;
        grid-template-columns: repeat(auto-fill, minmax(150px, 1fr));
        gap: 0.5rem;
    }

    .swal2-popup {
        max-width: 600px !important;
    }
    .options-container .flex-wrap {
        display: flex;
        flex-wrap: wrap;
        gap: 0.5rem;
    }
    
    .options-container label {
        transition: all 0.2s;
    }
    
    .options-container label:hover {
        background-color: #e9f0fd;
        border-color: #c3d9fa;
    }
    
    .options-container input:checked + span {
        color: #2563eb;
        font-weight: 500;
    }
</style>

<script>
    function addPackage() {
        Swal.fire({
            title: '<span class="text-xl font-semibold text-gray-800">Create New Package</span>',
            html: `
            <div class="package-creation-form">
                <form id="addPackageForm" class="space-y-4" enctype="multipart/form-data">
                    <!-- Image Upload Section -->
                    <div class="image-preview-container">
                        <img id="image-preview" class="image-preview" alt="Package preview">
                        <label class="upload-placeholder">
                            <svg class="w-10 h-10 text-gray-400 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm font-medium text-gray-600">Upload Package Image</span>
                            <span class="text-xs text-gray-500 mt-1">JPEG, PNG (Max 10MB)</span>
                            <input type="file" id="swal-image" name="image" accept="image/*" class="hidden" onchange="previewPackageImage(event)">
                        </label>
                        <div id="image-error" class="error-message"></div>
                    </div>

                    <!-- Basic Information Section -->
                    <div class="grid grid-cols-1 gap-4">
                        <div>
                            <label for="swal-name" class="block text-sm font-medium text-gray-700 mb-1">Package Name*</label>
                            <input type="text" id="swal-name" name="name" required
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400">
                            <div id="name-error" class="error-message"></div>
                        </div>
                        
                        <div>
                            <label for="swal-description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                            <textarea id="swal-description" name="description" rows="3"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400"></textarea>
                            <div id="description-error" class="error-message"></div>
                        </div>
                    </div>

                    <!-- Pricing Information -->
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label for="swal-price" class="block text-sm font-medium text-gray-700 mb-1">Price per person*</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">₱</span>
                                </div>
                                <input type="number" step="0.01" id="swal-price" name="price_per_person" required min="0.01"
                                    class="block w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400">
                            </div>
                            <div id="price_per_person-error" class="error-message"></div>
                        </div>

                        <div>
                            <label for="swal-minimum" class="block text-sm font-medium text-gray-700 mb-1">Minimum pax*</label>
                            <input type="number" id="swal-minimum" name="min_pax" required min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500 focus:border-blue-500 placeholder-gray-400">
                            <div id="min_pax-error" class="error-message"></div>
                        </div>
                    </div>

                    <!-- Items Selection (Collapsible) -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-gray-700">Select Items & Options*</label>
                            <button type="button" onclick="toggleAllItems()" class="text-xs text-blue-600 hover:text-blue-800">Select All</button>
                        </div>
                        <div class="selection-panel">
                            @foreach ($items as $item)
                                <div class="item-card">
                                    <label class="flex items-center space-x-2 cursor-pointer">
                                        <input type="checkbox" name="item_ids[]" value="{{ $item->id }}"
                                            class="form-checkbox h-4 w-4 text-green-600 item-checkbox"
                                            onchange="toggleItemOptions(this, {{ $item->id }})">
                                        <span class="text-sm font-medium text-gray-800">{{ $item->name }}</span>
                                    </label>

                                    @if ($item->itemOptions->count())
                                        <div id="item-options-{{ $item->id }}" class="options-container hidden mt-2">
                                            <div class="flex flex-wrap gap-2">
                                                @foreach ($item->itemOptions as $option)
                                                    <label class="inline-flex items-center px-2 py-1 bg-gray-50 rounded-md border border-gray-200">
                                                        <input type="checkbox" name="item_options[{{ $item->id }}][]" value="{{ $option->id }}"
                                                            class="form-checkbox h-4 w-4 text-blue-600 mr-1">
                                                        <span class="text-sm text-gray-700">{{ $option->type }}</span>
                                                    </label>
                                                @endforeach
                                            </div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                        <div id="items-error" class="error-message"></div>
                    </div>

                    <!-- Utilities Selection -->
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <label class="block text-sm font-medium text-gray-700">Select Utilities</label>
                            <button type="button" onclick="toggleAllUtilities()" class="text-xs text-blue-600 hover:text-blue-800">Select All</button>
                        </div>
                        <div class="selection-panel">
                            <div class="utility-grid">
                                @foreach ($utilities as $utility)
                                    <label class="flex items-center space-x-2">
                                        <input type="checkbox" name="utility_ids[]" value="{{ $utility->id }}" 
                                            class="form-checkbox h-4 w-4 text-green-600">
                                        <span class="text-sm text-gray-800">{{ $utility->name }}</span>
                                    </label>
                                @endforeach
                            </div>
                        </div>
                        <div id="utilities-error" class="error-message"></div>
                    </div>
                </form>
            </div>
        `,
            showCancelButton: true,
            confirmButtonText: 'Create Package',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            customClass: {
                popup: 'rounded-lg bg-white',
                confirmButton: 'px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm transition-colors',
                cancelButton: 'px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium border border-gray-300 rounded-md shadow-sm transition-colors'
            },
            width: 'auto',
            backdrop: 'rgba(0, 0, 0, 0.4)',
            didOpen: () => {
                const imageInput = document.getElementById('swal-image');
                const imagePreview = document.getElementById('image-preview');
                const nameInput = document.getElementById('swal-name');
                const priceInput = document.getElementById('swal-price');
                const minPaxInput = document.getElementById('swal-minimum');

                // Img preview function
                window.previewPackageImage = function(event) {
                    const file = event.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';
                            document.querySelector('.upload-placeholder').style.display = 'none';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.style.display = 'none';
                        document.querySelector('.upload-placeholder').style.display = 'flex';
                    }
                };

                // Real-time validations
                nameInput.addEventListener('blur', validatePackageName);
                priceInput.addEventListener('input', () => validateField(priceInput, 'price_per_person'));
                minPaxInput.addEventListener('input', () => validateField(minPaxInput, 'min_pax'));
            },
            preConfirm: async () => {
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                const formData = new FormData(document.getElementById('addPackageForm'));
                let hasErrors = false;

                // Validate fields
                hasErrors |= validateField(document.getElementById('swal-price'), 'price_per_person');
                hasErrors |= validateField(document.getElementById('swal-minimum'), 'min_pax');
                hasErrors |= validateImage(document.getElementById('swal-image'));

                // (at least one item required)
                const itemCheckboxes = document.querySelectorAll('input[name="item_ids[]"]:checked');
                if (itemCheckboxes.length === 0) {
                    document.getElementById('items-error').textContent = 'Please select at least one item';
                    hasErrors = true;
                } else {
                    hasErrors |= validateItemOptions();
                }


                // Asynchronously validate the package name for uniqueness
                hasErrors |= await validatePackageName();

                if (hasErrors) return false;

                return fetch("{{ route('package.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: formData
                    })
                    .then(handleResponse)
                    .catch(handleError);
            }
        }).then(handleSweetAlertResult);
    }

    // Toggle all items
    window.toggleAllItems = function() {
        const checkboxes = document.querySelectorAll('.item-checkbox');
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

        checkboxes.forEach(checkbox => {
            checkbox.checked = !allChecked;
            const itemId = checkbox.value;
            const optionsContainer = document.getElementById(`item-options-${itemId}`);
            if (optionsContainer) {
                optionsContainer.classList.toggle('hidden', !checkbox.checked);
            }
        });
    };

    // Toggle all utilities
    window.toggleAllUtilities = function() {
        const checkboxes = document.querySelectorAll('input[name="utility_ids[]"]');
        const allChecked = Array.from(checkboxes).every(checkbox => checkbox.checked);

        checkboxes.forEach(checkbox => {
            checkbox.checked = !allChecked;
        });
    };

    async function validatePackageName() {
        const nameInput = document.getElementById('swal-name');
        const errorElement = document.getElementById('name-error');
        const name = nameInput.value.trim();

        if (!name) {
            errorElement.textContent = 'Package name is required';
            return true;
        }

        try {
            const response = await fetch("{{ route('package.checkName') }}?name=" + encodeURIComponent(name));
            const data = await response.json();
            if (!data.available) {
                errorElement.textContent = 'Package name is already taken';
                return true;
            } else {
                errorElement.textContent = '';
                return false;
            }
        } catch (error) {
            errorElement.textContent = 'Error validating package name';
            return true;
        }
    }

    function validateField(input, fieldName) {
        const value = input.value.trim();
        const errorElement = document.getElementById(`${fieldName}-error`);

        if (!value) {
            errorElement.textContent = `${fieldName.replace(/_/g, ' ')} is required`;
            return true;
        }

        if (fieldName === 'min_pax' && (value < 1 || !Number.isInteger(Number(value)))) {
            errorElement.textContent = 'Minimum pax must be at least 1';
            return true;
        }

        if (fieldName === 'price_per_person' && value < 0.01) {
            errorElement.textContent = 'Price must be at least 0.01';
            return true;
        }

        errorElement.textContent = '';
        return false;
    }

    function validateImage(input) {
        const errorElement = document.getElementById('image-error');
        if (!input.files.length) {
            errorElement.textContent = 'Please upload an image';
            return true;
        }

        const file = input.files[0];
        const validTypes = ['image/jpeg', 'image/png', 'image/jpg', 'image/gif'];

        if (!validTypes.includes(file.type)) {
            errorElement.textContent = 'Invalid image format (JPEG, PNG, JPG, GIF only)';
            return true;
        }

        if (file.size > 10 * 1024 * 1024) { // 10MB
            errorElement.textContent = 'Image size must be less than 10MB';
            return true;
        }

        errorElement.textContent = '';
        return false;
    }

    function validateItemOptions() {
        const itemCheckboxes = document.querySelectorAll('input[name="item_ids[]"]:checked');
        let hasErrors = false;
        let errorMessage = '';

        // Check each selected item
        itemCheckboxes.forEach(checkbox => {
            const itemId = checkbox.value;
            const optionsContainer = document.getElementById(`item-options-${itemId}`);

            if (optionsContainer && optionsContainer.querySelectorAll('input[type="checkbox"]').length > 0) {
                const selectedOptions = optionsContainer.querySelectorAll('input[type="checkbox"]:checked');
                if (selectedOptions.length === 0) {
                    hasErrors = true;
                    const itemName = checkbox.nextElementSibling.textContent.trim();
                    errorMessage += `Please select at least one option for "${itemName}". `;
                }
            }
        });

        // Display error if any
        if (hasErrors) {
            document.getElementById('items-error').textContent = errorMessage;
        }

        return hasErrors;
    }

    async function handleResponse(response) {
        if (!response.ok) {
            const data = await response.json();
            showValidationErrors(data.errors || {
                message: data.message
            });
            throw new Error(data.message || 'Server error');
        }
        return response.json();
    }

    function handleError(error) {
        Swal.showValidationMessage(error.message);
        return false;
    }

    function showValidationErrors(errors) {
        Object.entries(errors).forEach(([field, messages]) => {
            const errorElement = document.getElementById(`${field}-error`);
            if (errorElement) errorElement.textContent = messages[0];
        });
    }

    function handleSweetAlertResult(result) {
        if (result.isConfirmed) {
            Swal.fire({
                toast: true,
                position: 'top-end',
                icon: 'success',
                title: 'Package Added!',
                text: 'The new package has been successfully created',
                showConfirmButton: false,
                timer: 2000,
                timerProgressBar: true,
                didOpen: (toast) => {
                    toast.addEventListener('mouseenter', Swal.stopTimer);
                    toast.addEventListener('mouseleave', Swal.resumeTimer);
                }
            }).then(() => location.reload());
        }
    }

    // Toggle item options visibility
    window.toggleItemOptions = function(checkbox, itemId) {
        const container = document.getElementById(`item-options-${itemId}`);
        if (checkbox.checked) {
            container.classList.remove('hidden');
        } else {
            container.classList.add('hidden');
            container.querySelectorAll('input[type="checkbox"]').forEach(cb => cb.checked = false);
        }
    };
</script>

<button onclick="addPackage()"
    class="cursor-pointer group bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition-all flex items-center gap-4 hover:border-green-200 hover:bg-green-50">
    <div
        class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 group-hover:bg-green-200 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
    </div>
    <div class="text-left">
        <h3 class="font-medium text-gray-800 group-hover:text-green-700">Add Package</h3>
        <p class="text-xs text-gray-500">Create a new package</p>
    </div>
</button>
