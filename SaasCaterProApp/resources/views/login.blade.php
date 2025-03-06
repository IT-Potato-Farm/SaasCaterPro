<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

</head>

<body class="">
    <main class="bg-gray-400 flex justify-center items-center h-screen">

    
    <div class="w-full max-w-sm bg-gray-300 p-6 rounded-lg shadow-md">
        <h2 class="text-3xl font-bold text-center text-gray-700 mb-4">Login</h2>

        {{-- error valid --}}
        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Account Created!',
                    text: '{{ session('success') }}',
                    confirmButtonText: 'OK'
                });
            </script>
        @endif
        {{-- success validation --}}
        {{-- @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative">
                {{ session('success') }}
            </div>
        @endif --}}

        <form id="loginForm" action="{{ route('user.login') }}" class="space-y-4" method="post" novalidate>
            @csrf
            <div>
                <input type="email" name="loginemail" id="loginemail" placeholder="Email Address"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
            </div>

            <div>
                <input type="password" name="loginpassword" id="loginpassword" placeholder="Password"
                    class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
            </div>
            <button type="submit"
                class="w-full bg-blue-500 text-white font-semibold py-2 rounded-lg hover:bg-blue-600">
                Login
            </button>
        </form>
        <span class="">Dont have an account? <a href="/register" class="hover:underline">Register here</a></span>

    </div>
</main>
</body>

</html>