<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 min-h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md max-w-md w-full">
        <div class="text-center mb-6">
            <svg class="mx-auto h-12 w-12 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"></path>
            </svg>
        </div>

        <h1 class="text-3xl font-bold text-gray-800 mb-4 text-center">
            Please Verify Your Email
        </h1>

        <p class="text-gray-600 text-center mb-6">
            We've sent a verification link to your email address. Please check your inbox and click the link to activate your account.
        </p>

        @if (session('status') === 'verification-link-sent')
            <div class="bg-green-100 text-green-700 rounded-lg p-4 mb-6 text-sm">
                A new verification link has been sent to your email address.
            </div>
        @endif

        <form action="{{ route('verification.send') }}" method="POST" class="text-center">
            @csrf
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 transition-colors duration-200 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                Resend Verification Email
            </button>
        </form>

        
    </div>
</body>
</html>