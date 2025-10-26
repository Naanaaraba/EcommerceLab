<?php

if (!isset($_GET['product_id'])) {
    die('Product ID is required.');
}
$product_id = intval($_GET['product_id']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Details</title>
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
            max-width: 900px;
            margin: auto;
        }

        .product-container {
            display: flex;
            flex-wrap: wrap;
            gap: 20px;
            background: #fff;
            border-radius: 12px;
            box-shadow: 0 2px 6px rgba(0, 0, 0, 0.06);
            padding: 20px;
        }

        .product-image {
            flex: 1 1 300px;
            max-width: 400px;
        }

        .product-image img {
            width: 100%;
            border-radius: 10px;
            object-fit: cover;
        }

        .product-details {
            flex: 1 1 300px;
            display: flex;
            flex-direction: column;
            gap: 12px;
        }

        .product-details h2 {
            margin: 0;
            font-size: 1.5rem;
        }

        .product-details .category-brand {
            font-size: 14px;
            color: #6b7280;
        }

        .product-details .price {
            font-size: 1.3rem;
            font-weight: 700;
            color: #0d6efd;
        }

        .product-details .desc,
        .product-details .keywords {
            font-size: 14px;
            color: #4b5563;
        }

        .btn-add-cart {
            background: #0d6efd;
            color: #fff;
            border: none;
            border-radius: 6px;
            padding: 10px 16px;
            font-size: 14px;
            cursor: pointer;
            width: fit-content;
        }

        .btn-add-cart:hover {
            background: #0848c7;
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
    <header>Product Details</header>

    <main>
        <a href="all_product.php" class="back-link">&larr; Back to Products</a>
        <div id="product_container" class="product-container">
            <div class="product-image">
                <img id="prod_img" src="https://via.placeholder.com/400x300?text=Loading..." alt="Product Image">
            </div>
            <div class="product-details">
                <h2 id="prod_title">Loading...</h2>
                <div class="category-brand">
                    <span id="prod_category">Category: --</span> •
                    <span id="prod_brand">Brand: --</span>
                </div>
                <div class="price" id="prod_price">₵0.00</div>
                <div class="desc" id="prod_desc">Loading description...</div>
                <div class="keywords" id="prod_keywords"></div>
                <button class="btn-add-cart">Add to Cart</button>
            </div>
        </div>
    </main>

    <script>
        $(document).ready(function() {
            const productId = <?= $product_id ?>;

            function fetchProduct(id) {
                $.ajax({
                    url: `../actions/product_actions.php?action=view_single&product_id=${id}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        console.log({
                            res
                        })
                        if (res.status === 'success') {
                            const p = res.data;
                            const imgSrc = p.image_url ? `../${p.image_url}` : 'https://via.placeholder.com/400x300?text=No+Image';
                            $('#prod_img').attr('src', imgSrc);
                            $('#prod_title').text(p.product_title || 'Unnamed Product');
                            $('#prod_category').text('Category: ' + (p.cat_name || 'Uncategorized'));
                            $('#prod_brand').text('Brand: ' + (p.brand_name || 'No Brand'));
                            $('#prod_price').text('₵' + Number(p.product_price || 0).toFixed(2));
                            $('#prod_desc').text(p.product_desc || 'No description available.');
                            $('#prod_keywords').text(p.product_keywords ? 'Keywords: ' + p.product_keywords : '');
                        } else {
                            $('#product_container').html('<p>Product not found.</p>');
                        }
                    },
                    error: function() {
                        $('#product_container').html('<p>Failed to load product details.</p>');
                    }
                });
            }

            fetchProduct(productId);
        });
    </script>
</body>

</html>