<style>
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    function addPackageUtility() {
        Swal.fire({
            title: '<span class="text-2xl font-bold text-gray-800">Add Package Utility</span>',
            html: `
                <form id="addPackageUtilityForm" class="grid grid-cols-1 gap-6" enctype="multipart/form-data">
                    
                    
                    <!-- Utility Name -->
                    <div>
                        <label for="utilityName" class="block text-sm font-medium text-gray-700">Utility Name</label>
                        <input type="text" id="utilityName" name="name" required class="w-full border rounded p-2">
                        <div id="name-error" class="error-message"></div>
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="utilityDescription" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="utilityDescription" name="description" class="w-full border rounded p-2" placeholder="(Optional)"></textarea>
                        <div id="description-error" class="error-message"></div>
                    </div>
                    
                    <!-- Quantity -->
                    <div>
                        <label for="utilityQuantity" class="block text-sm font-medium text-gray-700">Quantity</label>
                        <input type="number" id="utilityQuantity" name="quantity" required min="1" class="w-full border rounded p-2">
                        <div id="quantity-error" class="error-message"></div>
                    </div>
                    
                    <!-- img -->
                    <div>
                        <label for="utilityImage" class="block text-sm font-medium text-gray-700">Upload Image</label>
                        <input type="file" id="utilityImage" name="image" accept="image/*" class="w-full border rounded p-2">
                        <div id="image-error" class="error-message"></div>
                        <img id="utilityImagePreview" src="#" alt="Image Preview" style="display:none; max-height:300px; margin-top:10px;" class="rounded border border-dashed border-gray-300">
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Add Utility',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#ef4444',
            didOpen: () => {
                // img preview
                const imageInput = document.getElementById('utilityImage');
                const imagePreview = document.getElementById('utilityImagePreview');
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
            },
            preConfirm: () => {
                // Clear previous error messages.
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                const form = document.getElementById('addPackageUtilityForm');
                const formData = new FormData(form);
                let hasErrors = false;

               

                // Validate utility name.
                const nameInput = document.getElementById('utilityName');
                if (!nameInput.value.trim()) {
                    document.getElementById('name-error').textContent = 'Utility name is required.';
                    hasErrors = true;
                }

                // Validate quantity.
                const quantityInput = document.getElementById('utilityQuantity');
                if (!quantityInput.value || parseInt(quantityInput.value) < 1) {
                    document.getElementById('quantity-error').textContent = 'Quantity must be at least 1.';
                    hasErrors = true;
                }

                if (hasErrors) return false;

                return fetch("{{ route('utilities.store') }}", {
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
                    title: 'Utility Added!',
                    text: 'The package utility has been successfully created.',
                    timer: 2000
                }).then(() => location.reload());
            }
        });
    }
</script>

<button onclick="addPackageUtility()" class="px-2 py-1 bg-cyan-200 rounded mt-2 hover:cursor-pointer">
    Add a Package Utility here
</button>
