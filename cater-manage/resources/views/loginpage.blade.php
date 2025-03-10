<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body>
    <main class="bg-red-100 flex justify-center items-center min-h-screen">
        <div class="w-full max-w-md bg-white p-8 rounded-lg shadow-md">
            <div class="flex justify-center mb-8">
                <img src="{{ asset('images/saaslogo.png') }}" alt="Company Logo" class="h-16 w-16 rounded-full">
            </div>
            <div class="text-center mb-8">
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Welcome Back!</h1>
                <h2 class="text-gray-600">Login your account</h2>
            </div>

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

            <form id="loginForm" action="{{ route('user.login') }}" class="space-y-6" method="post" novalidate>
                @csrf

                <!-- email -->
                <div class="field-container">
                    <label for="loginemail" class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input type="email" name="loginemail" id="loginemail"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('loginemail') border-red-500 @enderror"
                        placeholder="name@email.com">
                    @error('loginemail')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- pw -->
                <div class="field-container">
                    <label for="loginpassword" class="block text-gray-700 font-semibold mb-1">Password</label>
                    <div class="relative">
                        <input type="password" name="loginpassword" id="loginpassword" placeholder="Password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-10 @error('loginpassword') border-red-500 @enderror">
                        <!-- eye icon -->
                        <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer"
                            onclick="togglePassword()">
                            <svg id="eyeIconOpen" xmlns="http://www.w3.org/2000/svg" class="w-6 h-6 text-gray-500"
                                viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" />
                            </svg>
                            <svg id="eyeIconClose" xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-gray-500 hidden" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10 10 0 014.06 4.06" />
                                <path d="M22 12s-3.5-7-10-7-10 7-10 7 3.5 7 10 7a9.88 9.88 0 005.5-1.5" />
                                <line x1="2" y1="2" x2="22" y2="22" />
                            </svg>
                        </span>
                    </div>
                    @error('loginpassword')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <a href="#" class="text-sm text-blue-600 hover:underline mt-2 inline-block">Forgot
                        password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Login
                </button>
            </form>

            <p class="text-center text-gray-600 mt-6">
                Don't have an account?
                <a href="/register" class="text-blue-600 hover:underline font-semibold">Sign up here</a>
            </p>
        </div>
    </main>

    <script>
        function togglePassword() {
            const passwordInput = document.getElementById("loginpassword");
            const eyeIconOpen = document.getElementById("eyeIconOpen");
            const eyeIconClose = document.getElementById("eyeIconClose");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeIconOpen.classList.add("hidden");
                eyeIconClose.classList.remove("hidden");
            } else {
                passwordInput.type = "password";
                eyeIconOpen.classList.remove("hidden");
                eyeIconClose.classList.add("hidden");
            }
        }

        ///live removal ng error if mag type
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    input.classList.remove('border-red-500');
                    const container = input.closest('.field-container');
                    if (container) {
                        const errorMsg = container.querySelector('.text-red-600');
                        if (errorMsg) {
                            errorMsg.remove();
                        }
                    }
                });
            });
        });
    </script>
</body>

</html>
