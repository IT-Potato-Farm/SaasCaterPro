@props(['categories'])
@php

    $categoryOptions = '';
    foreach ($categories as $category) {
        $categoryOptions .= '<option value="' . $category->id . '">' . e($category->name) . '</option>';
    }
    $checkNameUrl = route('check-name-availability');
    $storeItemUrl = route('menu-items.store');
    $csrfToken = csrf_token();
@endphp

<style>
    .image-preview {
        display: none;
        width: 100%;
        height: auto;
        max-height: 300px;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 2px dashed #ccc;
        padding: 0.5rem;
    }

    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<script>
    function addPartyTray() {
        const categoryOptions = `{!! $categoryOptions !!}`;
        const checkNameUrl = "{{ $checkNameUrl }}";
        const storeItemUrl = "{{ $storeItemUrl }}";
        const csrfToken = "{{ $csrfToken }}";

        Swal.fire({
            title: '<span class="text-xl font-semibold text-gray-800">Add Party Tray</span>',
            html: `
            <form id="addItemForm" class="space-y-5" enctype="multipart/form-data">
                <!-- Image Upload -->
                <div class="flex flex-col items-center space-y-3 p-4 bg-gray-50 rounded-lg">
                    <img id="image-preview" src="#" alt="Preview" class="w-full h-40 object-contain rounded-lg bg-white border border-gray-200">
                    <label class="w-full">
                        <div class="flex flex-col items-center justify-center py-3 px-4 border border-gray-300 border-dashed rounded-md cursor-pointer hover:bg-gray-100 transition">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-gray-600 mt-1">Click to upload image</span>
                        </div>
                        <input type="file" id="swal-image" name="image" accept="image/*" class="hidden">
                    </label>
                    <div id="image-error" class="text-xs text-red-500"></div>
                </div>

                <!-- Form Fields -->
                <div class="space-y-4">
                    <div>
                        <label for="swal-category" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                        <select id="swal-category" name="category_id" required class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            ${categoryOptions}
                        </select>
                        <div id="category-error" class="mt-1 text-xs text-red-500"></div>
                    </div>

                    <div>
                        <label for="swal-name" class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
                        <input type="text" id="swal-name" name="name" required class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <div id="name-error" class="mt-1 text-xs text-red-500"></div>
                    </div>

                    <div>
                        <label for="swal-description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="swal-description" name="description" rows="2" class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        <div id="description-error" class="mt-1 text-xs text-red-500"></div>
                    </div>
                </div>

                <!-- Pricing Section -->
                <div class="space-y-3">
                    <h3 class="text-sm font-medium text-gray-700">Pricing</h3>
                    <div class="grid grid-cols-2 gap-4">
                        <div>
                            <label for="swal-pricing-10-15" class="block text-xs font-medium text-gray-600 mb-1">10-15 Pax</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">₱</span>
                                </div>
                                <input type="number" id="swal-pricing-10-15" name="pricing[10-15]" required class="w-full pl-8 pr-3 py-2 text-gray-700 border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div id="pricing-10-15-error" class="mt-1 text-xs text-red-500"></div>
                        </div>
                        <div>
                            <label for="swal-pricing-15-20" class="block text-xs font-medium text-gray-600 mb-1">15-20 Pax</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">₱</span>
                                </div>
                                <input type="number" id="swal-pricing-15-20" name="pricing[15-20]" required class="w-full pl-8 pr-3 py-2 text-gray-700 border border-gray-300 rounded-md focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div id="pricing-15-20-error" class="mt-1 text-xs text-red-500"></div>
                        </div>
                    </div>
                </div>
            </form>`,
            showCancelButton: true,
            confirmButtonText: 'Save Party Tray',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            customClass: {
                popup: 'bg-white rounded-lg shadow-md p-6',
                confirmButton: 'px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md',
                cancelButton: 'px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium border border-gray-300 rounded-md'
            },
            width: '32rem',
            padding: '0',
            didOpen: () => {
                const imageInput = document.getElementById('swal-image');
                const imagePreview = document.getElementById('image-preview');
                const nameInput = document.getElementById('swal-name');

                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);

                        const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                        document.getElementById('image-error').textContent = validTypes.includes(
                                file.type) ?
                            '' :
                            'Please upload a valid image file (JPEG, PNG, GIF, WEBP)';
                    } else {
                        imagePreview.style.display = 'none';
                    }
                });

                nameInput.addEventListener('blur', function() {
                    if (!nameInput.value.trim()) {
                        document.getElementById('name-error').textContent = 'Item name is required';
                        return;
                    }

                    fetch(`${checkNameUrl}?name=${encodeURIComponent(nameInput.value)}`)
                        .then(response => response.json())
                        .then(data => {
                            document.getElementById('name-error').textContent = data.available ?
                                '' : 'This item name is already taken';
                        });
                });
            },
            preConfirm: () => {
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

                const form = document.getElementById('addItemForm');
                const formData = new FormData(form);
                const imageInput = document.getElementById('swal-image');
                const nameInput = document.getElementById('swal-name');
                const descriptionInput = document.getElementById('swal-description');
                const pricing10to15 = document.getElementById('swal-pricing-10-15');
                const pricing15to20 = document.getElementById('swal-pricing-15-20');

                let hasErrors = false;

                if (!nameInput.value.trim()) {
                    document.getElementById('name-error').textContent = 'Item name is required';
                    hasErrors = true;
                }
                if (!pricing10to15.value || pricing10to15.value <= 0) {
                    document.getElementById('pricing-10-15-error').textContent =
                        'Valid price is required for 10-15 pax';
                    hasErrors = true;
                }
                if (!pricing15to20.value || pricing15to20.value <= 0) {
                    document.getElementById('pricing-15-20-error').textContent =
                        'Valid price is required for 15-20 pax';
                    hasErrors = true;
                }
                if (descriptionInput.value.trim().length > 1000) {
                    document.getElementById('description-error').textContent =
                        'Description is too long (max 1000 characters)';
                    hasErrors = true;
                }
                if (imageInput.files.length === 0) {
                    document.getElementById('image-error').textContent = 'Please upload an image';
                    hasErrors = true;
                } else {
                    const file = imageInput.files[0];
                    const validTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                    if (file.size > 10 * 1024 * 1024) {
                        document.getElementById('image-error').textContent =
                            'Image size must not exceed 10MB';
                        hasErrors = true;
                    } else if (!validTypes.includes(file.type)) {
                        document.getElementById('image-error').textContent =
                            'Please upload a valid image file (JPEG, PNG, GIF, WEBP)';
                        hasErrors = true;
                    }
                }

                if (hasErrors) return false;

                return fetch(`${checkNameUrl}?name=${encodeURIComponent(nameInput.value)}`)
                    .then(response => response.json())
                    .then(data => {
                        if (!data.available) {
                            document.getElementById('name-error').textContent =
                                'This item name is already taken';
                            return false;
                        }

                        return fetch(storeItemUrl, {
                            method: "POST",
                            headers: {
                                "X-CSRF-TOKEN": csrfToken
                            },
                            body: formData
                        }).then(response => {
                            if (!response.ok) return response.json().then(data => {
                                throw new Error(data.message || 'Error');
                            });
                            return response.json();
                        }).then(data => {
                            if (!data.success) {
                                if (data.errors) {
                                    Object.keys(data.errors).forEach(field => {
                                        const errorElement = document.getElementById(
                                            `${field}-error`);
                                        if (errorElement) {
                                            errorElement.textContent = data.errors[
                                                field][0];
                                        }
                                    });
                                }
                                throw new Error('Please fix validation errors');
                            }
                            return data;
                        }).catch(error => {
                            Swal.showValidationMessage(error.message);
                            return false;
                        });
                    });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: '<span class="text-xl font-bold text-gray-800">Success!</span>',
                    text: 'The menu item was successfully added!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            }
        });
    }
</script>

<button onclick="addPartyTray()"
    class="cursor-pointer    group bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition-all flex items-center gap-4 hover:border-red-200 hover:bg-red-50">
    <div
        class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600 group-hover:bg-red-200 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z" />
        </svg>
    </div>
    <div class="text-left">
        <h3 class="font-medium text-gray-800 group-hover:text-red-700">Add Party Tray</h3>
        <p class="text-xs text-gray-500">Create new party trays</p>
    </div>
</button>
