<?php
include_once '../settings/core.php';
$is_logged_in = check_login();

$order_number = $_GET['order'] ?? ($_SESSION['last_order'] ?? 'SV' . date('Ymd') . rand(1000, 9999));
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Order Confirmation - ShopVerse</title>
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

        .cart-count {
            background: var(--clay);
            color: var(--deep-navy);
            border-radius: 50%;
            padding: 2px 6px;
            font-size: 0.7rem;
            margin-left: 5px;
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


        .confirmation-container {
            padding: 8rem 3rem 3rem;
            max-width: 800px;
            margin: 0 auto;
            text-align: center;
        }


        .page-title {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 300;
            font-size: 2.5rem;
            color: var(--stone);
            margin-bottom: 1rem;
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


        .confirmation-card {
            background: rgba(10, 17, 40, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(232, 228, 217, 0.15);
            padding: 3rem;
            margin-bottom: 2rem;
        }

        .success-icon {
            font-size: 4rem;
            color: var(--sage);
            margin-bottom: 2rem;
        }

        .order-number {
            font-family: 'Chivo Mono', monospace;
            font-size: 1.2rem;
            color: var(--clay);
            margin-bottom: 2rem;
            letter-spacing: 2px;
        }

        .confirmation-message {
            font-size: 1.1rem;
            line-height: 1.6;
            color: rgba(232, 228, 217, 0.8);
            margin-bottom: 2rem;
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
            display: inline-block;
            margin: 0.5rem;
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
            display: inline-block;
            margin: 0.5rem;
        }

        .btn-secondary:hover {
            background: var(--clay);
            color: var(--deep-navy);
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

            .confirmation-container {
                padding: 7rem 1.5rem 2rem;
            }

            .page-title {
                font-size: 2rem;
            }

            .page-subtitle {
                font-size: 0.9rem;
            }

            .confirmation-card {
                padding: 2rem;
            }

            .btn-primary,
            .btn-secondary {
                display: block;
                width: 100%;
                margin: 0.5rem 0;
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
            <a href="cart.php" class="nav-link">My Cart<span class="cart-count" id="nav-cart-count">0</span></a></a>
            <?php if ($is_logged_in): ?>
                <a href="../login/logout.php" class="nav-link">Logout</a>
            <?php else: ?>
                <a href="../login/login.php" class="nav-link">Login</a>
            <?php endif; ?>
        </div>
    </nav>


    <div class="confirmation-container">
        <div class="confirmation-card">
            <div class="success-icon">✓</div>
            <h1 class="page-title">Order Confirmed</h1>
            <p class="page-subtitle">Thank You for Your Purchase</p>

            <div class="order-number">Order #<?php echo $order_number; ?></div>

            <p class="confirmation-message">
                Your order has been successfully processed. You will receive a confirmation email shortly
                with your order details and tracking information. Our team is preparing your carefully
                curated selection for shipment.
            </p>

            <div class="action-buttons">
                <a href="all_product.php" class="btn-primary">Continue Shopping</a>
                <a href="../index.php" class="btn-secondary">Return Home</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="../js/cart_count.js"></script>
</body>

</html>