<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <style>
        @keyframes slide-in {
            from {
                transform: translateX(100%);
            }

            to {
                transform: translateX(0);
            }
        }

        @keyframes slide-out {
            from {
                transform: translateX(0);
            }

            to {
                transform: translateX(150%);
            }
        }

        .animate-slide-in {
            animation: slide-in 0.3s ease-out;
        }

        .animate-slide-out {
            animation: slide-out 0.3s ease-in;
        }
    </style>
</head>

<body class="bg-gray-500 p-5">
    <h1>ADMIN DASHBOARD</h1>

    @auth
        @if (Auth::user()->role === 'admin')
            <h2>Welcome, {{ Auth::user()->first_name }}</h2>
            <h2>Role: {{ Auth::user()->role }}</h2>
            <form action="/logout" method="post">
                @csrf
                <button class="hover:cursor-pointer px-4 bg-red-500 rounded">Logout</button>
            </form>

            {{-- category formm --}}
            {{-- <x-category-form /> --}}
            <x-category.add-category />
             <x-category.category-list /> {{--andto rin yung edit category sa popup modal --}}
            
        @else
            <script>
                window.location.href = "/";
            </script>
        @endif
    @else
        <script>
            window.location.href = "/";
        </script>
    @endauth

    <main class="mt-5">


    </main>
    @if (session('success'))
        <script>
            Swal.fire({
                icon: 'success',
                title: 'Success!',
                text: '{{ session('success') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#f0fdfa',
                iconColor: '#06b6d4',
                color: '#164e63',
                timerProgressBar: true,
                showClass: {
                    popup: 'swal2-show animate-slide-in'
                },
                hideClass: {
                    popup: 'swal2-hide animate-slide-out'
                }
            });
        </script>
    @endif
</body>

</html>
