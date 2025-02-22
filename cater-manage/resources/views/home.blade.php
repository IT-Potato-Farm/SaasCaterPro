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
    <main class="flex  items-center justify-center gap-5">
        <div class="w-full max-w-sm bg-gray-300 p-6 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold text-center text-gray-700 mb-4">Register</h2>

            <form action="/register" class="space-y-4" method="post">
                @csrf
                <div>
                    <input type="text" name="first_name" id="first_name" placeholder="First Name" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <input type="text" name="last_name" id="last_name" placeholder="Last Name" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <input type="email" name="email" id="email" placeholder="Email Address" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <input type="tel" name="mobile" id="mobile" placeholder="Mobile" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                <div>
                    <input type="password" name="password" id="password" placeholder="Password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-2 rounded-lg hover:bg-blue-600">
                    Register
                </button>
            </form>
        </div>

        <div class="w-full max-w-sm bg-gray-300 p-6 rounded-lg shadow-md">
            <h2 class="text-3xl font-bold text-center text-gray-700 mb-4">Login</h2>

            <form action="/login" class="space-y-4" method="post">
                @csrf
                
                <div>
                    <input type="email" name="loginemail" id="loginemail" placeholder="Email Address" 
                        class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                
                <div>
                    <input type="password" name="loginpassword" id="loginpassword" placeholder="Password" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-400">
                </div>
                <button type="submit" class="w-full bg-blue-500 text-white font-semibold py-2 rounded-lg hover:bg-blue-600">
                    Login
                </button>
            </form>
        </div>
    </main>
    @endauth
    

</body>
</html>
