<script>
    function openEditPackage(id, name, description, price_per_person, min_pax, image, status) {
    let editUrl = "{{ url('/packages/edit') }}/" + id;

    Swal.fire({
        title: `<div class="flex items-center gap-2">
                    
                    <span class="text-cyan-600 font-semibold text-1xl">Edit Package</span>
                </div>`,
        html: `
            <form id="editForm-${id}" action="${editUrl}" method="POST" class="text-left" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                <!-- Package Name -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Package Name</label>
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

                <!-- Price per Person -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Price per Person</label>
                    <input type="number" step="0.01" name="price_per_person" value="${price_per_person}" 
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none"
                        required min="0.01">
                </div>

                <!-- Minimum Pax -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Minimum Pax</label>
                    <input type="number" step="1" name="min_pax" value="${min_pax}" 
                        class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none"
                        required min="1">
                </div>

                <!-- Current Image Display -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Current Image</label>
                    <div class="w-32 h-32 mb-3">
                        <img src="${image}" alt="${name}" class="w-full h-full object-cover rounded-lg">
                    </div>
                </div>

                <!-- New Image Upload -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Upload New Image (Optional)</label>
                    <input type="file" name="image" accept="image/*" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none">
                </div>

                <!-- Status -->
                <div class="mb-5">
                    <label class="block text-sm font-medium text-gray-600 mb-2">Status</label>
                    <select name="status" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none">
                        <option value="available" ${status === 'available' ? 'selected' : ''}>available</option>
                        <option value="unavailable" ${status === 'unavailable' ? 'selected' : ''}>unavailable</option>
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
    <h2 class="text-3xl font-bold text-gray-800 mb-8 text-center"> Packages</h2>

    @if ($packages->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded-lg">
            <p class="text-gray-500">No packages available yet.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($packages as $package)
                <div
                    class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- img-->
                    <div class="h-48 bg-gray-100 relative">
                        @if ($package->image)
                            <img src="{{ asset('storage/packagePics/' . $package->image) }}" alt="{{ $package->name }}"
                                class="w-full h-full object-fill ">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                    </div>

                    <!-- package Details -->
                    <div class="p-6">
                        <div class="mb-4">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-1">{{ $package->name }}</h3>
                            @if ($package->category)
                                <p class="text-sm text-gray-500">{{ $package->category->name }}</p>
                            @endif
                        </div>

                        <p class="text-gray-600 mb-4 line-clamp-3 hover:line-clamp-none transition-all">
                            {{ $package->description }}
                        </p>

                        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                            <div>
                                <p class="text-gray-500">Price per person</p>
                                <p class="font-medium text-gray-800">₱{{ number_format($package->price_per_person, 2) }}
                                </p>
                            </div>
                            <div>
                                <p class="text-gray-500">Minimum Pax</p>
                                <p class="font-medium text-gray-800">{{ $package->min_pax }}</p>
                            </div>
                        </div>

                        <!-- -->
                        <div class="flex space-x-2 mt-4">
                            <button
                                onclick="openEditPackage(
                            {{ $package->id }}, 
                            {{ json_encode($package->name) }}, 
                            {{ json_encode($package->description) }},
                            {{ json_encode($package->price_per_person) }},
                            {{ json_encode($package->min_pax) }},
                            '{{ asset('storage/packagepics/' . $package->image) }}',
                            '{{ $package->status }}'
                            )"
                                class="flex-1 px-4 py-2 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 hover:cursor-pointer transition-colors">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Edit
                            </button>

                            <form action="{{ route('package.delete', $package->id) }}" method="POST"
                                class="delete-form">
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

                            {{-- view more  --}}
                            <a href="{{ route('package.show', $package->id) }}" 
                                class="flex-1 px-4 py-2 bg-green-100 text-green-800 rounded-md hover:bg-green-200 transition-colors">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 15l-4 4m0 0l-4-4m4 4V3" />
                                </svg>
                                View More
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>
