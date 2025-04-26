<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NAVBAR SECTION CMS</title>
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
                <!-- Page Header -->
                <div class="bg-white shadow-md rounded-lg mb-4 md:mb-6 p-4">
                    <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold text-center text-gray-800">
                        NAVBAR
                    </h1>
                </div>

                @if ($navbar)
                <div class="max-w-4xl mx-auto grid grid-cols-1 md:grid-cols-2 gap-8">

                    <!-- Preview Section -->
                    <div class="bg-white rounded shadow p-6">
                        <h2 class="text-lg font-semibold mb-4">Navbar Preview</h2>
                        <nav class="flex items-center justify-between p-4 bg-blue-600 rounded" id="navbar-preview">
                            <div class="flex items-center space-x-4">
                                <img src="{{ asset('storage/' . $navbar->logo) }}" id="logo-preview" class="h-12 rounded" alt="Navbar Logo">
                                <span class="text-white text-xl font-bold" id="title-preview">{{ $navbar->title }}</span>
                            </div>
                        </nav>
                    </div>

                    <!-- Form Section -->
                    <div class="bg-white rounded shadow p-6">
                        <form id="editForm" action="{{ route('admin.navbar.update') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            @method('PUT')

                            <div class="mb-4">
                                <label for="title" class="block text-sm font-medium text-gray-700">Navbar Title</label>
                                <input type="text" name="title" id="title" value="{{ old('title', $navbar->title) }}"
                                       class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm p-2"
                                       oninput="updateTitlePreview(this.value)">
                            </div>

                            <div class="mb-4">
                                <label for="logo" class="block text-sm font-medium text-gray-700">Navbar Logo</label>
                                <input type="file" name="logo" id="logo" class="mt-1 block w-full" onchange="previewLogo(event)">
                                @if ($navbar->logo)
                                    <img src="{{ asset('storage/' . $navbar->logo) }}" alt="Current Logo" class="h-16 mt-2 hidden">
                                @endif
                            </div>

                            <button type="submit" class="px-4 py-2 bg-blue-600 text-white rounded w-full">Update Navbar</button>
                        </form>
                    </div>
                </div>
                @else
                    <div class="bg-white shadow-md rounded-lg p-4 md:p-6 mb-6">
                        <p class="text-gray-700 text-sm md:text-base">No navbar content available.</p>
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
