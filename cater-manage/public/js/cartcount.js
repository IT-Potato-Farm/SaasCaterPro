$(document).ready(function () {
    function updateCartCount() {
        $.ajax({
            url: "/cart/count", // Laravel route to get cart count
            method: "GET",
            success: function (response) {
                if (response.success) {
                    $("#cart-count").text(response.count);
                }
            },
            error: function () {
                console.error("Failed to update cart count.");
            }
        });
    }

    // Call this function whenever an item is added to the cart
    $(".add-to-cart-btn").click(function (e) {
        e.preventDefault();
        let itemId = $(this).data("id");

        $.ajax({
            url: "/cart/add",
            method: "POST",
            data: {
                _token: $("meta[name='csrf-token']").attr("content"),
                item_id: itemId,
                quantity: 1, // Assuming default quantity is 1
            },
            success: function (response) {
                if (response.success) {
                    updateCartCount(); // Refresh cart count dynamically
                    alert("Item added to cart!");
                } else {
                    alert("Failed to add item.");
                }
            },
            error: function () {
                alert("Something went wrong!");
            }
        });
    });

    // Initial call to update cart count when page loads
    updateCartCount();
});
