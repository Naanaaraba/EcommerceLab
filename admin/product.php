<?php
include_once '../settings/core.php';
$is_logged_in = check_login();
$is_admin = is_admin();

if (!$is_logged_in || !$is_admin) {
  header('location: ../index.php');
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Product Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 30px;
      background: #f8f9fa;
    }

    h1,
    h2 {
      color: #333;
    }

    form {
      margin: 15px 0;
    }

    input,
    textarea,
    select {
      padding: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin: 5px 10px 5px 0;
    }

    button {
      padding: 6px 12px;
      background: #007bff;
      color: #fff;
      border: none;
      border-radius: 4px;
      cursor: pointer;
    }

    button:hover {
      background: #0056b3;
    }

    table {
      width: 100%;
      border-collapse: collapse;
      background: #fff;
      margin-top: 20px;
    }

    th,
    td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }

    th {
      background: #f1f1f1;
    }

    img {
      width: 60px;
      height: auto;
    }
  </style>
</head>

<body>
  <h1>Product Management</h1>

  <h2 id="form_title">Add Product</h2>
  <form id="product_form" enctype="multipart/form-data">
    <input type="hidden" id="product_id" name="product_id">

    <select id="category_id" name="category_id" required>
      <option value="">-- Select Category --</option>
    </select>

    <select id="brand_id" name="brand_id" required>
      <option value="">-- Select Brand --</option>
    </select><br>

    <input type="text" id="product_title" name="product_title" placeholder="Product Title" required><br>
    <input type="number" id="product_price" name="product_price" placeholder="Price" required><br>
    <textarea id="product_desc" name="product_desc" placeholder="Description"></textarea><br>
    <input type="text" id="product_keywords" name="product_keywords" placeholder="Keywords"><br>

  
    <input type="file" id="product_image" name="product_image" accept="image/*"><br>
  

    <button type="submit" id="save_product">Save Product</button>
  </form>

  <h2>All Products</h2>
  <table id="product_table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Image</th>
        <th>Title</th>
        <th>Price</th>
        <th>Category</th>
        <th>Brand</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody></tbody>
  </table>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../js/brand.js"></script>
  <script src="../js/product.js"></script>
</body>

</html>