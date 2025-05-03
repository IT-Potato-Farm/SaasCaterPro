<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Remove item from package</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script src="{{ asset('js/sweetalert2.all.min.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/flowbite/1.6.5/flowbite.min.js"></script>
</head>

<body>
    @if (session('success'))
        <script>
            Swal.fire({
                title: 'Success!',
                text: "{{ session('success') }}",
                icon: 'success',
                confirmButtonText: 'OK'
            });
        </script>
    @endif
    @if (session('error'))
        <script>
            Swal.fire({
                icon: 'error',
                title: 'Error!',
                text: '{{ session('error') }}',
                toast: true,
                position: 'top-end',
                showConfirmButton: false,
                timer: 3000,
                background: '#fef2f2',
                iconColor: '#dc2626',
                color: '#7f1d1d',
                timerProgressBar: true,
                showClass: {
                    popup: 'swal2-show animate-slide-in'
                },
                hideClass: {
                    popup: 'swal2-hide animate-slide-out'
                }
            });
        </script>
    @endif
    <div class="flex h-screen bg-gray-50">

        <x-dashboard.side-nav />
        <div class="flex-1 flex flex-col overflow-hidden">
        <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-100 p-6">
       
        <div class="container max-w-3xl mx-auto py-8 px-4">
            <h1 class="text-3xl font-bold text-gray-900 mb-4">{{ $package->name }}</h1>
            <p class="text-gray-600 text-lg mb-8">{{ $package->description ?? 'No description provided' }}</p>

            <h3 class="text-xl font-semibold text-gray-800 mb-6">Items in this Package</h3>

            @if ($package->packageItems->isEmpty())
                <p class="text-gray-500 italic">No items linked in this package.</p>
            @else
                <form action="{{ route('admin.removeItemFromPackage', $package->id) }}" method="POST"
                    class="space-y-8">
                    @csrf
                    @method('DELETE')

                    @foreach ($package->packageItems as $packageItem)
                        <div class="bg-white rounded-lg shadow-sm p-6 border border-gray-200">
                            <div class="mb-4">
                                <h4 class="text-lg font-medium text-gray-900">{{ $packageItem->item->name }}</h4>
                                <p class="text-gray-600 text-sm mt-1">
                                    {{ $packageItem->item->description ?? 'No description available' }}
                                </p>

                            </div>

                            <div class="mt-4">
                                <h5 class="text-sm font-semibold text-gray-700 mb-3">Options</h5>
                                @if ($packageItem->options->isEmpty())
                                    <p class="text-gray-500 italic text-sm">No options linked to this item.</p>
                                @else
                                    <ul class="space-y-2">
                                        @foreach ($packageItem->options as $packageItemOption)
                                            <li class="flex items-start space-x-3 p-3 bg-gray-50 rounded border border-gray-200">
                                                <input type="checkbox" name="options[]" value="{{ $packageItemOption->id }}"
                                                    class="mt-1 h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                                <div>
                                                    <span class="text-sm font-medium text-gray-700">
                                                        {{ $packageItemOption->itemOption->type }}
                                                    </span>
                                                    <p class="text-xs text-gray-500 mt-1">
                                                        {{ $packageItemOption->itemOption->description ?? 'No description provided' }}
                                                    </p>
                                                </div>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>

                            <div class="mt-6 flex items-center gap-2">
                                <input type="checkbox" name="items_to_remove[]" value="{{ $packageItem->id }}"
                                    id="remove_item_{{ $packageItem->id }}"
                                    class="h-4 w-4 text-red-600 border-gray-300 rounded focus:ring-red-500">
                                <label for="remove_item_{{ $packageItem->id }}"
                                    class="text-sm font-medium text-red-600 hover:text-red-700 cursor-pointer">
                                    Remove ulam sa Package
                                </label>
                            </div>
                        </div>
                    @endforeach

                    <button type="submit"
                        class="w-full bg-red-600 hover:bg-red-700 text-white font-medium py-2 px-4 rounded-lg transition-colors duration-200">
                        Remove Selected Items
                    </button>
                </form>
            @endif
        </div>
             
    </main>
</div>
    </div>
</body>

</html>
