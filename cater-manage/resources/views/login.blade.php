<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <script src="https://cdn.tailwindcss.com"></script>

</head>
<body class="bg-gray-400 flex justify-center items-center h-screen">
    <div class="w-full max-w-sm bg-gray-300 p-6 rounded-lg shadow-md">
        <h2 class="text-3xl font-bold text-center text-gray-700 mb-4">Login</h2>

        <form action="{{ url('/loginapi') }}" class="space-y-4" method="post">
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
        <span class="">Dont have an account? <a href="/register" class="hover:underline">Register here</a></span>

    </div>
</body>
</html>