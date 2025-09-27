<?php

require_once '../settings/db_class.php';

class Category extends db_connection
{
    private $id;
    private $cat_name;

    public function __construct()
    {
        parent::db_connect();
    }

    public function addCategory($cat_name)
    {
        $stmt = $this->db->prepare("INSERT INTO categories (cat_name) VALUES (?)");
        $stmt->bind_param("s", $cat_name);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }

    public function fetchCategories(){
        $stmt = $this->db->prepare("SELECT * FROM categories");
        $stmt->execute();
        $results = $stmt->get_result();
        if($results->num_rows > 0){
            return $results->fetch_all(MYSQLI_ASSOC);
        }
        return [];
    }

    public function deleteCategory($cat_id){
        $stmt = $this->db->prepare("DELETE FROM categories WHERE cat_id = ?");
        $stmt->bind_param("i", $cat_id);
        if ($stmt->execute()) {
            return true;
        }
        return false;
    }
    public function updateCategory($cat_id,$cat_name){
          $stmt = $this->db->prepare("UPDATE categories SET cat_name = ? WHERE cat_id = ?");
        $stmt->bind_param("si", $cat_name,$cat_id,);
        if ($stmt->execute()) {
            return true;
        }
        return false;

    }
}
