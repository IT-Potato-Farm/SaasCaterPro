<script>
    function openEditItem(id, name, description) {
        let editUrl = "{{ route('item.edit', ':id') }}".replace(':id', id);

        Swal.fire({
            title: `<div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        <span class="text-cyan-600 font-semibold text-xl">Edit Item</span>
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
                                  required>${description}</textarea>
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
                    form.submit();
                }
            }
        });
    }
</script>

<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center">Items</h2>

    @if ($items->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded-lg">
            <p class="text-gray-500">No items available yet.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($items as $item)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <div class="p-6">
                        <div class="mb-4">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-1">{{ $item->name }}</h3>
                        </div>

                        <p class="text-gray-600 mb-4 line-clamp-3 hover:line-clamp-none transition-all">
                            {{ $item->description }}
                        </p>
                        
                        {{--  item options --}}
                        @if($item->itemOptions->isNotEmpty())
                            <div class="mb-4">
                                <h4 class="font-semibold text-gray-700">Item Options:</h4>
                                <ul class="list-disc pl-6 space-y-1">
                                    @foreach($item->itemOptions as $option)
                                        <li class="text-gray-600">{{ $option->type }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @else
                            <p class="text-gray-500">No options available for this item.</p>
                        @endif

                        <div class="flex space-x-2 mt-4">
                            <button
                                onclick="openEditItem(
                            {{ $item->id }}, 
                            {{ json_encode($item->name) }}, 
                            {{ json_encode($item->description) }}
                            )"
                                class="flex-1 px-4 py-2 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition-colors">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Edit
                            </button>
                            <form action="{{ route('item.delete', $item->id) }}" method="POST" class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)"
                                    class="flex-1 px-4 py-2 bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition-colors">
                                    <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
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
