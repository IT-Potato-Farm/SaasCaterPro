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
            title: '<span class="text-2xl font-bold text-gray-800">Add Package</span>',
            html: `
                <form id="addPackageForm" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
                    <div class="flex flex-col items-center justify-center">
                        <img id="image-preview" src="#" alt="Image Preview" class="image-preview">
                        <label for="swal-image" class="mt-4 block text-sm font-medium text-gray-700">Upload Image</label>
                        <input type="file" id="swal-image" name="image" accept="image/*"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="image-error" class="error-message"></div>
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="swal-name" class="block text-sm font-medium text-gray-700">Package Name:</label>
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
                            <label for="swal-price" class="block text-sm font-medium text-gray-700">Price per person:</label>
                            <input type="number" step="0.01" id="swal-price" name="price_per_person" required min="0.01"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="price_per_person-error" class="error-message"></div>
                        </div>
                        <div>
                            <label for="swal-minimum" class="block text-sm font-medium text-gray-700">Minimum pax:</label>
                            <input type="number" id="swal-minimum" name="min_pax" required min="1"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <div id="min_pax-error" class="error-message"></div>
                        </div>
                        
                    </div>
                </form>`,
            showCancelButton: true,
            confirmButtonText: 'Add package',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#ef4444',
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

<button onclick="addPackage()" class="px-2 py-1 bg-cyan-200 rounded mt-2 hover:cursor-pointer">Add a package
    heree2</button>
