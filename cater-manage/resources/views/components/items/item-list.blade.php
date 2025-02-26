<div class="container mx-auto px-4 py-8">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Menu Items</h1>

    @if($menuItems->isEmpty())
        <p class="text-gray-500 text-center">No menu items available.</p>
    @else
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6">
            @foreach($menuItems as $menuItem)
                <div class="bg-white shadow-lg rounded-lg overflow-hidden">
                    @if($menuItem->image)
                        <img src="{{ asset($menuItem->image) }}" alt="{{ $menuItem->name }}" 
                            class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 flex items-center justify-center bg-gray-200 text-gray-500">
                            No Image
                        </div>
                    @endif
                    <div class="p-4">
                        <h2 class="text-lg font-semibold text-gray-800">{{ $menuItem->name }}</h2>
                        <p class="text-gray-600 text-sm">{{ $menuItem->description }}</p>
                        <p class="mt-2 text-lg font-bold text-green-600">₱{{ number_format($menuItem->price, 2) }}</p>
                        <p class="mt-1 text-sm {{ $menuItem->status == 'available' ? 'text-green-500' : 'text-red-500' }}">
                            {{ ucfirst($menuItem->status) }}
                        </p>
                        <div class="mt-4 flex justify-between">
                            <a href="{{ route('menu-items.edit', $menuItem->id) }}" 
                               class="px-3 py-1 bg-blue-500 text-white rounded hover:bg-blue-600 text-sm">Edit</a>
                            <form action="{{ route('menu-items.destroy', $menuItem->id) }}" method="POST" 
                                  onsubmit="return confirm('Are you sure you want to delete this item?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="px-3 py-1 bg-red-500 text-white rounded hover:bg-red-600 text-sm">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</div>