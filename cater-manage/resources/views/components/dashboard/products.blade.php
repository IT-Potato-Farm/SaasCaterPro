<script>
    function openEditModalItem(id, name, description, pricing10_15, pricing15_20, categoryId) {
        console.log("Editing item:", id);
        let editUrl = "{{ url('/menuitems/') }}/" + id + "/edit";
        Swal.fire({
            title: `<div class="flex items-center gap-2">
                        
                        <span class="text-cyan-600 font-semibold text-xl">Edit Item</span>
                    </div>`,
            html: `
                <form id="editItemForm-${id}" action="${editUrl}" method="POST" class="text-left">
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
                                required>${description}</textarea>
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
</script>

<div class="container mx-auto px-4 py-8">
    <header class="mb-8">
        <h1 class="text-3xl text-center font-bold text-gray-800">Menu Items</h1>

        <p class="text-gray-500 mt-2">Showing {{ $menuItems->count() }} items</p>
    </header>

    @if ($menuItems->isEmpty())
        <div class="text-center py-16 bg-gray-50 rounded-xl">
            <p class="text-cyan-600 font-medium">No menu items available. Start by adding your first item!</p>
        </div>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach ($menuItems as $menuItem)
                <div class="bg-white rounded-lg shadow-md hover:shadow-lg transition-shadow duration-300 group">
                    <!-- img -->
                    <div class="relative aspect-square bg-gray-50 overflow-hidden rounded-t-lg">
                        @if ($menuItem->image)
                            <img src="{{ asset('ItemsStored/' . $menuItem->image) }}" alt="{{ $menuItem->name }}"
                                class="w-full h-full object-cover transition-transform duration-300 group-hover:scale-105"
                                loading="lazy">
                        @else
                            <div class="w-full h-full flex flex-col items-center justify-center text-gray-400 p-4">
                                <svg class="w-12 h-12 mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span class="text-sm font-medium">No image available</span>
                            </div>
                        @endif
                    </div>

                    <!-- product description -->
                    <div class="p-4">
                        <div class="flex items-start justify-between gap-2 mb-3">
                            <h2 class="text-xl font-bold text-gray-800 truncate">{{ $menuItem->name }}</h2>
                            <span
                                class="px-2.5 py-1 rounded-full bg-purple-100 text-purple-800 text-sm font-medium shrink-0">
                                {{ $menuItem->category->name }}
                            </span>
                        </div>

                        <p class="text-gray-600 text-sm leading-relaxed line-clamp-2 mb-4 min-h-[3rem]">
                            {{ $menuItem->description }}
                        </p>
                        {{-- pricing --}}
                        <div class="mb-4">
                            <p class="text-gray-700 text-sm">
                                <strong>Price for 10-15 pax is:</strong> ₱{{ number_format($menuItem->pricing['10-15'] ?? 0, 2) }}
                            </p>
                            <p class="text-gray-700 text-sm">
                                <strong>Price for 15-20 pax is:</strong> ₱{{ number_format($menuItem->pricing['15-20'] ?? 0, 2) }}
                            </p>
                        </div>

                        <div class="flex items-center justify-between mb-4">

                            <span
                                class="px-2.5 py-1 rounded-full text-sm font-medium {{ $menuItem->status == 'available' ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ ucfirst($menuItem->status) }}
                            </span>
                        </div>

                        <!-- edit and delete -->
                        <div class="flex justify-between gap-3 pt-4 border-t border-gray-100">
                            <button
                                onclick="openEditModalItem(
                                {{ $menuItem->id }}, 
                                {{ json_encode($menuItem->name) }}, 
                                {{ json_encode($menuItem->description) }},
                                {{ json_encode($menuItem->pricing['10-15'] ?? 0) }},
                                {{ json_encode($menuItem->pricing['15-20'] ?? 0) }},
                                {{ $menuItem->category_id }}  
                                )"
                                class="flex-1 flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-md transition-colors hover:cursor-pointer">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 114.95 0 2.5 2.5 0 01-4.95 0M12 15h.01M12 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2v-5" />
                                </svg>
                                Edit
                            </button>
                            <form action="{{ route('menuitems.deleteItem', $menuItem->id) }}" method="POST"
                                class="flex-1">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)"
                                    class="w-full flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors hover:cursor-pointer">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                    </svg>
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
