@props(['order'])
<form action="{{ route('order.invoice', $order->id) }}"
    onsubmit="return confirmAction('Are you sure you want to generate the invoice?', event);"
    method="GET" class="inline">
    <button type="submit"
        class="text-indigo-600 hover:text-indigo-900 p-1 sm:p-1.5 rounded-md hover:bg-indigo-50 hover:cursor-pointer transition-colors"
        title="Generate Invoice">
        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none"
            stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round"
                stroke-width="2"
                d="M9 17v-2m3 2v-4m3 4v-6m2 10H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z">
            </path>
        </svg>
    </button>
</form>