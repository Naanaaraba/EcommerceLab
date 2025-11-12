 $(document).ready(function() {
            const customerID = '<?= $customer_id ?>';
            loadCart();


            updateCartCount();


            $(document).on('click', '.btn-quantity.plus', function() {
                const cartId = $(this).data('cart-id');
                const $input = $(this).siblings('.quantity-input');
                const newQuantity = parseInt($input.val()) + 1;
                $input.val(newQuantity);
                console.log(newQuantity);
                updateCartItemQuantity(cartId, newQuantity);
            });

            $(document).on('click', '.btn-quantity.minus', function() {
                const cartId = $(this).data('cart-id');
                const $input = $(this).siblings('.quantity-input');
                const newQuantity = Math.max(1, parseInt($input.val()) - 1);
                $input.val(newQuantity);
                updateCartItemQuantity(cartId, newQuantity);
            });

            $(document).on('change', '.quantity-input', function() {
                const cartId = $(this).data('cart-id');
                const quantity = Math.max(1, parseInt($(this).val()) || 1);
                $(this).val(quantity);
                updateCartItemQuantity(cartId, quantity);
            });


            $(document).on('click', '.btn-remove', function(e) {

                Swal.fire({
                    title: 'Remove Item?',
                    text: `Are you sure you want to remove this product from your cart?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, remove it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                        e.preventDefault();
                        const cartId = $(this).data('cart-id');
                        removeFromCart(cartId)
                    }
                });
            })


            
            $('#empty_cart_btn').on('click', function() {
                Swal.fire({
                    title: 'Remove Item?',
                    text: `Are you sure you want to empty your cart?`,
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#d33',
                    cancelButtonColor: '#6c757d',
                    confirmButtonText: 'Yes, remove it',
                    cancelButtonText: 'Cancel'
                }).then((result) => {
                    if (result.isConfirmed) {
                       
                       
                         emptyCart();
                    }
                });
                
            });

            function loadCart() {
                $.ajax({
                    url: '../actions/fetch_cart_action.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        $('#loading_state').hide();

                        if (response.data && response.data.length > 0) {
                            displayCartItems(response.data);
                            updateOrderSummary(response.cart_total || 0);
                            $('#cart_content').show();
                        } else {
                            $('#empty_state').show();
                        }
                    },
                    error: function() {
                        $('#loading_state').hide();
                        $('#empty_state').show().html(`
                            <h3>Error Loading Cart</h3>
                            <p>Unable to load your cart. Please try again.</p>
                            <a href="all_product.php" class="btn-primary">Explore Products</a>
                        `);
                    }
                });
            }


            function displayCartItems(cartItems) {
                const container = $('#cart_items_container');
                container.empty();

                let subtotal = 0;

                cartItems.forEach(item => {
                    const itemTotal = item.product_price * item.qty;
                    subtotal += itemTotal;

                    const cartItem = `
                        <div class="cart-item">
                            <img src="${item.image_url ? '../' + item.image_url : 'https://via.placeholder.com/100x100?text=No+Image'}" 
                                 alt="${item.product_title}" class="item-image">
                            
                            <div class="item-details">
                                <h4 class="item-title">${item.product_title}</h4>
                                <div class="item-price">₵${parseFloat(item.product_price).toFixed(2)}</div>
                            </div>
                            
                            <div class="quantity-controls">
                                <button type="button" class="btn-quantity minus" data-cart-id="${item.cart_id}">-</button>
                                <input type="number" value="${item.qty}" min="1" 
                                       class="quantity-input" data-cart-id="${item.cart_id}">
                                <button type="button" class="btn-quantity plus" data-cart-id="${item.cart_id}">+</button>
                            </div>
                            
                            <div class="item-total">₵${itemTotal.toFixed(2)}</div>
                            
                            <button class="btn-remove" data-cart-id="${item.cart_id}">Remove</button>
                        </div>
                    `;
                    container.append(cartItem);
                });


                $('#cart-items-title').text(`Cart Items (${cartItems.length})`);
            }


            function updateOrderSummary(subtotal) {
                const shipping = 50;
                const tax = subtotal * 0.12;
                const total = subtotal + shipping + tax;

                $('#subtotal').text('₵' + subtotal.toFixed(2));
                $('#shipping').text('₵' + shipping.toFixed(2));
                $('#tax').text('₵' + tax.toFixed(2));
                $('#total').text('₵' + total.toFixed(2));
            }


            function updateCartItemQuantity(cartId, quantity) {
                const formData = new FormData();
                formData.append('cart_id', cartId);
                formData.append('quantity', quantity);
                formData.append('customer_id', customerID);

                fetch('../actions/update_quantity_action.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            loadCart();
                            updateCartCount();
                        } else {
                            alert(data.message || 'Failed to update quantity');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while updating quantity');
                    });
            }


            function removeFromCart(cartId) {
                const formData = new FormData();
                formData.append('cart_id', cartId);
                formData.append('customer_id', customerID);

                fetch('../actions/remove_from_cart_action.php', {
                        method: 'POST',
                        body: formData
                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            loadCart();
                            updateCartCount();
                        } else {
                            alert(data.message || 'Failed to remove item');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while removing item');
                    });
            }


            function emptyCart() {
                const formData = new FormData();
                formData.append('customer_id', customerID);

                fetch('../actions/empty_cart_action.php', {
                        method: 'POST',
                        body:formData

                    })
                    .then(response => response.json())
                    .then(data => {
                        if (data.status === 'success') {
                            $('#cart_content').hide();
                            $('#empty_state').show();
                            updateCartCount();
                        } else {
                            alert(data.message || 'Failed to empty cart');
                        }
                    })
                    .catch(error => {
                        console.error('Error:', error);
                        alert('An error occurred while emptying cart');
                    });
            }

            function updateCartCount() {
                $.ajax({
                    url: '../actions/get_cart_count_action.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            $('#nav-cart-count').text(response.count);
                        }
                    }
                });
            }
        });