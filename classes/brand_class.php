<?php

require_once '../settings/db_class.php';

class Brand extends db_connection
{
    private $id;
    private $brand_name;

    public function __construct()
    {
        parent::db_connect();
    }

    public function addBrand($brand_name, $cat_id)
    {
        $stmt = $this->db->prepare("INSERT INTO brands (cat_id,brand_name) VALUES (?,?)");
        $stmt->bind_param("is", $cat_id, $brand_name);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function fetchBrands()
    {
        $stmt = $this->db->prepare("SELECT * FROM brands b JOIN categories c ON b.cat_id = c.cat_id");
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

    public function deleteBrand($brand_id)
    {
        $stmt = $this->db->prepare("DELETE FROM brands WHERE brand_id = ?");
        $stmt->bind_param("i", $brand_id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function updateBrand($brand_id, $brand_name, $cat_id)
    {
        $stmt = $this->db->prepare("UPDATE brands SET brand_name = ?, cat_id = ? WHERE brand_id = ?");
        $stmt->bind_param("sii", $brand_name, $cat_id, $brand_id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
}
