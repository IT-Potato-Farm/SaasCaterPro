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
                    <div
                        class="bg-white rounded-xl shadow-sm mb-6 p-6 text-center border border-gray-200/50 bg-gradient-to-r from-white to-blue-50">
                        <div class="inline-flex items-center justify-center w-14 h-14 bg-blue-100 rounded-full mb-3">
                            <i class="fas fa-shoe-prints text-blue-600 text-xl"></i>
                        </div>
                        <h1 class="text-2xl font-bold text-gray-800">
                            Footer Section Editor
                        </h1>
                        <p class="text-gray-500 mt-1 text-sm">Customize your website's footer content</p>
                    </div>

                    @if ($footerSection)
                    <!-- Form Section -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-200/50">
                        <form id="editFooterForm"
                            action="{{ route('admin.footer.update', $footerSection->id) }}" method="POST"
                            class="space-y-5" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div id="footer-success-message"
                                class="hidden p-3 bg-green-50/90 text-green-700 rounded-lg text-sm border border-green-200 flex items-center">
                                <i class="fas fa-check-circle mr-2"></i>
                                Footer updated successfully!
                            </div>

                            <!-- Two Column Layout -->
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                                <!-- Left Column -->
                                <div class="space-y-5">
                                    <!-- Company Name -->
                                    <div>
                                        <label for="company_name"
                                            class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Company
                                            Name</label>
                                        <div class="relative">
                                            <input type="text" id="company_name" name="company_name"
                                                value="{{ $footerSection->company_name }}"
                                                class="preview-field block w-full px-4 py-2 text-lg font-semibold text-gray-800 border-b-2 border-gray-200 focus:border-blue-500 focus:outline-none transition-colors"
                                                placeholder="Your Company Name" required>
                                            <div class="absolute right-2 top-2 text-blue-400">
                                                <i class="fas fa-building"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Description -->
                                    <div>
                                        <label for="description"
                                            class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Description</label>
                                        <div class="relative">
                                            <textarea id="description" name="description" rows="3"
                                                class="preview-field block w-full px-4 py-3 text-gray-700 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 focus:outline-none transition-all text-sm"
                                                placeholder="Brief company description for footer" required>{{ $footerSection->description }}</textarea>
                                            <div class="absolute right-2 top-2 text-blue-400">
                                                <i class="fas fa-align-left"></i>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Logo Upload -->
                                    <div>
                                        <label
                                            class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-2">Company
                                            Logo</label>
                                        <div class="flex flex-col items-center justify-center w-full">
                                            <label
                                                class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                                <div
                                                    class="flex flex-col items-center justify-center pt-5 pb-6 px-4 text-center">
                                                    <svg class="w-8 h-8 mb-3 text-gray-400" fill="none"
                                                        stroke="currentColor" viewBox="0 0 24 24"
                                                        xmlns="http://www.w3.org/2000/svg">
                                                        <path stroke-linecap="round" stroke-linejoin="round"
                                                            stroke-width="2"
                                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z">
                                                        </path>
                                                    </svg>
                                                    <p class="mb-2 text-sm text-gray-500"><span
                                                            class="font-semibold">Click to upload</span> or
                                                        drag and drop</p>
                                                    <p class="text-xs text-gray-500">SVG, PNG, JPG (MAX.
                                                        2MB)</p>
                                                </div>
                                                <input id="logo" name="logo" type="file"
                                                    class="hidden" accept="image/*">
                                            </label>
                                        </div>
                                        @if ($footerSection->logo)
                                            <div class="mt-3 flex items-center space-x-3">
                                                <span class="text-xs text-gray-500">Current logo:</span>
                                                <img src="{{ asset($footerSection->logo) }}"
                                                    class="h-10 rounded" alt="Current Logo"
                                                    id="current-logo">
                                            </div>
                                        @endif
                                        <p class="text-xs text-gray-500 mt-2 text-center"
                                            id="logo-file-name">No file selected</p>
                                    </div>
                                </div>

                                <!-- Right Column -->
                                <div class="space-y-5">
                                    <!-- Contact Information -->
                                    <div class="space-y-3">
                                        <h3
                                            class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Contact Information</h3>

                                        <!-- Address -->
                                        <div>
                                            <label for="address" class="sr-only">Address</label>
                                            <div class="relative">
                                                <div class="absolute left-3 top-3 text-gray-400">
                                                    <i class="fas fa-map-marker-alt"></i>
                                                </div>
                                                <textarea id="address" name="address" rows="2"
                                                    class="preview-field block w-full pl-10 pr-3 py-2 text-gray-700 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 focus:outline-none transition-all text-sm"
                                                    placeholder="Company address" required>{{ $footerSection->address }}</textarea>
                                            </div>
                                        </div>

                                        <!-- Phone -->
                                        <div>
                                            <label for="phone" class="sr-only">Phone</label>
                                            <div class="relative">
                                                <div class="absolute left-3 top-3 text-gray-400">
                                                    <i class="fas fa-phone"></i>
                                                </div>
                                                <input type="text" id="phone" name="phone"
                                                    value="{{ $footerSection->phone }}"
                                                    class="preview-field block w-full pl-10 pr-3 py-2 text-gray-700 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 focus:outline-none transition-all text-sm"
                                                    placeholder="Contact number" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Social Media -->
                                    <div class="space-y-3">
                                        <h3
                                            class="text-xs font-medium text-gray-500 uppercase tracking-wider">
                                            Social Links</h3>

                                        <!-- Facebook -->
                                        <div>
                                            <label for="facebook" class="sr-only">Facebook</label>
                                            <div class="relative">
                                                <div class="absolute left-3 top-3 text-gray-400">
                                                    <i class="fab fa-facebook-f"></i>
                                                </div>
                                                <input type="url" id="facebook" name="facebook"
                                                    value="{{ $footerSection->facebook }}"
                                                    class="preview-field block w-full pl-10 pr-3 py-2 text-gray-700 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 focus:outline-none transition-all text-sm"
                                                    placeholder="Facebook profile URL" required>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Copyright -->
                                    <div>
                                        <label for="copyright"
                                            class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Copyright
                                            Text</label>
                                        <div class="relative">
                                            <input type="text" id="copyright" name="copyright"
                                                value="{{ $footerSection->copyright }}"
                                                class="preview-field block w-full px-4 py-2 text-gray-700 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-100 focus:border-blue-500 focus:outline-none transition-all text-sm"
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
                                <button type="submit"
                                    class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
                                    <i class="fas fa-save mr-2"></i> Update Footer
                                </button>
                            </div>
                        </form>
                    </div>

                    <!-- Full Width Live Preview Section -->
                    <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-200/50">
                        <div class="mb-4 flex items-center justify-between">
                            <h3 class="text-base font-semibold text-gray-700">Live Preview</h3>
                            <span class="text-xs text-blue-500 bg-blue-50 px-2 py-1 rounded-full">
                                <i class="fas fa-sync-alt mr-1"></i> Updates in real-time
                            </span>
                        </div>

                        <!-- Preview Container -->
                        <div class="border border-dashed border-gray-300 rounded-lg p-4 bg-gray-50">
                            <!-- Full Width Footer Preview -->
                            <div id="footer-preview" class="bg-white rounded-lg shadow-sm dark:bg-gray-900 pt-8 pb-6 w-full">
                                <div class="w-full max-w-screen-xl mx-auto px-4">
                                    <!-- Main Content - 2 Columns -->
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 md:gap-8">
                                        <!-- Brand Info -->
                                        <div class="flex flex-col items-center md:items-start space-y-4">
                                            <div class="flex flex-col sm:flex-row items-center gap-4">
                                                <img id="preview-logo"
                                                    src="{{ asset($footerSection->logo) }}"
                                                    class="h-12 w-auto" alt="Company Logo">
                                                <div class="text-center md:text-left">
                                                    <h2 id="preview-company-name"
                                                        class="text-xl font-semibold text-gray-800 dark:text-white">
                                                        {{ $footerSection->company_name }}
                                                    </h2>
                                                    <p id="preview-description"
                                                        class="text-gray-600 dark:text-gray-300 text-sm mt-1">
                                                        {{ $footerSection->description }}
                                                    </p>
                                                </div>
                                            </div>
                                        </div>

                                        <!-- Contact Info -->
                                        <div class="flex flex-col items-center md:items-start space-y-4">
                                            <h3 class="text-lg font-semibold text-gray-800 dark:text-white">
                                                Contact Us</h3>

                                            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
                                                <!-- Contact Methods -->
                                                <div class="space-y-3">
                                                    <!-- Phone -->
                                                    <div class="flex items-center">
                                                        <a href="#"
                                                            class="flex items-center text-gray-600 dark:text-gray-300 hover:text-blue-600 transition-colors">
                                                            <i class="fas fa-phone-alt mr-3 text-blue-500"></i>
                                                            <span id="preview-phone"
                                                                class="text-sm">{{ $footerSection->phone }}</span>
                                                        </a>
                                                    </div>

                                                    <!-- Facebook -->
                                                    <div class="flex items-center">
                                                        <a href="#"
                                                            class="flex items-center text-gray-600 dark:text-gray-300 hover:text-blue-600 transition-colors">
                                                            <i class="fab fa-facebook-f mr-3 text-blue-500"></i>
                                                            <span class="text-sm">Visit Us On</span>
                                                        </a>
                                                    </div>
                                                </div>

                                                <!-- Address & Policy -->
                                                <div class="space-y-3">
                                                    <!-- Address -->
                                                    <div class="flex items-start">
                                                        <a href="#"
                                                            class="flex items-start text-gray-600 dark:text-gray-300 hover:text-blue-600 transition-colors">
                                                            <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-500"></i>
                                                            <span id="preview-address"
                                                                class="text-sm">{{ $footerSection->address }}</span>
                                                        </a>
                                                    </div>

                                                    <!-- Privacy Policy -->
                                                    <div class="flex items-center">
                                                        <a href="#"
                                                            class="flex items-center text-gray-600 dark:text-gray-300 hover:text-blue-600 transition-colors">
                                                            <i class="fas fa-file-alt mr-3 text-blue-500"></i>
                                                            <span class="text-sm">Privacy Policy</span>
                                                        </a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>

                                    <!-- Divider -->
                                    <hr class="my-6 border-gray-200 dark:border-gray-700" />

                                    <!-- Copyright -->
                                    <div class="text-center">
                                        <p id="preview-copyright"
                                            class="text-sm text-gray-500 dark:text-gray-400">
                                            {{ $footerSection->copyright }}
                                        </p>
                                    </div>
                                </div>
                            </div>

                            <!-- Preview Footer -->
                            <div class="mt-4 pt-4 border-t border-gray-200 text-center">
                                <span class="text-xs text-gray-500">This is a preview of how your footer
                                    will appear on your website</span>
                            </div>
                        </div>
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
        document.addEventListener('DOMContentLoaded', function() {
                    const logoInput = document.getElementById('logo');
                    const previewLogo = document.getElementById('preview-logo');
                    const currentLogo = document.getElementById('current-logo');

                    // Handle logo file upload
                    logoInput?.addEventListener('change', function(e) {
                        const file = e.target.files[0];
                        const fileName = file?.name || 'No file selected';
                        document.getElementById('logo-file-name').textContent = fileName;

                        // Update preview with selected image
                        if (file) {
                            const reader = new FileReader();
                            reader.onload = function(e) {
                                previewLogo.src = e.target.result;
                                if (currentLogo) {
                                    currentLogo.src = e.target.result;
                                }
                            }
                            reader.readAsDataURL(file);
                        }
                    });

                    // Set up live preview for text fields
                    const inputFields = document.querySelectorAll('.preview-field');
                    inputFields.forEach(field => {
                        field.addEventListener('input', function() {
                            const fieldId = this.id;
                            const value = this.value;

                            // Update the corresponding preview element
                            switch (fieldId) {
                                case 'company_name':
                                    document.getElementById('preview-company-name').textContent = value;
                                    break;
                                case 'description':
                                    document.getElementById('preview-description').textContent = value;
                                    break;
                                case 'address':
                                    document.getElementById('preview-address').textContent = value;
                                    break;
                                case 'phone':
                                    document.getElementById('preview-phone').textContent = value;
                                    break;
                                case 'copyright':
                                    document.getElementById('preview-copyright').textContent = value;
                                    break;
                            }
                        });
                    });

                    // FORM SUBMISSION
                    document.getElementById('editFooterForm')?.addEventListener('submit', function(e) {
                        e.preventDefault();

                        const formData = new FormData(this);

                        fetch(this.action, {
                                method: 'POST',
                                body: formData,
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                }
                            })
                            .then(response => response.ok ? response.json() : Promise.reject('Network error'))
                            .then(() => {
                                const successMessage = document.getElementById('footer-success-message');
                                successMessage.classList.remove('hidden');
                                setTimeout(() => successMessage.classList.add('hidden'), 3000);
                                successMessage.scrollIntoView({
                                    behavior: 'smooth',
                                    block: 'nearest'
                                });
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
        });
    </script>

</body>

</html>
