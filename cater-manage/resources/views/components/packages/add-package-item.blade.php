<div class="max-w-lg mx-auto bg-white shadow-md rounded-lg p-6">
    <h2 class="text-xl font-bold mb-4 text-center">Add Items to Package</h2>

    <form action="{{ route('package_items.store') }}" method="POST">
        @csrf

        <!-- Package Dropdown -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Select Package</label>
            <select name="package_id" id="packageSelect" required class="w-full border rounded p-2">
                <option value="">Choose a Package</option>
                @foreach ($packages as $package)
                    <option value="{{ $package->id }}">{{ $package->name }}</option>
                @endforeach
            </select>
        </div>

        <!-- Menu Items Multi-Select -->
        <div class="mb-4">
            <label class="block text-sm font-medium text-gray-700">Select Items</label>
            <select name="package_item_ids[]" id="packageItemsSelect" multiple required class="w-full border rounded p-2">
                @foreach ($package_items as $package_item)
                    <option value="{{ $package_item->id }}">
                        {{ $package_item->name }} -
                        ({{ $package_item->options->pluck('type')->implode(', ') }})
                    </option>
                @endforeach
            </select>
            <small class="text-gray-500">Hold Ctrl (Windows) or Command (Mac) to select multiple.</small>
        </div>

        <button type="submit" class="w-full bg-blue-500 text-white p-2 rounded">Add to Package</button>
    </form>
</div>

<script>
    document.getElementById('packageSelect').addEventListener('change', function() {
        let packageId = this.value;
        let packageItemsSelect = document.getElementById('packageItemsSelect');

        // Clear previous disables
        Array.from(packageItemsSelect.options).forEach(option => {
            option.disabled = false;
            option.textContent = option.textContent.replace(" (Already in this Package)", "");
        });

        if (packageId) {
            fetch(`/get-existing-package-items/${packageId}`)
                .then(response => response.json())
                .then(existingItems => {
                    Array.from(packageItemsSelect.options).forEach(option => {
                        if (existingItems.includes(parseInt(option.value))) {
                            option.disabled = true;
                            option.textContent += " (Already in this Package)";
                        }
                    });
                });
        }
    });
</script>
