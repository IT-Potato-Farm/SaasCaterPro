function addToCart(id) {
    const button = event.target;
    const parent = button.closest(".menu-item");
    const quantityElement = parent.querySelector(".quantity");
    const quantity = parseInt(quantityElement.textContent, 10); // Convert to number

    if (quantity <= 0) {
        Swal.fire({
            icon: "error",
            title: "Oops...",
            text: "Please select at least 1 item!",
        });
        return;
    }

    Swal.fire({
        position: "top-end",
        icon: "success",
        title: `${quantity} item(s) added to cart`,
        showConfirmButton: false,
        timer: 1500,
        toast: true,
        customClass: {
            popup: "rounded-none shadow-xl",
        },
    });

    console.log(`Adding ${quantity} of item ${id} to cart`);
    quantityElement.textContent = "0";

    console.log("yawa uy");

    quantityElement.textContent = "0";

    const cartCountElement = document.getElementById("cart-count");
    if (cartCountElement) {
        let currentCount = parseInt(cartCountElement.textContent, 10) || 0;
        cartCountElement.textContent = currentCount + quantity;
    }

    console.log("Cart updated successfully");
}












function incrementQuantity(button) {
    const quantitySpan = button.parentElement.querySelector(".quantity");
    let currentQuantity = parseInt(quantitySpan.textContent);
    currentQuantity++;
    quantitySpan.textContent = currentQuantity;
}

function decrementQuantity(button) {
    const quantitySpan = button.parentElement.querySelector(".quantity");
    let currentQuantity = parseInt(quantitySpan.textContent);
    if (currentQuantity > 0) {
        currentQuantity--;
    }
    quantitySpan.textContent = currentQuantity;
}
