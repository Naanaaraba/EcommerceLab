<?php
include_once './settings/core.php';
$is_logged_in = check_login();
$is_admin = is_admin();
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<title>ShopVerse - Curated Luxury</title>
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

		.nav-links {
			display: flex;
			gap: 2.5rem;
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
		}

		.nav-link:hover {
			opacity: 1;
			color: var(--clay);
		}

		.nav-link::after {
			content: '';
			position: absolute;
			bottom: -8px;
			left: 0;
			width: 0;
			height: 1px;
			background: var(--clay);
			transition: width 0.4s ease;
		}

		.nav-link:hover::after {
			width: 100%;
		}

		
		.main-content {
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 8rem 2rem 6rem;
		}

		.hero-section {
			text-align: center;
			max-width: 700px;
		}

		
		.experimental-logo {
			font-family: 'Space Grotesk', sans-serif;
			font-weight: 300;
			font-size: 3.5rem;
			color: var(--stone);
			margin-bottom: 1.5rem;
			line-height: 1.1;
			position: relative;
			letter-spacing: -0.5px;
		}

		.logo-accent {
			color: var(--clay);
			font-weight: 400;
		}

		.architectural-tagline {
			font-family: 'Chivo Mono', monospace;
			font-weight: 300;
			font-size: 1rem;
			color: var(--sage);
			letter-spacing: 3px;
			margin-bottom: 4rem;
			line-height: 1.8;
			text-transform: uppercase;
			opacity: 0.9;
		}

		
		.action-grid {
			display: grid;
			grid-template-columns: 1fr 1fr;
			gap: 1.5rem;
			margin: 3rem auto;
			max-width: 500px;
		}

		.grid-item {
			padding: 2.5rem 2rem;
			border: 1px solid rgba(232, 228, 217, 0.15);
			transition: all 0.4s ease;
			position: relative;
			overflow: hidden;
			background: rgba(232, 228, 217, 0.02);
		}

		.grid-item:hover {
			border-color: var(--clay);
			transform: translateY(-3px);
			background: rgba(232, 228, 217, 0.03);
		}

		
		.single-action {
			margin: 3rem auto;
			max-width: 400px;
		}

		.single-action-item {
			padding: 3rem 2.5rem;
			border: 1px solid rgba(232, 228, 217, 0.15);
			transition: all 0.4s ease;
			position: relative;
			overflow: hidden;
			background: rgba(232, 228, 217, 0.02);
		}

		.single-action-item:hover {
			border-color: var(--clay);
			transform: translateY(-3px);
			background: rgba(232, 228, 217, 0.03);
		}

		.action-title {
			font-family: 'Space Grotesk', sans-serif;
			font-size: 1.2rem;
			color: var(--stone);
			margin-bottom: 1rem;
			letter-spacing: 1px;
			font-weight: 400;
		}

		.action-desc {
			font-size: 0.9rem;
			color: var(--sage);
			line-height: 1.6;
			margin-bottom: 2rem;
			opacity: 0.8;
		}

		.action-btn {
			background: transparent;
			border: 1px solid var(--stone);
			color: var(--stone);
			padding: 0.9rem 2rem;
			font-family: 'Chivo Mono', monospace;
			font-size: 0.8rem;
			letter-spacing: 1.5px;
			cursor: pointer;
			transition: all 0.3s ease;
			text-decoration: none;
			display: inline-block;
			text-transform: uppercase;
		}

		.action-btn:hover {
			background: var(--stone);
			color: var(--deep-navy);
			border-color: var(--stone);
		}

		.primary-action-btn {
			background: var(--clay);
			border: 1px solid var(--clay);
			color: var(--deep-navy);
			padding: 1rem 2.5rem;
			font-size: 0.9rem;
			font-weight: 500;
		}

		.primary-action-btn:hover {
			background: transparent;
			color: var(--clay);
			border-color: var(--clay);
		}

		
		.arch-footer {
			position: fixed;
			bottom: 0;
			left: 0;
			width: 100%;
			padding: 1.5rem 3rem;
			background: rgba(10, 17, 40, 0.95);
			border-top: 1px solid rgba(232, 228, 217, 0.08);
			backdrop-filter: blur(15px);
		}

		.footer-content {
			display: flex;
			justify-content: space-between;
			align-items: center;
		}

		.footer-text {
			font-family: 'Chivo Mono', monospace;
			font-size: 0.75rem;
			color: var(--sage);
			letter-spacing: 1.5px;
			opacity: 0.7;
		}

		.footer-accent {
			color: var(--clay);
			opacity: 0.9;
		}

		
		.grid-item::before,
		.single-action-item::before {
			content: '';
			position: absolute;
			top: 0;
			left: -100%;
			width: 100%;
			height: 100%;
			background: linear-gradient(90deg, transparent, rgba(201, 125, 96, 0.08), transparent);
			transition: left 0.7s ease;
		}

		.grid-item:hover::before,
		.single-action-item:hover::before {
			left: 100%;
		}

		
		.user-status {
			font-family: 'Figtree', sans-serif;
			font-size: 0.9rem;
			color: var(--sage);
			margin-top: 2rem;
			letter-spacing: 0.5px;
			opacity: 0.8;
			font-style: italic;
		}

		
		.quick-actions {
			display: flex;
			gap: 1rem;
			justify-content: center;
			margin-top: 2rem;
		}

		.quick-action {
			color: var(--sage);
			text-decoration: none;
			font-size: 0.8rem;
			letter-spacing: 1px;
			transition: all 0.3s ease;
			opacity: 0.7;
		}

		.quick-action:hover {
			color: var(--clay);
			opacity: 1;
		}

		
		@media (max-width: 768px) {
			.arch-nav {
				padding: 1.5rem;
				flex-direction: column;
				gap: 1rem;
			}

			.nav-links {
				gap: 1.5rem;
			}

			.experimental-logo {
				font-size: 2.8rem;
			}

			.architectural-tagline {
				font-size: 0.9rem;
				letter-spacing: 2px;
			}

			.action-grid {
				grid-template-columns: 1fr;
				gap: 1rem;
			}

			.grid-item,
			.single-action-item {
				padding: 2rem 1.5rem;
			}

			.arch-footer {
				padding: 1rem 1.5rem;
			}

			.footer-content {
				flex-direction: column;
				gap: 0.5rem;
				text-align: center;
			}

			.quick-actions {
				flex-direction: column;
				gap: 0.5rem;
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
			<?php if ($is_logged_in): ?>
				<?php if (!$is_admin): ?>
					<a href="./view/all_product.php" class="nav-link">Collection</a>
					<a href="./login/logout.php" class="nav-link">Logout</a>
				<?php else: ?>
					<a href="./admin/category.php" class="nav-link">Categories</a>
					<a href="./admin/brand.php" class="nav-link">Brands</a>
					<a href="./admin/product.php" class="nav-link">Products</a>
					<a href="./login/logout.php" class="nav-link">Logout</a>
				<?php endif; ?>
			<?php else: ?>
				<a href="./login/login.php" class="nav-link">Access</a>
			<?php endif; ?>
		</div>
	</nav>

	
	<main class="main-content">
		<div class="hero-section">
			<h1 class="experimental-logo">
				SHOP<span class="logo-accent">VERSE</span>
			</h1>
			<p class="architectural-tagline">Curated Objects<br>Conscious Living</p>
			
			<?php if (!$is_logged_in): ?>
				
				<div class="action-grid">
					<div class="grid-item">
						<div class="action-title">Begin Journey</div>
						<div class="action-desc">Create your space with thoughtfully selected pieces that reflect your aesthetic</div>
						<a href="./login/register.php" class="action-btn">Register</a>
					</div>
					<div class="grid-item">
						<div class="action-title">Continue Journey</div>
						<div class="action-desc">Return to your curated selection and personalized recommendations</div>
						<a href="./login/login.php" class="action-btn">Login</a>
					</div>
				</div>
			<?php else: ?>
				
				<div class="single-action">
					<div class="single-action-item">
						<div class="action-title">Welcome Back</div>
						<div class="action-desc">
							<?php 
								if ($is_admin) {
									echo "Continue managing the ShopVerse collection and user experience";
								} else {
									echo "Your personalized curation awaits. Discover new arrivals and continue your journey";
								}
							?>
						</div>
						<a href="<?php echo $is_admin ? '#' : './view/all_product.php'; ?>" class="action-btn primary-action-btn">
							<?php echo $is_admin ? 'Access Dashboard' : 'Explore Collection'; ?>
						</a>
					</div>
				</div>

				
				<div class="quick-actions">
					<?php if (!$is_admin): ?>
						<a href="#" class="quick-action">Your Profile</a>
						<a href="#" class="quick-action">Wishlist</a>
						<a href="#" class="quick-action">Order History</a>
					<?php else: ?>
						<a href="#" class="quick-action">Analytics</a>
						<a href="#" class="quick-action">Users</a>
						<a href="#" class="quick-action">Orders</a>
					<?php endif; ?>
				</div>

				<p class="user-status">Ready to continue your curated experience</p>
			<?php endif; ?>
		</div>
	</main>

	
	<footer class="arch-footer">
		<div class="footer-content">
			<div class="footer-text">© 2025 <span class="footer-accent">ShopVerse</span></div>
			<div class="footer-text">
				<?php 
					if ($is_logged_in) {
						echo "Welcome to your curated space";
					} else {
						echo "Curating exceptional experiences";
					}
				?>
			</div>
		</div>
	</footer>

	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>