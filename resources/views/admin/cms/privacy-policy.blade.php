<!-- resources/views/admin/privacy-policy.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Privacy Policy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/toprightalert.js') }}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

</head>

<body class="bg-gray-500 flex h-screen">
    
    @if(session('success'))
    <script>
        showSuccessToast('{{ session('success') }}');
    </script>
    @endif
    
    @if(session('error'))
    <script>
        showErrorToast('{{ session('error') }}');
    </script>
    @endif
    
        <x-dashboard.side-nav />
        <div class="flex-1 flex flex-col overflow-hidden">
            <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-4 md:p-6">
                <h1 class="text-3xl font-bold text-gray-800 mb-6">EDIT Privacy Policy Page</h1>
                
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
                    <!-- Editor Column -->
                    <div class="bg-white p-6 rounded-lg shadow-md">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4">Editor</h2>
                        
                        <!-- Form for Editing Privacy Policy -->
                        <form action="{{ route('admin.privacy.update', $privacyPolicy->id) }}" method="POST" id="privacyForm">
                            @csrf
                            @method('PUT')
                
                            <!-- Title Input -->
                            <div class="mb-4">
                                <label for="title" class="block text-lg text-gray-700">Title</label>
                                <input type="text" name="title" id="title" class="w-full p-3 border border-gray-300 rounded-md" 
                                    value="{{ $privacyPolicy->title }}" required>
                            </div>
                
                            <!-- Content Editor -->
                            <div class="mb-6">
                                <label for="content" class="block text-lg text-gray-700">Content</label>
                                <textarea name="content" id="content" class="w-full p-3 border border-gray-300 rounded-md">{{ $privacyPolicy->content }}</textarea>
                            </div>
                
                            <div class="flex justify-between">
                                <button type="submit" class="px-6 py-2 bg-blue-600 hover:bg-blue-700 text-white rounded-md transition duration-300">
                                    <i class="fas fa-save mr-2"></i> Update Policy
                                </button>
                                <button type="button" id="previewToggle" class="px-6 py-2 bg-gray-600 hover:bg-gray-700 text-white rounded-md transition duration-300 lg:hidden">
                                    Toggle Preview
                                </button>
                            </div>
                        </form>
                    </div>
                    
                    <!-- Preview Column -->
                    <div class="bg-white p-6 rounded-lg shadow-md preview-column lg:block">
                        <h2 class="text-xl font-semibold text-gray-700 mb-4">Live Preview</h2>
                        
                        <div class="border rounded-lg overflow-hidden" style="height: calc(100vh - 250px);">
                            <div class="bg-white dark:bg-gray-800 p-6 overflow-auto h-full">
                                <!-- Preview Header -->
                                <div class="text-center mb-8">
                                    <h1 class="text-3xl font-bold text-white mb-4" id="previewTitle">
                                        <i class="fas fa-shield-alt text-blue-500 mr-3"></i>
                                        {{ $privacyPolicy->title }}
                                    </h1>
                                    <div class="inline-flex items-center px-4 py-2 bg-blue-50 rounded-full">
                                        <i class="fas fa-calendar-alt text-blue-500 mr-2"></i>
                                        <span class="text-blue-600 font-medium">
                                            Last Updated: April 2025
                                        </span>
                                    </div>
                                </div>
                    
                                <!-- Preview Content Section -->
                                <div class="prose max-w-none text-gray-300" id="previewContent">
                                    {!! $privacyPolicy->content !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    
    

    <!-- Initialize CKEditor -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            let editor;
            
            ClassicEditor
                .create(document.querySelector('#content'), {
                })
                .then(newEditor => {
                    editor = newEditor;
                    
                    editor.model.document.on('change:data', () => {
                        updatePreview();
                    });
                })
                .catch(error => {
                    console.error(error);
                });
                
            document.getElementById('title').addEventListener('input', updatePreview);
            
            // Toggle preview on mobile
            document.getElementById('previewToggle').addEventListener('click', () => {
                const previewColumn = document.querySelector('.preview-column');
                previewColumn.classList.toggle('hidden');
            });
            
            // Initialize preview on page load
            updatePreview();
            
            function updatePreview() {
                const title = document.getElementById('title').value;
                document.getElementById('previewTitle').innerHTML = '<i class="fas fa-shield-alt text-blue-500 mr-3"></i>' + title;
                
                const content = editor ? editor.getData() : document.getElementById('content').value;
                document.getElementById('previewContent').innerHTML = content;
            }
        });
    </script>
</body>
</html>
