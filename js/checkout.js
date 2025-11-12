$(document).ready(function() {

    $('#checkout-form').on('submit', function(e) {
        e.preventDefault();

       
        let valid = true;
        $(this).find('input[required], select[required]').each(function() {
            if (!$(this).val().trim()) {
                valid = false;
                $(this).addClass('error');
            } else {
                $(this).removeClass('error');
            }
        });

        if (!valid) {
            Swal.fire({
                title: 'Incomplete Form',
                text: 'Please fill in all required fields.',
                icon: 'warning',
                confirmButtonColor: '#d33'
            });
            return;
        }

        Swal.fire({
            title: 'Confirm Payment',
            text: 'Have you completed the payment?',
            icon: 'question',
            showCancelButton: true,
            confirmButtonText: "Yes, I’ve paid",
            cancelButtonText: "Cancel",
            confirmButtonColor: '#28a745',
            cancelButtonColor: '#6c757d'
        }).then((result) => {
            if (result.isConfirmed) {
                processCheckout(); 
            } else {
                Swal.fire({
                    title: 'Payment Cancelled',
                    text: 'Your order has not been processed.',
                    icon: 'info',
                    confirmButtonColor: '#6c757d'
                });
            }
        });
    });


    
    function processCheckout() {
        const customerId = '<?= $customer_id ?>';

        Swal.fire({
            title: 'Processing...',
            text: 'Please wait while we confirm your order.',
            allowOutsideClick: false,
            didOpen: () => {
                Swal.showLoading();
            }
        });

        $.ajax({
            url: '../actions/process_checkout_action.php',
            method: 'POST',
            dataType: 'json',
            data: {
                customer_id: customerId,
                payment_status: 'success' 
            },
            success: function(response) {
                Swal.close();

                if (response.status === 'success') {
                    showConfirmationScreen(response);
                } else if (response.status === 'warning') {
                    Swal.fire({
                        title: 'Partial Success',
                        text: response.message,
                        icon: 'warning',
                        confirmButtonColor: '#f0ad4e'
                    });
                } else {
                    Swal.fire({
                        title: 'Checkout Failed',
                        text: response.message || 'Something went wrong during checkout.',
                        icon: 'error',
                        confirmButtonColor: '#d33'
                    });
                }
            },
            error: function(xhr, status, error) {
                Swal.close();
                Swal.fire({
                    title: 'Network Error',
                    text: 'Unable to process checkout right now. Please try again later.',
                    icon: 'error',
                    confirmButtonColor: '#d33'
                });
                console.error('Checkout AJAX error:', error);
            }
        });
    }


    
    function showConfirmationScreen(response) {
        const { invoice_no, order_id, items_processed, items_failed } = response;


        $('.checkout-container').fadeOut(300, function() {
            const confirmationHtml = `
                <div id="confirmation-screen" style="padding: 4rem; text-align:center;">
                    <h2 style="color:#C97D60;">Order Confirmed!</h2>
                    <p>Your payment was successful.</p>
                    <p><strong>Reference:</strong> ${invoice_no}</p>
                    ${items_failed > 0 ? `<p style="color:red;">Items failed: ${items_failed}</p>` : ''}
                    <a href="all_product.php" class="btn-secondary" style="margin-top:2rem;">Continue Shopping</a>
                </div>
            `;
            $('.checkout-container').html(confirmationHtml).fadeIn(400);
        });

        
        Swal.fire({
            title: 'Order Confirmed!',
            html: `Reference: <strong>${invoice_no}</strong>`,
            icon: 'success',
            confirmButtonColor: '#28a745'
        });
    }
});
