{{-- ANDTO YUNG POP UP MODAL FOR ADDING NG CATEGORY TAPOS ID-DELIVER NYA YUNG DATA  --}}

<script>
    function addMenu() {
        Swal.fire({
            title: 'Add Menu',
            html: `
                <div class="space-y-4">
                    <label for="name" class="text-left block text-gray-700 font-medium">Menu Name</label>
                    <input type="text" id="swal-name" name="name" required placeholder="(Can be a package name or set)"
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500">

                    <label for="description" class="text-left block text-gray-700 font-medium">Description</label>
                    <textarea id="swal-description" name="description" rows="3" required
                        class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                </div>`,
            showCancelButton: true,
            confirmButtonText: 'Add Menu',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3b82f6', // Tailwind blue-500
            cancelButtonColor: '#ef4444',   // Tailwind red-500
            preConfirm: () => {
                const name = document.getElementById('swal-name').value.trim();
                const description = document.getElementById('swal-description').value.trim();

                if (!name || !description) {
                    Swal.showValidationMessage('Please fill in all fields');
                    return false;
                }
                // nagp-point to sa category controller -> pati models  
                return fetch("{{ route('menu.addMenu') }}", {
                    method: "POST",
                    headers: {
                        "Content-Type": "application/json",
                        "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    },
                    body: JSON.stringify({ name, description })
                })
                .then(response => response.json())
                .then(data => {
                    if (!data.success) {
                        throw new Error(data.message || 'Error adding menu');
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
                    title: 'Menu Added',
                    text: 'The Menu was successfully added!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    location.reload(); // Refresh 
                });
            }
        });
    }
</script>


<button onclick="addMenu()" class="px-2 py-1 bg-cyan-200 rounded mt-2 hover:cursor-pointer">Add a Menu here</button>