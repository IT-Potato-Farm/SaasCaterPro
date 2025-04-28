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
                
                <div class="max-w-5xl mx-auto">
                    <!-- Page Header -->
                    <div class="bg-white rounded-xl shadow-sm mb-6 p-6 text-center border border-gray-200/50 bg-gradient-to-r from-white to-blue-50">
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-blue-100 rounded-full mb-3">
                            <i class="fas fa-shoe-prints text-blue-600 text-xl"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            Footer Section Editor
                        </h1>
                        <p class="text-gray-500 mt-1 text-sm">Customize your website's footer content</p>
                    </div>

                    @if ($footerSection)
                        <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-200/50">
                            <form id="editFooterForm" action="{{ route('admin.footer.update', $footerSection->id) }}" method="POST" class="space-y-5" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div id="footer-success-message" class="hidden p-3 bg-green-50/90 text-green-700 rounded-lg text-sm border border-green-200 flex items-center">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Footer updated successfully!
                                </div>

                                <!-- Two Column Layout -->
                                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                    <!-- Left Column -->
                                    <div class="space-y-5">
                                        <!-- Company Name -->
                                        <div>
                                            <label for="company_name" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Company Name</label>
                                            <div class="relative">
                                                <input type="text" id="company_name" name="company_name" value="{{ $footerSection->company_name }}" 
                                                    class="block w-full px-4 py-2 text-lg font-semibold text-gray-800 border-b-2 border-gray-200 focus:border-blue-500 focus:outline-none transition-colors"
                                                    placeholder="Your Company Name"
                                                    required>
                                                <div class="absolute right-2 top-2 text-blue-400">
                                                    <i class="fas fa-building"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Description -->
                                        <div>
                                            <label for="description" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Description</label>
                                            <div class="relative">
                                                <textarea id="description" name="description" rows="3" 
                                                    class="block w-full px-4 py-3 text-gray-700 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 focus:outline-none transition-all text-sm"
                                                    placeholder="Brief company description for footer"
                                                    required>{{ $footerSection->description }}</textarea>
                                                <div class="absolute right-2 top-2 text-blue-400">
                                                    <i class="fas fa-align-left"></i>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Logo Upload -->
                                        <div>
                                            <label class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Company Logo</label>
                                            <div class="flex flex-col items-center justify-center w-full">
                                                <label class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                                    <div class="flex flex-col items-center justify-center pt-5 pb-6 px-4 text-center">
                                                        <svg class="w-8 h-8 mb-3 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                                        </svg>
                                                        <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                        <p class="text-xs text-gray-500">SVG, PNG, JPG (MAX. 2MB)</p>
                                                    </div>
                                                    <input id="logo" name="logo" type="file" class="hidden" accept="image/*">
                                                </label>
                                            </div>
                                            @if ($footerSection->logo)
                                                <div class="mt-3 flex items-center space-x-3">
                                                    <span class="text-xs text-gray-500">Current logo:</span>
                                                    <img src="{{ asset($footerSection->logo) }}" class="h-10 rounded" alt="Current Logo">
                                                </div>
                                            @endif
                                            <p class="text-xs text-gray-500 mt-2 text-center" id="logo-file-name">No file selected</p>
                                        </div>
                                    </div>

                                    <!-- Right Column -->
                                    <div class="space-y-5">
                                        <!-- Contact Information -->
                                        <div class="space-y-3">
                                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Contact Information</h3>
                                            
                                            <!-- Address -->
                                            <div>
                                                <label for="address" class="sr-only">Address</label>
                                                <div class="relative">
                                                    <div class="absolute left-3 top-3 text-gray-400">
                                                        <i class="fas fa-map-marker-alt"></i>
                                                    </div>
                                                    <textarea id="address" name="address" rows="2" 
                                                        class="block w-full pl-10 pr-3 py-2 text-gray-700 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 focus:outline-none transition-all text-sm"
                                                        placeholder="Company address"
                                                        required>{{ $footerSection->address }}</textarea>
                                                </div>
                                            </div>

                                            <!-- Phone -->
                                            <div>
                                                <label for="phone" class="sr-only">Phone</label>
                                                <div class="relative">
                                                    <div class="absolute left-3 top-3 text-gray-400">
                                                        <i class="fas fa-phone"></i>
                                                    </div>
                                                    <input type="text" id="phone" name="phone" value="{{ $footerSection->phone }}" 
                                                        class="block w-full pl-10 pr-3 py-2 text-gray-700 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 focus:outline-none transition-all text-sm"
                                                        placeholder="Contact number"
                                                        required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Social Media -->
                                        <div class="space-y-3">
                                            <h3 class="text-xs font-medium text-gray-500 uppercase tracking-wider">Social Links</h3>
                                            
                                            <!-- Facebook -->
                                            <div>
                                                <label for="facebook" class="sr-only">Facebook</label>
                                                <div class="relative">
                                                    <div class="absolute left-3 top-3 text-gray-400">
                                                        <i class="fab fa-facebook-f"></i>
                                                    </div>
                                                    <input type="url" id="facebook" name="facebook" value="{{ $footerSection->facebook }}" 
                                                        class="block w-full pl-10 pr-3 py-2 text-gray-700 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 focus:outline-none transition-all text-sm"
                                                        placeholder="Facebook profile URL"
                                                        required>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Copyright -->
                                        <div>
                                            <label for="copyright" class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Copyright Text</label>
                                            <div class="relative">
                                                <input type="text" id="copyright" name="copyright" value="{{ $footerSection->copyright }}" 
                                                    class="block w-full px-4 py-2 text-gray-700 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 focus:outline-none transition-all text-sm"
                                                    placeholder="© 2023 Company Name. All rights reserved."
                                                    required>
                                                <div class="absolute right-2 top-2 text-blue-400">
                                                    <i class="fas fa-copyright"></i>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end pt-4">
                                    <button type="submit" class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
                                        <i class="fas fa-save mr-2"></i> Update Footer
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-white rounded-xl shadow-sm p-6 text-center border border-gray-200/50">
                            <div class="mx-auto w-16 h-16 bg-gray-100 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-exclamation-circle text-gray-400 text-xl"></i>
                            </div>
                            <h3 class="text-base font-medium text-gray-700 mb-1">No Footer Content</h3>
                            <p class="text-gray-500 text-sm">Create footer content to complete your website</p>
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
