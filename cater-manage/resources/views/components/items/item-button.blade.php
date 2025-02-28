<style>
    /*  CSS for image preview */
    .image-preview {
        display: none;
        width: 100%;
        height: auto;
        max-height: 300px;
        object-fit: cover;
        border-radius: 0.5rem;
        border: 2px dashed #ccc;
        padding: 0.5rem;
    }
</style>


<script>
    function addItem() {
        Swal.fire({
            title: '<span class="text-2xl font-bold text-gray-800">Add Menu Item</span>',
            html: `
                <form id="addItemForm" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
                    <div class="flex flex-col items-center justify-center">
                        <img id="image-preview" src="#" alt="Image Preview" class="image-preview">
                        <label for="swal-image" class="mt-4 block text-sm font-medium text-gray-700">Upload Image</label>
                        <input type="file" id="swal-image" name="image" accept="image/*"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>

                    <div class="space-y-4">
                        <div>
                            <label for="swal-category" class="block text-sm font-medium text-gray-700">Select Category:</label>
                            <select id="swal-category" name="category_id" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach ($categories as $category)
                                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                                @endforeach
                            </select>
                        </div>

                        <div>
                            <label for="swal-menu" class="block text-sm font-medium text-gray-700">Select Menu:</label>
                            <select id="swal-menu" name="menu_id" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                @foreach ($items as $item)
                                    <option value="{{ $item->id }}">{{ $item->name }}</option>
                                @endforeach
                            </select>
                        </div>
                        <div>
                            <label for="swal-name" class="block text-sm font-medium text-gray-700">Item Name:</label>
                            <input type="text" id="swal-name" name="name" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="swal-description" class="block text-sm font-medium text-gray-700">Description:</label>
                            <textarea id="swal-description" name="description"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        </div>
                        <div>
                            <label for="swal-price" class="block text-sm font-medium text-gray-700">Price:</label>
                            <input type="number" step="0.01" id="swal-price" name="price" required
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        </div>
                        <div>
                            <label for="swal-status" class="block text-sm font-medium text-gray-700">Status:</label>
                            <select id="swal-status" name="status"
                                class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                                <option value="available">Available</option>
                                <option value="unavailable">Unavailable</option>
                            </select>
                        </div>
                    </div>
                </form>`,
            showCancelButton: true,
            confirmButtonText: 'Add Menu Item',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#ef4444',
            didOpen: () => {
                const imageInput = document.getElementById('swal-image');
                const imagePreview = document.getElementById('image-preview');

                imageInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    if (file) {
                        const reader = new FileReader();
                        reader.onload = function(e) {
                            imagePreview.src = e.target.result;
                            imagePreview.style.display = 'block';
                        };
                        reader.readAsDataURL(file);
                    } else {
                        imagePreview.style.display = 'none';
                    }
                });
            },
            preConfirm: () => {
                const form = document.getElementById('addItemForm');
                const formData = new FormData(form);
                const imageInput = document.getElementById('swal-image');

                // validate file size
                if (imageInput.files[0]) {
                    const file = imageInput.files[0];
                    const maxSize = 10 * 1024 * 1024; // 10MB in bytes

                    if (file.size > maxSize) {
                        Swal.showValidationMessage("Image size must not exceed 10MB");
                        return false;
                    }

                    formData.append('image', file);
                }
                for (let [key, value] of formData.entries()) {
                    console.log(key, value);
                }

                const selectedCategory = document.getElementById('swal-category').value;
                const selectedMenu = document.getElementById('swal-menu').value;
                formData.append('category_id', selectedCategory);
                formData.append('menu_id', selectedMenu);

                return fetch("{{ route('menu-items.store') }}", {
                        method: "POST",
                        headers: {
                            "X-CSRF-TOKEN": "{{ csrf_token() }}"
                        },
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (!data.success) {
                            throw new Error(data.message || 'Error adding menu item');
                        }
                        return data;
                    })
                    .catch(error => {
                        Swal.showValidationMessage(error.message);
                        return false;
                    });
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: '<span class="text-xl font-bold text-gray-800">Success!</span>',
                    text: 'The menu item was successfully added!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            }
        });
    }
</script>

<button onclick="addItem()" class="px-2 py-1 bg-cyan-200 rounded mt-2 hover:cursor-pointer">Add an item here</button>
