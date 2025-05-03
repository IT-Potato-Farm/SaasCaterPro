@props(['order'])



<form action="{{ route('orders.archive', $order->id) }}"
    onsubmit="return confirmAction('Are you sure you want to archive this order?', event);" method="POST"
    class="inline">
    @csrf
    @method('PUT')
    <button type="submit"
        class="text-purple-600 hover:text-purple-900 p-1 sm:p-1.5 rounded-md hover:bg-purple-50 hover:cursor-pointer transition-colors"
        title="Mark as Completed">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
        </svg>
    </button>
</form>