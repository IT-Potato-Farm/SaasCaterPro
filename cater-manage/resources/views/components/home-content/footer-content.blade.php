<footer class="rounded-lg shadow-sm mt-8 pt-16" style="background-color: {{ $bacc }};">
    <div class="w-full max-w-screen-xl mx-auto p-4 md:py-8">
        <div class="sm:flex sm:items-center sm:justify-between">
            <div class="holder flex items-center">
                <img src="{{ asset('images/' . $logo) }}" class="h-12">
                <span class="text-2xl font-semibold whitespace-nowrap" style = "color: {{ $teccc }}">
                    {{ $title }}
                </span>
            </div>
            <ul class="flex flex-wrap items-center mb-6 text-sm font-medium text-gray-500 sm:mb-0 dark:text-gray-400">
                <li><a href="#" class="hover:underline me-4 md:me-6">Privacy Policy</a></li>
                <li><a href="#" class="hover:underline me-4 md:me-6">Licensing</a></li>
                <li><a href="#" class="hover:underline">Contact</a></li>
            </ul>
        </div>
        <hr class="my-6 border-gray-200 sm:mx-auto dark:border-gray-700 lg:my-8" />
        <span class="block text-sm text-gray-500 sm:text-center dark:text-gray-400">
            © 2025. All Rights Reserved.
        </span>
    </div>
</footer>