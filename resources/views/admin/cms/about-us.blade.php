<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>About US SECTION CMS</title>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-cyan-300">

    <div class="flex h-screen">

        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 md:p-6">

                <div class="mt-4 ">
                    <!-- Page Header -->
                    <div class="bg-white shadow-md rounded-lg mb-4 md:mb-6 p-6">
                        <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-center text-gray-800">
                            About Us
                        </h1>
                        <p class="text-center text-gray-600 mt-2">Learn more about our mission and values.</p>
                    </div>

                    @if ($aboutUs)
                        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                            <form id="editForm" action="{{ route('admin.aboutus.update', $aboutUs->id) }}"
                                method="POST" class="space-y-6" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div id="success-message"
                                    class="hidden mt-4 p-3 bg-green-100 text-green-700 rounded-md text-sm md:text-base">
                                    Changes saved successfully!
                                </div>

                                <!-- Title Field -->
                                <div class="space-y-1">
                                    <label for="title"
                                        class="block text-sm md:text-base font-medium text-gray-700">Title</label>
                                    <input type="text" id="title" name="title" value="{{ $aboutUs->title }}"
                                        class="block w-full px-4 py-2 text-xl md:text-2xl font-semibold text-gray-800 border-b border-gray-300 focus:border-blue-500 focus:outline-none transition-colors"
                                        required>
                                </div>

                                <!-- Description Field -->
                                <div class="space-y-1">
                                    <label for="description"
                                        class="block text-sm md:text-base font-medium text-gray-700">Description</label>
                                    <textarea id="description" name="description" rows="4"
                                        class="block w-full px-4 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none transition-colors text-sm md:text-base"
                                        required>{{ $aboutUs->description }}</textarea>
                                </div>

                                <!-- Background Image Field -->
                                <div class="space-y-1">
                                    <label for="background_image" class="block text-sm md:text-base font-medium text-gray-700">Background Image</label>
                                    <div class="flex flex-col md:flex-row items-start md:items-center gap-4 relative">
                                
                                        <!-- Image Preview -->
                                        <div class="relative group">
                                            <img id="preview-image" 
                                                 src="{{ $aboutUs->background_image ? asset($aboutUs->background_image) : 'https://via.placeholder.com/300x200?text=No+Image' }}"
                                                 class="rounded-md shadow-lg w-full max-w-xs object-cover" alt="Preview Image">
                                
                                            <!-- Overlay Camera Icon -->
                                            <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity rounded-md">
                                                <i class="fas fa-camera text-white text-2xl"></i>
                                            </div>
                                
                                            <!-- Reset Button (X) -->
                                            <button id="reset-button" type="button" onclick="resetImage()" 
                                                class="hidden absolute top-2 right-2 bg-red-500 hover:bg-red-600 text-white rounded-full p-1 focus:outline-none">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                
                                        <!-- Upload Button -->
                                        <div class="w-full md:w-auto">
                                            <label class="cursor-pointer inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm md:text-base font-medium rounded-md hover:bg-blue-600 transition">
                                                <i class="fas fa-upload mr-2"></i> Upload New Image
                                                <input type="file" id="background_image" name="background_image" class="hidden" accept="image/*" onchange="previewImage(event)">
                                            </label>
                                            <p class="text-xs md:text-sm text-gray-500 mt-2" id="file-name">No file selected</p>
                                        </div>
                                    </div>
                                </div>


                                <!-- Submit Button -->
                                <div class="flex justify-end pt-3">
                                    <button type="submit"
                                        class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm md :text-base font-medium rounded-md hover:bg-blue-700 transition">
                                        <i class="fas fa-save mr-2"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-white shadow-md rounded-lg p-6 mb-6">
                            <p class="text-gray-700 text-sm md:text-base">No content available for the About Us section.
                            </p>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script>
        // Show selected file name
        document.getElementById('background_image')?.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'No file selected';
            document.getElementById('file-name').textContent = fileName;
        });

        // Form submission handling
        document.getElementById('editForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}'
                    }
                })
                .then(response => {
                    if (response.ok) {
                        return response.json();
                    }
                    throw new Error('Network response was not ok.');
                })
                .then(data => {
                    const successMessage = document.getElementById('success-message');
                    successMessage.classList.remove('hidden');
                    setTimeout(() => successMessage.classList.add('hidden'), 3000);

                    // Scroll to show the success message
                    successMessage.scrollIntoView({
                        behavior: 'smooth',
                        block: 'nearest'
                    });
                })
                .catch(error => {
                    console.error('Error:', error);
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while saving changes.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                });
        });
    </script>
    <script>
        const defaultImage = "{{ $aboutUs->background_image ? asset($aboutUs->background_image) : 'https://via.placeholder.com/300x200?text=No+Image' }}";
    
        function previewImage(event) {
            const fileInput = event.target;
            const file = fileInput.files[0];
            const preview = document.getElementById('preview-image');
            const fileNameText = document.getElementById('file-name');
            const resetButton = document.getElementById('reset-button');
    
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    preview.src = e.target.result;
                }
                reader.readAsDataURL(file);
    
                fileNameText.textContent = file.name;
    
                resetButton.classList.remove('hidden');
            }
        }
    
        function resetImage() {
            const fileInput = document.getElementById('background_image');
            const preview = document.getElementById('preview-image');
            const fileNameText = document.getElementById('file-name');
            const resetButton = document.getElementById('reset-button');
    
            fileInput.value = '';
    
            preview.src = defaultImage;
    
            fileNameText.textContent = 'No file selected';
    
            resetButton.classList.add('hidden');
        }
    </script>
    
</body>

</html>
