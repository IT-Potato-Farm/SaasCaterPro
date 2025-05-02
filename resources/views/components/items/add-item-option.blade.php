
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
            title: '<span class="text-xl font-semibold text-gray-800">Add Item Option </span>',
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

<button onclick="addItemOption()"
    class="cursor-pointer   group bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition-all flex items-center gap-4 hover:border-purple-200 hover:bg-purple-50">
    <div
        class="w-10 h-10 rounded-lg bg-purple-100 flex items-center justify-center text-purple-600 group-hover:bg-purple-200 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2" />
        </svg>
    </div>
    <div class="text-left">
        <h3 class="font-medium text-gray-800 group-hover:text-purple-700">Add Package Option</h3>
        <p class="text-xs text-gray-500">Create ulam options fried, curry, and etc</p>
    </div>
</button>
