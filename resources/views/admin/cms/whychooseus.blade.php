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

<body class="bg-gradient-to-b from-blue-50 to-indigo-50">

    <div class="flex h-screen">

        {{-- SIDENAV --}}
        <x-dashboard.side-nav />
        {{-- END SIDENAV --}}

        <div class="flex-1 flex flex-col overflow-hidden">

            <main class="flex-1 overflow-x-hidden overflow-y-auto p-4 md:p-6">

                <div class="max-w-4xl mx-auto">
                    <!-- Page Header -->
                    <div
                        class="bg-white rounded-xl shadow-sm mb-6 p-6 text-center border border-gray-200/50 bg-gradient-to-r from-white to-blue-50">
                        <h1 class="text-2xl font-bold text-gray-800 flex items-center justify-center">
                            <i class="fas fa-medal text-yellow-400 mr-3"></i> Why Choose Us Editor
                        </h1>
                    </div>

                    @if ($chooseSection)
                        <div class="bg-white rounded-xl shadow-sm p-6 mb-6 border border-gray-200/50 backdrop-blur-sm">
                            <form id="editForm" action="{{ route('admin.whychoose.update', $chooseSection->id) }}"
                                method="POST" class="space-y-5" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <div id="success-message"
                                    class="hidden p-3 bg-green-100/80 text-green-700 rounded-lg text-sm border border-green-200 flex items-center">
                                    <i class="fas fa-check-circle mr-2"></i>
                                    Changes saved successfully!
                                </div>

                                <!-- Title Field -->
                                <div>
                                    <label for="title"
                                        class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Main
                                        Title</label>
                                    <div class="relative">
                                        <input type="text" id="title" name="title"
                                            value="{{ $chooseSection->title }}"
                                            class="block w-full px-3 py-2 text-xl font-bold text-gray-800 border-b-2 border-blue-100 focus:border-blue-400 focus:outline-none bg-transparent transition-colors"
                                            placeholder="Why choose our service?" required>
                                        <div class="absolute right-2 top-2 text-blue-400">
                                            <i class="fas fa-heading"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Subtitle Field -->
                                <div>
                                    <label for="subtitle"
                                        class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Subtitle</label>
                                    <div class="relative">
                                        <input type="text" id="subtitle" name="subtitle"
                                            value="{{ $chooseSection->subtitle }}"
                                            class="block w-full px-3 py-2 text-gray-600 border-b-2 border-blue-100 focus:border-blue-400 focus:outline-none bg-transparent transition-colors"
                                            placeholder="Your unique value proposition" required>
                                        <div class="absolute right-2 top-2 text-blue-400">
                                            <i class="fas fa-subscript"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Description Field -->
                                <div>
                                    <label for="description"
                                        class="block text-xs font-medium text-gray-500 uppercase tracking-wider mb-1">Description</label>
                                    <div class="relative">
                                        <textarea id="description" name="description" rows="4"
                                            class="block w-full px-3 py-2 text-gray-700 border border-gray-200 rounded-lg focus:border-blue-400 focus:ring-2 focus:ring-blue-100 focus:outline-none transition-all text-sm"
                                            placeholder="List the key reasons customers should choose you" required>{{ $chooseSection->description }}</textarea>
                                        <div class="absolute right-2 top-2 text-blue-400">
                                            <i class="fas fa-align-left"></i>
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="flex justify-end pt-3">
                                    <button type="submit"
                                        class="inline-flex items-center px-5 py-2.5 bg-gradient-to-r from-blue-500 to-blue-600 text-white text-sm font-medium rounded-lg shadow-sm hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-400">
                                        <i class="fas fa-save mr-2"></i> Update Section
                                    </button>
                                </div>
                            </form>
                        </div>
                    @else
                        <div class="bg-white rounded-xl shadow-sm p-6 text-center border border-gray-200/50">
                            <div
                                class="mx-auto w-16 h-16 bg-blue-50 rounded-full flex items-center justify-center mb-3">
                                <i class="fas fa-question-circle text-blue-400 text-xl"></i>
                            </div>
                            <h3 class="text-base font-medium text-gray-700 mb-1">No content available</h3>
                            <p class="text-gray-500 text-sm">Create your "Why Choose Us" section to begin</p>
                        </div>
                    @endif
                </div>
            </main>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // Create preview container after the form
            const formContainer = document.querySelector('#editForm')?.closest('.bg-white');
            if (!formContainer) return;

            // Create and append the preview section
            const previewSection = document.createElement('div');
            previewSection.className =
                'bg-white rounded-xl shadow-sm p-6 mt-6 border border-gray-200/50 backdrop-blur-sm';
            previewSection.innerHTML = `
        <div class="mb-4 flex items-center justify-between">
            <h3 class="text-md font-semibold text-gray-700">
                <i class="fas fa-eye text-blue-500 mr-2"></i> Live Preview
            </h3>
            <span class="text-xs text-blue-500 animate-pulse" id="preview-status">
                <i class="fas fa-sync-alt mr-1"></i> Preview updates in real-time
            </span>
        </div>
        <div class="p-6 bg-white rounded-lg border border-gray-200">
            <!-- Preview container styled to match the actual frontend section -->
            <div id="preview-container" class="w-full py-8 bg-white">
                <div class="max-w-4xl mx-auto lg:text-center">
                    <h2 id="preview-title" class="text-2xl sm:text-3xl md:text-4xl font-bold text-gray-900 mb-4 sm:mb-6 lg:text-center">
                        ${document.getElementById('title')?.value || 'WHY CHOOSE US'}
                    </h2>
                    <h3 id="preview-subtitle" class="text-xl sm:text-2xl md:text-3xl font-normal text-gray-900 mb-4 sm:mb-6">
                        ${document.getElementById('subtitle')?.value || 'The all-in-one solution for effortless order tracking'}
                    </h3>
                    <p id="preview-description" class="text-base sm:text-lg text-gray-700 leading-relaxed">
                        ${formatDescription(document.getElementById('description')?.value || 'We are more than just your typical catering company at Saas. We are committed to turning your visions into reality.')}
                    </p>
                </div>
            </div>
        </div>
    `;

            formContainer.parentNode.insertBefore(previewSection, formContainer.nextSibling);

            // Format description text with proper paragraphs
            function formatDescription(text) {
                // For simple paragraphs in this case
                return text.split('\n').filter(line => line.trim() !== '')
                    .map(line => `<span class="block mb-2">${line}</span>`)
                    .join('');
            }

            // Add event listeners for real-time preview with immediate feedback
            const titleInput = document.getElementById('title');
            const subtitleInput = document.getElementById('subtitle');
            const descriptionTextarea = document.getElementById('description');
            const previewTitle = document.getElementById('preview-title');
            const previewSubtitle = document.getElementById('preview-subtitle');
            const previewDescription = document.getElementById('preview-description');

            // Function to update preview - more responsive version
            function updatePreviewElement(inputElement, previewElement, formatter = null) {
                if (!inputElement || !previewElement) return;

                // Use input event for immediate updates as you type
                inputElement.addEventListener('input', function() {
                    const value = this.value || (this.id === 'title' ? 'WHY CHOOSE US' :
                        this.id === 'subtitle' ?
                        'The all-in-one solution for effortless order tracking' :
                        'We are more than just your typical company. We are committed to turning your visions into reality.'
                        );

                    if (formatter) {
                        previewElement.innerHTML = formatter(value);
                    } else {
                        previewElement.textContent = value;
                    }

                    // Show update indicator
                    const previewStatus = document.getElementById('preview-status');
                    if (previewStatus) {
                        previewStatus.innerHTML =
                        '<i class="fas fa-check-circle mr-1"></i> Preview updated';

                        // Reset status message after a delay
                        clearTimeout(window.statusTimeoutId);
                        window.statusTimeoutId = setTimeout(() => {
                            previewStatus.innerHTML =
                                '<i class="fas fa-sync-alt mr-1"></i> Preview updates in real-time';
                        }, 1000);
                    }

                    // Add highlight animation
                    addChangeAnimation(previewElement);
                });
            }

            // Add subtle highlight animation effect when content changes
            function addChangeAnimation(element) {
                if (!element) return;
                element.classList.add('bg-blue-50', 'transition-colors');
                setTimeout(() => element.classList.remove('bg-blue-50'), 300);
            }

            // Initialize preview updates
            updatePreviewElement(titleInput, previewTitle);
            updatePreviewElement(subtitleInput, previewSubtitle);
            updatePreviewElement(descriptionTextarea, previewDescription, formatDescription);

            // Trigger initial update to ensure preview matches form
            if (titleInput) titleInput.dispatchEvent(new Event('input'));
            if (subtitleInput) subtitleInput.dispatchEvent(new Event('input'));
            if (descriptionTextarea) descriptionTextarea.dispatchEvent(new Event('input'));
        });



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
</body>

</html>
