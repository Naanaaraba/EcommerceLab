<?php
require_once('../settings/db_class.php');

class Order extends db_connection {

    public function __construct()
    {
        parent::db_connect();
    }

    public function createOrder($customer_id, $invoice_no, $order_date) {
        $sql = "INSERT INTO orders (customer_id, invoice_no, order_date, order_status) 
                VALUES (?, ?, ?, 'Pending')";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iss", $customer_id, $invoice_no, $order_date);

        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }

    public function addOrderDetail($order_id, $product_id, $qty, $price_at_purchase) {
        $sql = "INSERT INTO orderdetails (order_id, product_id, qty, price_at_purchase) 
                VALUES (?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("iiid", $order_id, $product_id, $qty, $price_at_purchase);
        
        return $stmt->execute();
    }

    public function addPayment($amt, $customer_id, $order_id, $currency = 'GHS', $payment_method = 'Card') {
        $sql = "INSERT INTO payment (amt, customer_id, order_id, currency, payment_method) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("diiss", $amt, $customer_id, $order_id, $currency, $payment_method);
        
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }

    public function getUserOrders($customer_id) {
        $sql = "SELECT o.order_id, o.invoice_no, o.order_date, o.order_status,
                       SUM(od.qty * od.price_at_purchase) AS total_amount,
                       p.payment_method, p.payment_date
                FROM orders o
                LEFT JOIN orderdetails od ON o.order_id = od.order_id
                LEFT JOIN payment p ON o.order_id = p.order_id
                WHERE o.customer_id = ?
                GROUP BY o.order_id, o.invoice_no, o.order_date, o.order_status, p.payment_method, p.payment_date
                ORDER BY o.order_date DESC";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function getOrderDetails($order_id) {
        $sql = "SELECT od.*, p.product_title, p.product_desc, pi.image_url
                FROM orderdetails od
                JOIN products p ON od.product_id = p.product_id
                LEFT JOIN product_images pi ON p.product_id = pi.product_id
                WHERE od.order_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $order_id);
        $stmt->execute();
        
        $result = $stmt->get_result();
        if ($result->num_rows > 0) {
            return $result->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function updateOrderStatus($order_id, $status) {
        $sql = "UPDATE orders SET order_status = ? WHERE order_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("si", $status, $order_id);
        
        return $stmt->execute();
    }

    public function getOrderCount($customer_id) {
        $sql = "SELECT COUNT(*) AS order_count FROM orders WHERE customer_id = ?";
        
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        
        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['order_count'] : 0;
    }
}
?>