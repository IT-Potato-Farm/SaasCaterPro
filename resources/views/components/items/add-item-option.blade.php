<style>
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<script>
    function addItemOption() {
        Swal.fire({
            title: '<span class="text-2xl font-bold text-gray-800">Add Item Option</span>',
            html: `
                <form id="addItemOptionForm" class="grid grid-cols-1 gap-6">
                    <!-- Type -->
                    <div>
                        <label for="swal-type" class="block text-sm font-medium text-gray-700">Type</label>
                        <input type="text" id="swal-type" name="type" required class="w-full border rounded p-2">
                        <div id="type-error" class="error-message"></div>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="swal-description" class="block text-sm font-medium text-gray-700">Description</label>
                        <textarea id="swal-description" name="description" class="w-full border rounded p-2" placeholder="(Optional)"></textarea>
                        <div id="description-error" class="error-message"></div>
                    </div>

                    <!-- Image -->
                    <div>
                        <label for="swal-image" class="block text-sm font-medium text-gray-700">Image (Optional)</label>
                        <input type="file" id="swal-image" name="image" class="w-full border rounded p-2" onchange="previewAddImage(event)">
                        <div id="image-error" class="error-message"></div>
                        <div id="imagePreviewContainer" class="mt-2 hidden">
                            <img id="imagePreview" src="" alt="Image Preview" class="w-24 h-24 object-cover rounded-lg">
                        </div>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Add Item Option',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#ef4444',
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
                    document.getElementById('type-error').textContent = 'This item option type is already taken.';
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
        const reader = new FileReader();
        reader.onload = function() {
            const imagePreview = document.getElementById('imagePreview');
            const imagePreviewContainer = document.getElementById('imagePreviewContainer');
            imagePreview.src = reader.result;
            imagePreviewContainer.classList.remove('hidden');
        };
        reader.readAsDataURL(event.target.files[0]);
    }
</script>

<button onclick="addItemOption()" class="px-2 py-1 bg-cyan-200 rounded mt-2 hover:cursor-pointer">
    Add Item Option
</button>
