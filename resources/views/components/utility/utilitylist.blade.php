
@props(['utilities', 'packages', 'package_utilities'])
<script>
    function openEditModalUtil(id, name, description, quantity, image, selectedPackageIds) {
        // console.log("Editing utility:", id);
        // console.log("Package ID passed to modal:", selectedPackageIds);
        if (description === null || description === 'null') {
            description = '';
        }

        let editUrl = "{{ route('utilities.update', ':id') }}".replace(':id', id);
        // console.log(editUrl);

        // Dynamically populate the dropdown with available packages
        let packages = @json($packages);
        let packageCheckboxes = packages.map(pkg => {
            let checked = selectedPackageIds.includes(pkg.id) ? 'checked' : '';
            return `
                    <div class="form-check">
                        <input class="form-check-input" type="checkbox" name="package_ids[]" value="${pkg.id}" id="package_${pkg.id}" ${checked}>
                        <label class="form-check-label" for="package_${pkg.id}">
                            ${pkg.name}
                        </label>
                    </div>
                `;
        }).join('');

        Swal.fire({
            title: `<div class="flex items-center gap-2">
        <span class="text-cyan-600 font-semibold text-xl">Edit Utility</span>
    </div>`,
            html: `
    <form id="editUtilityForm-${id}" action="${editUrl}" method="POST" enctype="multipart/form-data" class="text-left">
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
                    >${description}</textarea>
            </div>
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-600 mb-2">Quantity</label>
            <input type="number" name="quantity" value="${quantity}" 
                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none"
                required>
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-600 mb-2">Link to Packages</label>
            ${packageCheckboxes}
        </div>
        <div class="mb-5">
            <label class="block text-sm font-medium text-gray-600 mb-2">Image</label>
            <input type="file" name="image" 
                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none">
            <div class="mt-2">
                ${image ? `<img src="{{ asset('storage/utilities/${image}') }}" alt="Utility Image" class="w-32 h-32 object-cover">` : `<p>No image available</p>`}
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

                const form = document.getElementById(`editUtilityForm-${id}`);
                const checkedPackageIds = packages.filter(pkg => form.querySelector(`#package_${pkg.id}`)
                        .checked)
                    .map(pkg => pkg.id);

                // Find all unchecked checkboxes and collect their package IDs
                const uncheckedPackageIds = packages.filter(pkg => !form.querySelector(`#package_${pkg.id}`)
                        .checked)
                    .map(pkg => pkg.id);

                console.log("Selected Package IDs:", packages.filter(pkg => form.querySelector(
                    `#package_${pkg.id}`).checked).map(pkg => pkg.id));
                // Clear any existing hidden inputs related to package_ids
                form.querySelectorAll('input[name="package_ids[]"]').forEach(input => input.remove());

                checkedPackageIds.forEach(pkgId => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'package_ids[]';
                    hiddenInput.value = pkgId;
                    form.appendChild(hiddenInput);
                });

                uncheckedPackageIds.forEach(pkgId => {
                    const hiddenInput = document.createElement('input');
                    hiddenInput.type = 'hidden';
                    hiddenInput.name = 'removed_package_ids[]';
                    hiddenInput.value = pkgId;
                    form.appendChild(hiddenInput);
                });

                if (form.reportValidity()) {
                    form.submit();
                }
            }
        });
    }


    function confirmDeleteUtility(button) {
        Swal.fire({
            title: 'Are you sure?',
            text: "You won't be able to revert this!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonText: 'Yes, delete it!',
            cancelButtonText: 'No, keep it',
        }).then((result) => {
            if (result.isConfirmed) {
                const deleteForm = button.closest('form');
                deleteForm.submit();
            }
        });
    }
</script>



@if ($utilities->isEmpty())
    <div class="text-center p-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
        <div class="mb-4">
            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
            </svg>
        </div>
        <p class="text-lg font-medium text-cyan-600">No utilities available. Start by adding your first utility!</p>
    </div>
@else
    <div class="overflow-x-auto">
        <table class="min-w-full bg-white rounded-xl overflow-hidden shadow-lg">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden sm:table-cell">Image</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Utility</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider hidden md:table-cell">Description</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Quantity</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @foreach ($utilities as $utility)
                    @php
                        $selectedPackageIds = $utility->packages->pluck('id')->toArray();
                    @endphp
                    <tr class="hover:bg-gray-50 transition-colors duration-150">
                        {{-- img --}}
                        <td class="px-6 py-4 hidden sm:table-cell">
                            <div class="h-10 w-10 rounded-md overflow-hidden">
                                @if ($utility->image)
                                    <img src="{{ asset('storage/utilities/' . $utility->image) }}" alt="{{ $utility->name }}"
                                        class="h-full w-full object-cover">
                                @else
                                    <div class="h-full w-full bg-gray-100 flex items-center justify-center">
                                        <svg class="w-5 h-5 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </td>
                        <!-- Name Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-semibold text-gray-900">{{ $utility->name }}</div>
                            <!-- Mobile-only description preview -->
                            <div class="md:hidden mt-1 text-sm text-gray-500">
                                @if ($utility->description)
                                    {{ Str::limit($utility->description, 50) }}
                                @else
                                    <span class="italic text-gray-400">No description</span>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Description Column (hidden on mobile) -->
                        <td class="px-6 py-4 hidden md:table-cell">
                            <div class="text-sm text-gray-500">
                                @if ($utility->description)
                                    {{ $utility->description }}
                                @else
                                    <span class="italic text-gray-400">No description available</span>
                                @endif
                            </div>
                        </td>
                        
                        <!-- Quantity Column -->
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full bg-blue-100 text-blue-800">
                                {{ $utility->quantity }} pcs
                            </span>
                        </td>
                        
                       
                        
                        <!-- Actions Column -->
                        <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                            <div class="flex justify-end space-x-2">
                                <!-- Edit Button -->
                                <button
                                    onclick="openEditModalUtil(
                                        {{ $utility->id }}, 
                                        {{ json_encode($utility->name) }}, 
                                        {{ json_encode($utility->description) }},
                                        {{ json_encode($utility->quantity) }},
                                        {{ json_encode($utility->image) }},
                                        {{ json_encode($selectedPackageIds) }}
                                    )"
                                    class="p-2 bg-amber-100 text-amber-800 rounded-md cursor-pointer hover:bg-amber-200 transition-colors"
                                    title="Edit"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 114.95 0 2.5 2.5 0 01-4.95 0M12 15h.01M12 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2v-5" />
                                    </svg>
                                </button>
                                
                                <!-- Delete Button -->
                                <form action="{{ route('utilities.destroy', $utility->id) }}" method="POST">
                                    @csrf
                                    @method('DELETE')
                                    <button 
                                        type="button" 
                                        onclick="confirmDeleteUtility(this)"
                                        class="p-2 bg-red-100 text-red-800 cursor-pointer rounded-md hover:bg-red-200 transition-colors"
                                        title="Delete"
                                    >
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