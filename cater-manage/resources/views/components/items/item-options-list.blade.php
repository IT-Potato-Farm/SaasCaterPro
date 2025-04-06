<script>
    function openEditItemOption(id, type, description, image) {
        let editUrl = "{{ route('itemOption.edit', ':id') }}".replace(':id', id);

        Swal.fire({
            title: `<div class="flex items-center gap-2">
                        <svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                          <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path>
                        </svg>
                        <span class="text-cyan-600 font-semibold text-xl">Edit Item Option</span>
                    </div>`,
            html: `
                <form id="editForm-${id}" action="${editUrl}" method="POST" class="text-left" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    <!-- Item Type -->
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Item Type</label>
                        <input type="text" name="type" value="${type}" 
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

                    <!-- Image -->
                   <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Item Image</label>
                        <input type="file" name="image" 
                               class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none" 
                               onchange="previewImage(event)">
                        <small class="text-gray-500">Leave blank to keep the current image</small>
                        <div class="mt-2">
                            <!-- Display Image -->
                            <img id="imagePreview" src="${image}" alt="Item Image" class="w-24 h-24 object-cover rounded-lg" />
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
                    form.submit();
                }
            }
        });
    }

    // Live image preview function
    function previewImage(event) {
        const reader = new FileReader();
        reader.onload = function() {
            const imagePreview = document.getElementById('imagePreview');
            imagePreview.src = reader.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    //  Confirm delete 
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
                cancelButton: 'bg-gray-200 hover:bg-gray-300 text-gray-800 px-6 py-2 rounded-lg font-medium border border-gray-300 shadow-sm transition-all'
            }
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest('form').submit();
            }
        });
    }
</script>



<div class="max-w-4xl mx-auto p-4">
    <h1 class="text-2xl font-semibold mb-4 text-center">ITEM OPTIONS</h1>

    <ul class="space-y-4">
        @if ($itemOptions->isEmpty())
            <div class="text-center py-12 bg-gray-50 rounded-lg">
                <p class="text-gray-500">No item options available at the moment.</p>
            </div>
        @else
            @foreach ($itemOptions as $itemOption)
                <li class="bg-white p-4 rounded-lg shadow-md hover:bg-gray-100">
                    <div class="flex items-center space-x-4">
                        {{-- Image or Default SVG --}}
                        @if ($itemOption->image)
                            <img src="{{ asset('storage/' . $itemOption->image) }}" alt="Item Option Image"
                                class="w-16 h-16 object-cover rounded-full">
                        @else
                            <svg xmlns="http://www.w3.org/2000/svg" class="w-16 h-16 text-gray-400" viewBox="0 0 24 24"
                                fill="currentColor" stroke="currentColor" stroke-width="2">
                                <circle cx="12" cy="12" r="10" fill="none" />
                                <path d="M12 2v20M2 12h20" />
                            </svg>
                        @endif

                        <div class="flex-1">
                            <strong class="text-lg text-blue-600">{{ $itemOption->type }}</strong>
                            <p class="text-gray-700">{{ $itemOption->description }}</p>
                        </div>

                        {{-- Edit and Delete buttons --}}
                        <div class="flex space-x-2">

                            <button
                                onclick="openEditItemOption(
                                    {{ $itemOption->id }},
                                    {{ json_encode($itemOption->type) }},
                                    {{ json_encode($itemOption->description) }},
                                    '{{ asset('storage/' . $itemOption->image) }}'
                                )"
                                class="px-4 py-2 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 hover:cursor-pointer transition-colors">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Edit
                            </button>

                            {{-- Delete  --}}
                            <form action="{{ route('itemOption.delete', $itemOption->id) }}" method="POST"
                                class="delete-form">
                                @csrf
                                @method('DELETE')
                                <button type="button" onclick="confirmDelete(this)"
                                    class="px-4 py-2 bg-red-100 text-red-800 rounded-md hover:bg-red-200 hover:cursor-pointer transition-colors">
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
                </li>
            @endforeach
        @endif
    </ul>
</div>
