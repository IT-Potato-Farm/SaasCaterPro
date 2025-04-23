<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>FOOTER SECTION CMS</title>
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

                <div class="mt-4">
                    <div class="bg-white shadow-md rounded-lg mb-4 md:mb-6 p-4">
                        <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold text-center text-gray-800">
                            FOOTER SECTION
                        </h1>
                    </div>

                    @if ($footerSection)
                        <div class="bg-white shadow-md rounded-lg p-4 md:p-6 mb-6">
                            <form id="editFooterForm" action="{{ route('admin.footer.update', $footerSection->id) }}" method="POST" class="space-y-4 md:space-y-6" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div id="footer-success-message" class="hidden mt-4 p-3 md:p-4 bg-green-100 text-green-700 rounded-md text-sm md:text-base">
                                    Changes saved successfully!
                                </div>

                                <!-- Company Name -->
                                <div class="space-y-1 md:space-y-2">
                                    <label for="company_name" class="block text-sm md:text-base font-medium text-gray-700">Company Name</label>
                                    <div class="flex items-center">
                                        <input type="text" id="company_name" name="company_name" value="{{ $footerSection->company_name }}" class="block w-full px-3 py-2 text-xl md:text-2xl lg:text-3xl font-semibold text-gray-800 border-b border-gray-300 focus:border-blue-500 focus:outline-none focus:ring-0 transition-colors" required>
                                        <i class="fas fa-edit text-blue-500 text-sm ml-2"></i>
                                    </div>
                                </div>

                                <!-- Description -->
                                <div class="space-y-1 md:space-y-2">
                                    <label for="description" class="block text-sm md:text-base font-medium text-gray-700">Description</label>
                                    <div class="flex items-start">
                                        <textarea id="description" name="description" rows="4" class="block w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none transition-colors text-sm md:text-base" required>{{ $footerSection->description }}</textarea>
                                        <i class="fas fa-edit text-blue-500 text-sm mt-2 ml-2"></i>
                                    </div>
                                </div>

                                <!-- Phone -->
                                <div class="space-y-1 md:space-y-2">
                                    <label for="phone" class="block text-sm md:text-base font-medium text-gray-700">Phone</label>
                                    <div class="flex items-center">
                                        <input type="text" id="phone" name="phone" value="{{ $footerSection->phone }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none transition-colors text-sm md:text-base" required>
                                        <i class="fas fa-edit text-blue-500 text-sm ml-2"></i>
                                    </div>
                                </div>

                                <!-- Facebook -->
                                <div class="space-y-1 md:space-y-2">
                                    <label for="facebook" class="block text-sm md:text-base font-medium text-gray-700">Facebook</label>
                                    <div class="flex items-center">
                                        <input type="url" id="facebook" name="facebook" value="{{ $footerSection->facebook }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none transition-colors text-sm md:text-base" required>
                                        <i class="fas fa-edit text-blue-500 text-sm ml-2"></i>
                                    </div>
                                </div>

                                <!-- Address -->
                                <div class="space-y-1 md:space-y-2">
                                    <label for="address" class="block text-sm md:text-base font-medium text-gray-700">Address</label>
                                    <div class="flex items-start">
                                        <textarea id="address" name="address" rows="2" class="block w-full px-3 py-2 text-gray-700 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none transition-colors text-sm md:text-base" required>{{ $footerSection->address }}</textarea>
                                        <i class="fas fa-edit text-blue-500 text-sm mt-2 ml-2"></i>
                                    </div>
                                </div>

                                

                                <!-- Logo Upload -->
                                <div class="space-y-1 md:space-y-2">
                                    <label for="logo" class="block text-sm md:text-base font-medium text-gray-700">Logo</label>
                                    <div class="flex flex-col md:flex-row items-start md:items-center gap-4">
                                        @if ($footerSection->logo)
                                            <div class="relative group">
                                                <img src="{{ asset($footerSection->logo) }}" class="rounded-md shadow-lg w-full max-w-xs" alt="Logo Image">
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
                                                <i class="fas fa-upload mr-2"></i> Upload New Logo
                                                <input type="file" id="logo" name="logo" class="hidden" accept="image/*">
                                            </label>
                                            <p class="text-xs md:text-sm text-gray-500 mt-2" id="logo-file-name">No file selected</p>
                                        </div>
                                    </div>
                                </div>

                                <!-- Copyright -->
                                <div class="space-y-1 md:space-y-2">
                                    <label for="copyright" class="block text-sm md:text-base font-medium text-gray-700">Copyright</label>
                                    <div class="flex items-center">
                                        <input type="text" id="copyright" name="copyright" value="{{ $footerSection->copyright }}" class="block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring-blue-500 focus:outline-none transition-colors text-sm md:text-base" required>
                                        <i class="fas fa-edit text-blue-500 text-sm ml-2"></i>
                                    </div>
                                </div>

                                <!-- Submit -->
                                <div class="flex justify-end pt-3 md:pt-4">
                                    <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white text-sm md:text-base font-medium rounded-md hover:bg-blue-700 transition">
                                        <i class="fas fa-save mr-2"></i> Save Changes
                                    </button>
                                </div>

                            </form>
                        </div>
                    @else
                        <div class="bg-white shadow-md rounded-lg p-4 md:p-6 mb-6">
                            <p class="text-gray-700 text-sm md:text-base">No Footer section content available.</p>
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
