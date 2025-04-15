{{-- ANDTO YUNG POP UP MODAL FOR ADDING NG CATEGORY TAPOS ID-DELIVER NYA YUNG DATA  --}}

<script>
    function addCat() {
        Swal.fire({
            title: 'Add Category',
            html: `
                <form id="category-form" method="POST" action="{{ route('categories.addCategory') }}">
                    @csrf
                    <div class="space-y-4 text-left">
                        <label for="swal-name" class="block text-gray-700 font-medium">Category Name</label>
                        <input type="text" id="swal-name" name="name" required
                            class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Add Category',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#ef4444',
            preConfirm: () => {
                const nameInput = document.getElementById('swal-name');
                const name = nameInput.value.trim();

                if (!name) {
                    Swal.showValidationMessage('Category name is required.');
                    return false;
                }
                

                // If valid, submit the form
                document.getElementById('category-form').submit();
            }
        });
    }
</script>


<button onclick="addCat()" class="px-2 py-1 bg-cyan-200 rounded mt-2 hover:cursor-pointer">Add a category</button>