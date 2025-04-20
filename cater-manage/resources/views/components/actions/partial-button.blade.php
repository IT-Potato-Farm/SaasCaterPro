@props(['order'])
<form action="{{ route('orders.mark-partial', $order->id) }}"
    onsubmit="return confirmAction('Are you sure you want to mark this order as partially paid?', event);"
    method="POST" class="inline">
    @csrf
    @method('PUT')
    <button type="submit"
        class="text-orange-600 hover:text-orange-900 p-1 sm:p-1.5 rounded-md hover:bg-orange-50 hover:cursor-pointer transition-colors"
        title="Mark as Partially Paid">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" d="M12 2a10 10 0 100 20 10 10 0 000-20z">
            </path>
            <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2" d="M12 2v20">
            </path>
        </svg>
    </button>
</form>