<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <script src="https://unpkg.com/@tailwindcss/browser@4"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
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
            <x-category-form />

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
        <x-show-category/>

    </main>
</body>

</html>
