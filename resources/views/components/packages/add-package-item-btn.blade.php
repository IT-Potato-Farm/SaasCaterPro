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
            <form id="addItemForm" class="space-y-4">
                <!-- Item Name -->
                <div>
                    <label for="swal-name" class="block text-sm font-medium text-gray-700 mb-1">Item Name</label>
                    <input type="text" id="swal-name" name="name" required 
                        class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors">
                    <div id="name-error" class="mt-1 text-xs text-red-500"></div>
                </div>

                <!-- Description -->
                <div>
                    <label for="swal-description" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-gray-400 font-normal">(Optional)</span></label>
                    <textarea id="swal-description" name="description" rows="3"
                        class="w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500 transition-colors"></textarea>
                    <div id="description-error" class="mt-1 text-xs text-red-500"></div>
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
        <h3 class="font-medium text-gray-800 group-hover:text-blue-700">Add Package Item</h3>
        <p class="text-xs text-gray-500">Create new package items</p>
    </div>
</button>
