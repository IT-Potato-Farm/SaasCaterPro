@php
    $footer = \App\Models\FooterSection::first();
@endphp
<footer class="bg-white rounded-lg shadow-sm dark:bg-gray-900 mt-8 pt-12 pb-6">
    <div class="w-full max-w-screen-xl mx-auto px-4">
        <!-- Main Content - 2 Columns -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-8 md:gap-12">
            <!-- Brand Info -->
            <div class="flex flex-col items-center md:items-start space-y-4">
                <div class="flex flex-col sm:flex-row items-center gap-4">
                    <img src="{{ asset($footer->logo) }}" class="h-12 w-auto" alt="Saas Catering Logo">
                    <div class="text-center md:text-left">
                        <h2 class="text-xl font-semibold text-gray-800 dark:text-white">
                            {{ $footer->company_name }}
                        </h2>
                        <p class="text-gray-600 dark:text-gray-300 text-sm mt-1">
                            {{ $footer->description }}
                        </p>
                    </div>
                </div>
            </div>

            <!-- Contact Info -->
            <div class="flex flex-col items-center md:items-start space-y-4">
                <h3 class="text-lg font-semibold text-gray-800 dark:text-white">Contact Us</h3>
                
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 w-full">
                    <!-- Contact Methods -->
                    <div class="space-y-3">
                        <!-- Phone -->
                        <div class="flex items-center">
                            <a href="tel:{{ preg_replace('/\s+/', '', $footer->phone) }}" class="flex items-center text-gray-600 dark:text-gray-300 hover:text-blue-600 transition-colors">
                                <i class="fas fa-phone-alt mr-3 text-blue-500"></i>
                                <span class="text-sm">{{ $footer->phone }}</span>
                            </a>
                        </div>
                        
                        <!-- Facebook -->
                        <div class="flex items-center">
                            <a href="{{ $footer->facebook }}" target="_blank"
                               class="flex items-center text-gray-600 dark:text-gray-300 hover:text-blue-600 transition-colors">
                                <i class="fab fa-facebook-f mr-3 text-blue-500"></i>
                                <span class="text-sm">Visit Us On</span>
                            </a>
                        </div>
                    </div>
                    
                    <!-- Address & Policy -->
                    <div class="space-y-3">
                        <!-- Address -->
                        <div class="flex items-start">
                            <a href="https://maps.google.com/?q={{ urlencode($footer->address) }}" target="_blank"
                               class="flex items-start text-gray-600 dark:text-gray-300 hover:text-blue-600 transition-colors">
                                <i class="fas fa-map-marker-alt mt-1 mr-3 text-blue-500"></i>
                                <span class="text-sm">{{ $footer->address }}</span>
                            </a>
                        </div>
                        
                        <!-- Privacy Policy -->
                        <div class="flex items-center">
                            <a href="{{ route('privacy-policy.show') }}" class="flex items-center text-gray-600 dark:text-gray-300 hover:text-blue-600 transition-colors">
                                <i class="fas fa-file-alt mr-3 text-blue-500"></i>
                                <span class="text-sm">Privacy Policy</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Divider -->
        <hr class="my-6 border-gray-200 dark:border-gray-700" />

        <!-- Copyright -->
        <div class="text-center">
            <p class="text-sm text-gray-500 dark:text-gray-400">
                {{ $footer->copyright }}
            </p>
        </div>
    </div>
</footer>