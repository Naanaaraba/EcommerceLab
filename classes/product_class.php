<?php

require_once '../settings/db_class.php';

class Product extends db_connection
{

    public function __construct()
    {
        parent::db_connect();
    }

    public function addProduct($product_cat, $product_brand, $product_title, $product_price, $product_desc, $product_keywords)
    {
        $stmt = $this->db->prepare("INSERT INTO products (product_cat, product_brand, product_title, product_price, product_desc, product_keywords) VALUES (?,?,?,?,?,?)");
        $stmt->bind_param("iissss", $product_cat, $product_brand, $product_title, $product_price, $product_desc, $product_keywords);
        if ($stmt->execute()) {
            return $this->db->insert_id;
        }
        return false;
    }

    public function fetchProducts()
    {
        $stmt = $this->db->prepare(
            "SELECT p.product_id, 
        p.product_title, p.product_price, pi.image_url, b.brand_id, c.cat_id,
        b.brand_name, c.cat_name
        FROM products p 
        LEFT JOIN categories c ON p.product_cat = c.cat_id 
        LEFT JOIN brands b ON p.product_brand = b.brand_id
        LEFT JOIN product_images pi ON p.product_id = pi.product_id
        "
        );
        $stmt->execute();
        $results = $stmt->get_result();
        if ($results->num_rows > 0) {
            return $results->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function fetchBrandsByCategory($cat_id)
    {
        $stmt = $this->db->prepare("SELECT * FROM brands b JOIN categories c ON b.cat_id = c.cat_id WHERE c.cat_id=?");
        $stmt->bind_param('i', $cat_id);
        $stmt->execute();
        $results = $stmt->get_result();
        if ($results->num_rows > 0) {
            return $results->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function deleteProduct($product_id)
    {
        $stmt = $this->db->prepare("DELETE FROM products WHERE product_id = ?");
        $stmt->bind_param("i", $product_id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function updateProduct($product_id, $product_cat, $product_brand, $product_title, $product_price, $product_desc, $product_keywords)
    {
        $stmt = $this->db->prepare("UPDATE products 
                                SET product_cat = ?, 
                                    product_brand = ?, 
                                    product_title = ?, 
                                    product_price = ?, 
                                    product_desc = ?, 
                                    product_keywords = ? 
                                WHERE product_id = ?");
        $stmt->bind_param("iissssi", $product_cat, $product_brand, $product_title, $product_price, $product_desc, $product_keywords, $product_id);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }


    public function saveImage($product_id, $image_url)
    {
        $query = "INSERT INTO product_images (product_id, image_url) VALUES (?,?)";
        $stmt = $this->db->prepare($query);
        $stmt->bind_param('is', $product_id, $image_url);

        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function view_single_product($product_id)
    {
        $query = "SELECT p.*, c.cat_name, b.brand_name, i.image_url
                  FROM products p 
                  LEFT JOIN categories c ON p.product_cat = c.cat_id 
                  LEFT JOIN brands b ON p.product_brand = b.brand_id
                  LEFT JOIN product_images i ON p.product_id = i.product_id
                  WHERE p.product_id = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $product_id);
        $stmt->execute();
        $results = $stmt->get_result();

        return ($results->num_rows > 0) ? $results->fetch_assoc() : null;
    }


    public function search_products($query_term)
    {
        $search = "%" . $query_term . "%";
        $query = "SELECT p.*, c.cat_name, b.brand_name, i.image_url
                  FROM products p 
                  LEFT JOIN categories c ON p.product_cat = c.cat_id 
                  LEFT JOIN brands b ON p.product_brand = b.brand_id
                  LEFT JOIN product_images i ON p.product_id = i.product_id
                  WHERE p.product_title LIKE ? OR p.product_keywords LIKE ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('ss', $search, $search);
        $stmt->execute();
        $results = $stmt->get_result();

        return ($results->num_rows > 0) ? $results->fetch_all(MYSQLI_ASSOC) : [];
    }


    public function filter_products_by_category($cat_id)
    {
        $query = "SELECT p.*, c.cat_name, b.brand_name, i.image_url
                  FROM products p
                  LEFT JOIN categories c ON p.product_cat = c.cat_id 
                  LEFT JOIN brands b ON p.product_brand = b.brand_id
                  LEFT JOIN product_images i ON p.product_id = i.product_id
                  WHERE p.product_cat = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $cat_id);
        $stmt->execute();
        $results = $stmt->get_result();

        return ($results->num_rows > 0) ? $results->fetch_all(MYSQLI_ASSOC) : [];
    }


    public function filter_products_by_brand($brand_id)
    {
        $query = "SELECT p.*, c.cat_name, b.brand_name, i.image_url
                  FROM products p
                  LEFT JOIN categories c ON p.product_cat = c.cat_id 
                  LEFT JOIN brands b ON p.product_brand = b.brand_id
                  LEFT JOIN product_images i ON p.product_id = i.product_id
                  WHERE p.product_brand = ?";

        $stmt = $this->db->prepare($query);
        $stmt->bind_param('i', $brand_id);
        $stmt->execute();
        $results = $stmt->get_result();

        return ($results->num_rows > 0) ? $results->fetch_all(MYSQLI_ASSOC) : [];
    }
}
