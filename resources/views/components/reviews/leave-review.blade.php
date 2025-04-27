@props(['order'])

<script>
    function leaveReview(orderId) {
        Swal.fire({
            title: '<span class="text-2xl font-bold text-gray-800">Leave A Review</span>',
            html: `
                <form id="leaveReviewForm" class="grid grid-cols-1 md:grid-cols-2 gap-6" enctype="multipart/form-data">
                    
                    <input type="hidden" id="swal-order-id" name="order_id" value="${orderId}">

                    <!-- Rating -->
                    <div>
                        <label for="swal-rating" class="block text-sm font-medium text-gray-700">Rating:</label>
                        <select id="swal-rating" name="rating"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                            <option value="5">5 - Excellent</option>
                            <option value="4">4 - Good</option>
                            <option value="3">3 - Average</option>
                            <option value="2">2 - Poor</option>
                            <option value="1">1 - Terrible</option>
                        </select>
                        <div id="rating-error" class="error-message"></div>
                    </div>

                    <!-- Image -->
                    <div>
                        <label for="swal-image" class="block text-sm font-medium text-gray-700">Upload Image:</label>
                        <input type="file" id="swal-image" name="image" accept="image/*"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500">
                        <div id="image-error" class="error-message"></div>
                    </div>

                    <!-- Review -->
                    <div>
                        <label for="swal-review" class="block text-sm font-medium text-gray-700">Review:</label>
                        <textarea id="swal-review" name="review"
                            class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-blue-500"></textarea>
                        <div id="review-error" class="error-message"></div>
                    </div>
                </form>
            `,
            showCancelButton: true,
            confirmButtonText: 'Leave Review',
            cancelButtonText: 'Cancel',
            confirmButtonColor: '#3b82f6',
            cancelButtonColor: '#ef4444',
            
            preConfirm: () => {
                document.querySelectorAll('.error-message').forEach(el => el.textContent = '');

                const form = document.getElementById('leaveReviewForm');
                const formData = new FormData(form);

                let hasErrors = false;

                if (document.getElementById('swal-review').value.trim().length > 1000) {
                    document.getElementById('review-error').textContent = 'Review max words reached. Please leave a short review.';
                    hasErrors = true;
                }

                if (hasErrors) {
                    return false;
                }

                const imageInput = document.getElementById('swal-image');
                if (imageInput.files.length > 0) {
                    formData.append('image', imageInput.files[0]);
                }

                return submitForm(formData);
            }
        }).then((result) => {
            if (result.isConfirmed) {
                Swal.fire({
                    icon: 'success',
                    title: '<span class="text-xl font-bold text-gray-800">Success!</span>',
                    text: 'Review submitted successfully!',
                    showConfirmButton: false,
                    timer: 2000
                }).then(() => {
                    location.reload();
                });
            }
        });
    }

    function submitForm(formData) {
        formData.append("_token", document.querySelector('meta[name="csrf-token"]').getAttribute('content'));

        return fetch("{{ route('reviews.leaveReview') }}", {
            method: "POST",
            body: formData
        })
        .then(response => response.json().then(data => {
            if (!response.ok) {
                throw new Error(data.message || 'Server Error. Please try again later.');
            }
            return data;
        }))
        .then(data => {
            if (!data.success) {
                if (data.errors) {
                    Object.keys(data.errors).forEach(field => {
                        const errorElement = document.getElementById(`${field}-error`);
                        if (errorElement) {
                            errorElement.textContent = data.errors[field][0];
                        }
                    });
                    throw new Error('Error in validating. Please try again.');
                } else {
                    throw new Error(data.message || 'Error. Please try again.');
                }
            }
            return data;
        })
        .catch(error => {
            Swal.showValidationMessage(error.message);
            return false;
        });
    }
</script>

<button onclick="leaveReview(@json($order->id))"
    class="px-2 py-1 bg-cyan-200 rounded mt-2 hover:cursor-pointer">
    Leave a Review
</button>