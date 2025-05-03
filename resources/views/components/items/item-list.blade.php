<script>
    // Define item options as global window variables for easier access
    @foreach ($items as $item)
        window.itemOptions_{{ $item->id }} = @json($item->itemOptions->toArray());
        // Store all available options in a separate variable
        window.allItemOptions_{{ $item->id }} = @json(\App\Models\ItemOption::all()->toArray());
    @endforeach
</script>

<script>
    function openEditItem(id, name, description, selectedOptions, allOptions) {
        let editUrl = "{{ route('item.edit', ':id') }}".replace(':id', id);
        if (description === null || description === 'null') {
            description = '';
        }
        // Generate checkboxes for all available options
        let optionsHtml = '';
        allOptions.forEach(function(option) {
            // Check if this option is in the selected options array
            let isChecked = selectedOptions.some(itemOption => itemOption.id === option.id) ? 'checked' : '';

            optionsHtml += `
                <label class="inline-flex items-center space-x-2 mr-4 mb-2"> {{-- Added margin --}}
                    <input type="checkbox" name="item_options[]" value="${option.id}" class="form-checkbox h-4 w-4 text-cyan-600 border-gray-300 rounded focus:ring-cyan-500" ${isChecked}> {{-- Tailwind checkbox styling --}}
                    <span class="ml-2 text-sm text-gray-700">${option.type}</span>
                </label>
            `;
        });

        Swal.fire({
            title: `<div class="flex items-center ">
                        <span class="text-cyan-600 font-semibold text-2xl">Edit Item ulam</span>
                    </div>`,
            html: `
                <form id="editForm-${id}" action="${editUrl}" method="POST" class="text-left mt-4 space-y-4"> {{-- Added margin and spacing --}}
                    @csrf
                    @method('PUT')
                    <!-- Item Name -->
                    <div>
                        <label for="edit-name-${id}" class="block text-sm font-medium text-gray-600 mb-1">Item Name</label>
                        <input id="edit-name-${id}" type="text" name="name" value="${name}"
                            class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none"
                            required>
                    </div>
                    <!-- Description -->
                    <div>
                        <label for="edit-description-${id}" class="block text-sm font-medium text-gray-600 mb-1">Description</label>
                        <textarea id="edit-description-${id}" name="description"
                                class="w-full px-4 py-2 rounded-lg border border-gray-300 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none h-32 resize-none" {{-- Added resize-none --}}
                                >${description}</textarea>
                    </div>
                    <!-- ulam items fried, buttered, etc -->
                    <div>
                        <label class="block text-sm font-medium text-gray-600 mb-2">Options</label> {{-- Simplified label --}}
                        <div class="flex flex-wrap gap-x-4 gap-y-2 border border-gray-200 p-3 rounded-md max-h-40 overflow-y-auto"> {{-- Added border, padding, scroll --}}
                            ${optionsHtml}
                        </div>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Save Changes',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            customClass: {
                popup: 'rounded-xl shadow-2xl w-full max-w-lg', // Responsive width
                confirmButton: 'bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white px-6 py-2 rounded-lg font-medium shadow-sm transition-all',
                cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium border border-gray-300 shadow-sm transition-all mr-2' // Added margin
            },
            width: 'auto', // Let customClass handle width
            preConfirm: () => {
                const form = document.getElementById(`editForm-${id}`);
                // Basic HTML5 validation check
                if (!form.checkValidity()) {
                    form.reportValidity(); // Trigger browser validation messages
                    return false; // Prevent submission
                }
               
                // Find current page from pagination controls
                const paginationControls = document.getElementById("pagination-controls");
                let currentPageToSave = 1; // Default to 1 if controls not found or no active button
                if (paginationControls) {
                    const activeButton = paginationControls.querySelector(
                        'button.bg-blue-500'); // Find the active button by its class
                    if (activeButton) {
                        currentPageToSave = parseInt(activeButton.textContent, 10);
                    }
                }

                // *** Store the current page number before submitting ***
                sessionStorage.setItem('itemListPage', currentPageToSave);
                console.log('Saving page:', currentPageToSave); // For debugging

                // Process selected options for form submission
                const selectedOptionsValues = [];
                form.querySelectorAll('input[name="item_options[]"]:checked').forEach(function(checkbox) {
                    selectedOptionsValues.push(checkbox.value);
                });

                // Remove any previously added hidden inputs for selected_options to avoid duplication
                form.querySelectorAll('input[name="selected_options[]"]').forEach(input => input.remove());

                // Add hidden inputs for the currently selected options
                selectedOptionsValues.forEach(optionId => {
                    let hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'selected_options[]'; // Match controller expectation
                    hiddenInput.value = optionId;
                    form.appendChild(hiddenInput);
                });

                // Submit the form programmatically
                return form.submit(); // Return the submission to allow Swal to close, etc.
            }
        });
    }

    // Confirm delete (no changes needed here for pagination)
    function confirmDeleteUlam(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This ulam will be permanently deleted!',
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
                // *** Store the current page number before submitting delete form ***
                const paginationControls = document.getElementById("pagination-controls");
                let currentPageToSave = 1;
                if (paginationControls) {
                    const activeButton = paginationControls.querySelector('button.bg-blue-500');
                    if (activeButton) {
                        currentPageToSave = parseInt(activeButton.textContent, 10);
                    }
                }
                sessionStorage.setItem('itemListPage', currentPageToSave);
                console.log('Saving page before delete:', currentPageToSave);

                button.closest('form').submit();
            }
        });
    }
</script>

<!-- Rest of your HTML (Table, etc.) -->
<div class="container mx-auto px-4  ">


    @if ($items->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded-lg">
            <p class="text-gray-500">No items available yet.</p>
        </div>
    @else
        <div class="overflow-x-auto bg-white rounded-lg shadow-md p-4 md:p-6">
            {{-- <h1 class="text-2xl text-center font-semibold text-gray-700 mb-6">ULAM MANAGEMENT</h1>  --}}
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Name</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">
                                Description</th>
                            <th scope="col"
                                class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">
                                Options</th>
                            <th scope="col"
                                class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">
                                Actions</th>
                        </tr>
                    </thead>
                    <tbody id="item-table-body" class="bg-white divide-y divide-gray-200">
                        @foreach ($items as $item)
                            <tr class="item-row hover:bg-gray-50 transition-colors duration-150">
                                <!-- Name Column -->
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-semibold text-gray-900">{{ $item->name }}</div>
                                    <div class="md:hidden mt-1 text-sm text-gray-500 line-clamp-2">
                                        {{ $item->description ?? 'No description' }}
                                    </div>
                                    <div class="md:hidden mt-1">
                                        @if ($item->itemOptions->isNotEmpty())
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-100 text-blue-800">
                                                {{ $item->itemOptions->count() }}
                                                {{ Str::plural('option', $item->itemOptions->count()) }}
                                            </span>
                                        @else
                                            <span
                                                class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-gray-100 text-gray-800">
                                                No options
                                            </span>
                                        @endif
                                    </div>
                                </td>
                                <!-- Description Column -->
                                <td class="px-6 py-4 hidden md:table-cell">
                                    <div
                                        class="text-sm text-gray-600 line-clamp-3 hover:line-clamp-none transition-all cursor-default max-w-xs">
                                        {{-- Added max-width --}}
                                        {{ $item->description ?? 'N/A' }}
                                    </div>
                                </td>
                                <!-- Options Column -->
                                <td class="px-6 py-4 hidden lg:table-cell">
                                    @if ($item->itemOptions->isNotEmpty())
                                        <p class="text-sm text-gray-600 max-w-xs truncate"> {{-- Added max-width & truncate --}}
                                            {{ $item->itemOptions->pluck('type')->join(', ') }}
                                        </p>
                                    @else
                                        <p class="text-sm text-gray-500">N/A</p>
                                    @endif
                                </td>
                                <!-- Actions Column -->
                                <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                    <div class="flex justify-end items-center space-x-2 ">
                                        <button type="button" {{-- Explicitly set type --}}
                                            onclick="openEditItem(
                                                {{ $item->id }},
                                                {{ json_encode($item->name) }},
                                                {{ json_encode($item->description) }},
                                                window.itemOptions_{{ $item->id }},
                                                window.allItemOptions_{{ $item->id }}
                                            )"
                                            class="p-1.5 cursor-pointer text-blue-600 hover:text-blue-800 hover:bg-blue-100 rounded-md transition-colors"
                                            title="Edit">
                                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                <path
                                                    d="M17.414 2.586a2 2 0 00-2.828 0L7 10.172V13h2.828l7.586-7.586a2 2 0 000-2.828z">
                                                </path>
                                                <path fill-rule="evenodd"
                                                    d="M2 6a2 2 0 012-2h4a1 1 0 010 2H4v10h10v-4a1 1 0 112 0v4a2 2 0 01-2 2H4a2 2 0 01-2-2V6z"
                                                    clip-rule="evenodd"></path>
                                            </svg>
                                        </button>

                                        <form action="{{ route('item.delete', $item->id) }}" method="POST"
                                            class="delete-form inline-block"> {{-- Added inline-block --}}
                                            @csrf
                                            @method('DELETE')
                                            <button type="button" onclick="confirmDeleteUlam(this)"
                                                class="p-1.5 cursor-pointer text-red-600 hover:text-red-800 hover:bg-red-100 rounded-md transition-colors"
                                                title="Delete">
                                                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20">
                                                    <path fill-rule="evenodd"
                                                        d="M9 2a1 1 0 00-.894.553L7.382 4H4a1 1 0 000 2v10a2 2 0 002 2h8a2 2 0 002-2V6a1 1 0 100-2h-3.382l-.724-1.447A1 1 0 0011 2H9zM7 8a1 1 0 012 0v6a1 1 0 11-2 0V8zm5-1a1 1 0 00-1 1v6a1 1 0 102 0V8a1 1 0 00-1-1z"
                                                        clip-rule="evenodd"></path>
                                                </svg>
                                            </button>
                                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
            {{-- Pagination Controls Container --}}
            <div id="pagination-controls" class="flex justify-center mt-6 gap-2"></div>
            <footer class="mb-2">
                <p id="items-count" class="text-gray-500 mt-2 text-center"></p>
            </footer>
        </div>
    @endif
</div>


{{-- PAGINATION FOR ITEM TABLES --}}
<script>
    document.addEventListener("DOMContentLoaded", function() {
        const rowsPerPage = 5;
        const tableBody = document.getElementById("item-table-body");
        const paginationControls = document.getElementById("pagination-controls");
        let currentPage = 1;

        function getRows() {
            return document.querySelectorAll("#item-table-body .item-row");
        }

        const savedPage = sessionStorage.getItem('itemListPage');
        if (savedPage) {
            const potentialPage = parseInt(savedPage, 10);
            const maxPage = Math.ceil(getRows().length / rowsPerPage);
            if (!isNaN(potentialPage) && potentialPage > 0 && potentialPage <= maxPage) {
                currentPage = potentialPage;
                console.log('Restored page:', currentPage);
            } else {
                console.log('Saved page invalid or out of bounds, defaulting to 1.');
            }
            sessionStorage.removeItem('itemListPage');
        }

        function displayRows(page) {
            const rows = getRows();
            const start = (page - 1) * rowsPerPage;
            const end = start + rowsPerPage;

            if (!tableBody) return;

            rows.forEach(row => row.style.display = 'none');
            Array.from(rows).slice(start, end).forEach(row => row.style.display = '');
            updateItemCountDisplay(); // Update count when rows are displayed

        }

        function setupPagination() {
            const rows = getRows();
            if (!paginationControls || rows.length <= rowsPerPage) {
                if (paginationControls) paginationControls.innerHTML = "";
                updateItemCountDisplay(); // Update count when no pagination is needed

                return;
            }

            paginationControls.innerHTML = "";
            const pageCount = Math.ceil(rows.length / rowsPerPage);

            for (let i = 1; i <= pageCount; i++) {
                const button = document.createElement("button");
                button.textContent = i;
                button.className = `px-3 py-1 border rounded transition-colors duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-blue-400 ${
                    i === currentPage
                        ? "bg-blue-500 text-white border-blue-500 cursor-default"
                        : "bg-white text-gray-700 border-gray-300 hover:bg-gray-100"
                }`;

                button.addEventListener("click", function() {
                    if (i === currentPage) return;
                    currentPage = i;
                    displayRows(currentPage);

                    const currentActive = paginationControls.querySelector('button.bg-blue-500');
                    if (currentActive) {
                        currentActive.classList.remove('bg-blue-500', 'text-white', 'border-blue-500',
                            'cursor-default');
                        currentActive.classList.add('bg-white', 'text-gray-700', 'border-gray-300',
                            'hover:bg-gray-100');
                    }
                    button.classList.add('bg-blue-500', 'text-white', 'border-blue-500',
                        'cursor-default');
                    button.classList.remove('bg-white', 'text-gray-700', 'border-gray-300',
                        'hover:bg-gray-100');
                });

                paginationControls.appendChild(button);
            }
            updateItemCountDisplay(); // Update count after pagination setup

        }

        function updateItemCountDisplay() {
            const rows = getRows();
            const totalItems = rows.length;
            const start = (currentPage - 1) * rowsPerPage + 1;
            const end = Math.min(currentPage * rowsPerPage, totalItems);

            const countText = `Showing ${start}–${end} of ${totalItems} items`;
            document.getElementById('items-count').textContent = countText;
        }

        // Global refresh function to call after adding items dynamically
        window.refreshItemPagination = function() {
            const rows = getRows();
            const maxPage = Math.ceil(rows.length / rowsPerPage);
            if (currentPage > maxPage) currentPage = maxPage;

            setupPagination();
            displayRows(currentPage);
        };

        // Initial render
        setupPagination();
        displayRows(currentPage);
    });
</script>
