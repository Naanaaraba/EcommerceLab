<?php
include_once '../settings/core.php';
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Login - ShopVerse</title>
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
            opacity: 0.3;
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
            padding: 2rem 3rem;
            z-index: 1000;
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: rgba(10, 17, 40, 0.9);
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

        .back-home {
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

        .back-home:hover {
            opacity: 1;
            color: var(--clay);
        }

     
        .login-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 8rem 2rem 4rem;
        }

        .login-card {
            background: rgba(10, 17, 40, 0.8);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(232, 228, 217, 0.15);
            border-radius: 0;
            padding: 3rem;
            max-width: 450px;
            width: 100%;
            position: relative;
            overflow: hidden;
            transition: all 0.4s ease;
        }

        .login-card:hover {
            border-color: var(--clay);
            transform: translateY(-2px);
        }

        .login-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(201, 125, 96, 0.08), transparent);
            transition: left 0.7s ease;
        }

        .login-card:hover::before {
            left: 100%;
        }

       
        .login-title {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 300;
            font-size: 2rem;
            color: var(--stone);
            margin-bottom: 0.5rem;
            text-align: center;
            letter-spacing: 1px;
        }

        .login-subtitle {
            font-family: 'Chivo Mono', monospace;
            font-weight: 300;
            font-size: 0.9rem;
            color: var(--sage);
            letter-spacing: 2px;
            margin-bottom: 2.5rem;
            text-align: center;
            text-transform: uppercase;
            opacity: 0.8;
        }

        
        .form-group {
            margin-bottom: 2rem;
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

       
        .login-btn {
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
            display: block;
            width: 100%;
            text-transform: uppercase;
            margin-top: 1.5rem;
        }

        .login-btn:hover {
            background: var(--stone);
            color: var(--deep-navy);
            border-color: var(--stone);
        }

      
        .login-footer {
            text-align: center;
            margin-top: 2.5rem;
            padding-top: 2rem;
            border-top: 1px solid rgba(232, 228, 217, 0.1);
        }

        .footer-text {
            font-family: 'Chivo Mono', monospace;
            font-size: 0.75rem;
            color: var(--sage);
            letter-spacing: 1px;
            opacity: 0.7;
            margin-bottom: 1rem;
        }

        .register-link {
            color: var(--clay);
            text-decoration: none;
            font-size: 0.8rem;
            letter-spacing: 1px;
            transition: all 0.3s ease;
            font-family: 'Chivo Mono', monospace;
        }

        .register-link:hover {
            color: var(--stone);
            text-decoration: underline;
        }

        
        .alert-custom {
            background: rgba(201, 125, 96, 0.1);
            border: 1px solid rgba(201, 125, 96, 0.3);
            color: var(--stone);
            border-radius: 0;
            font-family: 'Figtree', sans-serif;
            font-size: 0.9rem;
            margin-bottom: 2rem;
        }

       
        @media (max-width: 768px) {
            .arch-nav {
                padding: 1.5rem;
            }

            .login-container {
                padding: 6rem 1.5rem 2rem;
            }

            .login-card {
                padding: 2rem 1.5rem;
            }

            .login-title {
                font-size: 1.5rem;
            }

            .login-subtitle {
                font-size: 0.8rem;
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
        <a href="../index.php" class="back-home">Back to Home</a>
    </nav>

    
    <div class="login-container">
        <div class="login-card">
            <h1 class="login-title">Access Your Account</h1>
            <p class="login-subtitle">Continue Your Journey</p>

            
            <?php if (isset($_GET['error'])): ?>
                <div class="alert alert-custom alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_GET['error']); ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            <?php if (isset($_GET['success'])): ?>
                <div class="alert alert-custom alert-dismissible fade show" role="alert">
                    <?php echo htmlspecialchars($_GET['success']); ?>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php endif; ?>

            
            <form method="POST" id="login-form">
                <div class="form-group">
                    <label for="email" class="form-label">Email Address</label>
                    <input type="email" class="form-control" id="email" name="email" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label for="password" class="form-label">Password</label>
                    <input type="password" class="form-control" id="password" name="password" placeholder="Enter your password" required>
                </div>
                <button type="submit" class="login-btn">Login</button>
            </form>

            <div class="login-footer">
                <p class="footer-text">Don't have an account?</p>
                <a href="register.php" class="register-link">Create Your ShopVerse Account</a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script src="../js/login.js"></script>


</body>

</html>