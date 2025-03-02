<script>
    function openEditModalItem(id, name, description, price, categoryId) {
        console.log("item clicked edit");
        
       

        let editUrl = "{{ url('/menuitems/') }}/" + id + "/edit";
        Swal.fire({
            title: '<div class="flex items-center gap-2"><svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg><span class="text-cyan-600 font-semibold text-xl">Edit Item</span></div>',
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
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                <!-- Optional icon -->
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Description</label>
                        <div class="relative">
                            <textarea name="description" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none h-32"
                                required>${description}</textarea>
                            <div class="absolute top-3 right-3">
                                <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Price</label>
                        <div class="relative">
                            <input type="number" step="0.01" name="price" value="${price}" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none"
                                required>
                        </div>
                    </div>
                  
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Category</label>
                        <select name="category_id" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none">
                            @foreach($categories as $category)
                                <option value="{{ $category->id }}" ${categoryId == {{ $category->id }} ? 'selected' : ''}>{{ $category->name }}</option>
                            @endforeach
                        </select>
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
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Menu Items</h1>

    @if ($menuItems->isEmpty())
        <p class="text-cyan-500 text-center">No menu items available.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach ($menuItems as $menuItem)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden hover:shadow-xl transition-shadow duration-300">
                    <div class="relative aspect-square overflow-hidden"> 
                        @if ($menuItem->image)
                            <img 
                                src="{{ asset('ItemsStored/' . $menuItem->image) }}" 
                                alt="{{ $menuItem->name }}"
                                class="w-full h-full object-cover rounded-t-lg hover:scale-105 transition-transform duration-300"
                                loading="lazy"
                            >
                        @else
                            <div class="w-full h-full flex items-center justify-center bg-gray-100 text-gray-500">
                                No Image
                            </div>
                        @endif
                    </div>
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800">{{ $menuItem->name }}</h2>
                        <p class="text-gray-600 text-sm line-clamp-2">{{ $menuItem->description }}</p>
                        <p class="mt-2 text-lg font-bold text-green-600">₱{{ number_format($menuItem->price, 2) }}</p>
                        <p class="mt-1 text-sm {{ $menuItem->status == 'available' ? 'text-green-500' : 'text-red-500' }}">
                            {{ ucfirst($menuItem->status) }}
                        </p>
                        <div class="mt-4 flex justify-between">
                                <button onclick="openEditModalItem(
                                {{ $menuItem->id }}, 
                                {{ json_encode($menuItem->name) }}, 
                                {{ json_encode($menuItem->description) }},
                                {{ json_encode($menuItem->price) }},
                                 {{ $menuItem->category_id }}  // Add this line
                                )" 
                                class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition hover:cursor-pointer">
                                Edit
                            </button>
                            <form action="{{ route('menuitems.deleteItem', $menuItem->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)" 
                                    class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition hover:cursor-pointer">
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