<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>HERO SECTION CMS</title>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gray-50">

    <div class="flex h-screen">

        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">

            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-50 p-4 md:p-6">

                <div class="mt-4">
                    <!-- Page Header -->
                    <div class="bg-white rounded-xl shadow-sm mb-6 p-6 text-center border border-gray-100">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                            HERO SECTION
                        </h1>
                        <p class="text-gray-500 mt-2">Customize your website's hero banner</p>
                    </div>

                    @if ($heroSection)
                        <!-- Live Preview Section -->
                        <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
                            <h2 class="text-xl font-semibold text-gray-800 mb-3 flex items-center">
                                <i class="fas fa-eye mr-2 text-blue-500"></i>
                                Live Preview
                                <span class="ml-2 text-xs font-normal text-gray-500 bg-gray-100 px-2 py-1 rounded">Updates in real-time</span>
                            </h2>
                            
                            <div class="border border-gray-200 rounded-lg overflow-hidden shadow-sm">
                                <!-- Hero Preview -->
                                <section 
                                    id="preview-hero"
                                    class="relative bg-cover bg-center bg-no-repeat flex items-center"
                                    style="background-image: url('{{ asset($heroSection->background_image ?? 'images/sectionhero.jpg') }}'); height: 400px;"
                                    aria-label="Hero section preview">
                                    
                                    {{-- Dark overlay --}}
                                    <div class="absolute bg-black bg-opacity-50 inset-0"></div>
                                    
                                    {{-- Content container --}}
                                    <div class="relative z-10 w-full px-4 mx-auto max-w-screen-xl text-center py-12">
                                        <h1 id="preview-title" class="mb-2 text-5xl font-bold tracking-tight text-white animate-fade-in">
                                            {{ $heroSection->title }}
                                        </h1>
                                        
                                        <p id="preview-subtitle" class="mb-4 text-xl font-medium text-white animate-fade-in-delayed">
                                            {{ $heroSection->subtitle }}
                                        </p>
                                        
                                        <p id="preview-description" class="mb-6 text-lg font-normal text-white/90 max-w-3xl mx-auto animate-fade-in-delayed-more">
                                            {{ $heroSection->description }}
                                        </p>
                                    </div>
                                </section>
                            </div>
                            <p class="text-xs text-gray-400 text-right mt-2">This is a scaled-down preview. Actual appearance may vary based on your site's layout.</p>
                        </div>

                        <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100">
                            <form id="editForm" action="{{ route('admin.hero.update', $heroSection->id) }}"
                                method="POST" class="space-y-6" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div id="success-message"
                                    class="hidden p-4 bg-green-50 text-green-700 rounded-lg text-sm border border-green-100 flex items-center">
                                    <i class="fas fa-check-circle mr-2 text-lg"></i>
                                    Changes saved successfully!
                                </div>

                                <!-- Title Field -->
                                <div>
                                    <label for="title"
                                        class="block text-sm font-medium text-gray-700 mb-2">Title</label>
                                    <div class="relative">
                                        <input type="text" id="title" name="title"
                                            value="{{ $heroSection->title }}"
                                            class="block w-full px-4 py-3 text-xl font-semibold text-gray-800 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                            placeholder="Your hero headline" required>
                                        <div class="absolute right-3 top-3 text-blue-500">
                                            <i class="fas fa-heading"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subtitle Field -->
                                <div>
                                    <label for="subtitle"
                                        class="block text-sm font-medium text-gray-700 mb-2">Subtitle</label>
                                    <div class="relative">
                                        <input type="text" id="subtitle" name="subtitle"
                                            value="{{ $heroSection->subtitle }}"
                                            class="block w-full px-4 py-3 text-lg text-gray-600 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                            placeholder="Supporting headline text" required>
                                        <div class="absolute right-3 top-3 text-blue-500">
                                            <i class="fas fa-text-width"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description Field -->
                                <div>
                                    <label for="description"
                                        class="block text-sm font-medium text-gray-700 mb-2">Description</label>
                                    <div class="relative">
                                        <textarea id="description" name="description" rows="4"
                                            class="block w-full px-4 py-3 text-gray-700 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                            placeholder="Detailed description of your hero section" required>{{ $heroSection->description }}</textarea>
                                        <div class="absolute right-3 top-3 text-blue-500">
                                            <i class="fas fa-align-left"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Background Image Field -->
                                <div>
                                    <label for="background_image"
                                        class="block text-sm font-medium text-gray-700 mb-3">Background Image</label>

                                    <div class="flex flex-col md:flex-row gap-6">
                                        <!-- Current Image Preview -->
                                        @if ($heroSection->background_image)
                                            <div class="w-full md:w-1/3">
                                                <div
                                                    class="relative group rounded-xl overflow-hidden shadow-lg border-2 border-gray-200">
                                                    <img src="{{ asset($heroSection->background_image) }}"
                                                        class="w-full h-48 md:h-64 object-cover"
                                                        alt="Current Background" id="current-image">
                                                    <div
                                                        class="absolute inset-0 bg-black/30 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity p-4">
                                                        <span class="text-white font-medium text-sm mb-1">Current
                                                            Image</span>
                                                        <span class="text-white/90 text-xs text-center">Click new image
                                                            to replace</span>
                                                    </div>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-2 text-center">Current image</p>
                                            </div>
                                        @endif

                                        <!-- Upload Area -->
                                        <div class="flex-1">
                                            <div class="flex flex-col items-center justify-center w-full">
                                                <label
                                                    class="flex flex-col items-center justify-center w-full h-48 border-2 border-dashed border-gray-300 rounded-xl cursor-pointer bg-gray-50 hover:border-blue-400 hover:bg-blue-50 transition-all duration-200">
                                                    <div
                                                        class="flex flex-col items-center justify-center pt-5 pb-6 px-4 text-center">
                                                        <svg class="w-10 h-10 mb-3 text-gray-400 group-hover:text-blue-400 transition-colors"
                                                            fill="none" stroke="currentColor" viewBox="0 0 24 24"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                                stroke-width="2"
                                                                d="M7 16a4 4 0 01-.88-7.903A5 5 0 1115.9 6L16 6a5 5 0 011 9.9M15 13l-3-3m0 0l-3 3m3-3v12">
                                                            </path>
                                                        </svg>
                                                        <p
                                                            class="mb-2 text-sm text-gray-500 group-hover:text-blue-500 transition-colors">
                                                            <span class="font-semibold">Click to upload</span> or drag
                                                            and drop
                                                        </p>
                                                        <p
                                                            class="text-xs text-gray-400 group-hover:text-blue-400 transition-colors">
                                                            PNG, JPG, JPEG (MAX. 5MB)</p>
                                                    </div>
                                                    <input id="background_image" name="background_image" type="file"
                                                        class="hidden" accept="image/*">
                                                </label>
                                            </div>

                                            <!-- File Info -->
                                            <div class="mt-3 flex items-center justify-between">
                                                <p class="text-sm text-gray-500" id="file-name">No file selected</p>
                                                <p id="image-error" class="text-sm text-red-500"></p>
                                            </div>

                                            <!-- New Image Preview -->
                                            <div class="mt-4 hidden" id="preview-container">
                                                <div class="flex items-center justify-between mb-2">
                                                    <p class="text-sm font-medium text-gray-700">New Image Preview</p>
                                                    <button type="button" onclick="clearImageSelection()"
                                                        class="text-xs text-red-500 hover:text-red-700 flex items-center">
                                                        <i class="fas fa-times mr-1"></i> Remove
                                                    </button>
                                                </div>
                                                <div
                                                    class="relative rounded-lg overflow-hidden border border-gray-200 shadow-sm">
                                                    <img id="preview-image"
                                                        class="w-full h-auto max-h-64 object-contain" />
                                                    <div
                                                        class="absolute inset-0 bg-gradient-to-t from-black/20 to-transparent opacity-0 hover:opacity-100 transition-opacity flex items-end p-3">
                                                        <span class="text-white text-xs">Preview</span>
                                                    </div>
                                                </div>
                                                <p class="text-xs text-gray-500 mt-1 text-right">Image will be cropped
                                                    to fit</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end pt-2">
                                    <button type="submit"
                                        class="inline-flex items-center px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-medium rounded-lg shadow-sm hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                        <i class="fas fa-save mr-2"></i> Save Changes
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-100 text-center">
                            <div
                                class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-exclamation-circle text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-800 mb-2">No hero section content available</h3>
                            <p class="text-gray-500">Please create hero section content to get started.</p>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Form Fields
            const titleInput = document.getElementById('title');
            const subtitleInput = document.getElementById('subtitle');
            const descriptionInput = document.getElementById('description');
            const fileInput = document.getElementById('background_image');
            
            // Preview Elements
            const previewTitle = document.getElementById('preview-title');
            const previewSubtitle = document.getElementById('preview-subtitle');
            const previewDescription = document.getElementById('preview-description');
            const previewHero = document.getElementById('preview-hero');
            
            // File Preview Elements
            const fileNameDisplay = document.getElementById('file-name');
            const previewImage = document.getElementById('preview-image');
            const imageError = document.getElementById('image-error');
            const previewContainer = document.getElementById('preview-container');
            
            // Live Preview Updates
            if (titleInput) {
                titleInput.addEventListener('input', function() {
                    previewTitle.textContent = this.value || 'SAAS';
                    // Apply a quick highlight effect
                    previewTitle.classList.add('bg-white/10');
                    setTimeout(() => {
                        previewTitle.classList.remove('bg-white/10');
                    }, 300);
                });
            }
            
            if (subtitleInput) {
                subtitleInput.addEventListener('input', function() {
                    previewSubtitle.textContent = this.value || 'CATERING AND FOOD SERVICES';
                    // Apply a quick highlight effect
                    previewSubtitle.classList.add('bg-white/10');
                    setTimeout(() => {
                        previewSubtitle.classList.remove('bg-white/10');
                    }, 300);
                });
            }
            
            if (descriptionInput) {
                descriptionInput.addEventListener('input', function() {
                    previewDescription.textContent = this.value || 'Offers an exquisite goodness taste of Halal Cuisine';
                    // Apply a quick highlight effect
                    previewDescription.classList.add('bg-white/10');
                    setTimeout(() => {
                        previewDescription.classList.remove('bg-white/10');
                    }, 300);
                });
            }
            
            // File Input Handling
            if (fileInput) {
                fileInput.addEventListener('change', function(e) {
                    const file = e.target.files[0];
                    fileNameDisplay.textContent = file?.name || 'No file selected';
                    
                    // Reset error if any
                    imageError.textContent = ''; 
                    
                    if (file) {
                        // Validate file type
                        if (!file.type.startsWith('image/')) {
                            imageError.textContent = 'Please select a valid image file (PNG, JPG, JPEG)';
                            clearImageSelection();
                            return;
                        }
                        
                        // Validate file size (max 5MB)
                        if (file.size > 5 * 1024 * 1024) {
                            imageError.textContent = 'Image size must be less than 5MB';
                            clearImageSelection();
                            return;
                        }
                        
                        const reader = new FileReader();
                        reader.onload = function(event) {
                            // Update the individual preview
                            previewImage.src = event.target.result;
                            previewContainer.classList.remove('hidden');
                            
                            // Update the hero preview background
                            previewHero.style.backgroundImage = `url('${event.target.result}')`;
                            
                            // Add a visual feedback that preview has been updated
                            previewHero.classList.add('ring-4', 'ring-blue-300', 'ring-opacity-50');
                            setTimeout(() => {
                                previewHero.classList.remove('ring-4', 'ring-blue-300', 'ring-opacity-50');
                            }, 600);
                        };
                        reader.readAsDataURL(file);
                    } else {
                        clearImageSelection();
                    }
                });
            }
        });

        // CLEAR IMAGE FUNCTION
        function clearImageSelection() {
            const fileInput = document.getElementById('background_image');
            const previewImage = document.getElementById('preview-image');
            const previewContainer = document.getElementById('preview-container');
            const fileNameDisplay = document.getElementById('file-name');
            const imageError = document.getElementById('image-error');
            const previewHero = document.getElementById('preview-hero');
            const currentImage = document.getElementById('current-image');
            
            fileInput.value = '';
            previewImage.src = '';
            previewContainer.classList.add('hidden');
            fileNameDisplay.textContent = 'No file selected';
            
            if (imageError) {
                imageError.textContent = '';
            }
            
            // Reset hero preview to current image
            if (currentImage) {
                previewHero.style.backgroundImage = `url('${currentImage.src}')`;
            }
        }

        // Handle form submission
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
            .then(async response => {
                if (!response.ok) {
                    const errorData = await response.json();
                    throw errorData;
                }
                return response.json();
            })
            .then(data => {
                const successMessage = document.getElementById('success-message');
                successMessage.classList.remove('hidden');
                
                setTimeout(() => {
                    successMessage.classList.add('hidden');
                    location.reload(); 
                }, 1000); 
                
                successMessage.scrollIntoView({
                    behavior: 'smooth',
                    block: 'nearest'
                });
            })
            .catch(errorData => {
                if (errorData.errors && errorData.errors.background_image) {
                    imageError.textContent = errorData.errors.background_image[0];
                } else {
                    Swal.fire({
                        title: 'Error!',
                        text: 'An error occurred while saving changes.',
                        icon: 'error',
                        confirmButtonText: 'OK'
                    });
                }
            });
        });
    </script>


</body>

</html>
