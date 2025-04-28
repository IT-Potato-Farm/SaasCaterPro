<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOOTER SECTION CMS</title>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>

<body class="bg-gradient-to-b from-gray-50 to-gray-100">

    <div class="flex h-screen">

        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-6">
                
                <div class="max-w-6xl mx-auto">
                    <!-- Page Header -->
                    <div class="bg-white rounded-xl shadow-sm mb-6 p-6 text-center border border-gray-200/50 bg-gradient-to-r from-white to-indigo-50">
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-indigo-100 rounded-full mb-3">
                            <i class="fas fa-building text-indigo-600 text-xl"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            About Us Editor
                        </h1>
                        <p class="text-indigo-500 mt-1 text-sm">Tell your company's story with pride</p>
                    </div>

                    @if ($aboutUs)
                        <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-200/50">
                            <form id="editAboutForm" action="{{ route('admin.aboutus.update', $aboutUs->id) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div id="success-message" class="hidden p-3 bg-green-50/90 text-green-700 rounded-lg text-sm border border-green-200 flex items-center">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    About Us updated successfully!
                                </div>

                                <!-- Two Column Layout -->
                                <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                                    <!-- Left Column - Content -->
                                    <div class="space-y-6">
                                        <!-- Title -->
                                        <div>
                                            <label for="title" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Section Title</label>
                                            <div class="relative">
                                                <input type="text" id="title" name="title" value="{{ $aboutUs->title }}" 
                                                    class="block w-full px-4 py-3 text-xl font-bold text-gray-800 border-b-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition-colors"
                                                    placeholder="Our Company Story"
                                                    required>
                                                <div class="absolute right-3 top-3 text-indigo-400">
                                                    <i class="fas fa-heading"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Subtitle -->
                                        <div>
                                            <label for="subtitle" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Subtitle</label>
                                            <div class="relative">
                                                <input type="text" id="subtitle" name="subtitle" value="{{ $aboutUs->subtitle }}" 
                                                    class="block w-full px-4 py-2 text-gray-600 border-b-2 border-gray-200 focus:border-indigo-500 focus:outline-none transition-colors"
                                                    placeholder="What makes us special"
                                                    required>
                                                <div class="absolute right-3 top-3 text-indigo-400">
                                                    <i class="fas fa-subscript"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div>
                                            <label for="description" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Our Story</label>
                                            <div class="relative">
                                                <textarea id="description" name="description" rows="6" 
                                                    class="block w-full px-4 py-3 text-gray-700 border border-gray-200 rounded-lg focus:ring-2 focus:ring-indigo-100 focus:border-indigo-500 focus:outline-none transition-all text-sm"
                                                    placeholder="Tell your company's history, mission, and values..."
                                                    required>{{ $aboutUs->description }}</textarea>
                                                <div class="absolute right-3 top-3 text-indigo-400">
                                                    <i class="fas fa-align-left"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Right Column - Media -->
                                    <div class="space-y-6">
                                        <!-- Featured Image -->
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Featured Image</label>
                                            <div class="relative group rounded-xl overflow-hidden border-2 border-dashed border-gray-300 hover:border-indigo-300 transition-colors">
                                                @if ($aboutUs->featured_image)
                                                    <img src="{{ asset($aboutUs->featured_image) }}" 
                                                        class="w-full h-64 object-cover" 
                                                        alt="Current Featured Image">
                                                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <span class="text-white text-sm font-medium bg-black/50 px-3 py-1 rounded-full">Current Image</span>
                                                    </div>
                                                @else
                                                    <div class="w-full h-64 bg-gray-100 flex flex-col items-center justify-center">
                                                        <i class="fas fa-image text-gray-400 text-4xl mb-3"></i>
                                                        <p class="text-gray-500 text-sm">No featured image selected</p>
                                                    </div>
                                                @endif
                                                <input type="file" id="featured_image" name="featured_image" 
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                                    accept="image/*">
                                            </div>
                                            <p class="text-xs text-gray-500 mt-2 text-center">Recommended size: 1200×800px</p>
                                        </div>

                                        <!-- Team Photo -->
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Team Photo (Optional)</label>
                                            <div class="relative group rounded-xl overflow-hidden border-2 border-dashed border-gray-300 hover:border-indigo-300 transition-colors">
                                                @if ($aboutUs->team_photo)
                                                    <img src="{{ asset($aboutUs->team_photo) }}" 
                                                        class="w-full h-48 object-cover" 
                                                        alt="Current Team Photo">
                                                    <div class="absolute inset-0 bg-black/30 flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity">
                                                        <span class="text-white text-sm font-medium bg-black/50 px-3 py-1 rounded-full">Current Photo</span>
                                                    </div>
                                                @else
                                                    <div class="w-full h-48 bg-gray-100 flex flex-col items-center justify-center">
                                                        <i class="fas fa-users text-gray-400 text-3xl mb-3"></i>
                                                        <p class="text-gray-500 text-sm">Upload team photo</p>
                                                    </div>
                                                @endif
                                                <input type="file" id="team_photo" name="team_photo" 
                                                    class="absolute inset-0 w-full h-full opacity-0 cursor-pointer" 
                                                    accept="image/*">
                                            </div>
                                        </div>

                                        <!-- Milestones -->
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Key Milestones</label>
                                            <div class="space-y-3">
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0 mt-1">
                                                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                            <i class="fas fa-star text-indigo-500 text-xs"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="milestone1" value="{{ $aboutUs->milestone1 }}" 
                                                        class="flex-1 px-3 py-2 text-sm text-gray-700 border-b border-gray-200 focus:border-indigo-500 focus:outline-none"
                                                        placeholder="E.g., Founded in 2010">
                                                </div>
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0 mt-1">
                                                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                            <i class="fas fa-star text-indigo-500 text-xs"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="milestone2" value="{{ $aboutUs->milestone2 }}" 
                                                        class="flex-1 px-3 py-2 text-sm text-gray-700 border-b border-gray-200 focus:border-indigo-500 focus:outline-none"
                                                        placeholder="E.g., 1000+ happy customers">
                                                </div>
                                                <div class="flex items-start space-x-3">
                                                    <div class="flex-shrink-0 mt-1">
                                                        <div class="w-8 h-8 rounded-full bg-indigo-100 flex items-center justify-center">
                                                            <i class="fas fa-star text-indigo-500 text-xs"></i>
                                                        </div>
                                                    </div>
                                                    <input type="text" name="milestone3" value="{{ $aboutUs->milestone3 }}" 
                                                        class="flex-1 px-3 py-2 text-sm text-gray-700 border-b border-gray-200 focus:border-indigo-500 focus:outline-none"
                                                        placeholder="E.g., Award winning service">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end pt-4">
                                    <button type="submit" 
                                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-indigo-500 to-indigo-600 text-white text-sm font-medium rounded-lg shadow-sm hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-400">
                                        <i class="fas fa-save mr-2"></i> Update About Us
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-white rounded-xl shadow-sm p-6 text-center border border-gray-200/50">
                            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-info-circle text-gray-400 text-xl"></i>
                            </div>
                            <h3 class="text-base font-medium text-gray-700 mb-1">No About Us Content</h3>
                            <p class="text-gray-500 text-sm">Create content to showcase your company story</p>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script>
        document.getElementById('logo')?.addEventListener('change', function(e) {
            const fileName = e.target.files[0]?.name || 'No file selected';
            document.getElementById('logo-file-name').textContent = fileName;
        });

        document.getElementById('editFooterForm')?.addEventListener('submit', function(e) {
            e.preventDefault();

            const formData = new FormData(this);

            fetch(this.action, {
                method: 'POST',
                body: formData,
                headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' }
            })
            .then(response => response.ok ? response.json() : Promise.reject('Network error'))
            .then(() => {
                const successMessage = document.getElementById('footer-success-message');
                successMessage.classList.remove('hidden');
                setTimeout(() => successMessage.classList.add('hidden'), 3000);
                successMessage.scrollIntoView({ behavior: 'smooth', block: 'nearest' });
            })
            .catch(() => {
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
