@props(['order'])

<button type="button"
    onclick="addPenalty({{ $order->id }})"
    class="text-red-600 hover:text-red-900 p-1 sm:p-1.5 rounded-md hover:bg-red-50 hover:cursor-pointer transition-colors"
    title="Add Penalty">
    <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
    </svg>
</button>

<script>
    function addPenalty(orderId) {
        Swal.fire({
            title: 'Add Penalty',
            html: `
                <form id="penaltyForm-${orderId}" action="/orders/${orderId}/add-penalty" method="POST">
                    @csrf
                    <div class="mb-4 text-left">
                        <label for="penaltyAmount-${orderId}" class="block mb-2 text-sm font-medium text-gray-700">Penalty Amount (₱)</label>
                        <input type="number" name="amount" id="penaltyAmount-${orderId}" step="0.01" min="0.01"
                            placeholder="Enter amount..." class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500" required>
                    </div>
                    <div class="mb-4 text-left">
                        <label for="penaltyReason-${orderId}" class="block mb-2 text-sm font-medium text-gray-700">Reason (optional)</label>
                        <input type="text" name="reason" id="penaltyReason-${orderId}" maxlength="255"
                            placeholder="Enter reason..." class="w-full p-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Add Penalty',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            customClass: {
                popup: 'max-w-md w-full p-4', // Responsive width and padding
                title: 'text-lg font-semibold mb-4', // Title styling
                confirmButton: 'bg-red-600 text-white hover:bg-red-700 rounded-md px-4 py-2', // Confirm button styling
                cancelButton: 'bg-gray-300 text-gray-700 hover:bg-gray-400 rounded-md px-4 py-2' // Cancel button styling
            },
            preConfirm: () => {
                const form = document.getElementById(`penaltyForm-${orderId}`);
                const amountInput = form.querySelector('input[name="amount"]');
                const reasonInput = form.querySelector('input[name="reason"]');

                const amount = amountInput.value.trim();
                const reason = reasonInput.value.trim();

                if (amount === '') {
                    Swal.showValidationMessage('Penalty amount cannot be empty.');
                    return false;
                }

                if (isNaN(amount) || parseFloat(amount) < 0.01) {
                    Swal.showValidationMessage('Please enter a valid penalty amount greater than 0.');
                    return false;
                }

                if (reason.length > 255) {
                    Swal.showValidationMessage('Reason must not exceed 255 characters.');
                    return false;
                }

                form.submit();
            }
        });
    }
</script>