@props(['order'])

<form action="{{ route('orders.mark-ongoing', $order->id) }}"
    onsubmit="return confirmAction('Are you sure you want to mark this order as ongoing?', event);"
    method="POST" class="inline">
    @csrf
    @method('PUT')
    <button type="submit"
        class="text-blue-600 hover:text-blue-900 p-1 sm:p-1.5 rounded-md hover:bg-blue-50 hover:cursor-pointer transition-colors"
        title="Mark as Ongoing">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2"
                d="M4 4v5h.582m15.836 2A9 9 0 111 12a9 9 0 0118 0z">
            </path>
        </svg>
    </button>
</form>