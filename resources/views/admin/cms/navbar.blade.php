<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NAVBAR SECTION CMS</title>
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
                    <div class="bg-white shadow-sm rounded-xl mb-6 p-6 text-center">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800">
                            NAVBAR SECTION
                        </h1>
                        <p class="text-gray-500 mt-2">Customize your website navigation bar</p>
                    </div>
    
                    @if ($navbar)
                    <div class="max-w-6xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-6">
    
                        <!-- Preview Section -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <div class="flex items-center justify-between mb-4">
                                <h2 class="text-xl font-semibold text-gray-800">Navbar Preview</h2>
                                <span class="px-2 py-1 text-xs bg-blue-100 text-blue-800 rounded-full">Live Preview</span>
                            </div>
                            <nav class="flex items-center justify-between p-4 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-lg shadow" id="navbar-preview">
                                <div class="flex items-center space-x-4">
                                    <img src="{{ asset('storage/' . $navbar->logo) }}" id="logo-preview" class="h-10 rounded-lg" alt="Navbar Logo">
                                    <span class="text-white text-xl font-semibold" id="title-preview">{{ $navbar->title }}</span>
                                </div>
                                <button class="lg:hidden text-white">
                                    <i class="fas fa-bars"></i>
                                </button>
                            </nav>
                            <div class="mt-4 text-sm text-gray-500">
                                <p>This is how your navbar will appear to visitors.</p>
                            </div>
                        </div>
    
                        <!-- Form Section -->
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100">
                            <h2 class="text-xl font-semibold text-gray-800 mb-6">Navbar Settings</h2>
                            <form id="editForm" action="{{ route('admin.navbar.update') }}" method="POST" enctype="multipart/form-data">
                                @csrf
                                @method('PUT')
    
                                <div class="mb-6">
                                    <label for="title" class="block text-sm font-medium text-gray-700 mb-2">Navbar Title</label>
                                    <input type="text" name="title" id="title" value="{{ old('title', $navbar->title) }}"
                                           class="w-full px-4 py-2.5 border border-gray-200 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-blue-500 transition-all"
                                           oninput="updateTitlePreview(this.value)"
                                           placeholder="Your brand name">
                                    <p class="mt-1 text-sm text-gray-500">This will appear next to your logo</p>
                                </div>
    
                                <div class="mb-6">
                                    <label for="logo" class="block text-sm font-medium text-gray-700 mb-2">Navbar Logo</label>
                                    <div class="flex items-center justify-center w-full">
                                        <label for="logo" class="flex flex-col items-center justify-center w-full h-32 border-2 border-gray-300 border-dashed rounded-lg cursor-pointer bg-gray-50 hover:bg-gray-100 transition-colors">
                                            <div class="flex flex-col items-center justify-center pt-5 pb-6">
                                                <svg class="w-8 h-8 mb-4 text-gray-500" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 20 16">
                                                    <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 13h3a3 3 0 0 0 0-6h-.025A5.56 5.56 0 0 0 16 6.5 5.5 5.5 0 0 0 5.207 5.021C5.137 5.017 5.071 5 5 5a4 4 0 0 0 0 8h2.167M10 15V6m0 0L8 8m2-2 2 2"/>
                                                </svg>
                                                <p class="mb-2 text-sm text-gray-500"><span class="font-semibold">Click to upload</span> or drag and drop</p>
                                                <p class="text-xs text-gray-500">PNG, JPG (MAX. 2MB)</p>
                                            </div>
                                            <input id="logo" name="logo" type="file" class="hidden" onchange="previewLogo(event)">
                                        </label>
                                    </div>
                                    @if ($navbar->logo)
                                        <div class="mt-4 flex items-center space-x-4">
                                            <span class="text-sm text-gray-500">Current logo:</span>
                                            <img src="{{ asset('storage/' . $navbar->logo) }}" alt="Current Logo" class="h-10 rounded-lg">
                                        </div>
                                    @endif
                                </div>
    
                                <button type="submit" class="w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-700 text-white font-medium rounded-lg shadow-sm hover:opacity-90 transition-opacity focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Update Navbar
                                </button>
                            </form>
                        </div>
                    </div>
                    @else
                        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 text-center">
                            <div class="mx-auto w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mb-4">
                                <i class="fas fa-exclamation-circle text-gray-400 text-3xl"></i>
                            </div>
                            <h3 class="text-lg font-medium text-gray-800 mb-2">No navbar content available</h3>
                            <p class="text-gray-500">Please create navbar content to get started.</p>
                        </div>
                    @endif
    
                </div>
    
            </main>
        </div>
    </div>

<script>
    function updateTitlePreview(value) {
        document.getElementById('title-preview').textContent = value || 'Navbar Title';
    }

    function previewLogo(event) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('logo-preview').src = e.target.result;
        };
        reader.readAsDataURL(event.target.files[0]);
    }

    
    document.getElementById('editForm')?.addEventListener('submit', async function(e) {
        e.preventDefault(); 
        
        const form = e.target;
        const formData = new FormData(form);

        try {
            const response = await fetch(form.action, {
                method: 'POST', 
                body: formData,
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('input[name="_token"]').value
                }
            });

            if (response.ok) {
                const data = await response.json();
                
                Swal.fire({
                    toast: true,
                    position: 'top-end',
                    icon: 'success',
                    title: data.message,
                    showConfirmButton: false,
                    timer: 3000,
                    timerProgressBar: true,
                    didOpen: (toast) => {
                        toast.addEventListener('mouseenter', Swal.stopTimer);
                        toast.addEventListener('mouseleave', Swal.resumeTimer);
                    }
                });


                if (data.logo) {
                    document.getElementById('logo-preview').src = data.logo;
                }
                if (data.title) {
                    document.getElementById('title-preview').textContent = data.title;
                }

            } else if (response.status === 422) {
                const errorData = await response.json();
                let errors = Object.values(errorData.errors).flat().join('<br>');

                Swal.fire({
                    icon: 'error',
                    title: 'Validation Error',
                    html: errors,
                });
            } else {
                Swal.fire({
                    icon: 'error',
                    title: 'Error',
                    text: 'Something went wrong. Please try again.',
                });
            }

        } catch (error) {
            Swal.fire({
                icon: 'error',
                title: 'Error',
                text: error.message,
            });
        }
    });
</script>


</body>

</html>
