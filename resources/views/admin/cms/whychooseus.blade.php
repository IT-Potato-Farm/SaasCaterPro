<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WHY CHOOSE US SECTION CMS</title>
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
                {{-- <x-dashboard.header /> --}}
                
                <div class="mt-4 md:mt-6">
                    <!-- Page Header -->
                    <div class="bg-white shadow-md rounded-lg mb-4 md:mb-6 p-4">
                        <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold text-center text-gray-800">
                            WHY CHOOSE US SECTION
                        </h1>
                    </div>
                    
                    @if ($chooseSection)
                        <div class="bg-white shadow-md rounded-lg p-4 md:p-6 mb-6">
                            <form id="editForm" action="{{ route('admin.whychoose.update', $chooseSection->id) }}" 
                                  method="POST" class="space-y-4 md:space-y-6" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
                                
                                <div id="success-message" 
                                     class="hidden mt-4 p-3 md:p-4 bg-green-100 text-green-700 rounded-md text-sm md:text-base">
                                    Changes saved successfully!
                                </div>

                                <!-- Title Field -->
                                <div class="space-y-1 md:space-y-2">
                                    <label for="title" class="block text-sm md:text-base font-medium text-gray-700">Title</label>
                                    <div class="flex items-center">
                                        <input type="text" id="title" name="title" 
                                               value="{{ $chooseSection->title }}" 
                                               class="block w-full px-3 py-2 text-xl md:text-2xl lg:text-3xl font-semibold text-gray-800 border-b border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-0 transition-colors"
                                               required>
                                        <i class="fas fa-edit text-blue-500 text-sm ml-2"></i>
                                    </div>
                                </div>
                                
                                <!-- Subtitle Field -->
                                <div class="space-y-1 md:space-y-2">
                                    <label for="subtitle" class="block text-sm md:text-base font-medium text-gray-700">Subtitle</label>
                                    <div class="flex items-center">
                                        <input type="text" id="subtitle" name="subtitle" 
                                               value="{{ $chooseSection->subtitle }}" 
                                               class="block w-full px-3 py-2 text-lg md:text-xl text-gray-600 border-b border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-0 transition-colors"
                                               required>
                                        <i class="fas fa-edit text-blue-500 text-sm ml-2"></i>
                                    </div>
                                </div>
                                
                                <!-- Description Field -->
                                <div class="space-y-1 md:space-y-2">
                                    <label for="description" class="block text-sm md:text-base font-medium text-gray-700">Description</label>
                                    <div class="flex items-start">
                                        <textarea id="description" name="description" rows="4" 
                                                  class="block w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none transition-colors text-sm md:text-base"
                                                  required>{{ $chooseSection->description }}</textarea>
                                        <i class="fas fa-edit text-blue-500 text-sm mt-2 ml-2"></i>
                                    </div>
                                </div>
                                
                                <!-- Background Image Field -->
                                <div class="space-y-1 md:space-y-2">
                                    <label for="background_image" class="block text-sm md:text-base font-medium text-gray-700">Background Image</label>
                                    <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                                        @if ($chooseSection->background_image)
                                            <div class="relative group">
                                                <img src="{{ asset($chooseSection->background_image) }}" 
                                                     class="rounded-md shadow-lg w-full max-w-xs" alt="Background Image">
                                                <div class="absolute inset-0 bg-black bg-opacity-40 opacity-0 group-hover:opacity-100 flex items-center justify-center transition-opacity rounded-md">
                                                    <i class="fas fa-camera text-white text-2xl"></i>
                                                </div>
                                            </div>
                                        @else
                                            <div class="w-32 h-32 bg-gray-200 rounded-md flex items-center justify-center">
                                                <i class="fas fa-image text-gray-400 text-3xl"></i>
                                            </div>
                                        @endif
                                        
                                        <div class="w-full md:w-auto">
                                            <label class="cursor-pointer inline-flex items-center px-4 py-2 bg-blue-500 text-white text-sm md:text-base font-medium rounded-md hover:bg-blue-600 transition">
                                                <i class="fas fa-upload mr-2"></i> Upload New Image
                                                <input type="file" id="background_image" name="background_image" class="hidden" accept="image/*">
                                            </label>
                                            <p class="text-xs md:text-sm text-gray-500 mt-2" id="file-name">No file selected</p>
                                        </div>
                                    </div>
                                </div>
                                
                                <!-- Submit Button -->
                                <div class="flex justify-end pt-3 md:pt-4">
                                    <button type="submit"
                                            class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm md:text-base font-medium rounded-md hover:bg-blue-700 transition">
                                        <i class="fas fa-save mr-2"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-white shadow-md rounded-lg p-4 md:p-6 mb-6">
                            <p class="text-gray-700 text-sm md:text-base">No Choose Us section content available.</p>
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
                successMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
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
</body>
</html>