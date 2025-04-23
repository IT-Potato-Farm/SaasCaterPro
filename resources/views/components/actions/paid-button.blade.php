@props(['order'])
<form action="{{ route('orders.mark-paid', $order->id) }}" method="POST"
    onsubmit="return confirmAction('Are you sure you want to mark this order as paid?', event);"
    class="inline">
    @csrf
    @method('PUT')
    <button type="submit"
        class="text-green-600 hover:text-green-900 p-1 sm:p-1.5 rounded-md hover:bg-green-50 hover:cursor-pointer transition-colors"
        title="Mark as Paid">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2"
                d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z">
            </path>
        </svg>
    </button>
</form>