<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaasCaterPro Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-slate-400 flex flex-col items-center justify-center min-h-screen">

   
    <header class="container mx-auto p-6 text-center">
        <h3 class="text-5xl font-bold text-gray-800">SaasCaterPro</h3>
        
    </header>

    @auth
    <a href="/dashboard" class="text-blue-500 hover:underline mt-2 inline-block">View Dashboard</a>
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
    

</body>
</html>
