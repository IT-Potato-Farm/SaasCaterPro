<div id="editCategoryModal" class="hidden fixed inset-0 flex items-center justify-center bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h2 class="text-xl font-semibold mb-2">Edit Category</h2>
        <form id="editCategoryForm" method="POST">
            @csrf
            @method('POST')
            <input type="hidden" name="id" id="categoryId">
            
            <label class="block mb-2 text-sm font-medium text-gray-700">Category Name</label>
            <input type="text" name="name" id="editCategoryName" class="w-full border rounded p-2">
            
            <label class="block mt-2 text-sm font-medium text-gray-700">Description</label>
            <textarea name="description" id="editCategoryDescription" class="w-full border rounded p-2"></textarea>

            <div class="mt-4 flex justify-end space-x-2">
                <button type="button" onclick="closeEditModal()" class="bg-gray-500 text-white px-4 py-2 rounded hover:bg-gray-600">Cancel</button>
                <button type="submit" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-600">Update</button>
            </div>
        </form>
    </div>
</div>

<!-- Move the script to the bottom -->

{{-- <script>
    function openEditModal(categoryId, categoryName, categoryDescription) {

        Swal.fire({
            title: "Edit Category",
            html: `
                <form id="editCategoryForm" action="/categories/${categoryId}/edit" method="POST">
                    @csrf
                    @method('POST')
                    <label class="block text-left text-sm font-medium text-gray-700">Category Name</label>
                    <input type="text" id="editCategoryName" name="name" value="${categoryName}" class="swal2-input">

                    <label class="block text-left text-sm font-medium text-gray-700">Description</label>
                    <textarea id="editCategoryDescription" name="description" class="swal2-textarea">${categoryDescription}</textarea>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: "Update",
            cancelButtonText: "Cancel",
            preConfirm: () => {
                document.getElementById("editCategoryForm").submit();
            }
        });
    }
</script>  --}}