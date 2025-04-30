@props(['order'])

@php
    $partialAmount = number_format($order->total / 2, 2, '.', '');
@endphp

<button type="button"
    onclick="openPartialPaymentModal({{ $order->id }}, '{{ $partialAmount }}')"
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

<script>
    function openPartialPaymentModal(orderId, partialAmount) {
        let formattedAmount = parseFloat(partialAmount).toLocaleString(); 
        Swal.fire({
            title: 'Confirm Partial Payment',
            html: `
                <p class="mb-4 text-gray-700">You're about to apply a partial payment of <strong>₱${formattedAmount}</strong> to this order (50% of total).</p>
                <form id="partialPaymentForm-${orderId}" action="/orders/${orderId}/mark-partial" method="POST">
                    @csrf
                    @method('PUT')
                    <input type="hidden" name="partial_amount" value="${partialAmount}">
                </form>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Confirm Partial Payment',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                const form = document.getElementById(`partialPaymentForm-${orderId}`);
                form.submit();
            }
        });
    }
</script>