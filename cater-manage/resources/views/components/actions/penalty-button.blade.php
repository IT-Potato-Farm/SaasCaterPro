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
                        <input type="number" name="penalty_fee" id="penaltyAmount-${orderId}" step="0.01" min="0"
                            placeholder="Enter amount..." class="swal2-input" required>
                </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Add Penalty',
            cancelButtonText: 'Cancel',
            focusConfirm: false,
            preConfirm: () => {
                const form = document.getElementById(`penaltyForm-${orderId}`);
                const amount = form.querySelector('input[name="penalty_fee"]');

                if (!amount.value || parseFloat(amount.value) <= 0) {
                    Swal.showValidationMessage('Please enter a valid penalty amount.');
                    return false;
                }

                form.submit();  
            }
        });
    }
</script>
