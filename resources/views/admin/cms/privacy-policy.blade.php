<!-- resources/views/admin/privacy-policy.blade.php -->
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Privacy Policy</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/27.1.0/classic/ckeditor.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="{{ asset('js/toprightalert.js') }}"></script>
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
                <h1 class="text-3xl font-bold text-gray-800">EDIT Privacy Policy Page</h1>
    
            <!-- Form for Editing Privacy Policy -->
            <form action="{{ route('admin.privacy.update', $privacyPolicy->id) }}" method="POST">
                @csrf
                @method('PUT')
    
                <!-- Title Input -->
                <div class="mb-4">
                    <label for="title" class="block text-lg text-gray-700">Title</label>
                    <input type="text" name="title" id="title" class="w-full p-3 border border-gray-300 rounded-md" value="{{ $privacyPolicy->title }}" required>
                </div>
    
                <!-- Content Editor -->
                <div class="mb-4">
                    <label for="content" class="block text-lg text-gray-700">Content</label>
                    <textarea name="content" id="content" class="w-full p-3 border border-gray-300 rounded-md">{{ $privacyPolicy->content }}</textarea>
                </div>
    
                <!-- Submit Button -->
                <button type="submit" class="px-4 py-2 bg-blue-500 text-white rounded-md">Update Policy</button>
            </form>
            </main>
            
        </div>
    
    

    <!-- Initialize CKEditor -->
    <script>
        ClassicEditor
            .create(document.querySelector('#content'))
            .catch(error => {
                console.error(error);
            });
    </script>
</body>
</html>
