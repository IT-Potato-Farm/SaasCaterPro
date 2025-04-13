<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reset Password</title>
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
                <h1 class="text-2xl font-bold text-gray-800 mb-2">Reset Password</h1>
                <h2 class="text-gray-600">Create a new password</h2>
            </div>

            @if (session('error'))
                <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded mb-4">
                    {{ session('error') }}
                </div>
            @endif

            <form action="{{ route('password.update') }}" class="space-y-6" method="post" novalidate>
                @csrf
                <input type="hidden" name="token" value="{{ $token }}">

                <!-- email -->
                <div class="field-container">
                    <label for="email" class="block text-gray-700 font-semibold mb-1">Email</label>
                    <input type="email" name="email" id="email" value="{{ $email ?? old('email') }}" readonly
                        class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent @error('email') border-red-500 @enderror"
                        placeholder="name@email.com" required autocomplete="email" autofocus>
                    @error('email')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                </div>


                <!-- password requirements info -->
                <div class="bg-blue-50 border border-blue-200 text-blue-700 px-4 py-3 rounded text-sm">
                    <p class="font-semibold">Password requirements:</p>
                    <ul class="list-disc pl-5 mt-1">
                        <li>At least 8 characters long</li>
                        <li>Include uppercase and lowercase letters</li>
                        <li>Include at least one number</li>
                        <li>Include at least one special character</li>
                        <li>Must be different from your current password</li>
                    </ul>
                </div>

                <!-- password -->
                <div class="field-container">
                    <label for="password" class="block text-gray-700 font-semibold mb-1">New Password</label>
                    <div class="relative">
                        <input type="password" name="password" id="password" placeholder="New Password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-10 @error('password') border-red-500 @enderror"
                            required>
                        <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer"
                            onclick="togglePassword('password', 'eyeIconOpenPassword', 'eyeIconClosePassword')">
                            <svg id="eyeIconOpenPassword" xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" />
                            </svg>
                            <svg id="eyeIconClosePassword" xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-gray-500 hidden" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10 10 0 014.06 4.06" />
                                <path d="M22 12s-3.5-7-10-7-10 7-10 7 3.5 7 10 7a9.88 9.88 0 005.5-1.5" />
                                <line x1="2" y1="2" x2="22" y2="22" />
                            </svg>
                        </span>
                    </div>
                    @error('password')
                        <p class="text-red-600 text-xs mt-1">{{ $message }}</p>
                    @enderror
                    <div id="password-strength" class="mt-2"></div>
                </div>

                <!-- confirm password -->
                <div class="field-container">
                    <label for="password-confirm" class="block text-gray-700 font-semibold mb-1">Confirm
                        Password</label>
                    <div class="relative">
                        <input type="password" name="password_confirmation" id="password-confirm"
                            placeholder="Confirm Password"
                            class="w-full px-4 py-3 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent pr-10"
                            required>
                        <span class="absolute inset-y-0 right-3 flex items-center cursor-pointer"
                            onclick="togglePassword('password-confirm', 'eyeIconOpenConfirm', 'eyeIconCloseConfirm')">
                            <svg id="eyeIconOpenConfirm" xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-gray-500" viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                <path d="M2 12s3.5-7 10-7 10 7 10 7-3.5 7-10 7-10-7-10-7z" />
                            </svg>
                            <svg id="eyeIconCloseConfirm" xmlns="http://www.w3.org/2000/svg"
                                class="w-6 h-6 text-gray-500 hidden" viewBox="0 0 24 24" fill="none"
                                stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round">
                                <path d="M17.94 17.94A10 10 0 014.06 4.06" />
                                <path d="M22 12s-3.5-7-10-7-10 7-10 7 3.5 7 10 7a9.88 9.88 0 005.5-1.5" />
                                <line x1="2" y1="2" x2="22" y2="22" />
                            </svg>
                        </span>
                    </div>
                </div>

                <button type="submit"
                    class="w-full bg-blue-600 text-white font-semibold py-3 rounded-lg hover:bg-blue-700 transition-colors">
                    Reset Password
                </button>
            </form>
        </div>
    </main>

    <script>
        // Function to safely toggle password visibility
        function togglePassword(inputId, openIconId, closeIconId) {
            const passwordInput = document.getElementById(inputId);
            const eyeIconOpen = document.getElementById(openIconId);
            const eyeIconClose = document.getElementById(closeIconId);

            if (passwordInput && eyeIconOpen && eyeIconClose) {
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
        }

        // Password strength meter
        document.addEventListener('DOMContentLoaded', function() {
            const passwordField = document.getElementById('password');
            const strengthIndicator = document.getElementById('password-strength');

            if (passwordField && strengthIndicator) {
                passwordField.addEventListener('input', function() {
                    const password = passwordField.value;
                    let strength = 0;
                    let feedback = '';

                    // Check length
                    if (password.length >= 8) strength += 1;

                    // Check for mixed case
                    if (password.match(/[a-z]/) && password.match(/[A-Z]/)) strength += 1;

                    // Check for numbers
                    if (password.match(/\d/)) strength += 1;

                    // Check for special characters
                    if (password.match(/[^a-zA-Z\d]/)) strength += 1;

                    // Display feedback
                    if (password.length === 0) {
                        strengthIndicator.innerHTML = '';
                    } else if (strength < 2) {
                        strengthIndicator.innerHTML =
                            '<div class="h-2 w-full bg-red-500 rounded"></div><p class="text-red-600 text-xs mt-1">Weak password</p>';
                    } else if (strength < 4) {
                        strengthIndicator.innerHTML =
                            '<div class="h-2 w-full bg-yellow-500 rounded"></div><p class="text-yellow-600 text-xs mt-1">Medium strength password</p>';
                    } else {
                        strengthIndicator.innerHTML =
                            '<div class="h-2 w-full bg-green-500 rounded"></div><p class="text-green-600 text-xs mt-1">Strong password</p>';
                    }
                });
            }

            // live remove error messages on input
            const inputs = document.querySelectorAll('input');
            inputs.forEach(function(input) {
                input.addEventListener('input', function() {
                    input.classList.remove('border-red-500');
                    const container = input.closest('.field-container');
                    if (container) {
                        const errorMsg = container.querySelector('.text-red-600');
                        if (errorMsg && errorMsg.id !== 'password-strength') {
                            errorMsg.remove();
                        }
                    }
                });
            });

            const form = document.querySelector('form');
            if (form) {
                form.addEventListener('submit', function(e) {
                    const password = document.getElementById('password');
                    const confirmPassword = document.getElementById('password-confirm');
                    const container = confirmPassword.closest('.field-container');

                    // Remove previous error if exists
                    const existingError = container.querySelector('.text-red-600');
                    if (existingError) {
                        existingError.remove();
                    }

                    if (password.value !== confirmPassword.value) {
                        e.preventDefault();

                        // add error style
                        confirmPassword.classList.add('border-red-500');

                        // create and append error message like Laravel
                        const errorMessage = document.createElement('p');
                        errorMessage.classList.add('text-red-600', 'text-xs', 'mt-1');
                        errorMessage.textContent = 'Passwords do not match.';

                        container.appendChild(errorMessage);
                    }
                });
            }
        });
    </script>
</body>

</html>
