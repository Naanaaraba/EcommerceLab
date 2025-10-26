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
  <title>Brand Management (AJAX)</title>
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
    input[type="text"], select {
      padding: 6px;
      border: 1px solid #ccc;
      border-radius: 4px;
      margin-right: 10px;
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
  <h1>Brand Management (AJAX Version)</h1>

  <!-- CREATE FORM -->
  <h2>Create Brand</h2>
  <form id="brand_form">
    <input id="brand_name" type="text" name="brand_name" placeholder="Brand name" required>
    <select id="category_id" name="category_id" required>
      <option value="">-- Select Category --</option>
    </select>
    <button type="submit" name="create">Create</button>
  </form>

  <!-- LIST Brands -->
  <h2>Your Brands</h2>
  <table id="brand_table">
    <thead>
      <tr>
        <th>ID</th>
        <th>Brand Name</th>
        <th>Category</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>       
    </tbody>
  </table>

  
  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/category.js"></script>
    <script src="../js/brand.js"></script>
  <!-- <script>
  $(document).ready(function() {
    const categorySelect = $('#category_id');
    const brandTable = $('#brand_table tbody');

    // 1️⃣ Load Categories
    function loadCategories() {
      $.ajax({
        url: '../actions/get_categories.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
          categorySelect.empty().append('<option value="">-- Select Category --</option>');
          data.forEach(cat => {
            categorySelect.append(`<option value="${cat.cat_id}">${cat.cat_name}</option>`);
          });
        },
        error: function() {
          Swal.fire('Error', 'Could not load categories.', 'error');
        }
      });
    }

    // 2️⃣ Load Brands
    function loadBrands() {
      $.ajax({
        url: '../actions/get_brands.php',
        method: 'GET',
        dataType: 'json',
        success: function(data) {
          brandTable.empty();
          if (data.length === 0) {
            brandTable.append('<tr><td colspan="4">No brands found.</td></tr>');
            return;
          }
          data.forEach(b => {
            brandTable.append(`
              <tr>
                <td>${b.brand_id}</td>
                <td>${b.brand_name}</td>
                <td>${b.cat_name}</td>
                <td>
                  <a href="#" class="delete-link" data-id="${b.brand_id}">Delete</a>
                </td>
              </tr>
            `);
          });
        },
        error: function() {
          Swal.fire('Error', 'Failed to load brands.', 'error');
        }
      });
    }

    // 3️⃣ Create New Brand
    $('#brand_form').on('submit', function(e) {
      e.preventDefault();
      const brand_name = $('#brand_name').val();
      const category_id = $('#category_id').val();

      if (!brand_name || !category_id) {
        Swal.fire('Error', 'Please fill in all fields.', 'warning');
        return;
      }

      $.ajax({
        url: '../actions/add_brand.php',
        method: 'POST',
        data: { brand_name, category_id },
        success: function(response) {
          Swal.fire('Success', response, 'success');
          $('#brand_name').val('');
          $('#category_id').val('');
          loadBrands();
        },
        error: function() {
          Swal.fire('Error', 'Could not create brand.', 'error');
        }
      });
    });

    // 4️⃣ Delete Brand
    $(document).on('click', '.delete-link', function(e) {
      e.preventDefault();
      const brand_id = $(this).data('id');

      Swal.fire({
        title: 'Are you sure?',
        text: 'This will permanently delete the brand.',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonText: 'Yes, delete it!'
      }).then((result) => {
        if (result.isConfirmed) {
          $.ajax({
            url: '../actions/delete_brand.php',
            method: 'POST',
            data: { brand_id },
            success: function(response) {
              Swal.fire('Deleted!', response, 'success');
              loadBrands();
            },
            error: function() {
              Swal.fire('Error', 'Could not delete brand.', 'error');
            }
          });
        }
      });
    });

    // Initialize
    loadCategories();
    loadBrands();
  });
  </script> -->
</body>
</html>
