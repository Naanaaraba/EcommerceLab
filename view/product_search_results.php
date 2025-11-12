<?php
include_once '../settings/core.php';
$is_logged_in = check_login();
$query = isset($_GET['query']) ? trim($_GET['query']) : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Results for "<?php echo htmlspecialchars($query); ?>" - ShopVerse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
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

            0%,
            100% {
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


        .search-container {
            padding: 8rem 3rem 3rem;
            max-width: 1400px;
            margin: 0 auto;
        }


        .page-title {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 300;
            font-size: 2.5rem;
            color: var(--stone);
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
        }

        .search-query {
            color: var(--clay);
            font-style: italic;
        }

        .page-subtitle {
            font-family: 'Chivo Mono', monospace;
            font-weight: 300;
            font-size: 1rem;
            color: var(--sage);
            letter-spacing: 2px;
            margin-bottom: 3rem;
            text-transform: uppercase;
            opacity: 0.8;
        }

        .cart-count {
            background: var(--clay);
            color: var(--deep-navy);
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.7rem;
            margin-left: 5px;
        }

        .toolbar-section {
            background: rgba(10, 17, 40, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(232, 228, 217, 0.15);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 1.5rem;
        }

        .search-group {
            display: flex;
            align-items: center;
            gap: 1rem;
            flex: 1;
            max-width: 500px;
        }

        .form-control {
            background: rgba(232, 228, 217, 0.05);
            border: 1px solid rgba(232, 228, 217, 0.2);
            border-radius: 0;
            color: var(--stone);
            padding: 0.8rem 1rem;
            font-family: 'Figtree', sans-serif;
            font-size: 0.9rem;
            transition: all 0.3s ease;
            flex: 1;
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
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 1rem;
        }

        select.form-control {
            appearance: none;
            background-image: url("data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' width='16' height='16' fill='%23E8E4D9' viewBox='0 0 16 16'%3E%3Cpath d='M7.247 11.14 2.451 5.658C1.885 5.013 2.345 4 3.204 4h9.592a1 1 0 0 1 .753 1.659l-4.796 5.48a1 1 0 0 1-1.506 0z'/%3E%3C/svg%3E");
            background-repeat: no-repeat;
            background-position: right 1rem center;
            background-size: 12px;
            min-width: 180px;
        }


        .btn-primary {
            background: transparent;
            border: 1px solid var(--stone);
            color: var(--stone);
            padding: 0.8rem 1.5rem;
            font-family: 'Chivo Mono', monospace;
            font-size: 0.8rem;
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

        .btn-clear {
            background: transparent;
            border: 1px solid rgba(220, 53, 69, 0.5);
            color: rgba(220, 53, 69, 0.8);
            padding: 0.8rem 1.5rem;
            font-family: 'Chivo Mono', monospace;
            font-size: 0.8rem;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .btn-clear:hover {
            background: rgba(220, 53, 69, 0.1);
            border-color: #dc3545;
            color: #dc3545;
        }

        .btn-view {
            background: transparent;
            border: 1px solid var(--clay);
            color: var(--clay);
            padding: 0.6rem 1.2rem;
            font-family: 'Chivo Mono', monospace;
            font-size: 0.75rem;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .btn-view:hover {
            background: var(--clay);
            color: var(--deep-navy);
        }


        .grid-section {
            background: rgba(10, 17, 40, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(232, 228, 217, 0.15);
            padding: 2rem;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(280px, 1fr));
            gap: 2rem;
        }

        .card {
            background: rgba(232, 228, 217, 0.02);
            border: 1px solid rgba(232, 228, 217, 0.1);
            border-radius: 0;
            overflow: hidden;
            display: flex;
            flex-direction: column;
            transition: all 0.4s ease;
            position: relative;
        }

        .card:hover {
            border-color: var(--clay);
            transform: translateY(-5px);
        }

        .card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(201, 125, 96, 0.05), transparent);
            transition: left 0.7s ease;
        }

        .card:hover::before {
            left: 100%;
        }

        .card-image {
            width: 100%;
            height: 220px;
            object-fit: cover;
            background: rgba(232, 228, 217, 0.05);
        }

        .card-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 1.5rem;
        }

        .card-title {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 400;
            font-size: 1.1rem;
            color: var(--stone);
            margin: 0 0 0.5rem 0;
            line-height: 1.3;
        }

        .card-meta {
            font-family: 'Chivo Mono', monospace;
            font-size: 0.75rem;
            color: var(--sage);
            letter-spacing: 1px;
            margin-bottom: 1rem;
            text-transform: uppercase;
            opacity: 0.8;
        }

        .card-desc {
            color: rgba(232, 228, 217, 0.7);
            font-size: 0.85rem;
            line-height: 1.5;
            margin-bottom: 1.5rem;
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 1rem 1.5rem;
            background: rgba(232, 228, 217, 0.03);
            border-top: 1px solid rgba(232, 228, 217, 0.1);
        }

        .card-price {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 500;
            color: var(--clay);
            font-size: 1.1rem;
        }

        .results-info {
            font-family: 'Chivo Mono', monospace;
            font-size: 0.8rem;
            color: var(--sage);
            letter-spacing: 1px;
            margin-bottom: 1.5rem;
            opacity: 0.8;
        }

        .empty-state {
            text-align: center;
            padding: 4rem 2rem;
            color: rgba(232, 228, 217, 0.5);
        }

        .empty-state h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 300;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .empty-state p {
            font-family: 'Figtree', sans-serif;
            font-size: 0.9rem;
            opacity: 0.7;
        }

        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--sage);
            text-decoration: none;
            font-family: 'Chivo Mono', monospace;
            font-size: 0.8rem;
            letter-spacing: 1px;
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .back-link:hover {
            color: var(--clay);
        }


        .search-header {
            margin-bottom: 2rem;
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

            .search-container {
                padding: 7rem 1.5rem 2rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .page-subtitle {
                font-size: 0.9rem;
            }

            .toolbar-section {
                padding: 1.5rem;
            }

            .toolbar {
                flex-direction: column;
                align-items: stretch;
            }

            .search-group {
                max-width: none;
            }

            .filters {
                justify-content: space-between;
            }

            select.form-control {
                min-width: auto;
                flex: 1;
            }

            .grid {
                grid-template-columns: repeat(auto-fill, minmax(250px, 1fr));
                gap: 1.5rem;
            }

            .grid-section {
                padding: 1.5rem;
            }
        }

        @media (max-width: 480px) {
            .grid {
                grid-template-columns: 1fr;
            }

            .card-footer {
                flex-direction: column;
                gap: 1rem;
                align-items: stretch;
            }

            .btn-view {
                text-align: center;
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
        <div class="nav-brand">SHOPVERSE</div>
        <div class="nav-links">
            <a href="../index.php" class="nav-link">Home</a>
            <a href="../view/cart.php" class="nav-link">My Cart<span class="cart-count" id="nav-cart-count">0</span></a>
            <?php if ($is_logged_in): ?>
                <a href="../login/logout.php" class="nav-link">Logout</a>
            <?php else: ?>
                <a href="../login/login.php" class="nav-link">Login</a>
            <?php endif; ?>
        </div>
    </nav>


    <div class="search-container">
        <a href="all_product.php" class="back-link">
            <span>←</span> Back to All Products
        </a>

        <div class="search-header">
            <h1 class="page-title">
                Search Results for "<span class="search-query"><?php echo htmlspecialchars($query); ?></span>"
            </h1>
            <p class="page-subtitle">Curated Discoveries</p>
        </div>


        <div class="toolbar-section">
            <div class="toolbar">
                <div class="search-group">
                    <input type="search" id="search" class="form-control" placeholder="Search products..." value="<?php echo htmlspecialchars($query); ?>">
                    <button class="btn-primary" id="search_btn">Search</button>
                    <button class="btn-clear" id="clear_search">Clear</button>
                </div>
                <div class="filters">
                    <select id="filter_category" class="form-control">
                        <option value="">All Categories</option>
                    </select>
                    <select id="filter_brand" class="form-control">
                        <option value="">All Brands</option>
                    </select>
                </div>
            </div>
        </div>


        <div class="results-info" id="results_info"></div>


        <div class="grid-section">
            <div id="product_grid" class="grid"></div>
            <div id="empty_state" class="empty-state" style="display:none;">
                <h3>No Products Found</h3>
                <p>Try adjusting your search terms or filters</p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            const $grid = $('#product_grid');
            const $empty = $('#empty_state');
            const $search = $('#search');
            const $clear = $('#clear_search');
            const $searchBtn = $('#search_btn');
            const $filterCategory = $('#filter_category');
            const $filterBrand = $('#filter_brand');
            const $resultsInfo = $('#results_info');

            let products = [];

            function imageFor(p) {
                return p.product_image || p.image_url || null;
            }

            function loadCategories() {
                $.ajax({
                    url: '../actions/fetch_category_action.php',
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            $filterCategory.empty().append('<option value="">All Categories</option>');
                            res.data.forEach(c => $filterCategory.append(`<option value="${c.cat_id}">${c.cat_name}</option>`));
                        }
                    }
                });
            }

            function loadBrands(cat_id) {
                $.ajax({
                    url: '../actions/fetch_brand_by_category_action.php?cat_id=' + cat_id,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        if (res.status === 'success') {
                            $filterBrand.empty().append('<option value="">All Brands</option>');
                            res.data.forEach(b => $filterBrand.append(`<option value="${b.brand_id}">${b.brand_name}</option>`));
                        }
                    }
                });
            }

            function loadResults() {
                const query = $search.val().trim();
                const cat = $filterCategory.val();
                const brand = $filterBrand.val();

                $.ajax({
                    url: '../actions/product_actions.php',
                    type: 'GET',
                    dataType: 'json',
                    data: {
                        action: 'search',
                        query
                    },
                    success: function(res) {
                        if (res.status === 'success') {
                            products = res.data || [];
                            render();
                        } else {
                            $empty.show().text('No products found.');
                        }
                    },
                    error: function() {
                        $empty.show().text('Failed to load search results.');
                    }
                });
            }

            function render() {
                const q = $search.val().trim().toLowerCase();
                const cat = $filterCategory.val();
                const brand = $filterBrand.val();

                const filtered = products.filter(p => {
                    if (cat && String(p.cat_id) !== String(cat)) return false;
                    if (brand && String(p.brand_id) !== String(brand)) return false;
                    if (q && !(String(p.product_title || '').toLowerCase().includes(q) ||
                            String(p.product_desc || '').toLowerCase().includes(q)))
                        return false;
                    return true;
                });

                $grid.empty();

                if (filtered.length === 0) {
                    $empty.show();
                    $resultsInfo.text('');
                    return;
                }

                $empty.hide();
                $resultsInfo.text(`${filtered.length} product${filtered.length > 1 ? 's' : ''} found`);

                filtered.forEach(p => {
                    const img = imageFor(p) ? `../${imageFor(p)}` : 'https://via.placeholder.com/400x300?text=No+Image';
                    const card = $(`
                        <article class="card" data-id="${p.product_id}">
                            <img class="card-image" src="${img}" alt="${p.product_title || 'Product'}">
                            <div class="card-content">
                                <h3 class="card-title">${p.product_title || 'Unnamed Product'}</h3>
                                <div class="card-meta">${p.cat_name || 'Uncategorized'} • ${p.brand_name || 'No Brand'}</div>
                                <p class="card-desc">${p.product_desc || 'No description available.'}</p>
                            </div>
                            <div class="card-footer">
                                <div class="card-price">₵${Number(p.product_price || 0).toFixed(2)}</div>
                                <button class="btn-view view-btn" data-id="${p.product_id}">View Details</button>
                            </div>
                        </article>
                    `);
                    $grid.append(card);
                });
            }


            $search.on('keypress', function(e) {
                if (e.which === 13) {
                    e.preventDefault();
                    const query = $search.val().trim();
                    if (query) {
                        window.location.href = `product_search_results.php?query=${encodeURIComponent(query)}`;
                    }
                }
            });


            $searchBtn.on('click', function(e) {
                e.preventDefault();
                const query = $search.val().trim();
                if (query) {
                    window.location.href = `product_search_results.php?query=${encodeURIComponent(query)}`;
                }
            });


            $filterCategory.on('change', function() {
                const selectedCat = $(this).val();
                loadBrands(selectedCat);
                $filterBrand.val('');
                render();
            });
            $filterBrand.on('change', render);


            $clear.on('click', function() {
                $search.val('');
                $filterCategory.val('');
                $filterBrand.val('');
                loadResults();
            });


            $(document).on('click', '.view-btn', function() {
                const id = $(this).data('id');
                window.location.href = `single_product.php?product_id=${id}`;
            });

            loadCategories();
            loadResults();
        });
    </script>
</body>

</html>