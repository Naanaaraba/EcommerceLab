<?php

require_once '../controllers/order_controller.php';
require_once '../controllers/cart_controller.php';
require_once '../settings/core.php';


if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $customer_id = get_user_id();
    
   
    $invoice_no = generate_invoice_number_ctr();
    $order_date = date('Y-m-d H:i:s');
    

    $order_id = create_order_ctr($customer_id, $invoice_no, $order_date);
    
    if ($order_id) {
  
        $cart_items = fetch_cart_ctr($customer_id);
        $total_amount = 0;
        

        foreach ($cart_items as $item) {
            $item_total = $item['product_price'] * $item['qty'];
            $total_amount += $item_total;
            
            add_order_detail_ctr(
                $order_id, 
                $item['product_id'], 
                $item['qty'], 
                $item['product_price']
            );
        }
        
        
        $payment_id = add_payment_ctr($total_amount, $customer_id, $order_id);
        
        if ($payment_id) {
            
            empty_cart_ctr($customer_id);
            
            echo json_encode([
                'status' => 'success',
                'message' => 'Order placed successfully',
                'order_id' => $order_id,
                'invoice_no' => $invoice_no
            ]);
        } else {
           
            echo json_encode([
                'status' => 'error',
                'message' => 'Payment processing failed'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to create order'
        ]);
    }
}
?>