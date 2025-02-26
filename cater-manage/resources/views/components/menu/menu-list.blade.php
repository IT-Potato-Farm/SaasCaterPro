
<script>
    function openEditModalMenu(id, name, description) {
        let editUrl = "{{ url('/menu/') }}/" + id + "/edit";

        Swal.fire({
            title: '<div class="flex items-center gap-2"><svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg><span class="text-cyan-600 font-semibold text-xl">Edit Menu</span></div>',
            html: `
                <form id="editForm-${id}" action="${editUrl}" method="POST" class="text-left">
                    @csrf
                    @method('PUT')
                    <div class="mb-5">
                        <label class="block text-sm font-medium text-gray-600 mb-2">Name</label>
                        <div class="relative">
                            <input type="text" name="name" value="${name}" 
                                class="w-full px-4 py-2.5 rounded-lg border border-gray-200 focus:border-cyan-500 focus:ring-2 focus:ring-cyan-200 transition-all outline-none"
                                required>
                            <div class="absolute inset-y-0 right-3 flex items-center pointer-events-none">
                                
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
                const form = document.getElementById(`editForm-${id}`);
                if (form.reportValidity()) {
                    form.submit();
                }
            }
        });
    }
</script>

<div class="border border-cyan-200 bg-cyan-50 rounded-xl shadow-lg p-6 mt-5">
    <h2 class="text-2xl font-bold text-cyan-800 mb-5 text-center">All Menu</h2>
    
    @if($menus->isEmpty())
        <p class="text-center text-cyan-600">No menu found. Create your first menu!</p>
    @else
        <ul class="space-y-3 list-none p-0">
            @foreach ($menus as $menu)
                <li class="bg-white p-4 rounded-lg shadow-sm hover:bg-cyan-50 transition-colors border-l-4 border-cyan-400 flex justify-between items-center">
                    <div>
                        <span class="font-semibold text-cyan-700 text-lg">{{ $menu->name }}</span>
                        <p class="text-cyan-600 mt-1 text-sm">{{ $menu->description }}</p>
                    </div>
                    <div class="flex space-x-2">
                        <!-- Edit Button -->
                        <button onclick="openEditModalMenu(
                            {{ $menu->id }}, 
                            {{ json_encode($menu->name) }}, 
                            {{ json_encode($menu->description) }}
                        )" 
                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition hover:cursor-pointer">
                            Edit
                        </button>

                        <!-- Delete Button -->
                        <form action="{{ route('menu.delete', $menu->id) }}" method="POST" class="delete-form">
                            @csrf
                            @method('DELETE')
                            <button type="button" onclick="confirmDelete(this)" 
                                class="bg-red-500 text-white px-3 py-1 rounded hover:bg-red-600 transition hover:cursor-pointer">
                                Delete
                            </button>
                        </form>
                    </div>
                </li>
            @endforeach
        </ul>
    @endif
</div>