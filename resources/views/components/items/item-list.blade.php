@props(['items'])
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
                <label class="flex items-center space-x-2">
                    <input type="checkbox" name="item_options[]" value="${option.id}" class="mr-2 form-checkbox text-blue-500" ${isChecked}>
                    <span>${option.type}</span>
                </label><br>
            `;
        });

        Swal.fire({
            title: `<div class="flex items-center ">
                        <span class="text-cyan-600 font-semibold text-2xl">Edit Item ulam</span>
                    </div>`,
            html: `
                <form id="editForm-${id}" action="${editUrl}" method="POST" class="text-left">
                    @csrf
                    @method('PUT')
                    <!-- Item Name -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Item Name</label>
                        <input type="text" name="name" value="${name}" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none"
                            required>
                    </div>
                    <!-- Description -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Description</label>
                        <textarea name="description" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none h-32"
                                >${description}</textarea>
                    </div>
                    <!-- ulam items fried, buttered, etc -->
                    <div class="mb-2">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Dagdag ng type of ulam</label>
                        <div class="space-y-1">
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
                popup: 'rounded-xl shadow-2xl',
                confirmButton: 'bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white px-6 py-2 rounded-lg font-medium shadow-sm transition-all',
                cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium border border-gray-300 shadow-sm transition-all'
            },
            preConfirm: () => {
                const form = document.getElementById(`editForm-${id}`);
                if (form.reportValidity()) {

                    
                    const selectedOptions = [];
                    form.querySelectorAll('input[name="item_options[]"]:checked').forEach(function(checkbox) {
                        selectedOptions.push(checkbox.value);
                    });

                    
                    form.querySelectorAll('input[name="selected_options[]"]').forEach(input => input.remove());
                    selectedOptions.forEach(optionId => {
                        let hiddenInput = document.createElement('input');
                        hiddenInput.type = 'hidden';
                        hiddenInput.name = 'selected_options[]';
                        hiddenInput.value = optionId;
                        form.appendChild(hiddenInput);
                    });

                    form.submit();  
                }
            }
        });
    }
    //  Confirm delete 
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
                cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-medium border border-gray-300 shadow-sm transition-all'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
</script>

<div class="container mx-auto px-4  ">
    

    @if ($items->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded-lg">
            <p class="text-gray-500">No items available yet.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg overflow-hidden shadow-md">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Name</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden lg:table-cell">Options</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($items as $item)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- Name Column (always visible) -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-semibold text-gray-900">{{ $item->name }}</div>
                                <!-- Mobile-only description preview -->
                                <div class="md:hidden mt-1 text-sm text-gray-500 line-clamp-2">
                                    {{ $item->description ?? 'No description available' }}
                                </div>
                                <!-- Mobile-only options preview -->
                                <div class="md:hidden mt-1">
                                    @if ($item->itemOptions->isNotEmpty())
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-blue-100 text-blue-800">
                                            {{ $item->itemOptions->count() }} options
                                        </span>
                                    @else
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-gray-100 text-gray-800">
                                            No options
                                        </span>
                                    @endif
                                </div>
                            </td>
                            
                            <!-- Description Column (hidden on mobile) -->
                            <td class="px-6 py-4 hidden md:table-cell">
                                <div class="text-sm text-gray-600 line-clamp-3 hover:line-clamp-none transition-all cursor-default">
                                    {{ $item->description ?? 'No description available' }}
                                </div>
                            </td>
                            
                            <!-- Options Column (hidden on mobile and tablet) -->
                            <td class="px-6 py-4 hidden lg:table-cell">
                                @if ($item->itemOptions->isNotEmpty())
                                    <ul class="list-disc pl-5 space-y-1 text-sm text-gray-600">
                                        @foreach ($item->itemOptions as $option)
                                            <li>{{ $option->type }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-sm text-gray-500">No options available</p>
                                @endif
                            </td>
                            
                            <!-- Actions Column (always visible) -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <button
                                        onclick="openEditItem(
                                            {{ $item->id }}, 
                                            {{ json_encode($item->name) }}, 
                                            {{ json_encode($item->description) }},
                                            window.itemOptions_{{ $item->id }},
                                            window.allItemOptions_{{ $item->id }}
                                        )"
                                        class="p-2 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 cursor-pointer transition-colors"
                                        title="Edit"
                                    >
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                        </svg>
                                    </button>

                                    <form action="{{ route('item.delete', $item->id) }}" method="POST" class="delete-form">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="button" 
                                            onclick="confirmDeleteUlam(this)"
                                            class="p-2 bg-red-100 text-red-800 rounded-md hover:bg-red-200 cursor-pointer transition-colors"
                                            title="Delete"
                                        >
                                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
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
    @endif
</div>