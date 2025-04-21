<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $privacyPolicy->title }} | Saas Catering & Food Services</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
</head>
<body class="bg-gray-50 dark:bg-gray-900">
    <!-- Privacy Policy Page -->
    <div class="bg-white dark:bg-gray-800 py-12 px-4 sm:px-6 lg:px-8 shadow-sm">
        <div class="max-w-4xl mx-auto">
            <!-- Header -->
            <div class="text-center mb-12">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800 dark:text-white mb-4">
                    <i class="fas fa-shield-alt text-blue-500 mr-3"></i>
                    {{ $privacyPolicy->title }}
                </h1>
                <div class="inline-flex items-center px-4 py-2 bg-blue-50 dark:bg-gray-700 rounded-full">
                    <i class="fas fa-calendar-alt text-blue-500 dark:text-blue-400 mr-2"></i>
                    <span class="text-blue-600 dark:text-blue-300 font-medium">
                        Last Updated: April 2025
                    </span>
                </div>
            </div>

            <!-- Dynamic Content Section -->
            <div class="prose max-w-none text-gray-800 dark:text-gray-100" style="white-space: pre-wrap;">
                {!! $privacyPolicy->content !!}
            </div>

            <div class="text-center mt-10">
                <a href="{{ route('landing') }}" 
                   class="inline-flex items-center px-6 py-3 text-white bg-blue-600 hover:bg-blue-700 rounded-full shadow transition duration-300">
                    <i class="fas fa-arrow-left mr-2"></i>
                    Back to Home
                </a>
            </div>
        </div>
    </div>
</body>
</html>
