<?php
include_once '../settings/core.php';
$is_logged_in = check_login();

if (!isset($_GET['product_id'])) {
    die('Product ID is required.');
}
$product_id = intval($_GET['product_id']);
$customer_id = intval(get_user_id());

// echo $customer_id;
// exit;
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Product Details - ShopVerse</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
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

        /* Fluid Background */
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

        /* Navigation */
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

        .cart-count {
            background: var(--clay);
            color: var(--deep-navy);
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.7rem;
            margin-left: 5px;
        }

        /* Main Content */
        .product-container {
            padding: 8rem 3rem 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Back Link */
        .back-link {
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
            color: var(--sage);
            text-decoration: none;
            font-family: 'Chivo Mono', monospace;
            font-size: 0.8rem;
            letter-spacing: 1px;
            margin-bottom: 3rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .back-link:hover {
            color: var(--clay);
        }

        /* Product Layout */
        .product-layout {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 4rem;
            align-items: start;
        }

        /* Product Image */
        .product-image-section {
            position: relative;
        }

        .product-image {
            width: 100%;
            height: 500px;
            object-fit: cover;
            background: rgba(232, 228, 217, 0.05);
            border: 1px solid rgba(232, 228, 217, 0.15);
            transition: all 0.4s ease;
        }

        .product-image:hover {
            border-color: var(--clay);
        }

        .image-placeholder {
            width: 100%;
            height: 500px;
            background: rgba(232, 228, 217, 0.05);
            border: 1px solid rgba(232, 228, 217, 0.15);
            display: flex;
            align-items: center;
            justify-content: center;
            color: rgba(232, 228, 217, 0.4);
            font-family: 'Chivo Mono', monospace;
            font-size: 0.9rem;
            letter-spacing: 1px;
            text-transform: uppercase;
        }

        /* Product Details */
        .product-details-section {
            background: rgba(10, 17, 40, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(232, 228, 217, 0.15);
            padding: 2.5rem;
            position: relative;
            overflow: hidden;
        }

        .product-details-section::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(201, 125, 96, 0.05), transparent);
            transition: left 0.7s ease;
        }

        .product-details-section:hover::before {
            left: 100%;
        }

        /* Typography */
        .product-title {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 400;
            font-size: 2rem;
            color: var(--stone);
            margin-bottom: 1rem;
            line-height: 1.2;
        }

        .product-meta {
            font-family: 'Chivo Mono', monospace;
            font-size: 0.85rem;
            color: var(--sage);
            letter-spacing: 1.5px;
            margin-bottom: 2rem;
            text-transform: uppercase;
            opacity: 0.8;
        }

        .product-price {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 500;
            font-size: 2.5rem;
            color: var(--clay);
            margin-bottom: 2rem;
        }

        .product-description {
            color: rgba(232, 228, 217, 0.8);
            font-size: 1rem;
            line-height: 1.6;
            margin-bottom: 2rem;
        }

        .product-keywords {
            font-family: 'Chivo Mono', monospace;
            font-size: 0.8rem;
            color: var(--sage);
            letter-spacing: 1px;
            margin-bottom: 2.5rem;
            opacity: 0.7;
        }

        /* Buttons */
        .action-buttons {
            display: flex;
            gap: 1rem;
            flex-wrap: wrap;
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
            flex: 1;
            min-width: 200px;
            text-align: center;
        }

        .btn-primary:hover {
            background: var(--stone);
            color: var(--deep-navy);
            border-color: var(--stone);
        }

        .btn-secondary {
            background: transparent;
            border: 1px solid var(--clay);
            color: var(--clay);
            padding: 1rem 2rem;
            font-family: 'Chivo Mono', monospace;
            font-size: 0.85rem;
            letter-spacing: 1.5px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-decoration: none;
            text-transform: uppercase;
            flex: 1;
            min-width: 200px;
            text-align: center;
        }

        .btn-secondary:hover {
            background: var(--clay);
            color: var(--deep-navy);
        }

      
        .loading {
            opacity: 0.6;
            pointer-events: none;
        }

        .skeleton {
            background: linear-gradient(90deg, rgba(232, 228, 217, 0.1) 25%, rgba(232, 228, 217, 0.2) 50%, rgba(232, 228, 217, 0.1) 75%);
            background-size: 200% 100%;
            animation: loading 1.5s infinite;
            border-radius: 2px;
        }

        @keyframes loading {
            0% {
                background-position: 200% 0;
            }

            100% {
                background-position: -200% 0;
            }
        }

        .skeleton-title {
            height: 2rem;
            width: 80%;
            margin-bottom: 1rem;
        }

        .skeleton-meta {
            height: 1rem;
            width: 60%;
            margin-bottom: 2rem;
        }

        .skeleton-price {
            height: 2.5rem;
            width: 40%;
            margin-bottom: 2rem;
        }

        .skeleton-desc {
            height: 1rem;
            width: 100%;
            margin-bottom: 0.5rem;
        }

        .skeleton-desc.short {
            width: 80%;
        }

       
        .error-state {
            text-align: center;
            padding: 4rem 2rem;
            color: rgba(232, 228, 217, 0.5);
        }

        .error-state h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 300;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .error-state p {
            font-family: 'Figtree', sans-serif;
            font-size: 0.9rem;
            opacity: 0.7;
            margin-bottom: 2rem;
        }

       
        @media (max-width: 968px) {
            .product-layout {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .product-image,
            .image-placeholder {
                height: 400px;
            }
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

            .product-container {
                padding: 7rem 1.5rem 2rem;
            }

            .product-title {
                font-size: 1.5rem;
            }

            .product-price {
                font-size: 2rem;
            }

            .product-details-section {
                padding: 2rem;
            }

            .action-buttons {
                flex-direction: column;
            }

            .btn-primary,
            .btn-secondary {
                min-width: auto;
            }
        }

        @media (max-width: 480px) {

            .product-image,
            .image-placeholder {
                height: 300px;
            }

            .product-title {
                font-size: 1.3rem;
            }

            .product-price {
                font-size: 1.8rem;
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
            <a href="all_product.php" class="nav-link">Products</a>
            <?php if ($is_logged_in): ?>
                <a href="../login/logout.php" class="nav-link">Logout</a>
            <?php else: ?>
                <a href="../login/login.php" class="nav-link">Login</a>
            <?php endif; ?>
        </div>
    </nav>


    <div class="product-container">
        <a href="all_product.php" class="back-link">
            <span>←</span> Back to Products
        </a>

        <div id="product_content">

            <div id="loading_state">
                <div class="product-layout">
                    <div class="product-image-section">
                        <div class="image-placeholder skeleton">Loading Image</div>
                    </div>
                    <div class="product-details-section">
                        <div class="skeleton skeleton-title"></div>
                        <div class="skeleton skeleton-meta"></div>
                        <div class="skeleton skeleton-price"></div>
                        <div class="skeleton skeleton-desc"></div>
                        <div class="skeleton skeleton-desc"></div>
                        <div class="skeleton skeleton-desc short"></div>
                        <div class="action-buttons">
                            <div class="skeleton" style="height: 3rem; width: 100%;"></div>
                        </div>
                    </div>
                </div>
            </div>


            <div id="product_display" style="display: none;">
                <div class="product-layout">
                    <div class="product-image-section">
                        <img id="prod_img" class="product-image" src="" alt="Product Image">
                    </div>
                    <div class="product-details-section">
                        <h1 class="product-title" id="prod_title"></h1>
                        <div class="product-meta">
                            <span id="prod_category">Category: --</span> •
                            <span id="prod_brand">Brand: --</span>
                        </div>
                        <div class="product-price" id="prod_price"></div>
                        <div class="customer_id" data-customer_id="<?php ?>"></div>
                        <div class="product-description" id="prod_desc"></div>
                        <div class="product-keywords" id="prod_keywords"></div>
                        <div class="action-buttons">
                            <button class="btn-primary">Add to Cart</button>
                            <button class="btn-secondary">Save to Wishlist</button>
                        </div>
                    </div>
                </div>
            </div>


            <div id="error_state" class="error-state" style="display: none;">
                <h3>Product Not Found</h3>
                <p>The product you're looking for doesn't exist or is no longer available.</p>
                <a href="all_product.php" class="btn-primary">Back to Products</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        $(document).ready(function() {
            const productId = <?= $product_id ?>;
            const customerId = <?= $customer_id ?>;
            const $loading = $('#loading_state');
            const $display = $('#product_display');
            const $error = $('#error_state');

            function fetchProduct(id) {
                $.ajax({
                    url: `../actions/product_actions.php?action=view_single&product_id=${id}`,
                    type: 'GET',
                    dataType: 'json',
                    success: function(res) {
                        console.log('Product response:', res);

                        if (res.status === 'success' && res.data) {
                            const p = res.data;
                            const imgSrc = p.product_image ? `../${p.product_image}` :
                                p.image_url ? `../${p.image_url}` :
                                'https://via.placeholder.com/600x400?text=No+Image';

                            $('#prod_img').attr('src', imgSrc).attr('alt', p.product_title || 'Product Image');
                            $('#prod_title').text(p.product_title || 'Unnamed Product');
                            $('#prod_category').text('Category: ' + (p.cat_name || 'Uncategorized'));
                            $('#prod_brand').text('Brand: ' + (p.brand_name || 'No Brand'));
                            $('#prod_price').text('₵' + Number(p.product_price || 0).toFixed(2));
                            $('#prod_desc').text(p.product_desc || 'No description available.');

                            if (p.product_keywords) {
                                $('#prod_keywords').text('Keywords: ' + p.product_keywords);
                            } else {
                                $('#prod_keywords').hide();
                            }

                            $loading.hide();
                            $display.show();
                        } else {
                            showError();
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error fetching product:', error);
                        showError();
                    }
                });
            }

            function showError() {
                $loading.hide();
                $error.show();
            }
            $(document).on('click', '.btn-primary', function(e) {
                e.preventDefault();

                const productTitle = $('#prod_title').text();
                // const productId = $(this).data('id');
                //const customerId = $(this).data('customer'); 

                $.ajax({
                    url: '../actions/add_to_cart_action.php',
                    method: 'POST',
                    data: {
                        product_id: productId,
                        customer_id: customerId
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.status === 'success') {
                            Swal.fire({
                                title: 'Added to Cart!',
                                text: `"${productTitle}" has been added to your cart.`,
                                icon: 'success',
                                confirmButtonColor: '#28a745',
                                confirmButtonText: 'OK'
                            });
                        } else {
                            Swal.fire({
                                title: 'Failed!',
                                text: `Failed to add "${productTitle}" to cart. Please try again.`,
                                icon: 'error',
                                confirmButtonColor: '#d33',
                                confirmButtonText: 'Try Again'
                            });
                        }
                    },
                    error: function(xhr, status, error) {
                        console.error('Error adding to cart:', error);
                        Swal.fire({
                            title: 'Error!',
                            text: 'Something went wrong. Please try again later.',
                            icon: 'error',
                            confirmButtonColor: '#d33',
                            confirmButtonText: 'Close'
                        });
                    }
                });
            });





            $(document).on('click', '.btn-secondary', function() {
                const productTitle = $('#prod_title').text();
                alert(`"${productTitle}" has been saved to your wishlist!`);
            });


            fetchProduct(productId);
        });
    </script>
    <script src="../js/cart_count.js"></script>
</body>

</html>