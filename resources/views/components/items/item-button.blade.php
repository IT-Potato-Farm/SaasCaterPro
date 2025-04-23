@props(['categories'])
@php
    dump($categories ?? 'NOT SET');
    dump(get_defined_vars());
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
    function addItem() {
        const categoryOptions = `{!! $categoryOptions !!}`;
        const checkNameUrl = "{{ $checkNameUrl }}";
        const storeItemUrl = "{{ $storeItemUrl }}";
        const csrfToken = "{{ $csrfToken }}";

        Swal.fire({
            title: '<span class="text-2xl font-bold text-gray-800">Add Item</span>',
            html: `
                <form id="addItemForm" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
                    <div class="flex flex-col items-center justify-center">
                        <img id="image-preview" src="#" alt="Image Preview" class="image-preview">
                        <label for="swal-image" class="mt-4 block text-sm font-medium text-gray-700">Upload Image</label>
                        <input type="file" id="swal-image" name="image" accept="image/*"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="image-error" class="error-message"></div>
                    </div>
                    <div class="space-y-4">
                        <div>
                            <label for="swal-category" class="block text-sm font-medium text-gray-700">Select Category:</label>
                            <select id="swal-category" name="category_id" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                ${categoryOptions}
                            </select>
                            <div id="category-error" class="error-message"></div>
                        </div>
                        <div>
                            <label for="swal-name" class="block text-sm font-medium text-gray-700">Item Name:</label>
                            <input type="text" id="swal-name" name="name" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="name-error" class="error-message"></div>
                        </div>
                        <div>
                            <label for="swal-description" class="block text-sm font-medium text-gray-700">Description:</label>
                            <textarea id="swal-description" name="description"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                            <div id="description-error" class="error-message"></div>
                        </div>
                        <div>
                            <h3 class="block text-sm font-medium text-gray-700">Pricing</h3>
                            <div class="grid grid-cols-2 gap-4 mt-2">
                                <div>
                                    <label for="swal-pricing-10-15" class="block text-sm font-medium text-gray-700">10-15 Pax Price:</label>
                                    <input type="number" id="swal-pricing-10-15" name="pricing[10-15]" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <div id="pricing-10-15-error" class="error-message"></div>
                                </div>
                                <div>
                                    <label for="swal-pricing-15-20" class="block text-sm font-medium text-gray-700">15-20 Pax Price:</label>
                                    <input type="number" id="swal-pricing-15-20" name="pricing[15-20]" required
                                        class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                    <div id="pricing-15-20-error" class="error-message"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>`,
            showCancelButton: true,
            confirmButtonText: 'Add Menu Item',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#ef4444',
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

<button onclick="addItem()" class="px-2 py-1 bg-cyan-200 rounded mt-2 hover:cursor-pointer">Add Party tray here</button>
