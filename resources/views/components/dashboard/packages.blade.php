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
//  Confirm delete 
function confirmDeletePackage(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: 'This package will be permanently deleted!',
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


<div class="container mx-auto px-4 py-6">
    

    @if ($packages->isEmpty())
        <div class="bg-white rounded-xl shadow-sm p-8 border border-gray-100 text-center">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-12 w-12 mx-auto text-gray-300 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 7l-8-4-8 4m16 0l-8 4m8-4v10l-8 4m0-10L4 7m8 4v10M4 7v10l8 4" />
            </svg>
            <p class="text-gray-500 mb-4">No packages available yet</p>
            <button class="px-4 py-2 bg-blue-600 text-white text-sm font-medium rounded-lg hover:bg-blue-700 transition-colors">
                Create Your First Package
            </button>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="min-w-full bg-white rounded-xl shadow-sm border border-gray-100">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Package</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Description</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Price</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Min Pax</th>
                        <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-200">
                    @foreach ($packages as $package)
                        <tr class="hover:bg-gray-50 transition-colors duration-150">
                            <!-- Package Column with Image -->
                            <td class="px-6 py-4">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-16 w-16 rounded-md overflow-hidden bg-gray-50">
                                        @if ($package->image)
                                            <img src="{{ asset('storage/packagepics/' . $package->image) }}" alt="{{ $package->name }}"
                                                class="h-full w-full object-cover">
                                        @else
                                            <div class="h-full w-full flex items-center justify-center text-gray-300">
                                                <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                        d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                                </svg>
                                            </div>
                                        @endif
                                    </div>
                                    <div class="ml-4">
                                        <div class="text-sm font-semibold text-gray-900">{{ $package->name }}</div>
                                        <!-- Mobile-only description preview -->
                                        <div class="md:hidden mt-1 text-xs text-gray-500 line-clamp-2">
                                            {{ $package->description }}
                                        </div>
                                    </div>
                                </div>
                            </td>
                            
                            <!-- Description Column (hidden on mobile) -->
                            <td class="px-6 py-4 hidden md:table-cell">
                                <div class="text-sm text-gray-500">
                                    {{ $package->description }}
                                </div>
                            </td>
                            
                            <!-- Price Column -->
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="text-sm font-bold text-gray-900">₱{{ number_format($package->price_per_person, 2) }}</div>
                                <div class="text-xs text-gray-500 md:hidden">Per person</div>
                            </td>
                            
                            <!-- Min Pax Column (hidden on mobile) -->
                            <td class="px-6 py-4 whitespace-nowrap hidden sm:table-cell">
                                <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-gray-100 text-gray-800">
                                    {{ $package->min_pax }} pax
                                </span>
                            </td>
                            
                            
                            
                            <!-- Actions Column -->
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                <div class="flex justify-end space-x-1">
                                    <!-- View Button -->
                                    <a href="{{ route('package.show', $package->id) }}" 
                                        class="p-2 text-blue-600 hover:text-blue-800 rounded-md hover:bg-blue-50 transition-colors"
                                        title="View">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                        </svg>
                                    </a>
                                    
                                    <!-- Edit Button -->
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
                                        class="p-2 text-amber-600 hover:text-amber-800 rounded-md hover:bg-amber-50 cursor-pointer transition-colors"
                                        title="Edit">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 114.95 0 2.5 2.5 0 01-4.95 0M12 15h.01M12 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2v-5" />
                                        </svg>
                                    </button>
                                    
                                    <!-- Delete Button -->
                                    <form action="{{ route('package.delete', $package->id) }}" method="POST">
                                        @csrf
                                        @method('DELETE')
                                        <button 
                                            type="button" 
                                            onclick="confirmDeletePackage(this)"
                                            class="p-2 text-red-600 hover:text-red-800 rounded-md hover:bg-red-50 cursor-pointer transition-colors"
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
    @endif
</div>