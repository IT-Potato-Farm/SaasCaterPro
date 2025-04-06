<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Management Dashboard</title>
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        

        function openEditModalItem(id, name, description, quantity, image, packageId) {
            console.log("Editing utility:", id);
            let editUrl = "{{ url('/packageutility/update') }}/" + id;

            // Dynamically populate the dropdown with available packages
            let packages = @json($packages); // Use the packages from your backend
            let packageOptions = packages.map(pkg => {
                return `<option value="${pkg.id}" ${pkg.id === packageId ? 'selected' : ''}>${pkg.name}</option>`;
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
                        required>${description}</textarea>
                </div>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 mb-2">Quantity</label>
                <input type="number" name="quantity" value="${quantity}" 
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none"
                    required>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 mb-2">Package</label>
                <select name="package_id" class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none" required>
                    <option value="">Select Package</option>
                    ${packageOptions}
                </select>
            </div>
            <div class="mb-5">
                <label class="block text-sm font-medium text-gray-600 mb-2">Image</label>
                <input type="file" name="image" 
                    class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none">
                <div class="mt-2">
                    ${image ? `<img src="{{ asset('storage/packageUtilities/${image}') }}" alt="Utility Image" class="w-32 h-32 object-cover">` : `<p>No image available</p>`}
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
</head>

<body>
    @if (session('success'))
    <script>
        Swal.fire({
            title: 'Success!',
            text: "{{ session('success') }}",
            icon: 'success',
            confirmButtonText: 'OK'
        });
    </script>
@endif
    <div class="flex h-screen">

        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
                <x-dashboard.header />
                <x-packages.add-package-utility />
                <h1 class="text-xl font-semibold mb-6">List of Utilities</h1>
                @if ($utilities->isEmpty())
                    <div class="text-center p-8 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200">
                        <div class="mb-4">
                            <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10" />
                            </svg>
                        </div>
                        <p class="text-lg font-medium text-cyan-600">No utilities available. Start by adding your first
                            utility!</p>
                    </div>
                @else
                    <div class="grid gap-6 md:grid-cols-2 lg:grid-cols-3">
                        @foreach ($utilities as $utility)
                            <div
                                class="relative group bg-white rounded-xl p-6 shadow-lg hover:shadow-xl transition-shadow duration-200">
                                <div class="flex justify-between items-start mb-4">
                                    <div>
                                        <h3 class="text-xl font-semibold text-gray-800">{{ $utility->name }}</h3>
                                        <p class="text-sm text-gray-500 mt-1">
                                            @if ($utility->description)
                                                {{ $utility->description }}
                                            @else
                                                <span class="italic text-gray-400">No description available</span>
                                            @endif
                                        </p>
                                    </div>
                                    <span class="px-3 py-1 bg-blue-100 text-blue-800 rounded-full text-sm font-medium">
                                        {{ $utility->quantity }} pcs
                                    </span>
                                </div>

                                <div class="mt-4 aspect-video overflow-hidden rounded-lg border border-gray-200">
                                    @if ($utility->image)
                                        <img src="{{ asset('storage/packageUtilities/' . $utility->image) }}"
                                            alt="{{ $utility->name }}" class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full bg-gray-100 flex items-center justify-center">
                                            <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                </div>

                                <div class="mt-6 flex justify-end space-x-3">
                                    <!-- Edit Icon -->
                                    <button
                                        onclick="openEditModalItem(
                                            {{ $utility->id }}, 
                                            {{ json_encode($utility->name) }}, 
                                            {{ json_encode($utility->description) }},
                                            {{ json_encode($utility->quantity) }},
                                            {{ json_encode($utility->image) }},
                                             {{ json_encode($utility->package_id) }}

                                            )"
                                        class="flex-1 flex items-center justify-center gap-2 bg-amber-500 hover:bg-amber-600 text-white px-4 py-2 rounded-md transition-colors hover:cursor-pointer">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 114.95 0 2.5 2.5 0 01-4.95 0M12 15h.01M12 3H7a2 2 0 00-2 2v14a2 2 0 002 2h10a2 2 0 002-2v-5" />
                                        </svg>
                                        Edit
                                    </button>

                                    <!-- Delete Icon -->
                                    <form action="{{ route('package_utilities.destroy', $utility->id) }}"
                                        method="POST" class="flex-1">
                                        @csrf
                                        @method('DELETE')
                                        <button type="button" onclick="confirmDeleteUtility(this)"
                                            class="w-full flex items-center justify-center gap-2 bg-red-500 hover:bg-red-600 text-white px-4 py-2 rounded-md transition-colors hover:cursor-pointer">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor"
                                                viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                    d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                            </svg>
                                            Delete
                                        </button>
                                    </form>
                                </div>
                            </div>
                        @endforeach
                    </div>
                @endif
            </main>
        </div>

    </div>
</body>

</html>
