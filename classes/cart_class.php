
<?php
require_once '../settings/db_class.php';

class Cart extends db_connection
{
    public function __construct()
    {
        parent::db_connect();
    }

    public function add_to_cart($customer_id, $product_id, $qty)
    {

        $existing_item = $this->check_product_in_cart($customer_id, $product_id);

        if ($existing_item) {

            $new_qty = $existing_item['qty'] + $qty;
            return $this->update_cart_item($existing_item['cart_id'], $new_qty);
        } else {
            $stmt = $this->db->prepare("INSERT INTO cart (customer_id, product_id, qty) VALUES (?, ?, ?)");
            $stmt->bind_param("iii", $customer_id, $product_id, $qty);

            if ($stmt->execute()) {
                return $this->db->insert_id;
            }
            return false;
        }
    }


    public function update_cart_item($cart_id, $qty)
    {
        $stmt = $this->db->prepare("UPDATE cart SET qty = ? WHERE cart_id = ?");
        $stmt->bind_param("ii", $qty, $cart_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    public function remove_from_cart($cart_id)
    {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE cart_id = ?");
        $stmt->bind_param("i", $cart_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    public function fetch_cart($customer_id)
    {
        $stmt = $this->db->prepare(
            "SELECT c.cart_id, c.customer_id, c.product_id, c.qty, 
                    p.product_title, p.product_price, p.product_desc,
                    i.image_url, cat.cat_name, b.brand_name
             FROM cart c
             JOIN products p ON c.product_id = p.product_id
             LEFT JOIN product_images i ON p.product_id = i.product_id
             LEFT JOIN categories cat ON p.product_cat = cat.cat_id
             LEFT JOIN brands b ON p.product_brand = b.brand_id
             WHERE c.customer_id = ?
             ORDER BY c.cart_id DESC"
        );
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $results = $stmt->get_result();

        if ($results->num_rows > 0) {
            return $results->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }


    public function empty_cart($customer_id)
    {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    public function check_product_in_cart($customer_id, $product_id)
    {
        $stmt = $this->db->prepare(
            "SELECT cart_id, qty FROM cart 
             WHERE customer_id = ? AND product_id = ? 
             LIMIT 1"
        );
        $stmt->bind_param("ii", $customer_id, $product_id);
        $stmt->execute();
        $results = $stmt->get_result();

        if ($results->num_rows > 0) {
            return $results->fetch_assoc();
        }
        return false;
    }


    public function get_cart_item_count($customer_id)
    {
        $stmt = $this->db->prepare("SELECT SUM(qty) as total_count FROM cart WHERE customer_id = ?");
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $results = $stmt->get_result();

        if ($results->num_rows > 0) {
            $row = $results->fetch_assoc();
            return $row['total_count'] ?: 0;
        }
        return 0;
    }


    public function get_cart_total_amount($customer_id)
    {
        $stmt = $this->db->prepare(
            "SELECT SUM(p.product_price * c.qty) as total_amount 
             FROM cart c 
             JOIN products p ON c.product_id = p.product_id 
             WHERE c.customer_id = ?"
        );
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();
        $results = $stmt->get_result();

        if ($results->num_rows > 0) {
            $row = $results->fetch_assoc();
            return $row['total_amount'] ?: 0;
        }
        return 0;
    }


    public function remove_product_from_cart($customer_id, $product_id)
    {
        $stmt = $this->db->prepare("DELETE FROM cart WHERE customer_id = ? AND product_id = ?");
        $stmt->bind_param("ii", $customer_id, $product_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function get_cart_count($customer_id)
    {
        $sql = "SELECT COUNT(*) AS total_items FROM cart WHERE customer_id = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->bind_param("i", $customer_id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();
        return $result ? $result['total_items'] : 0;
    }
}
