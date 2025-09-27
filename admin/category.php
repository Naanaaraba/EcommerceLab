<?php
include_once '../settings/core.php';
$is_logged_in = check_login();
$is_admin = is_admin();

if(!$is_logged_in || !$is_admin ){
    header('location: ../index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <title>Category Management</title>
  <style>
    body {
      font-family: Arial, sans-serif;
      margin: 30px;
      background: #f8f9fa;
    }
    h1, h2 {
      color: #333;
    }
    form {
      margin: 15px 0;
    }
    input[type="text"] {
      padding: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
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
    th, td {
      border: 1px solid #ddd;
      padding: 10px;
      text-align: left;
    }
    th {
      background: #f1f1f1;
    }
    a.delete-link {
      color: #dc3545;
      text-decoration: none;
      margin-left: 10px;
    }
    a.delete-link:hover {
      text-decoration: underline;
    }
  </style>
</head>
<body>
  <h1>Category Management</h1>

  <!-- CREATE FORM -->
  <h2>Create Category</h2>
  <form id="category_form">
    <input id="cat_name" type="text" name="cat_name" placeholder="Category name" required>
    <button type="submit" name="create">Create</button>
  </form>

  <!-- LIST CATEGORIES -->
  <h2>Your Categories</h2>
  <table id="cat_table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Category Name</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>       
    </tbody>
  </table>
   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/category.js"></script>
</body>
</html>
