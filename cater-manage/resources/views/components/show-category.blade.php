<div class="border border-cyan-200 bg-cyan-50  rounded-xl shadow-lg p-6">
    <h2 class="text-2xl font-bold text-cyan-800 mb-5 text-center">All Categories</h2>
    <ul class="space-y-3 list-none p-0">
        @foreach($categories as $category)
            <li class="bg-white p-4 rounded-lg shadow-sm hover:bg-cyan-50 transition-colors border-l-4 border-cyan-400">
                <span class="font-semibold text-cyan-700 text-lg">{{ $category->name }}</span>
                <p class="text-cyan-600 mt-1 text-sm">{{ $category->description }}</p>
            </li>
        @endforeach
    </ul>
</div>