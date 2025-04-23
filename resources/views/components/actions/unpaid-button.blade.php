@props(['order'])

<form action="{{ route('orders.mark-unpaid', $order->id) }}"
    onsubmit="return confirmAction('Are you sure you want to mark this order as unpaid?', event);"
    method="POST" class="inline">
    @csrf
    @method('PUT')
    <button type="submit"
        class="text-red-600 hover:text-red-900 p-1 sm:p-1.5 rounded-md hover:bg-red-50 hover:cursor-pointer transition-colors"
        title="Mark as Unpaid">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2"
                d="M10 14l2-2m0 0l2-2m-2 2l-2-2m2 2l2 2m7-2a9 9 0 11-18 0 9 9 0 0118 0z">
            </path>
        </svg>
    </button>
</form>