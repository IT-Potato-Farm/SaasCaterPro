@props(['order'])
<form action="{{ route('order.cancel', $order->id) }}"
    method="POST"
    onsubmit="return confirmAction('Are you sure you want to mark this order as cancelled', event);"
    class="inline">
    @csrf
    @method('PUT')
    <button type="submit"
        class="text-red-600 hover:text-red-900 p-1 sm:p-1.5 rounded-md hover:bg-red-50 hover:cursor-pointer transition-colors"
        title="Cancel Booking">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round"
                stroke-linejoin="round" stroke-width="2"
                d="M6 18L18 6M6 6l12 12"></path>
        </svg>
    </button>
</form>