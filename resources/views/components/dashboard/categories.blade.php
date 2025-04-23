
<script>
    function openEditModal(id, name, description) {
        let editUrl = "{{ url('/categories/') }}/" + id + "/edit";

        Swal.fire({
            title: '<div class="flex items-center gap-2"><svg class="w-6 h-6 text-cyan-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z"></path></svg><span class="text-cyan-600 font-semibold text-xl">Edit Category</span></div>',
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
    <h2 class="text-2xl font-bold text-cyan-800 mb-5 text-center">All Categories </h2>
    
    @if($categories->isEmpty())
        <p class="text-center text-cyan-600">No categories found. Create your first category!</p>
    @else
        <ul class="space-y-3 list-none p-0">
            @foreach ($categories as $category)
                <li class="bg-white p-4 rounded-lg shadow-sm hover:bg-cyan-50 transition-colors border-l-4 border-cyan-400 flex justify-between items-center">
                    <div>
                        <span class="font-semibold text-cyan-700 text-lg">{{ $category->name }}</span>
                        
                    </div>
                    <div class="flex space-x-2">
                        <!-- Edit Button -->
                        <button onclick="openEditModal(
                            {{ $category->id }}, 
                            {{ json_encode($category->name) }}
                            
                        )" 
                            class="bg-yellow-500 text-white px-3 py-1 rounded hover:bg-yellow-600 transition hover:cursor-pointer">
                            Edit
                        </button>

                        <!-- Delete Button -->
                        <form action="{{ route('categories.delete', $category->id) }}" method="POST" class="delete-form">
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

<script>
    function confirmDelete(button) {
        Swal.fire({
            title: "Are you sure?",
            text: "You won't be able to undo this action!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#d33",
            cancelButtonColor: "#3085d6",
            confirmButtonText: "Yes, delete it!"
        }).then((result) => {
            if (result.isConfirmed) {
                button.closest("form").submit(); 
            }
        });
    }
</script>
{{-- @if (session('success'))
<script>
    Swal.fire({
        icon: 'success',
        title: 'Success!',
        text: '{{ session('success') }}',
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        background: '#f0fdfa',
        iconColor: '#06b6d4',
        color: '#164e63',
        timerProgressBar: true,
        showClass: {
            popup: 'swal2-show animate-slide-in'
        },
        hideClass: {
            popup: 'swal2-hide animate-slide-out'
        }
    });
</script>
@endif --}}
