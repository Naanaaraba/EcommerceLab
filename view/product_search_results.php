<?php

$query = isset($_GET['query']) ? trim($_GET['query']) : '';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Search Results for "<?php echo htmlspecialchars($query); ?>"</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: "Inter", sans-serif;
            background: #f9fafb;
            margin: 0;
            padding: 0;
            color: #111;
        }

        header {
            background: #0d6efd;
            color: white;
            padding: 18px 30px;
            font-size: 1.3rem;
            font-weight: 600;
        }

        main {
            padding: 30px;
            max-width: 1200px;
            margin: auto;
        }

        .toolbar {
            display: flex;
            flex-wrap: wrap;
            align-items: center;
            justify-content: space-between;
            gap: 10px;
            margin-bottom: 24px;
        }

        .filters {
            display: flex;
            flex-wrap: wrap;
            gap: 10px;
        }

        select,
        input[type="search"] {
            padding: 8px 10px;
            border: 1px solid #ccc;
            border-radius: 6px;
            font-size: 14px;
        }

        input[type="search"] {
            flex: 1;
            min-width: 180px;
        }

        .grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(240px, 1fr));
            gap: 20px;
            margin-top: 24px;
        }

        .card {
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
            display: flex;
            flex-direction: column;
            transition: transform 0.15s ease, box-shadow 0.15s ease;
        }

        .card:hover {
            transform: translateY(-4px);
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
        }

        .card img.thumb {
            width: 100%;
            height: 180px;
            object-fit: cover;
            background: #f2f3f6;
        }

        .card-content {
            flex: 1;
            display: flex;
            flex-direction: column;
            padding: 14px;
        }

        .card-title {
            font-weight: 600;
            font-size: 15px;
            margin: 0 0 4px 0;
            color: #111;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .card-category {
            font-size: 13px;
            color: #6b7280;
            margin-bottom: 8px;
        }

        .card-desc {
            color: #4b5563;
            font-size: 13px;
            line-height: 1.4;
            margin-bottom: 10px;
            flex-grow: 1;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .card-footer {
            display: flex;
            align-items: center;
            justify-content: space-between;
            border-top: 1px solid #e5e7eb;
            padding: 10px 14px;
            background: #fafbfc;
        }

        .card-price {
            font-weight: 700;
            color: #0d6efd;
            font-size: 15px;
        }

        .btn-small {
            background: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 6px 10px;
            font-size: 13px;
            cursor: pointer;
            transition: background 0.15s ease;
        }

        .btn-small:hover {
            background: #0848c7;
        }

        .empty {
            text-align: center;
            color: #6b7280;
            font-size: 16px;
            padding: 40px 0;
        }

        .results-info {
            font-size: 14px;
            color: #555;
            margin-top: 8px;
        }

        .back-link {
            margin-bottom: 20px;
            display: inline-block;
            color: #0d6efd;
            text-decoration: none;
        }

        .back-link:hover {
            text-decoration: underline;
        }
    </style>
</head>

<body>
    <header>Search Results for "<?php echo htmlspecialchars($query); ?>"</header>
    <main>

        <a href="all_product.php" class="back-link">&larr; Back to Products</a>
        <div class="toolbar">
            <input type="search" id="search" placeholder="Search products..." value="<?php echo htmlspecialchars($query); ?>">
            <button id="clear_search">Clear</button>
            <div class="filters">
                <select id="filter_category">
                    <option value="">All Categories</option>
                </select>
                <select id="filter_brand">
                    <option value="">All Brands</option>
                </select>
            </div>
        </div>
        <div class="results-info" id="results_info"></div>
        <div id="product_grid" class="grid"></div>
        <div id="empty_state" class="empty" style="display:none;">No products found.</div>
    </main>

    <script>
        $(document).ready(function() {
            const $grid = $('#product_grid');
            const $empty = $('#empty_state');
            const $search = $('#search');
            const $clear = $('#clear_search');
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
                    <img class="thumb" src="${img}" alt="${p.product_title || 'Product'}">
                    <div class="card-content">
                        <h3 class="card-title">${p.product_title || 'Unnamed Product'}</h3>
                        <div class="card-category">${p.cat_name || 'Uncategorized'} • ${p.brand_name || 'No Brand'}</div>
                        <p class="card-desc">${p.product_desc || 'No description available.'}</p>
                    </div>
                    <div class="card-footer">
                        <div class="card-price">₵${Number(p.product_price || 0).toFixed(2)}</div>
                        <button class="btn-small view-btn" data-id="${p.product_id}">View</button>
                    </div>
                </article>
            `);
                    $grid.append(card);
                });
            }

           
            $search.on('keypress', function(e) {
                if (e.which === 13) loadResults();
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