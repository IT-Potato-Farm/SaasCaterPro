@props(['menuItems', 'categories'])

<script>
    function openEditModalItem(id, name, description, image, pricing10_15, pricing15_20, categoryId, status) {
        console.log("Editing item:", id);
        
        let editUrl = "{{ url('/menuitems/') }}/" + id + "/edit";
        Swal.fire({
            title: `<div class="flex items-center ">
                        
                        <span class="text-cyan-600 font-semibold ">Edit Party Tray</span>
                    </div>`,
            html: `
                <form id="editItemForm-${id}" action="${editUrl}" method="POST" class="text-left" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Name</label>
                        <div class="relative">
                            <input type="text" name="name" value="${name}" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none"
                                required>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Description</label>
                        <div class="relative">
                            <textarea name="description" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none h-32"
                               required >${description}</textarea>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Price for 10-15 Pax</label>
                        <input type="number" step="0.01" name="pricing[10-15]" value="${pricing10_15}" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none"
                            required>
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Price for 15-20 Pax</label>
                        <input type="number" step="0.01" name="pricing[15-20]" value="${pricing15_20}" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none"
                            required>
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Category</label>
                        <select name="category_id" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none">
                            @foreach ($categories as $category)
                                <option value="{{ $category->id }}" ${categoryId == {{ $category->id }} ? 'selected' : ''}>{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>

                    

                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Current Image</label>
                        <div class=" w-full rounded-lg  overflow-hidden mb-3">
                            ${image ? `<img src="/storage/party_traypics/${image}" alt="Party tray" class=" h-32 object-cover" id="image-preview-${id}">` : `<p>No image available</p>`}
                        </div>
                        <input type="file" name="image" accept="image/*" onchange="previewImage(event, ${id})" 
                            class="w-full px-4 py-2.5 rounded-lg border border-gray-200">
                    </div>

                    <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none">
                        <option value="available" ${status == 'available' ? 'selected' : ''}>Available</option>
                        <option value="unavailable" ${status == 'unavailable' ? 'selected' : ''}>Not Available</option>
                    </select>
                </div>
                </div>

                </form>`,
            showCancelButton: true,
            confirmButtonText: 'Save Changes',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            customClass: {
                popup: 'rounded-xl shadow-2xl',
                confirmButton: 'bg-gradient-to-r from-cyan-500 to-cyan-600 hover:from-cyan-600 hover:to-cyan-700 text-white px-6 py-2 rounded-lg font-medium shadow-sm transition-all',
                cancelButton: 'bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2 rounded-lg font-medium border border-gray-300 shadow-sm transition-all',
                input: 'focus:ring-2 focus:ring-cyan-200 focus:border-cyan-500'
            },
            preConfirm: () => {
                const form = document.getElementById(`editItemForm-${id}`);
                if (form.reportValidity()) {
                    form.submit();
                }
            }
        });
    }

    function confirmDelete(button) {
        Swal.fire({
            title: 'Are you sure you want to delete this party tray?',
            text: "This action cannot be undone.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, cancel!',
            confirmButtonColor: '#d33',
            cancelButtonColor: '#3085d6',
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }

    function previewImage(event, id) {
        const file = event.target.files[0];
        const preview = document.getElementById(`image-preview-${id}`);
        if (file) {
            preview.src = URL.createObjectURL(file);
            preview.style.display = 'block';
        } else {
            preview.src = '';
            preview.style.display = 'none';
        }
    }
</script>
<div class="container mx-auto px-4 ">
    

    @if ($menuItems->isEmpty())
        <div class="text-center py-16 bg-gray-50 rounded-xl">
            <p class="text-cyan-600 font-medium">No party trays available.</p>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-lg shadow-sm">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Item</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Pricing</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Category</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($menuItems as $menuItem)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- Item Column with Image -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16 rounded-md overflow-hidden bg-gray-50">
                                        @if ($menuItem->image)
                                            <img src="{{ asset('storage/party_traypics/' . $menuItem->image) }}"
                                                alt="{{ $menuItem->name }}"
                                                class="h-full w-full object-cover"
                                                loading="lazy">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-gray-400">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $menuItem->name }}</div>
                                        <!-- Mobile-only description preview -->
                                        <div class="md:hidden mt-1 text-xs text-gray-500 line-clamp-2">
                                            {{ $menuItem->description }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Description Column (hidden on mobile) -->
                            <td class="px-6 py-4 hidden md:table-cell">
                                <div class="text-sm text-gray-500">
                                    {{ $menuItem->description }}
                                </div>
                            </td>
                            
                            <!-- Pricing Column -->
                            <td class="px-6 py-4">
                                <div class="text-sm space-y-1">
                                    <div class="text-gray-700">
                                        <span class="font-medium">10-15 pax:</span> 
                                        ₱{{ number_format($menuItem->pricing['10-15'] ?? 0, 2) }}
                                    </div>
                                    <div class="text-gray-700">
                                        <span class="font-medium">15-20 pax:</span> 
                                        ₱{{ number_format($menuItem->pricing['15-20'] ?? 0, 2) }}
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Category Column (hidden on mobile) -->
                            <td class="px-6 py-4 hidden sm:table-cell">
                                @if ($menuItem->category)
                                    <span class="px-2 py-1 rounded-full bg-purple-100 text-purple-800 text-xs font-medium">
                                        {{ $menuItem->category->name }}
                                    </span>
                                @else
                                    <span class="text-xs text-gray-400">None</span>
                                @endif
                            </td>
                            
                            <!-- Status Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <span class="px-2 py-1 rounded-full text-xs font-medium {{ $menuItem->status == 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                    {{ ucfirst($menuItem->status) }}
                                </span>
                            </td>
                            
                            <!-- Actions Column -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-2">
                                    <!-- Edit Button -->
                                    <button
                                        onclick="openEditModalItem(
                                            {{ $menuItem->id }}, 
                                            {{ json_encode($menuItem->name) }}, 
                                            {{ json_encode($menuItem->description) }},
                                            {{ json_encode($menuItem->image) }},
                                            {{ json_encode($menuItem->pricing['10-15'] ?? 0) }},
                                            {{ json_encode($menuItem->pricing['15-20'] ?? 0) }},
                                            {{ $menuItem->category_id ?? 'null' }},
                                            {{ json_encode($menuItem->status) }}
                                        )"
                                        class="p-2 bg-amber-100 text-amber-800 cursor-pointer rounded-md hover:bg-amber-200 transition-colors"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 114.95 0 2.5 2.5 0 01-4.95 0M12 15h.01M12 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2v-5" />
                                        </svg>
                                    </button>
                                    
                                    <!-- Delete Button -->
                                    <form action="{{ route('menuitems.deleteItem', $menuItem->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="button" 
                                            onclick="confirmDelete(this)"
                                            class="p-2 bg-red-100 text-red-800 cursor-pointer rounded-md hover:bg-red-200 transition-colors"
                                            title="Delete">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
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
        <footer class="mb-2">
            <p class="text-gray-500 mt-2 text-center">Showing {{ $menuItems->count() }} items</p>
        </footer>
    @endif
</div>