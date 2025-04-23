@props(['order'])

<form action="{{ route('orders.destroy', $order->id) }}"
    method="POST" class="inline"
    onsubmit="return confirmDelete(this);">
    @csrf
    @method('DELETE')
    <button type="submit"
        class="text-red-600 hover:text-red-900 p-1 sm:p-1.5 rounded-md hover:bg-red-50 hover:cursor-pointer transition-colors"
        title="Delete Order">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</form>