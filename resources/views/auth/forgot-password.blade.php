<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
        .forgot-container {
            background: linear-gradient(145deg, #ffffff 0%, #f8fafc 100%);
        }
    </style>
</head>

<body class="bg-surface-100">
    <main class="flex justify-center items-center min-h-screen p-4">
        <div class="w-full max-w-md forgot-container p-8 rounded-xl shadow-sm border border-surface-200">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('images/saaslogo.png') }}" alt="Company Logo" class="h-14 w-14">
            </div>
            
            <div class="text-center mb-6">
                <h1 class="text-2xl font-bold text-dark-800 mb-1">Forgot Password</h1>
                <p class="text-gray-500 text-sm">Enter your email to reset your password</p>
            </div>

            @if (session('success'))
            <script>
                Swal.fire({
                    icon: 'success',
                    title: 'Email Sent!',
                    text: "{{ session('success') }}",
                    confirmButtonText: 'OK',
                    confirmButtonColor: '#2563eb',
                });
            </script>
            @endif

            <form action="{{ route('password.email') }}" class="space-y-4" method="post" novalidate>
                @csrf

                <!-- Email -->
                <div class="space-y-1">
                    <label for="email" class="block text-sm font-medium text-gray-600">Email address</label>
                    <input type="email" name="email" id="email"
                        class="w-full px-3 py-2.5 text-sm border border-surface-200 rounded-lg transition duration-150 ease-in-out focus:outline-none focus:ring-2 focus:ring-primary-500 focus:ring-opacity-50 @error('email') border-red-500 @enderror"
                        placeholder="your@email.com"
                        required>
                    @error('email')
                    <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-primary-600 text-white font-medium text-sm py-2.5 px-4 rounded-lg hover:bg-primary-700 focus:outline-none focus:ring-2 focus:ring-offset-1 focus:ring-primary-500 transition-colors duration-150">
                    Send Password Reset Link
                </button>
            </form>

            <div class="mt-5 text-center text-xs text-gray-500">
                Remember your password?
                <a href="{{ route('login') }}" class="font-medium text-primary-600 hover:underline">Back to login</a>
            </div>
        </div>
    </main>

    <script>
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