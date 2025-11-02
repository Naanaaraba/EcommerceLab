<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
  <title>Product Management - ShopVerse</title>
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
      max-width: 1400px;
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
      grid-template-columns: 1fr 1fr;
      gap: 2rem;
      margin-bottom: 1.5rem;
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

    select.form-control {
      appearance: none;
      background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23E8E4D9' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
      background-repeat: no-repeat;
      background-position: right 1rem center;
      background-size: 16px;
    }

    textarea.form-control {
      min-height: 120px;
      resize: vertical;
    }

    
    .btn-primary {
      background: transparent;
      border: 1px solid var(--stone);
      color: var(--stone);
      padding: 1rem 2rem;
      font-family: 'Chivo Mono', monospace;
      font-size: 0.85rem;
      letter-spacing: 1.5px;
      cursor: pointer;
      transition: all 0.3s ease;
      text-decoration: none;
      text-transform: uppercase;
    }

    .btn-primary:hover {
      background: var(--stone);
      color: var(--deep-navy);
      border-color: var(--stone);
    }

.table-section {
  background: rgba(10, 17, 40, 0.6);
  backdrop-filter: blur(20px);
  border: 1px solid rgba(232, 228, 217, 0.1);
  padding: 2rem;
  border-radius: 8px;
}


.table-responsive {
  border-radius: 6px;
  overflow: hidden;
  background: transparent;
}

.table {
  color: var(--stone); 
  border: none;
  margin: 0;
  width: 100%;
  background: transparent;
  font-size: 0.95rem;
}


.table th {
  font-family: 'Chivo Mono', monospace;
  font-weight: 600;
  font-size: 0.75rem;
  letter-spacing: 1.5px;
  text-transform: uppercase;
  border: none;
  background: rgba(232, 228, 217, 0.05);
  padding: 1.25rem 1rem;
  color: var(--stone); 
  border-bottom: 1px solid rgba(232, 228, 217, 0.1);
  transition: color .18s ease, background-color .18s ease;
}


.table td {
  border: none;
  padding: 1.25rem 1rem;
  vertical-align: middle;
  border-bottom: 1px solid rgba(232, 228, 217, 0.05);
  transition: all 0.25s ease;
  background: transparent;
  color: var(--stone);     
  font-weight: 500;
  opacity: 0.98;
}

.table tbody tr {
  transition: background-color 180ms ease, transform 180ms ease;
  background: transparent;
}

.table tbody tr:hover {
  background: rgba(201, 125, 96, 0.20); 
  transform: translateY(-2px);
}

table tbody tr:hover td,
.table tbody tr:hover th {
  background: rgba(201, 125, 96, 0.20); 
  color: var(--deep-navy);              
  font-weight: 600;
  transition: color 160ms ease, background-color 160ms ease;
}

.table tbody tr:hover a,
.table tbody tr:hover a:visited {
  color: var(--deep-navy);
  text-decoration: underline;
}


.table tbody tr:focus-within,
.table tbody tr a:focus {
  outline: 3px solid rgba(0, 230, 255, 0.12);
  outline-offset: 2px;
}

 
    .product-image {
      width: 50px;
      height: 50px;
      object-fit: cover;
      border: 1px solid rgba(232, 228, 217, 0.2);
      border-radius: 4px;
      transition: all 0.3s ease;
    }

    .table tbody tr:hover .product-image {
      border-color: var(--clay);
      transform: scale(1.05);
    }

 
    .product-title {
      font-family: 'Space Grotesk', sans-serif;
      font-weight: 400;
      font-size: 0.95rem;
      line-height: 1.4;
      color: var(--stone);
      max-width: 200px;
    }

    .product-price {
      font-family: 'Chivo Mono', monospace;
      font-weight: 400;
      font-size: 0.9rem;
      color: var(--clay);
    }

    .product-id {
      font-family: 'Chivo Mono', monospace;
      font-size: 0.8rem;
      color: var(--sage);
      opacity: 0.7;
    }

    .product-category, .product-brand {
      font-family: 'Figtree', sans-serif;
      font-size: 0.85rem;
      color: var(--stone);
      opacity: 0.9;
    }

    
    .action-buttons {
      display: flex;
      gap: 0.5rem;
      justify-content: flex-start;
    }

    .btn-edit {
      background: transparent;
      border: 1px solid var(--sage);
      color: var(--sage);
      padding: 0.5rem 1rem;
      font-family: 'Chivo Mono', monospace;
      font-size: 0.75rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      transition: all 0.3s ease;
      text-decoration: none;
      cursor: pointer;
      border-radius: 2px;
    }

    .btn-edit:hover {
      background: var(--sage);
      color: var(--deep-navy);
      transform: translateY(-1px);
    }

    .btn-delete {
      background: transparent;
      border: 1px solid var(--clay);
      color: var(--clay);
      padding: 0.5rem 1rem;
      font-family: 'Chivo Mono', monospace;
      font-size: 0.75rem;
      letter-spacing: 1px;
      text-transform: uppercase;
      transition: all 0.3s ease;
      text-decoration: none;
      cursor: pointer;
      border-radius: 2px;
    }

    .btn-delete:hover {
      background: var(--clay);
      color: var(--deep-navy);
      transform: translateY(-1px);
    }

   
    .empty-state {
      text-align: center;
      padding: 3rem 2rem;
      color: var(--sage);
    }

    .empty-state-icon {
      font-size: 3rem;
      margin-bottom: 1rem;
      opacity: 0.5;
    }

    .empty-state-text {
      font-family: 'Space Grotesk', sans-serif;
      font-size: 1.1rem;
      margin-bottom: 0.5rem;
      color: var(--stone);
    }

    .empty-state-subtext {
      font-family: 'Figtree', sans-serif;
      font-size: 0.9rem;
      opacity: 0.7;
      max-width: 400px;
      margin: 0 auto;
    }

   
    .file-input-wrapper {
      position: relative;
      overflow: hidden;
      display: inline-block;
      width: 100%;
    }

    .file-input-wrapper input[type=file] {
      position: absolute;
      left: 0;
      top: 0;
      opacity: 0;
      width: 100%;
      height: 100%;
      cursor: pointer;
    }

    .file-input-label {
      display: block;
      padding: 0.9rem 1rem;
      background: rgba(232, 228, 217, 0.05);
      border: 1px solid rgba(232, 228, 217, 0.2);
      color: rgba(232, 228, 217, 0.6);
      font-family: 'Figtree', sans-serif;
      font-size: 0.9rem;
      cursor: pointer;
      transition: all 0.3s ease;
    }

    .file-input-wrapper:hover .file-input-label {
      border-color: var(--clay);
      color: var(--stone);
    }

 
    .table th:nth-child(1),
    .table td:nth-child(1) {
      width: 80px; 
      text-align: center;
    }

    .table th:nth-child(2),
    .table td:nth-child(2) {
      width: 70px; 
      text-align: center;
    }

    .table th:nth-child(3),
    .table td:nth-child(3) {
      width: 250px; 
    }

    .table th:nth-child(4),
    .table td:nth-child(4) {
      width: 100px; 
      text-align: right;
    }

    .table th:nth-child(5),
    .table td:nth-child(5) {
      width: 120px; 
    }

    .table th:nth-child(6),
    .table td:nth-child(6) {
      width: 120px; 
    }

    .table th:nth-child(7),
    .table td:nth-child(7) {
      width: 150px; 
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
        min-width: 800px;
      }

      .action-buttons {
        flex-direction: column;
        gap: 0.25rem;
      }

      .btn-edit,
      .btn-delete {
        padding: 0.4rem 0.8rem;
        font-size: 0.7rem;
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
      <a href="../admin/category.php" class="nav-link">Categories</a>
      <a href="../admin/brand.php" class="nav-link">Brands</a>
      <a href="../login/logout.php" class="nav-link">Logout</a>
    </div>
  </nav>

 
  <div class="admin-container">
    <h1 class="admin-title">Product Management</h1>
    <p class="admin-subtitle">Curate Your Collection</p>

   
    <div class="form-section">
      <h3 class="section-title" id="form_title">Add Product</h3>
      <form id="product_form" enctype="multipart/form-data">
        <input type="hidden" id="product_id" name="product_id">

        <div class="form-row">
          <div class="form-group">
            <label for="category_id" class="form-label">Category</label>
            <select id="category_id" name="category_id" class="form-control" required>
              <option value="">-- Select Category --</option>
            </select>
          </div>

          <div class="form-group">
            <label for="brand_id" class="form-label">Brand</label>
            <select id="brand_id" name="brand_id" class="form-control" required>
              <option value="">-- Select Brand --</option>
            </select>
          </div>
        </div>

        <div class="form-row">
          <div class="form-group">
            <label for="product_title" class="form-label">Product Title</label>
            <input type="text" id="product_title" name="product_title" class="form-control" placeholder="Enter product title" required>
          </div>

          <div class="form-group">
            <label for="product_price" class="form-label">Price</label>
            <input type="number" id="product_price" name="product_price" class="form-control" placeholder="Enter price" step="0.01" required>
          </div>
        </div>

        <div class="form-group">
          <label for="product_desc" class="form-label">Description</label>
          <textarea id="product_desc" name="product_desc" class="form-control" placeholder="Enter product description"></textarea>
        </div>

        <div class="form-group">
          <label for="product_keywords" class="form-label">Keywords</label>
          <input type="text" id="product_keywords" name="product_keywords" class="form-control" placeholder="Enter keywords (comma separated)">
        </div>

        <div class="form-group">
          <label class="form-label">Product Image</label>
          <div class="file-input-wrapper">
            <input type="file" id="product_image" name="product_image" accept="image/*">
            <div class="file-input-label" id="file-input-text">Choose product image...</div>
          </div>
        </div>

        <button type="submit" class="btn-primary" id="save_product">Save Product</button>
      </form>
    </div>

  
    <div class="table-section">
      <h3 class="section-title">All Products</h3>
      <div class="table-responsive">
        <table class="table" id="product_table">
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
          <tbody>
           
            <tr>
              <td class="product-id">1</td>
              <td>
                <img src="../admin/product_images/sample.jpg" class="product-image" alt="Product" onerror="this.src='data:image/svg+xml;base64,PHN2ZyB3aWR0aD0iNTAiIGhlaWdodD0iNTAiIHZpZXdCb3g9IjAgMCA1MCA1MCIgZmlsbD0ibm9uZSIgeG1sbnM9Imh0dHA6Ly93d3cudzMub3JnLzIwMDAvc3ZnIj4KPHJlY3Qgd2lkdGg9IjUwIiBoZWlnaHQ9IjUwIiBmaWxsPSJyZ2JhKDIzMiwgMjI4LCAyMTcsIDAuMSkiIHJ4PSI0Ii8+CjxwYXRoIGQ9Ik0yNSAzMkMyOC4zMTM3IDMyIDMxIDI5LjMxMzcgMzEgMjZDMzEgMjIuNjg2MyAyOC4zMTM3IDIwIDI1IDIwQzIxLjY4NjMgMjAgMTkgMjIuNjg2MyAxOSAyNkMxOSAyOS4zMTM3IDIxLjY4NjMgMzIgMjUgMzJaIiBmaWxsPSJyZ2JhKDIzMiwgMjI4LCAyMTcsIDAuMykiLz4KPHBhdGggZD0iTTE4IDE4TDM0IDE4TDM0IDM0TDE4IDM0TDE4IDE4WiIgc3Ryb2tlPSJyZ2JhKDIzMiwgMjI4LCAyMTcsIDAuNSkiIHN0cm9rZS13aWR0aD0iMiIvPgo8L3N2Zz4K'">
              </td>
              <td class="product-title">Quis laboriosam eu s</td>
              <td class="product-price">$678.00</td>
              <td class="product-category">Beauty</td>
              <td class="product-brand">nivea</td>
              <td>
                <div class="action-buttons">
                  <button class="btn-edit">Edit</button>
                  <button class="btn-delete">Delete</button>
                </div>
              </td>
           
          </tbody>
        </table>
      </div>
    </div>
  </div>

  <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
  <!-- <script src="../js/brand.js"></script>  -->
  <script src="../js/product.js"></script>
</body>

</html>