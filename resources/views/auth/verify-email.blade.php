<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Verify Your Account</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: {
                            600: '#2563eb',
                            700: '#1d4ed8',
                        }
                    }
                }
            }
        }
    </script>
</head>
<body class="bg-gray-50 min-h-screen flex items-center justify-center p-4">
    <div class="bg-white p-8 rounded-xl shadow-lg max-w-md w-full border border-gray-100">
        <div class="flex flex-col items-center">
            <!-- Animated envelope icon -->
            <div class="relative mb-6">
                <div class="w-16 h-16 bg-primary-600 rounded-2xl flex items-center justify-center shadow-md shadow-primary-100 animate-bounce">
                    <svg class="h-8 w-8 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                    </svg>
                </div>
                <div class="absolute -bottom-2 -right-2 bg-white rounded-full p-1 shadow">
                    <div class="bg-primary-600 rounded-full p-1.5">
                        <svg class="h-3 w-3 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>
                        </svg>
                    </div>
                </div>
            </div>

            <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-2 text-center">
                Verify Your Account
            </h1>

            <p class="text-gray-600 text-center mb-6 max-w-xs">
                We've sent a 6-digit code to your email. Please enter it below to continue.
            </p>

            @if (session('status') === 'verification-code-sent')
                <div class="bg-green-50 border border-green-200 text-green-700 rounded-lg p-3 mb-6 text-sm w-full flex items-center">
                    <svg class="h-4 w-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    A new verification code has been sent to your email.
                </div>
            @endif
        </div>

        <form action="{{ route('verification.verify-code') }}" method="POST" class="space-y-6">
            @csrf
            
            <!-- OTP Input Field -->
            <div class="flex justify-center gap-2">
                <input type="text" name="code1" maxlength="1" class="w-12 h-14 text-2xl text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600 outline-none transition" 
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');if(this.value.length===1)this.nextElementSibling.focus()" 
                    autofocus required>
                <input type="text" name="code2" maxlength="1" class="w-12 h-14 text-2xl text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600 outline-none transition" 
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');if(this.value.length===1)this.nextElementSibling.focus()" required>
                <input type="text" name="code3" maxlength="1" class="w-12 h-14 text-2xl text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600 outline-none transition" 
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');if(this.value.length===1)this.nextElementSibling.focus()" required>
                <input type="text" name="code4" maxlength="1" class="w-12 h-14 text-2xl text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600 outline-none transition" 
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');if(this.value.length===1)this.nextElementSibling.focus()" required>
                <input type="text" name="code5" maxlength="1" class="w-12 h-14 text-2xl text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600 outline-none transition" 
                    oninput="this.value=this.value.replace(/[^0-9]/g,'');if(this.value.length===1)this.nextElementSibling.focus()" required>
                <input type="text" name="code6" maxlength="1" class="w-12 h-14 text-2xl text-center border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary-600 focus:border-primary-600 outline-none transition" 
                    oninput="this.value=this.value.replace(/[^0-9]/g,'')" required>
            </div>

            <!-- Hidden field to combine the code -->
            <input type="hidden" name="code" id="combinedCode">

            @error('code')
                <div class="text-red-500 text-sm text-center flex items-center justify-center">
                    <svg class="h-4 w-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
                    </svg>
                    {{ $message }}
                </div>
            @enderror

            <button type="submit" class="w-full bg-primary-600 text-white py-3 px-4 rounded-lg font-medium hover:bg-primary-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-primary-600 focus:ring-offset-2">
                Verify Account
            </button>
        </form>

        <div class="mt-6 text-center text-sm text-gray-500">
            Didn't receive a code?
            <form action="{{ route('verification.resend-code') }}" method="POST" class="inline">
                @csrf
                <button type="submit" class="text-primary-600 hover:text-primary-700 font-medium ml-1 focus:outline-none focus:underline">
                    Resend Code
                </button>
            </form>
        </div>

        <!-- Countdown timer (optional) -->
        <div id="countdown" class="text-center text-xs text-gray-400 mt-2 hidden">
            Resend code in <span id="timer">60</span> seconds
        </div>
    </div>

    <script>
        // Combine OTP digits into a single field
        document.querySelector('form').addEventListener('submit', function(e) {
            const digits = Array.from({length: 6}, (_, i) => 
                document.querySelector(`input[name="code${i+1}"]`).value).join('');
            document.getElementById('combinedCode').value = digits;
        });


        document.querySelector('input[name="code1"]').focus();

        
        document.querySelector('form[action="{{ route('verification.resend-code') }}"]').addEventListener('submit', function() {
            const countdown = document.getElementById('countdown');
            const timer = document.getElementById('timer');
            let timeLeft = 60;
            
            countdown.classList.remove('hidden');
            this.style.display = 'none';
            
            const interval = setInterval(() => {
                timeLeft--;
                timer.textContent = timeLeft;
                
                if (timeLeft <= 0) {
                    clearInterval(interval);
                    countdown.classList.add('hidden');
                    this.style.display = 'inline';
                }
            }, 1000);
        });
    </script>
</body>
</html>