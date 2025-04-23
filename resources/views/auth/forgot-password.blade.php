<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Forgot Password</title>
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
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Forgot Password</h1>
                <h2 class="text-gray-600">Enter your email to reset your password</h2>
            </div>

            @if (session('success'))
                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Email Sent!',
                        text: "{{ session('success') }}",
                        confirmButtonText: 'OK'
                    });
                </script>
            @endif

            <form action="{{ route('password.email') }}" class="space-y-6" method="post" novalidate>
                @csrf

                <!-- email -->
                <div class="field-container">
                    <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input type="email" name="email" id="email"
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                        placeholder="name@email.com">
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Send Password Reset Link
                </button>
            </form>

            <p class="text-center text-gray-600 mt-6">
                Remember your password?
                <a href="{{route('login')}}" class="text-blue-600 hover:underline font-semibold">Back to login</a>
            </p>
        </div>
    </main>

    <script>
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