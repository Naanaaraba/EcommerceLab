<?php
include_once '../settings/core.php';
$is_logged_in = check_login();

$customer_id = intval(get_user_id());

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Checkout - ShopVerse</title>
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

        .cart-count {
            background: var(--clay);
            color: var(--deep-navy);
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.7rem;
            margin-left: 5px;
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


        .checkout-container {
            padding: 8rem 3rem 3rem;
            max-width: 1200px;
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


        .checkout-layout {
            display: grid;
            grid-template-columns: 2fr 1fr;
            gap: 3rem;
        }


        .form-section {
            background: rgba(10, 17, 40, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(232, 228, 217, 0.15);
            padding: 2.5rem;
            margin-bottom: 2rem;
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
            gap: 1rem;
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
        }


        .order-item {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 1rem 0;
            border-bottom: 1px solid rgba(232, 228, 217, 0.1);
        }

        .order-item:last-child {
            border-bottom: none;
        }

        .item-info {
            display: flex;
            align-items: center;
            gap: 1rem;
        }

        .item-image {
            width: 60px;
            height: 60px;
            object-fit: cover;
            border: 1px solid rgba(232, 228, 217, 0.1);
        }

        .item-name {
            font-family: 'Figtree', sans-serif;
            font-size: 0.9rem;
            color: var(--stone);
        }

        .item-quantity {
            font-family: 'Chivo Mono', monospace;
            font-size: 0.8rem;
            color: var(--sage);
        }

        .item-price {
            font-family: 'Chivo Mono', monospace;
            color: var(--stone);
        }

        .summary-totals {
            margin-top: 2rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(232, 228, 217, 0.1);
        }

        .total-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: 0.5rem 0;
        }

        .total-row.final {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.2rem;
            color: var(--clay);
            border-top: 1px solid rgba(232, 228, 217, 0.2);
            padding-top: 1rem;
            margin-top: 1rem;
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


        @media (max-width: 968px) {
            .checkout-layout {
                grid-template-columns: 1fr;
                gap: 2rem;
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

            .checkout-container {
                padding: 7rem 1.5rem 2rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .page-subtitle {
                font-size: 0.9rem;
            }

            .form-section {
                padding: 2rem;
            }

            .form-row {
                grid-template-columns: 1fr;
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
            <a href="cart.php" class="nav-link">Cart<span class="cart-count" id="nav-cart-count">0</span></a>
            <?php if ($is_logged_in): ?>
                <a href="../login/logout.php" class="nav-link">Logout</a>
            <?php else: ?>
                <a href="../login/login.php" class="nav-link">Login</a>
            <?php endif; ?>
        </div>
    </nav>


    <div class="checkout-container">
        <a href="cart.php" class="back-link" style="display: inline-flex; align-items: center; gap: 0.5rem; color: var(--sage); text-decoration: none; font-family: 'Chivo Mono', monospace; font-size: 0.8rem; letter-spacing: 1px; margin-bottom: 2rem; transition: all 0.3s ease; text-transform: uppercase;">
            <span>←</span> Back to Cart
        </a>

        <h1 class="page-title">Checkout</h1>
        <p class="page-subtitle">Complete Your Purchase</p>

        <form method="POST" id="checkout-form">
            <div class="checkout-layout">

                <div>

                    <div class="form-section">
                        <h3 class="section-title">Shipping Information</h3>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">First Name</label>
                                <input type="text" class="form-control" name="first_name" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Last Name</label>
                                <input type="text" class="form-control" name="last_name" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Email Address</label>
                            <input type="email" class="form-control" name="email" required>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Address</label>
                            <input type="text" class="form-control" name="address" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">City</label>
                                <input type="text" class="form-control" name="city" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">Postal Code</label>
                                <input type="text" class="form-control" name="postal_code" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Country</label>
                            <select class="form-control" name="country" required>
                                <option value="">Select Country</option>
                                <option value="GH">Ghana</option>
                                <option value="US">United States</option>
                                <option value="UK">United Kingdom</option>
                                <option value="CA">Canada</option>
                            </select>
                        </div>
                    </div>


                    <div class="form-section">
                        <h3 class="section-title">Payment Information</h3>

                        <div class="form-group">
                            <label class="form-label">Card Number</label>
                            <input type="text" class="form-control" placeholder="1234 5678 9012 3456" required>
                        </div>

                        <div class="form-row">
                            <div class="form-group">
                                <label class="form-label">Expiry Date</label>
                                <input type="text" class="form-control" placeholder="MM/YY" required>
                            </div>
                            <div class="form-group">
                                <label class="form-label">CVV</label>
                                <input type="text" class="form-control" placeholder="123" required>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="form-label">Cardholder Name</label>
                            <input type="text" class="form-control" required>
                        </div>
                    </div>
                </div>


                <div class="form-section">
                    <h3 class="section-title">Order Summary</h3>

                    <?php foreach ($_SESSION['cart'] as $item): ?>
                        <div class="order-item">
                            <div class="item-info">
                                <img src="<?php echo $item['product_image']; ?>" alt="<?php echo $item['product_title']; ?>" class="item-image">
                                <div>
                                    <div class="item-name"><?php echo $item['product_title']; ?></div>
                                    <div class="item-quantity">Qty: <?php echo $item['quantity']; ?></div>
                                </div>
                            </div>
                            <div class="item-price">₵<?php echo number_format($item['product_price'] * $item['quantity'], 2); ?></div>
                        </div>
                    <?php endforeach; ?>

                    <div class="summary-totals">
                        <div class="total-row">
                            <span>Subtotal</span>
                            <span>₵<?php echo number_format($subtotal, 2); ?></span>
                        </div>
                        <div class="total-row">
                            <span>Shipping</span>
                            <span>₵<?php echo number_format($shipping, 2); ?></span>
                        </div>
                        <div class="total-row">
                            <span>Tax</span>
                            <span>₵<?php echo number_format($tax, 2); ?></span>
                        </div>
                        <div class="total-row final">
                            <span>Total</span>
                            <span>₵<?php echo number_format($total, 2); ?></span>
                        </div>
                    </div>

                    <button type="submit" class="btn-primary">Complete Purchase</button>
                    <a href="cart.php" class="btn-secondary">Modify Cart</a>
                </div>
            </div>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
   
    <script src="../js/checkout.js"></script>
    <script src="../js/cart_count.js"></script>
</body>

</html>