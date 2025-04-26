{{-- ADD PACKAGE BUTTON SA ADMIN DASHBOARD  --}}
@props(['categories'])
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
    function addPackage() {
        Swal.fire({
            title: '<span class="text-xl font-semibold text-gray-800">Add Package</span>',
            html: `
            <form id="addPackageForm" class="space-y-5" enctype="multipart/form-data">
                <!-- Image Upload Section -->
                <div class="flex flex-col items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                    <img id="image-preview" src="#" alt="Preview" 
                        class="w-full max-w-xs h-40 object-contain mb-4 rounded-lg bg-white border-2 border-dashed border-gray-300">
                    
                    <label class="w-full">
                        <div class="flex flex-col items-center justify-center py-3 px-4 border border-gray-300 border-dashed rounded-md cursor-pointer hover:bg-gray-100 transition">
                            <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <span class="text-sm text-gray-600 mt-1">Click to upload image</span>
                        </div>
                        <input type="file" id="swal-image" name="image" accept="image/*" class="hidden" onchange="previewPackageImage(event)">
                    </label>
                    <div id="image-error" class="mt-2 text-xs text-red-500"></div>
                </div>

                <!-- Form Fields -->
                <div class="space-y-4">
                    <!-- Package Name -->
                    <div>
                        <label for="swal-name" class="block text-sm font-medium text-gray-700 mb-1">Package Name</label>
                        <input type="text" id="swal-name" name="name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <div id="name-error" class="mt-1 text-xs text-red-500"></div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="swal-description" class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                        <textarea id="swal-description" name="description" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        <div id="description-error" class="mt-1 text-xs text-red-500"></div>
                    </div>

                    <!-- Pricing Section -->
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        <div>
                            <label for="swal-price" class="block text-sm font-medium text-gray-700 mb-1">Price per person</label>
                            <div class="relative">
                                <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                    <span class="text-gray-500">₱</span>
                                </div>
                                <input type="number" step="0.01" id="swal-price" name="price_per_person" required min="0.01"
                                    class="block w-full pl-8 pr-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            </div>
                            <div id="price_per_person-error" class="mt-1 text-xs text-red-500"></div>
                        </div>

                        <div>
                            <label for="swal-minimum" class="block text-sm font-medium text-gray-700 mb-1">Minimum pax</label>
                            <input type="number" id="swal-minimum" name="min_pax" required min="1"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                            <div id="min_pax-error" class="mt-1 text-xs text-red-500"></div>
                        </div>
                    </div>
                </div>
            </form>
        `,
            showCancelButton: true,
            confirmButtonText: 'Add Package',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            customClass: {
                popup: 'rounded-lg max-w-md mx-4 bg-white',
                confirmButton: 'px-4 py-2 bg-blue-600 hover:bg-blue-700 text-white text-sm font-medium rounded-md shadow-sm',
                cancelButton: 'px-4 py-2 bg-white hover:bg-gray-50 text-gray-700 text-sm font-medium border border-gray-300 rounded-md shadow-sm'
            },
            width: 'auto',
            backdrop: 'rgba(0, 0, 0, 0.4)',
            didOpen: () => {
                const imageInput = document.getElementById('swal-image');
                const imagePreview = document.getElementById('image-preview');
                const nameInput = document.getElementById('swal-name');
                const priceInput = document.getElementById('swal-price');
                const minPaxInput = document.getElementById('swal-minimum');

                // img preview
                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.style.display = 'none';
                    }
                });

                // Real-time validations
                nameInput.addEventListener('blur', validatePackageName);
                priceInput.addEventListener('input', () => validateField(priceInput, 'price_per_person'));
                minPaxInput.addEventListener('input', () => validateField(minPaxInput, 'min_pax'));
            },
            preConfirm: async () => {

                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                const formData = new FormData(document.getElementById('addPackageForm'));
                let hasErrors = false;

                // Validate non-name fields
                hasErrors |= validateField(document.getElementById('swal-price'), 'price_per_person');
                hasErrors |= validateField(document.getElementById('swal-minimum'), 'min_pax');
                hasErrors |= validateImage(document.getElementById('swal-image'));

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
            errorElement.textContent = `${fieldName.replace('_', ' ')} is required`;
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
</script>

<button onclick="addPackage()"
    class="cursor-pointer  group bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition-all flex items-center gap-4 hover:border-green-200 hover:bg-green-50">
    <div
        class="w-10 h-10 rounded-lg bg-green-100 flex items-center justify-center text-green-600 group-hover:bg-green-200 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
        </svg>
    </div>
    <div class="text-left">
        <h3 class="font-medium text-gray-800 group-hover:text-green-700">Add Package</h3>
        <p class="text-xs text-gray-500">Create a packages</p>
    </div>
</button>
