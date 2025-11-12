<?php
include_once '../settings/core.php';
$is_logged_in = check_login();

if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = [];
}
$customer_id = intval(get_user_id());
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Shopping Cart - ShopVerse</title>
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
        .cart-container {
            padding: 8rem 3rem 3rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        /* Typography */
        .page-title {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 300;
            font-size: 2.5rem;
            color: var(--stone);
            margin-bottom: 0.5rem;
            letter-spacing: 1px;
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
            margin-bottom: 2rem;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .back-link:hover {
            color: var(--clay);
        }

        /* Cart Layout */
        .cart-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
        }

        /* Cart Items */
        .cart-section {
            background: rgba(10, 17, 40, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(232, 228, 217, 0.15);
            padding: 2.5rem;
        }

        .section-title {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 400;
            font-size: 1.3rem;
            color: var(--stone);
            margin-bottom: 2rem;
            letter-spacing: 1px;
        }

        .cart-item {
            display: grid;
            grid-template-columns: 100px 1fr auto auto;
            gap: 1.5rem;
            align-items: center;
            padding: 1.5rem 0;
            border-bottom: 1px solid rgba(232, 228, 217, 0.1);
        }

        .cart-item:last-child {
            border-bottom: none;
        }

        .item-image {
            width: 100px;
            height: 100px;
            object-fit: cover;
            border: 1px solid rgba(232, 228, 217, 0.1);
        }

        .item-details {
            display: flex;
            flex-direction: column;
            gap: 0.5rem;
        }

        .item-title {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 400;
            font-size: 1.1rem;
            color: var(--stone);
        }

        .item-price {
            font-family: 'Chivo Mono', monospace;
            font-size: 0.9rem;
            color: var(--clay);
        }

        .quantity-controls {
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }

        .quantity-input {
            width: 60px;
            background: rgba(232, 228, 217, 0.05);
            border: 1px solid rgba(232, 228, 217, 0.2);
            color: var(--stone);
            padding: 0.5rem;
            text-align: center;
            font-family: 'Figtree', sans-serif;
        }

        .btn-quantity {
            background: transparent;
            border: 1px solid rgba(232, 228, 217, 0.3);
            color: var(--stone);
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            cursor: pointer;
            transition: all 0.3s ease;
        }

        .btn-quantity:hover {
            border-color: var(--clay);
            color: var(--clay);
        }

        .item-total {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 500;
            color: var(--stone);
            min-width: 80px;
            text-align: right;
        }

        .btn-remove {
            background: transparent;
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: rgba(220, 53, 69, 0.7);
            padding: 0.5rem 1rem;
            font-family: 'Chivo Mono', monospace;
            font-size: 0.7rem;
            letter-spacing: 1px;
            cursor: pointer;
            transition: all 0.3s ease;
            text-transform: uppercase;
        }

        .btn-remove:hover {
            background: rgba(220, 53, 69, 0.1);
            border-color: #dc3545;
            color: #dc3545;
        }

        /* Cart Summary */
        .summary-section {
            background: rgba(10, 17, 40, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(232, 228, 217, 0.15);
            padding: 2.5rem;
            height: fit-content;
        }

        .summary-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(232, 228, 217, 0.1);
        }

        .summary-row:last-child {
            border-bottom: none;
            font-weight: 600;
        }

        .summary-label {
            font-family: 'Figtree', sans-serif;
            color: var(--stone);
            opacity: 0.8;
        }

        .summary-value {
            font-family: 'Chivo Mono', monospace;
            color: var(--stone);
        }

        .total-row {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.2rem;
            color: var(--clay);
        }

        /* Buttons */
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
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 1.5rem;
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
            display: block;
            width: 100%;
            text-align: center;
            margin-top: 1rem;
        }

        .btn-secondary:hover {
            background: var(--clay);
            color: var(--deep-navy);
        }

        /* Empty State */
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
            margin-bottom: 2rem;
        }

        /* Loading State */
        .loading-state {
            text-align: center;
            padding: 3rem;
            color: rgba(232, 228, 217, 0.5);
        }

        .loading-spinner {
            border: 3px solid rgba(232, 228, 217, 0.1);
            border-radius: 50%;
            border-top: 3px solid var(--clay);
            width: 40px;
            height: 40px;
            animation: spin 1s linear infinite;
            margin: 0 auto 1rem;
        }

        @keyframes spin {
            0% {
                transform: rotate(0deg);
            }

            100% {
                transform: rotate(360deg);
            }
        }

        /* Responsive */
        @media (max-width: 968px) {
            .cart-layout {
                grid-template-columns: 1fr;
                gap: 2rem;
            }

            .cart-item {
                grid-template-columns: 80px 1fr;
                gap: 1rem;
            }

            .quantity-controls {
                grid-column: 1 / -1;
                justify-content: flex-start;
            }

            .item-total,
            .btn-remove {
                grid-column: 1 / -1;
                text-align: left;
                margin-top: 1rem;
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

            .cart-container {
                padding: 7rem 1.5rem 2rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .page-subtitle {
                font-size: 0.9rem;
            }

            .cart-section,
            .summary-section {
                padding: 2rem;
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
            <a href="all_product.php" class="nav-link">Products</a>
            <a href="cart.php" class="nav-link">
                My Cart <span class="cart-count" id="nav-cart-count">0</span>
            </a>
            <?php if ($is_logged_in): ?>
                <a href="../login/logout.php" class="nav-link">Logout</a>
            <?php else: ?>
                <a href="../login/login.php" class="nav-link">Login</a>
            <?php endif; ?>
        </div>
    </nav>


    <div class="cart-container">
        <a href="all_product.php" class="back-link">
            <span>←</span> Continue Shopping
        </a>

        <h1 class="page-title">Your Cart</h1>
        <p class="page-subtitle">Review Your Curated Selection</p>

 
        <div id="loading_state" class="loading-state">
            <div class="loading-spinner"></div>
            <p>Loading your cart...</p>
        </div>

    
        <div id="empty_state" class="empty-state" style="display: none;">
            <h3>Your Cart is Empty</h3>
            <p>Discover exceptional pieces to add to your collection</p>
            <a href="all_product.php" class="btn-primary">Explore Products</a>
        </div>

   
        <div id="cart_content" style="display: none;">
            <div class="cart-layout">
     
                <div class="cart-section">
                    <h3 class="section-title" id="cart-items-title">Cart Items</h3>
                    <div id="cart_items_container"></div>
                    <button id="empty_cart_btn" class="btn-secondary">Clear Cart</button>
                </div>

              
                <div class="summary-section">
                    <h3 class="section-title">Order Summary</h3>
                    <div id="order_summary">
                        <div class="summary-row">
                            <span class="summary-label">Subtotal</span>
                            <span class="summary-value" id="subtotal">₵0.00</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Shipping</span>
                            <span class="summary-value" id="shipping">₵0.00</span>
                        </div>
                        <div class="summary-row">
                            <span class="summary-label">Tax</span>
                            <span class="summary-value" id="tax">₵0.00</span>
                        </div>
                        <div class="summary-row total-row">
                            <span class="summary-label">Total</span>
                            <span class="summary-value" id="total">₵0.00</span>
                        </div>
                    </div>
                    <a href="checkout.php" class="btn-primary">Proceed to Checkout</a>
                    <a href="all_product.php" class="btn-secondary">Continue Shopping</a>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/cart_count.js"></script>
    <script src="../js/cart.js"></script>
</body>

</html>