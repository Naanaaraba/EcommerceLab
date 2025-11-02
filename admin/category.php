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
  <title>Category Management - ShopVerse</title>
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
  <link href="https://fonts.googleapis.com/css2?family=Chivo+Mono:wght@300;400&family=Figtree:wght@300;400;500&family=Space+Grotesk:wght@300;400&display=swap" rel="stylesheet">
  <style>
    :root {
      --deep-navy: #0A1128;
      --stone: #E8E4D9;
      --clay: #C97D60;
      --sage: #A4B8A4;
      --mist: #8DA7BE;
    }

    * {
      margin: 0;
      padding: 0;
      box-sizing: border-box;
    }

    body {
      background: var(--deep-navy);
      color: var(--stone);
      font-family: 'Figtree', sans-serif;
      font-weight: 300;
      overflow-x: hidden;
      min-height: 100vh;
      position: relative;
      padding: 0;
    }

    .fluid-bg {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      height: 100%;
      z-index: -1;
      opacity: 0.2;
    }

    .fluid-shape {
      position: absolute;
      filter: blur(80px);
      border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
    }

    .fluid-1 {
      width: 500px;
      height: 500px;
      background: var(--clay);
      top: -150px;
      left: -150px;
      animation: morph 30s ease-in-out infinite;
    }

    .fluid-2 {
      width: 400px;
      height: 400px;
      background: var(--sage);
      bottom: -100px;
      right: 10%;
      animation: morph 25s ease-in-out infinite reverse;
    }

    @keyframes morph {
      0%, 100% { 
        border-radius: 40% 60% 70% 30% / 40% 50% 60% 50%;
        transform: scale(1) rotate(0deg);
      }
      33% { 
        border-radius: 60% 40% 30% 70% / 60% 30% 70% 40%;
        transform: scale(1.05) rotate(120deg);
      }
      66% { 
        border-radius: 30% 60% 70% 40% / 50% 60% 30% 60%;
        transform: scale(0.95) rotate(240deg);
      }
    }

    .arch-nav {
      position: fixed;
      top: 0;
      left: 0;
      width: 100%;
      padding: 1.5rem 3rem;
      z-index: 1000;
      display: flex;
      justify-content: space-between;
      align-items: center;
      background: rgba(10, 17, 40, 0.95);
      backdrop-filter: blur(15px);
      border-bottom: 1px solid rgba(232, 228, 217, 0.08);
    }

    .nav-brand {
      font-family: 'Chivo Mono', monospace;
      font-weight: 300;
      font-size: 1.1rem;
      color: var(--stone);
      letter-spacing: 3px;
      opacity: 0.9;
    }

    .nav-links {
      display: flex;
      gap: 2rem;
      align-items: center;
    }

    .nav-link {
      color: var(--stone);
      text-decoration: none;
      font-size: 0.85rem;
      letter-spacing: 1.5px;
      position: relative;
      opacity: 0.7;
      transition: all 0.3s ease;
      text-transform: uppercase;
      font-family: 'Chivo Mono', monospace;
    }

    .nav-link:hover {
      opacity: 1;
      color: var(--clay);
    }

    .admin-container {
      padding: 8rem 3rem 3rem;
      max-width: 1200px;
      margin: 0 auto;
    }

    .admin-title {
      font-family: 'Space Grotesk', sans-serif;
      font-weight: 300;
      font-size: 2.5rem;
      color: var(--stone);
      margin-bottom: 0.5rem;
      letter-spacing: 1px;
    }

    .admin-subtitle {
      font-family: 'Chivo Mono', monospace;
      font-weight: 300;
      font-size: 1rem;
      color: var(--sage);
      letter-spacing: 2px;
      margin-bottom: 3rem;
      text-transform: uppercase;
      opacity: 0.8;
    }

    
    .form-section {
      background: rgba(10, 17, 40, 0.8);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(232, 228, 217, 0.15);
      padding: 2.5rem;
      margin-bottom: 3rem;
      position: relative;
      overflow: hidden;
      transition: all 0.4s ease;
    }

    .form-section:hover {
      border-color: var(--clay);
    }

    .form-section::before {
      content: '';
      position: absolute;
      top: 0;
      left: -100%;
      width: 100%;
      height: 100%;
      background: linear-gradient(90deg, transparent, rgba(201, 125, 96, 0.08), transparent);
      transition: left 0.7s ease;
    }

    .form-section:hover::before {
      left: 100%;
    }

    .section-title {
      font-family: 'Space Grotesk', sans-serif;
      font-weight: 400;
      font-size: 1.3rem;
      color: var(--stone);
      margin-bottom: 2rem;
      letter-spacing: 1px;
    }

    
    .form-group {
      margin-bottom: 1.5rem;
    }

    .form-row {
      display: grid;
      grid-template-columns: 1fr auto;
      gap: 1.5rem;
      align-items: end;
    }

    .form-label {
      font-family: 'Chivo Mono', monospace;
      font-size: 0.8rem;
      color: var(--stone);
      letter-spacing: 1.5px;
      margin-bottom: 0.8rem;
      text-transform: uppercase;
      opacity: 0.9;
    }

    .form-control {
      background: rgba(232, 228, 217, 0.05);
      border: 1px solid rgba(232, 228, 217, 0.2);
      border-radius: 0;
      color: var(--stone);
      padding: 0.9rem 1rem;
      font-family: 'Figtree', sans-serif;
      font-size: 0.9rem;
      transition: all 0.3s ease;
      width: 100%;
    }

    .form-control:focus {
      background: rgba(232, 228, 217, 0.08);
      border-color: var(--clay);
      color: var(--stone);
      box-shadow: none;
      outline: none;
    }

    .form-control::placeholder {
      color: rgba(232, 228, 217, 0.4);
      font-family: 'Figtree', sans-serif;
    }

    
    .btn-primary {
      background: transparent;
      border: 1px solid var(--stone);
      color: var(--stone);
      padding: 0.9rem 2rem;
      font-family: 'Chivo Mono', monospace;
      font-size: 0.85rem;
      letter-spacing: 1.5px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      text-transform: uppercase;
      height: fit-content;
    }

    .btn-primary:hover {
      background: var(--stone);
      color: var(--deep-navy);
      border-color: var(--stone);
    }

    .btn-sm {
      padding: 0.5rem 1rem;
      font-size: 0.75rem;
    }

    .btn-edit {
      background: transparent;
      border: 1px solid var(--sage);
      color: var(--sage);
      transition: all 0.3s ease;
    }

    .btn-edit:hover {
      background: var(--sage);
      color: var(--deep-navy);
    }

    .btn-delete {
      background: transparent;
      border: 1px solid #dc3545;
      color: #dc3545;
      transition: all 0.3s ease;
    }

    .btn-delete:hover {
      background: #dc3545;
      color: var(--stone);
    }

  
    .table-section {
      background: rgba(10, 17, 40, 0.8);
      backdrop-filter: blur(20px);
      border: 1px solid rgba(232, 228, 217, 0.15);
      padding: 2rem;
    }

    .table {
      color: var(--stone);
      border-color: rgba(232, 228, 217, 0.2);
    }

    .table th {
      font-family: 'Chivo Mono', monospace;
      font-weight: 400;
      font-size: 0.8rem;
      letter-spacing: 1.5px;
      text-transform: uppercase;
      border-color: rgba(232, 228, 217, 0.2);
      background: rgba(232, 228, 217, 0.05);
      padding: 1rem;
    }

    .table td {
      border-color: rgba(232, 228, 217, 0.1);
      padding: 1rem;
      vertical-align: middle;
    }

    .action-buttons {
      display: flex;
      gap: 0.5rem;
    }

    
    .empty-state {
      text-align: center;
      padding: 3rem;
      color: var(--sage);
      opacity: 0.7;
    }

    .empty-state .icon {
      font-size: 3rem;
      margin-bottom: 1rem;
      opacity: 0.5;
    }

    .empty-state p {
      font-family: 'Chivo Mono', monospace;
      font-size: 0.9rem;
      letter-spacing: 1px;
      margin-bottom: 0;
    }

    
    @media (max-width: 768px) {
      .arch-nav {
        padding: 1rem 1.5rem;
        flex-direction: column;
        gap: 1rem;
      }

      .nav-links {
        gap: 1rem;
      }

      .admin-container {
        padding: 7rem 1.5rem 2rem;
      }

      .admin-title {
        font-size: 2rem;
      }

      .admin-subtitle {
        font-size: 0.9rem;
      }

      .form-section {
        padding: 1.5rem;
      }

      .form-row {
        grid-template-columns: 1fr;
        gap: 1rem;
      }

      .table-section {
        padding: 1rem;
        overflow-x: auto;
      }

      .table {
        font-size: 0.85rem;
      }

      .action-buttons {
        flex-direction: column;
      }
    }
  </style>
</head>
<body>

  
  <div class="fluid-bg">
    <div class="fluid-shape fluid-1"></div>
    <div class="fluid-shape fluid-2"></div>
  </div>

 
  <nav class="arch-nav">
    <div class="nav-brand">SHOPVERSE ADMIN</div>
    <div class="nav-links">
      <a href="../index.php" class="nav-link">Home</a>
      <a href="../admin/product.php" class="nav-link">Products</a>
      <a href="../admin/brand.php" class="nav-link">Brands</a>
      <a href="../login/logout.php" class="nav-link">Logout</a>
    </div>
  </nav>


  <div class="admin-container">
    <h1 class="admin-title">Category Management</h1>
    <p class="admin-subtitle">Organize Your Collections</p>

 
    <div class="form-section">
      <h3 class="section-title" id="form_title">Create Category</h3>
      <form id="category_form">
        <div class="form-row">
          <div class="form-group" style="flex: 1;">
            <label for="cat_name" class="form-label">Category Name</label>
            <input id="cat_name" type="text" name="cat_name" class="form-control" placeholder="Enter category name" required>
          </div>
          <button type="submit" class="btn-primary" name="create">Create Category</button>
        </div>
      </form>
    </div>

  
    <div class="table-section">
      <h3 class="section-title">Your Categories</h3>
      <div class="table-responsive">
        <table class="table" id="cat_table">
          <thead>
            <tr>
              <th>ID</th>
              <th>Category Name</th>
              <th>Actions</th>
            </tr>
          </thead>
          <tbody>
           
            <tr id="empty-state" style="display: none;">
              <td colspan="3" class="empty-state">
                <div class="icon">📁</div>
                <p>No categories found. Create your first category to get started.</p>
              </td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <script src="../js/category.js"></script>
</body>
</html>