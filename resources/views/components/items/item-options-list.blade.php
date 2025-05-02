@props(['itemOptions', 'categories'])

<script>
    function openEditItemOption(id, type, description, image, categoryId) {
        console.log("Editing item option:", id, "Category ID:", categoryId); // Log category ID on open

        let editUrl = "{{ route('itemOption.edit', ':id') }}".replace(':id', id);
        if (description === null || description === 'null' || description === undefined) { // Check for undefined too
            description = '';
        }
        // Ensure image path is handled correctly if null/empty
        let currentImageSrc = image && image !== 'null' && image !== 'undefined' ? image : '/placeholder.png'; // Provide a default placeholder if no image

        Swal.fire({
            title: `<div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        <span class="text-cyan-600 font-semibold text-xl">Edit Item Option</span>
                    </div>`,
            html: `
                <form id="editForm-${id}" action="${editUrl}" method="POST" class="text-left mt-4 space-y-4" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Item Type -->
                    <div>
                        <label for="edit-type-${id}" class="block text-sm font-medium text-gray-600 mb-1">Item Type</label>
                        <input id="edit-type-${id}" type="text" name="type" value="${type}"
                               class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none"
                               required>
                    </div>

                    <!-- Description -->
                    <div>
                        <label for="edit-desc-${id}" class="block text-sm font-medium text-gray-600 mb-1">Description</label>
                        <textarea id="edit-desc-${id}" name="description"
                                  class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none h-24 resize-none"
                                  >${description}</textarea>
                    </div>

                    <!-- Category -->
                    <div>
                        <label for="categoryDropdown-${id}" class="block text-sm font-medium text-gray-600 mb-1">Category</label>
                        <select name="category_id" id="categoryDropdown-${id}" class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none">
                            <option value="">Not Set</option> {{-- Option for no category --}}
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <!-- Image -->
                   <div>
                        <label for="edit-image-${id}" class="block text-sm font-medium text-gray-600 mb-1">Item Image</label>
                        <div class="flex items-center space-x-4">
                           <img id="imagePreview-${id}" src="${currentImageSrc}" alt="Current Image" class="w-16 h-16 object-cover rounded-lg border border-gray-200" />
                           <div class="flex-grow">
                               <input id="edit-image-${id}" type="file" name="image"
                                      class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-cyan-50 file:text-cyan-700 hover:file:bg-cyan-100"
                                      onchange="previewImage(event, 'imagePreview-${id}')"> {{-- Pass preview ID --}}
                               <p class="text-xs text-gray-500 mt-1">Leave blank to keep the current image.</p>
                           </div>
                        </div>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Save Changes',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            customClass: {
                popup: 'rounded-xl shadow-2xl w-full max-w-md', // Adjusted width
                confirmButton: 'bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white px-6 py-2 rounded-lg font-medium shadow-sm transition-all',
                cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium border border-gray-300 shadow-sm transition-all mr-2' // Added margin
            },
            width: 'auto',
            didOpen: () => {
                // Set the category dropdown value correctly, handling null/undefined
                const dropdown = document.getElementById(`categoryDropdown-${id}`);
                if (dropdown) {
                    dropdown.value = (categoryId === null || categoryId === undefined) ? '' : categoryId;
                    console.log("Setting dropdown value to:", dropdown.value);
                }
            },
            preConfirm: () => {
                const form = document.getElementById(`editForm-${id}`);
                if (!form) {
                    Swal.showValidationMessage(`Error: Could not find form.`);
                    return false;
                }

                // Basic HTML5 validation check
                 if (!form.checkValidity()) {
                     form.reportValidity(); // Trigger browser validation messages
                     return false; // Prevent submission
                 }

                // *** START: Save current page number ***
                const paginationControls = document.getElementById("optionspagination-controls"); // Use correct ID
                let currentPageToSave = 1;
                if (paginationControls) {
                    const activeButton = paginationControls.querySelector('button.bg-blue-500'); // Find active button
                    if (activeButton) {
                        currentPageToSave = parseInt(activeButton.textContent, 10);
                    }
                }
                sessionStorage.setItem('itemOptionListPage', currentPageToSave); // Use specific key
                console.log('Saving item option page:', currentPageToSave);
                // *** END: Save current page number ***


                // Prepare FormData for fetch
                const formData = new FormData(form);

                 // IMPORTANT for PUT/PATCH with FormData via fetch when file might be empty:
                 // If no new file is selected, remove the 'image' field from FormData
                 // so the backend doesn't try to process an empty upload.
                 const imageInput = form.querySelector('input[name="image"]');
                 if (imageInput && imageInput.files.length === 0) {
                     formData.delete('image');
                 }

                 // Add _method for Laravel to recognize PUT/PATCH with FormData
                 formData.append('_method', 'PUT');


                return fetch(form.action, {
                    method: 'POST', // Use POST because FormData + PUT/PATCH can be tricky
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content'), // Add CSRF token
                        'X-Requested-With': 'XMLHttpRequest',
                        'Accept': 'application/json'
                    }
                })
                .then(async response => { // Use async to await response.json() easily
                    if (!response.ok) {
                        const errorData = await response.json(); // Await the json body
                        console.error("Server error response:", errorData);
                        let errorMessage = 'An error occurred.';
                        if (errorData.errors) {
                            errorMessage = Object.values(errorData.errors).flat().join('<br>'); // Flatten errors
                        } else if (errorData.message) {
                            errorMessage = errorData.message;
                        }
                        // Throw an error that Swal's catch block below will handle
                        throw new Error(errorMessage);
                    }
                    return response.json(); // Return successful data
                })
                .then(data => {
                     console.log("Success response:", data);
                     return data; // Pass success data to the next .then()
                 })
                .catch(error => {
                    console.error("Fetch error:", error);
                    // Show validation message using the error thrown from the .then block or fetch failure
                    Swal.showValidationMessage(`Request failed: ${error.message}`);
                    return false; // Indicate preConfirm failure
                });
            }
        }).then((result) => {
             // Check if preConfirm resolved successfully (didn't return false) and wasn't dismissed
            if (result.isConfirmed && result.value) {
                Swal.fire({
                    icon: 'success',
                    title: 'Success!',
                    text: result.value.message || 'Item option updated successfully', // Use message from server if available
                    timer: 1500, // Auto close timer
                    showConfirmButton: false
                    // customClass: { // Removed custom class for default look
                    //     confirmButton: '...'
                    // }
                }).then(() => {
                    location.reload(); // Refresh page after success alert
                });
            } else if (result.dismiss) {
                console.log("Edit modal dismissed:", result.dismiss);
            } else {
                 // This might happen if preConfirm returned false due to validation or fetch error
                console.log("Edit modal closed without confirmation (likely validation error).");
            }
        });
    }

    // Updated Live image preview function
    function previewImage(event, previewElementId) {
        const reader = new FileReader();
        const imagePreview = document.getElementById(previewElementId); // Use the passed ID

        if (!imagePreview) return; // Element not found

        reader.onload = function() {
            if (reader.result) {
                imagePreview.src = reader.result;
            }
        };
         reader.onerror = function() {
             console.error("Error reading file for preview.");
             // Optionally reset to a default image or show an error
         }

        if (event.target.files[0]) {
            reader.readAsDataURL(event.target.files[0]);
        } else {
             // Maybe reset to original image if user cancels file selection?
             // imagePreview.src = originalImageSrc; // You'd need to store the original src
        }
    }

    // Update `confirmDelete` Function
    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This item option will be permanently deleted!',
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            customClass: {
                confirmButton: 'bg-red-600 hover:bg-red-700 text-white px-6 py-2 rounded-lg font-medium shadow-sm transition-all',
                cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-medium border border-gray-300 shadow-sm transition-all mr-2'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                // *** START: Save current page number ***
                const paginationControls = document.getElementById("optionspagination-controls"); // Use correct ID
                let currentPageToSave = 1;
                if (paginationControls) {
                    const activeButton = paginationControls.querySelector('button.bg-blue-500');
                    if (activeButton) {
                        currentPageToSave = parseInt(activeButton.textContent, 10);
                    }
                }
                sessionStorage.setItem('itemOptionListPage', currentPageToSave); // Use specific key
                console.log('Saving item option page before delete:', currentPageToSave);
                // *** END: Save current page number ***

                // Submit the form
                button.closest('form').submit();
            }
        });
    }
        </script>

<div class="mx-auto p-4 mb-4">
    
    @if ($itemOptions->isEmpty())
    <div class="text-center py-12 bg-gray-50 rounded-lg">
        <p class="text-gray-500">No item options available at the moment.</p>
    </div>
    @else
    {{-- <h1 class="text-2xl font-semibold text-center">MANAGE ITEM OPTIONS</h1> --}}
    <div class="overflow-x-auto bg-white rounded-lg shadow-md p-4 md:p-6">
        <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-md">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Image</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Type</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Description</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="itemoption-table-body divide-y divide-gray-200">
                    @foreach ($itemOptions as $itemOption)
                        <tr class="itemoption-row hover:bg-gray-50 transition-colors duration-150">
                            <!-- Image Column -->
                            <td class="px-6 py-4">
                                <div class="flex-shrink-0 h-16 w-16">
                                    @if ($itemOption->image)
                                        <img src="{{ asset('storage/' . $itemOption->image) }}" alt="Item Option Image"
                                            class="h-16 w-16 object-cover rounded-full">
                                    @else
                                        <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400" viewBox="0 0 24 24"
                                            fill="currentColor" stroke="currentColor" stroke-width="2">
                                            <circle cx="12" cy="12" r="10" fill="none" />
                                            <path d="M12 2v20M2 12h20" />
                                        </svg>
                                    @endif
                                </div>
                            </td>

                            <!-- Type Column -->
                            <td class="px-6 py-4">
                                <div class="text-lg font-semibold text-gray-900">{{ $itemOption->type }}</div>
                                <!-- Mobile-only description preview -->
                                <div class="md:hidden mt-1 text-sm text-gray-700 line-clamp-2">
                                    {{ $itemOption->description }}
                                </div>
                            </td>
                            {{-- category --}}
                            <td class="px-6 py-4">
                                <div class="text-lg font-semibold text-gray-900">
                                    {{ $itemOption->category ? $itemOption->category->name : 'No category' }}
                                </div>
                            </td>

                            <!-- Description Column (hidden on mobile) -->
                            <td class="px-6 py-4 hidden md:table-cell">
                                <div class="text-sm text-gray-700">
                                    {{ $itemOption->description }}
                                </div>
                            </td>

                            <!-- Actions Column  -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button
                                        onclick="openEditItemOption(
                                            {{ $itemOption->id }},
                                            {{ json_encode($itemOption->type) }},
                                            {{ json_encode($itemOption->description) }},
                                            '{{ asset('storage/' . $itemOption->image) }}',
                                            {{ $itemOption->category_id ?? 'null' }}
                                        )"
                                        class="flex items-center px-3 py-2 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 cursor-pointer transition-colors"
                                        title="Edit"
                                    >
                                        <svg class="w-5 h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                        <span class="hidden md:inline">Edit</span>
                                    </button>

                                    <form action="{{ route('itemOption.delete', $itemOption->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button
                                            type="button"
                                            onclick="confirmDelete(this)"
                                            class="flex items-center px-3 py-2 bg-red-100 text-red-800 rounded-md hover:bg-red-200 cursor-pointer transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-5 h-5 mr-1 md:mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            <span class="hidden md:inline">Delete</span>
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
            <div id="optionspagination-controls" class="flex justify-center mt-4 gap-2"></div>
            <footer class="mb-2">
                <p id="itemsoption-count" class="text-gray-500 mt-2 text-center"></p>
            </footer>
        </div>
    @endif
</div>



{{-- PAGINATION FOR ITEM  options TABLES --}}
{{-- PAGINATION FOR ITEM OPTIONS TABLES --}}
<script>
    document.addEventListener("DOMContentLoaded", function () {
        const rows = document.querySelectorAll(".itemoption-row"); // Use correct row class
        const rowsPerPage = 5;
        const tableBody = document.querySelector(".itemoption-table-body"); // Use class selector
        const paginationControls = document.getElementById("optionspagination-controls"); // Use correct ID

         // Guard clauses for missing elements
         if (!tableBody || !paginationControls) {
            console.warn("Pagination elements not found for item options.");
            return;
         }
         if (rows.length === 0) {
             paginationControls.innerHTML = ""; // Clear controls if no rows
             return; // No rows to paginate
         }


        // *** Default starting page ***
        let currentPage = 1;

        // *** Retrieve and set the page from sessionStorage if available ***
        const savedPage = sessionStorage.getItem('itemOptionListPage'); // Use specific key
        if (savedPage) {
            const potentialPage = parseInt(savedPage, 10);
            const maxPage = Math.ceil(rows.length / rowsPerPage);
            // Ensure saved page is valid and within bounds
            if (!isNaN(potentialPage) && potentialPage > 0 && potentialPage <= maxPage) {
                currentPage = potentialPage;
                console.log('Restored item option page:', currentPage);
            } else {
                console.log('Saved item option page invalid or out of bounds, defaulting to 1.');
            }
            // *** IMPORTANT: Remove the item after reading it ***
            sessionStorage.removeItem('itemOptionListPage');
        }

        function displayRows(page) {
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            rows.forEach((row, index) => {
                // Set display based on index range
                row.style.display = (index >= start && index < end) ? "" : "none";
            });

            updateItemOptionCountDisplay(); // Update item count whenever rows are displayed

        }

        function setupPagination() {
             if (rows.length <= rowsPerPage) {
                 paginationControls.innerHTML = ""; // No pagination needed if fits on one page
                 updateItemOptionCountDisplay(); // Update count when no pagination is needed

                 return;
             };

            paginationControls.innerHTML = ""; // Clear existing buttons
            const pageCount = Math.ceil(rows.length / rowsPerPage);

            for (let i = 1; i <= pageCount; i++) {
                const button = document.createElement("button");
                button.textContent = i;
                // Apply Tailwind classes for styling
                button.className = `px-3 py-1 border rounded transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-400 ${
                    i === currentPage
                        ? "bg-blue-500 text-white border-blue-500 cursor-default" // Active page style
                        : "bg-white text-gray-700 border-gray-300 hover:bg-gray-100" // Inactive page style
                }`;

                button.addEventListener("click", function () {
                    if (i === currentPage) return; // Don't re-render if clicking the active page

                    currentPage = i;
                    displayRows(currentPage);

                    // Update button styles efficiently
                    const currentActive = paginationControls.querySelector('button.bg-blue-500');
                    if (currentActive) {
                        currentActive.className = currentActive.className.replace("bg-blue-500 text-white border-blue-500 cursor-default", "bg-white text-gray-700 border-gray-300 hover:bg-gray-100");
                    }
                    button.className = button.className.replace("bg-white text-gray-700 border-gray-300 hover:bg-gray-100", "bg-blue-500 text-white border-blue-500 cursor-default");
                });

                paginationControls.appendChild(button);
            }
            updateItemOptionCountDisplay();
        }
        function updateItemOptionCountDisplay() {
        const totalItems = rows.length;
        const start = (currentPage - 1) * rowsPerPage + 1;
        const end = Math.min(currentPage * rowsPerPage, totalItems);

        const countText = `Showing ${start}–${end} of ${totalItems} items`;
        document.getElementById('itemsoption-count').textContent = countText;
    }
        

        // Initial display and pagination setup
        displayRows(currentPage);
        setupPagination();
    });
</script>
