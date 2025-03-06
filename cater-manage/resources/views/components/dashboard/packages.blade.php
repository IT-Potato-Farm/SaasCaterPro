<div class="container mx-auto px-4 py-8">
    <h2 class="text-3xl font-bold text-gray-800 mb-8"> Packages</h2>
    
    @if($packages->isEmpty())
        <div class="text-center py-12 bg-gray-50 rounded-lg">
            <p class="text-gray-500">No packages available yet.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($packages as $package)
                <div class="bg-white rounded-xl shadow-md overflow-hidden hover:shadow-lg transition-shadow duration-300">
                    <!-- img-->
                    <div class="h-48 bg-gray-100 relative">
                        @if($package->image)
                            <img src="{{ asset('packagePics/' . $package->image) }}" 
                                 alt="{{ $package->name }}" 
                                 class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full flex items-center justify-center text-gray-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                        @endif
                       
                    </div>

                    <!-- Package Details -->
                    <div class="p-6">
                        <div class="mb-4">
                            <h3 class="text-2xl font-semibold text-gray-800 mb-1">{{ $package->name }}</h3>
                            @if($package->category)
                                <p class="text-sm text-gray-500">{{ $package->category->name }}</p>
                            @endif
                        </div>

                        <p class="text-gray-600 mb-4 line-clamp-3 hover:line-clamp-none transition-all">
                            {{ $package->description }}
                        </p>

                        <div class="grid grid-cols-2 gap-4 text-sm mb-4">
                            <div>
                                <p class="text-gray-500">Price per person</p>
                                <p class="font-medium text-gray-800">₱{{ number_format($package->price_per_person, 2) }}</p>
                            </div>
                            <div>
                                <p class="text-gray-500">Minimum Pax</p>
                                <p class="font-medium text-gray-800">{{ $package->min_pax }}</p>
                            </div>
                        </div>

                        <!-- Action Buttons -->
                        <div class="flex space-x-2 mt-4">
                            <button onclick="editPackage({{ $package->id }})" 
                                    class="flex-1 px-4 py-2 bg-blue-100 text-blue-800 rounded-md hover:bg-blue-200 transition-colors">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.036H3v-3.572L16.732 3.732z" />
                                </svg>
                                Edit
                            </button>
                            <button onclick="deletePackage({{ $package->id }})" 
                                    class="flex-1 px-4 py-2 bg-red-100 text-red-800 rounded-md hover:bg-red-200 transition-colors">
                                <svg class="w-5 h-5 inline mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>