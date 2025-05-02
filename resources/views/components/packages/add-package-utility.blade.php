@props(['utilities', 'packages', 'packageUtilities'])
<style>
    .error-message {
        color: #ef4444;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }
</style>


<script>
    let packages = @json($packages);
    let selectedPackageIds = [];
    let packageCheckboxes = packages.map(pkg => {
        let checked = selectedPackageIds.includes(pkg.id) ? 'checked' : '';
        return `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="package_ids[]" value="${pkg.id}" id="package_${pkg.id}" ${checked}>
                        <label class="form-check-label" for="package_${pkg.id}">
                            ${pkg.name}
                        </label>
                    </div>
                `;
    }).join('');

    function addPackageUtility() {
        Swal.fire({
            title: '<span class="text-xl font-semibold text-gray-800">Add Package Utility</span>',
            html: `
                <form id="addPackageUtilityForm" class="space-y-4" enctype="multipart/form-data">
                    <!-- Image Upload Section -->
                    <div class="flex flex-col items-center p-4 bg-gray-50 rounded-lg border border-gray-200">
                        <img id="utilityImagePreview" src="#" alt="Preview" 
                            class="w-full max-w-xs h-40 object-contain mb-4 rounded-lg bg-white border-2 border-dashed border-gray-300 hidden">
                        
                        <label class="w-full">
                            <div class="flex flex-col items-center justify-center py-3 px-4 border border-gray-300 border-dashed rounded-md cursor-pointer hover:bg-gray-100 transition">
                                <svg class="w-6 h-6 text-gray-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm text-gray-600 mt-1">Click to upload image</span>
                            </div>
                            <input type="file" id="utilityImage" name="image" accept="image/*" class="hidden">
                        </label>
                        <div id="image-error" class="mt-2 text-xs text-red-500"></div>
                    </div>

                    <!-- Utility Name -->
                    <div>
                        <label for="utilityName" class="block text-sm font-medium text-gray-700 mb-1">Utility Name</label>
                        <input type="text" id="utilityName" name="name" required
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <div id="name-error" class="mt-1 text-xs text-red-500"></div>
                    </div>
                    
                    <!-- Description -->
                    <div>
                        <label for="utilityDescription" class="block text-sm font-medium text-gray-700 mb-1">Description <span class="text-gray-400 font-normal">(Optional)</span></label>
                        <textarea id="utilityDescription" name="description" rows="3"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500"></textarea>
                        <div id="description-error" class="mt-1 text-xs text-red-500"></div>
                    </div>
                    
                    <!-- Quantity -->
                    <div>
                        <label for="utilityQuantity" class="block text-sm font-medium text-gray-700 mb-1">Quantity</label>
                        <input type="number" id="utilityQuantity" name="quantity" required min="1"
                            class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-1 focus:ring-blue-500 focus:border-blue-500">
                        <div id="quantity-error" class="mt-1 text-xs text-red-500"></div>
                    </div>

                     <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Link to Packages</label>
                        ${packageCheckboxes}
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Add Utility',
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
                const imageInput = document.getElementById('utilityImage');
                const imagePreview = document.getElementById('utilityImagePreview');

                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.classList.remove('hidden');
                        };
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.classList.add('hidden');
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

                // Get selected package IDs
                const checkedPackageIds = packages.filter(pkg => form.querySelector(`#package_${pkg.id}`)
                        .checked)
                    .map(pkg => pkg.id);

                // Find all unchecked checkboxes and collect their package IDs
                const uncheckedPackageIds = packages.filter(pkg => !form.querySelector(`#package_${pkg.id}`)
                        .checked)
                    .map(pkg => pkg.id);

                console.log("Selected Package IDs:", packages.filter(pkg => form.querySelector(
                    `#package_${pkg.id}`).checked).map(pkg => pkg.id));
                // Clear any existing hidden inputs related to package_ids
                form.querySelectorAll('input[name="package_ids[]"]').forEach(input => input.remove());

                checkedPackageIds.forEach(pkgId => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'package_ids[]';
                    hiddenInput.value = pkgId;
                    form.appendChild(hiddenInput);
                });

                uncheckedPackageIds.forEach(pkgId => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'removed_package_ids[]';
                    hiddenInput.value = pkgId;
                    form.appendChild(hiddenInput);
                });



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

<button onclick="addPackageUtility()"
    class="cursor-pointer   group bg-white rounded-xl shadow-sm p-5 border border-gray-100 hover:shadow-md transition-all flex items-center gap-4 hover:border-amber-200 hover:bg-amber-50">
    <div
        class="w-10 h-10 rounded-lg bg-amber-100 flex items-center justify-center text-amber-600 group-hover:bg-amber-200 transition-colors">
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
        </svg>
    </div>
    <div class="text-left">
        <h3 class="font-medium text-gray-800 group-hover:text-amber-700">Add Utility</h3>
        <p class="text-xs text-gray-500">Add utilities for the packages</p>
    </div>
</button>
