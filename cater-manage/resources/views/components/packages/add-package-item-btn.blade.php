<style>
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>

<script>
    function addPackageItem() {
        Swal.fire({
            title: '<span class="text-2xl font-bold text-gray-800">Add Package Item</span>',
            html: `
            <form id="addPackageItemForm" class="grid grid-cols-1 gap-6" enctype="multipart/form-data">
                <!-- Package Dropdown -->
                <div>
                    <label for="packageSelect" class="block text-sm font-medium text-gray-700">Select Package</label>
                    <select name="package_id" id="packageSelect" required class="w-full border rounded p-2">
                        <option value="">Choose a Package</option>
                        @foreach ($packages as $package)
                            <option value="{{ $package->id }}">{{ $package->name }}</option>
                        @endforeach
                    </select>
                    <div id="package_id-error" class="error-message"></div>
                </div>
                
                <!-- Item Name -->
                <div>
                    <label for="swal-name" class="block text-sm font-medium text-gray-700">Item Name</label>
                    <input type="text" id="swal-name" name="name" required class="w-full border rounded p-2">
                    <div id="name-error" class="error-message"></div>
                </div>
                
                <!-- Description -->
                <div>
                    <label for="swal-description" class="block text-sm font-medium text-gray-700">Description</label>
                    <textarea id="swal-description" name="description" class="w-full border rounded p-2" placeholder="(Optional)"></textarea>
                    <div id="description-error" class="error-message"></div>
                </div>
            </form>
        `,
            showCancelButton: true,
            confirmButtonText: 'Add Package Item',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#ef4444',
            didOpen: () => {
                const nameInput = document.getElementById('swal-name');
                const packageSelect = document.getElementById('packageSelect');
                const nameError = document.getElementById('name-error');

                async function validateName() {
                    const nameValue = nameInput.value.trim();
                    const packageId = packageSelect.value;

                    if (nameValue.length > 0 && packageId) {
                        try {
                            const response = await fetch("{{ route('package_items.checkName') }}", {
                                method: "POST",
                                headers: {
                                    "X-CSRF-TOKEN": "{{ csrf_token() }}",
                                    "Content-Type": "application/json"
                                },
                                body: JSON.stringify({
                                    name: nameValue,
                                    package_id: packageId
                                })
                            });

                            const data = await response.json();
                            if (data.exists) {
                                nameError.textContent =
                                    'This package item name is already taken for the selected package.';
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

                // Add event listeners
                nameInput.addEventListener('input', validateName);
                packageSelect.addEventListener('change', validateName);
            },
            preConfirm: async () => {
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');
                const form = document.getElementById('addPackageItemForm');
                const formData = new FormData(form);
                let hasErrors = false;

                const packageSelect = document.getElementById('packageSelect');
                if (!packageSelect.value) {
                    document.getElementById('package_id-error').textContent = 'Please select a package.';
                    hasErrors = true;
                }

                const nameInput = document.getElementById('swal-name');
                if (!nameInput.value.trim()) {
                    document.getElementById('name-error').textContent = 'Item name is required.';
                    hasErrors = true;
                }

                // Ensure the name is valid before submitting
                if (nameInput.dataset.valid === "false") {
                    document.getElementById('name-error').textContent =
                        'This package item name is already taken.';
                    hasErrors = true;
                }

                if (hasErrors) return false;

                return fetch("{{ route('package_items.store') }}", {
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
                    title: 'Package Item Added!',
                    text: 'The package item has been successfully created.',
                    timer: 2000
                }).then(() => location.reload());
            }
        });
    }
</script>

<button onclick="addPackageItem()" class="px-2 py-1 bg-cyan-200 rounded mt-2 hover:cursor-pointer">
    Add a Package Item here
</button>
