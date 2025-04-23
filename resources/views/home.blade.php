<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaasCaterPro Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-slate-400 flex flex-col items-center justify-center min-h-screen">


    <header class="container mx-auto p-6 text-center">
        <h3 class="text-5xl font-bold text-gray-800">SaasCaterPro</h3>

    </header>

    @auth
        @if (Auth::user()->role === 'admin')
            <a href="{{route('admin.dashboard')}}" class="text-blue-500 hover:underline mt-2 inline-block">View Dashboard</a>
        @endif

        <h2>You are logged in</h2>
        <form action="/logout" method="post">
            @csrf
            <button class="px-4 bg-red-500 rounded">Logout</button>
        </form>
    @else
        <div class="flex items-center gap-5">
            <a href="/login" class="px-4 bg-cyan-200">Go Login</a>
            <a href="/register" class="px-4 bg-cyan-200">Go Signup</a>
        </div>
    @endauth



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
