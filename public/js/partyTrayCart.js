async function addToCart(itemId, type = 'menu_item') {
    // Retrieve CSRF token from the meta tag
    const csrfToken = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    // Prepare the payload based on type
    const payload = { quantity: 1 };
    
    if (type === 'package') {
        payload.package_id = itemId;
    } else {
        // Default to menu item if not package
        payload.menu_item_id = itemId;
        
        // Check if a variant selection exists for this menu item
        const variantSelect = document.getElementById('variant-' + itemId);
        if (variantSelect) {
            payload.variant = variantSelect.value; // e.g. "10-15" or "15-20"
        }
    }
    console.log("Payload being sent:", payload);
    try {
        const response = await fetch('/cart/add', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': csrfToken,
                'Accept': 'application/json'
            },
            body: JSON.stringify(payload)
        });

        if (response.status === 401) {
            Swal.fire({
                icon: 'info',
                title: 'Login Required',
                text: 'Please log in to add items to your cart',
                confirmButtonText: 'Login Now'
            }).then((result) => {
                if (result.isConfirmed) {
                    window.location.href = '/loginpage';
                }
            });
            return;
        }

        if (!response.ok) {
            const errorData = await response.json();
            throw new Error(errorData.message || 'Something went wrong.');
        }

        const data = await response.json();

        // Show a success toast message using SweetAlert2
        Swal.fire({
            position: 'top-end',
            icon: 'success',
            title: '<span class="text-gray-200">Added to Cart!</span>',
            text: data.message || 'Item added to your cart.',
            timer: 2000,
            showConfirmButton: false,
            background: '#1F2937',
            color: '#E5E7EB',
            toast: true
        });
    } catch (error) {
        Swal.fire({
            icon: 'error',
            title: 'Error',
            text: error.message,
            confirmButtonText: 'OK'
        });
    }
}
