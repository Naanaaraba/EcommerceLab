$(document).ready(function () {
    updateCartCount();

    function updateCartCount() {
        $.ajax({
            url: '../actions/get_cart_count_action.php',
            type: 'GET',
            dataType: 'json',
            success: function (response) {
                if (response.status === 'success') {
                    $('#nav-cart-count').text(response.count);
                }
            }
        });
    }
});