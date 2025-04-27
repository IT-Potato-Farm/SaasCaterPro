@props(['order'])
<button type="button"
    onclick="openPartialPaymentModal({{ $order->id }})"
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
    function openPartialPaymentModal(orderId) {
        Swal.fire({
            title: 'Enter Partial Payment Amount',
            html: `
                <form id="partialPaymentForm-${orderId}" action="/orders/${orderId}/mark-partial" method="POST">
                    @csrf
                    @method('PUT')
                    <div class="mb-4">
                        <label for="partial_amount-${orderId}" class="block text-sm font-medium text-gray-700">Partial Payment Amount (₱)</label>
                        <input type="number" name="partial_amount" id="partial_amount-${orderId}" step="0.01" min="0"
                            placeholder="Enter partial payment amount" class="swal2-input" required>
                    </div>
                </form>
            `,
            focusConfirm: false,
            showCancelButton: true,
            confirmButtonText: 'Mark as Partially Paid',
            cancelButtonText: 'Cancel',
            preConfirm: () => {
                const form = document.getElementById(`partialPaymentForm-${orderId}`);
                const partialAmount = form.querySelector('input[name="partial_amount"]').value;

                if (!partialAmount || partialAmount <= 0) {
                    Swal.showValidationMessage('Please enter a valid partial payment amount.');
                    return false;
                }

                form.submit();
            }
        });
    }
</script>