<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            600: '#2563eb',
                            700: '#1d4ed8',
                        },
                        surface: {
                            50: '#f8fafc',
                            100: '#f1f5f9',
                            200: '#e2e8f0',
                        },
                        dark: {
                            800: '#1e293b',
                            900: '#0f172a',
                        }
                    },
                    fontFamily: {
                        sans: ['Inter', 'system-ui', 'sans-serif'],
                    },
                }
            }
        }
    </script>
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap');

        body {
            font-family: 'Inter', sans-serif;
            background-color: #f1f5f9;
        }

        .form-input:focus {
            box-shadow: 0 0 0 3px rgba(37, 99, 235, 0.2);
            border-color: rgba(37, 99, 235, 0.5);
        }

        .login-container {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        }
    </style>
</head>

<body class="bg-surface-100">
    <main class="flex justify-center items-center min-h-screen p-4">
        <div class="w-full max-w-md login-container p-8 rounded-xl shadow-sm border border-surface-200">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/saaslogo.png') }}" alt="Company Logo" class="h-14 w-14">
            </div>

            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-dark-800 mb-1">Welcome back</h1>
                <p class="text-gray-500 text-sm">Please enter your credentials to login</p>
            </div>

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Account Created!',
                        text: '{{ session('success') }}',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#2563eb',
                    });
                </script>
            @endif
            @if (session('message'))
                <div class="bg-yellow-50 text-yellow-800 px-3 py-2 rounded-lg mb-4 border border-yellow-100 text-xs">
                    {{ session('message') }}
                </div>
            @endif

            <form id="loginForm" action="{{ route('user.login') }}" class="space-y-4" method="post" novalidate>
                @csrf

                <!-- Email -->
                <div class="space-y-1">
                    <label for="loginemail" class="block text-sm font-medium text-gray-600">Email address</label>
                    <input type="email" name="loginemail" id="loginemail"
                        class="w-full px-3 py-2.5 text-sm border border-surface-200 rounded-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50 @error('loginemail') border-red-500 @enderror"
                        placeholder="your@email.com" autocomplete="email" autofocus>
                    @error('loginemail')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="space-y-1">
                    <div class="flex justify-between items-center">
                        <label for="loginpassword" class="block text-sm font-medium text-gray-600">Password</label>
                    </div>
                    <div class="relative">
                        <input type="password" name="loginpassword" id="loginpassword"
                            class="w-full px-3 py-2.5 text-sm border border-surface-200 rounded-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50 @error('loginpassword') border-red-500 @enderror"
                            placeholder="••••••••" autocomplete="current-password">
                        <!-- Eye icon -->
                        <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer"
                            onclick="togglePassword()">
                            <svg id="eyeIconOpen" xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 text-gray-400"
                                viewBox="0 0 20 20" fill="currentColor">
                                <path d="M10 12a2 2 0 100-4 2 2 0 000 4z" />
                                <path fill-rule="evenodd"
                                    d="M.458 10C1.732 5.943 5.522 3 10 3s8.268 2.943 9.542 7c-1.274 4.057-5.064 7-9.542 7S1.732 14.057.458 10zM14 10a4 4 0 11-8 0 4 4 0 018 0z"
                                    clip-rule="evenodd" />
                            </svg>
                            <svg id="eyeIconClose" xmlns="http://www.w3.org/2000/svg"
                                class="h-5 w-5 items-center text-gray-400 hidden" viewBox="0 0 20 20"
                                fill="currentColor">
                                <path fill-rule="evenodd"
                                    d="M3.707 2.293a1 1 0 00-1.414 1.414l14 14a1 1 0 001.414-1.414l-1.473-1.473A10.014 10.014 0 0019.542 10C18.268 5.943 14.478 3 10 3a9.958 9.958 0 00-4.512 1.074l-1.78-1.781zm4.261 4.26l1.514 1.515a2.003 2.003 0 012.45 2.45l1.514 1.514a4 4 0 00-5.478-5.478z"
                                    clip-rule="evenodd" />
                                <path
                                    d="M12.454 16.697L9.75 13.992a4 4 0 01-3.742-3.741L2.335 6.578A9.98 9.98 0 00.458 10c1.274 4.057 5.065 7 9.542 7 .847 0 1.669-.105 2.454-.303z" />
                            </svg>
                        </span>
                    </div>
                    @error('loginpassword')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <a href="{{ route('password.request') }}" class="text-xs text-primary-600 hover:underline">Forgot
                        password?</a>
                </div>

                <button type="submit"
                    class="w-full bg-primary-600 text-white font-medium text-sm py-2.5 px-4 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary-500 transition-colors duration-150 mt-2">
                    Login
                </button>
            </form>

            <div class="mt-5 text-center text-xs text-gray-500">
                Don't have an account?
                <a href="/register" class="font-medium text-primary-600 hover:underline">Sign up</a>
            </div>
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

        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    input.classList.remove('border-red-500');
                    const container = input.closest('.space-y-1');
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
