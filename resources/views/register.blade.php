<!DOCTYPE html>
<html lang="en">

<head>
    <link rel="icon" href="{{ asset('images/saaslogo.png') }}" type="image/png">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registration</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="bg-red-100 min-h-screen flex items-center justify-center p-4 sm:p-6">
    <div class="w-full max-w-md bg-white rounded-lg shadow-md p-6 sm:p-8 mx-4">
        <h1 class="text-2xl sm:text-3xl font-bold text-gray-800 text-center mb-6 sm:mb-8">Create an Account</h1>

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

        <form class="space-y-4 sm:space-y-6" action="{{ route('user.register') }}" method="POST" novalidate>
            @csrf
            <div class="space-y-3 sm:space-y-4">
                <!-- First Name -->
                <div class="field-container">
                    <label class="block text-sm sm:text-base font-medium text-gray-700 mb-1">First Name</label>
                    <input type="text" name="first_name" value="{{ old('first_name') }}"
                        class="w-full px-3 py-2 sm:px-4 sm:py-2 text-sm sm:text-base border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('first_name') border-red-500 @enderror">
                    @error('first_name')
                        <p class="error-msg text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Last Name -->
                <div class="field-container">
                    <label class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Last Name</label>
                    <input type="text" name="last_name" value="{{ old('last_name') }}"
                        class="w-full px-3 py-2 sm:px-4 sm:py-2 text-sm sm:text-base border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('last_name') border-red-500 @enderror">
                    @error('last_name')
                        <p class="error-msg text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Email Address -->
                <div class="field-container">
                    <label class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" placeholder="name@email.com"
                        class="w-full px-3 py-2 sm:px-4 sm:py-2 text-sm sm:text-base border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('email') border-red-500 @enderror">
                    @error('email')
                        <p class="error-msg text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Password -->
                <div class="field-container">
                    <label class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" placeholder="••••••••"
                            class="w-full px-3 py-2 sm:px-4 sm:py-2 text-sm sm:text-base border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10 @error('password') border-red-500 @enderror">
                        <button type="button" onclick="togglePassword()"
                            class="absolute inset-y-0 right-0 px-3 flex items-center">
                            <svg id="eye-open" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-500" fill="none" stroke="currentColor"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-closed" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-500 hidden" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password')
                        <p class="error-msg text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Confirm Password -->
                <div class="field-container">
                    <label class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Confirm Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password_confirmation"
                            placeholder="••••••••"
                            class="w-full px-3 py-2 sm:px-4 sm:py-2 text-sm sm:text-base border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 pr-10 @error('password_confirmation') border-red-500 @enderror">
                        <button type="button" onclick="togglePasswordConfirmation()"
                            class="absolute inset-y-0 right-0 px-3 flex items-center">
                            <svg id="eye-open-confirm" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-500" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                            </svg>
                            <svg id="eye-closed-confirm" class="h-4 w-4 sm:h-5 sm:w-5 text-gray-500 hidden" fill="none"
                                stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                            </svg>
                        </button>
                    </div>
                    @error('password_confirmation')
                        <p class="error-msg text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <!-- Mobile Number -->
                <div class="field-container">
                    <label class="block text-sm sm:text-base font-medium text-gray-700 mb-1">Mobile Number</label>
                    <input type="tel" name="mobile" value="{{ old('mobile') }}" placeholder="+63 912 345 6789"
                        class="w-full px-3 py-2 sm:px-4 sm:py-2 text-sm sm:text-base border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 @error('mobile') border-red-500 @enderror">
                    @error('mobile')
                        <p class="error-msg text-red-600 text-xs sm:text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
            </div>

            <button type="submit" id="submit-button"
                class="w-full bg-blue-600 text-white py-2 px-4 rounded-lg hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2 transition disabled:opacity-75 disabled:cursor-not-allowed text-sm sm:text-base">
                <div class="flex items-center justify-center gap-2">
                    <span id="button-text">Create Account</span>
                    <svg id="loading-spinner" class="hidden h-4 w-4 sm:h-5 sm:w-5 animate-spin text-white"
                        xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor"
                            stroke-width="4"></circle>
                        <path class="opacity-75" fill="currentColor"
                            d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z">
                        </path>
                    </svg>
                </div>
            </button>
        </form>

        <p class="text-center text-gray-600 text-xs sm:text-sm mt-4 sm:mt-6">
            Already have an account?
            <a href="{{ route('login') }}" class="text-blue-600 hover:underline">Login here</a>
        </p>
    </div>

    <script>
        document.querySelector('form').addEventListener('submit', function(e) {
            const button = document.getElementById('submit-button');
            const buttonText = document.getElementById('button-text');
            const spinner = document.getElementById('loading-spinner');
            
            if (this.checkValidity()) {
                button.disabled = true;
                buttonText.textContent = 'Creating Account...';
                spinner.classList.remove('hidden');
            }
        });

        function togglePassword() {
            const password = document.getElementById('password');
            const eyeOpen = document.getElementById('eye-open');
            const eyeClosed = document.getElementById('eye-closed');

            if (password.type === 'password') {
                password.type = 'text';
                eyeOpen.classList.add('hidden');
                eyeClosed.classList.remove('hidden');
            } else {
                password.type = 'password';
                eyeOpen.classList.remove('hidden');
                eyeClosed.classList.add('hidden');
            }
        }

        function togglePasswordConfirmation() {
            const passwordConfirmation = document.getElementById('password_confirmation');
            const eyeOpenConfirm = document.getElementById('eye-open-confirm');
            const eyeClosedConfirm = document.getElementById('eye-closed-confirm');

            if (passwordConfirmation.type === 'password') {
                passwordConfirmation.type = 'text';
                eyeOpenConfirm.classList.add('hidden');
                eyeClosedConfirm.classList.remove('hidden');
            } else {
                passwordConfirmation.type = 'password';
                eyeOpenConfirm.classList.remove('hidden');
                eyeClosedConfirm.classList.add('hidden');
            }
        }

        // Live removal of error when typing
        document.addEventListener('DOMContentLoaded', function() {
            const inputs = document.querySelectorAll('input');
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    input.classList.remove('border-red-500');
                    const container = input.closest('.field-container');
                    if (container) {
                        const errorMsg = container.querySelector('.error-msg');
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