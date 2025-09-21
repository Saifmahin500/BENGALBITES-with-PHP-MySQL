<?php
if (session_status() === PHP_SESSION_NONE) session_start();
$msg = $_SESSION['flash'] ?? 'Thank you';
unset($_SESSION['flash']);
?>
<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	<title>Thank You for Your Order | Please Check Your Email</title>
	<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
	<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
	<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">

	<style>
		:root {
			--brand-primary: #173831;
			--brand-secondary: #DBF0DD;
			--brand-accent: #2E5C4A;
			--brand-light: #F0F9F1;
			--brand-dark: #0D1F18;
		}

		* {
			margin: 0;
			padding: 0;
			box-sizing: border-box;
		}

		body {
			font-family: 'Poppins', sans-serif;
			background: linear-gradient(135deg, var(--brand-secondary) 0%, var(--brand-light) 100%);
			min-height: 100vh;
			display: flex;
			align-items: center;
			justify-content: center;
			padding: 20px;
		}

		.thank-you-container {
			background: white;
			border-radius: 20px;
			box-shadow: 0 20px 60px rgba(23, 56, 49, 0.15);
			overflow: hidden;
			max-width: 600px;
			width: 100%;
			position: relative;
			animation: fadeInUp 0.8s ease-out;
		}

		.container {
			display: flex;
			align-items: center;
			justify-content: center;
			min-height: 100vh;
			padding: 0;
			/* Bootstrap এর padding মুছে ফেলা */
		}


		@keyframes fadeInUp {
			from {
				opacity: 0;
				transform: translateY(30px);
			}

			to {
				opacity: 1;
				transform: translateY(0);
			}
		}

		.header-section {
			background: linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
			color: white;
			text-align: center;
			padding: 3rem 2rem 2rem;
			position: relative;
			overflow: hidden;
		}

		.header-section::before {
			content: '';
			position: absolute;
			top: -50%;
			left: -50%;
			width: 200%;
			height: 200%;
			background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><circle cx="50" cy="50" r="2" fill="rgba(255,255,255,0.1)"/></svg>') repeat;
			animation: float 20s infinite linear;
		}

		@keyframes float {
			0% {
				transform: translateX(0) translateY(0);
			}

			100% {
				transform: translateX(-50px) translateY(-50px);
			}
		}

		.success-icon {
			background: white;
			color: var(--brand-primary);
			width: 80px;
			height: 80px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 1.5rem;
			font-size: 2.5rem;
			position: relative;
			z-index: 2;
			animation: pulse 2s infinite;
		}

		@keyframes pulse {

			0%,
			100% {
				transform: scale(1);
			}

			50% {
				transform: scale(1.05);
			}
		}

		.main-title {
			font-size: 2.2rem;
			font-weight: 700;
			margin-bottom: 0.5rem;
			position: relative;
			z-index: 2;
		}

		.subtitle {
			font-size: 1.1rem;
			opacity: 0.9;
			font-weight: 300;
			position: relative;
			z-index: 2;
		}

		.content-section {
			padding: 3rem 2rem;
			text-align: center;
		}

		.message-card {
			background: var(--brand-light);
			border: 2px solid var(--brand-secondary);
			border-radius: 15px;
			padding: 2rem;
			margin-bottom: 2rem;
			position: relative;
		}

		.message-text {
			color: var(--brand-primary);
			font-size: 1.2rem;
			font-weight: 500;
			margin-bottom: 1rem;
		}

		.order-details {
			display: flex;
			justify-content: space-around;
			margin: 2rem 0;
			flex-wrap: wrap;
		}

		.detail-item {
			text-align: center;
			margin: 1rem 0;
		}

		.detail-icon {
			background: var(--brand-primary);
			color: white;
			width: 50px;
			height: 50px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			margin: 0 auto 0.5rem;
			font-size: 1.2rem;
		}

		.detail-title {
			font-weight: 600;
			color: var(--brand-primary);
			font-size: 0.9rem;
			text-transform: uppercase;
			letter-spacing: 0.5px;
		}

		.detail-text {
			color: var(--brand-accent);
			font-size: 0.9rem;
			margin-top: 0.25rem;
		}

		.home-button {
			background: linear-gradient(135deg, var(--brand-primary), var(--brand-accent));
			border: none;
			color: white;
			padding: 1rem 2.5rem;
			border-radius: 50px;
			font-weight: 600;
			font-size: 1.1rem;
			text-decoration: none;
			display: inline-flex;
			align-items: center;
			gap: 0.5rem;
			transition: all 0.3s ease;
			box-shadow: 0 10px 30px rgba(23, 56, 49, 0.3);
		}

		.home-button:hover {
			transform: translateY(-2px);
			box-shadow: 0 15px 40px rgba(23, 56, 49, 0.4);
			color: white;
			text-decoration: none;
		}

		.food-icons {
			position: absolute;
			top: 20px;
			right: 20px;
			opacity: 0.1;
			font-size: 3rem;
			color: var(--brand-primary);
			animation: bounce 3s infinite;
		}

		@keyframes bounce {

			0%,
			100% {
				transform: translateY(0);
			}

			50% {
				transform: translateY(-10px);
			}
		}

		.footer-note {
			background: var(--brand-secondary);
			padding: 1.5rem;
			margin-top: 2rem;
			border-radius: 10px;
			color: var(--brand-primary);
			font-size: 0.95rem;
		}

		.social-links {
			margin-top: 1.5rem;
			display: flex;
			justify-content: center;
			gap: 1rem;
		}

		.social-link {
			background: var(--brand-primary);
			color: white;
			width: 40px;
			height: 40px;
			border-radius: 50%;
			display: flex;
			align-items: center;
			justify-content: center;
			text-decoration: none;
			transition: all 0.3s ease;
		}

		.social-link:hover {
			background: var(--brand-accent);
			transform: translateY(-2px);
			color: white;
			text-decoration: none;
		}

		@media (max-width: 768px) {
			.main-title {
				font-size: 1.8rem;
			}

			.header-section {
				padding: 2rem 1rem 1.5rem;
			}

			.content-section {
				padding: 2rem 1rem;
			}

			.order-details {
				flex-direction: column;
				align-items: center;
			}
		}

		/* Decorative elements */
		.decoration-leaf {
			position: absolute;
			color: var(--brand-secondary);
			opacity: 0.3;
			animation: rotate 10s linear infinite;
		}

		@keyframes rotate {
			0% {
				transform: rotate(0deg);
			}

			100% {
				transform: rotate(360deg);
			}
		}

		.leaf-1 {
			top: 10px;
			left: 10px;
			font-size: 2rem;
		}

		.leaf-2 {
			bottom: 10px;
			right: 10px;
			font-size: 1.5rem;
			animation-direction: reverse;
		}
	</style>
</head>

<body>
	<div class="container">
		<div class="thank-you-container">
			<!-- Decorative Elements -->
			<div class="decoration-leaf leaf-1">
				<i class="fas fa-leaf"></i>
			</div>
			<div class="decoration-leaf leaf-2">
				<i class="fas fa-seedling"></i>
			</div>
			<div class="food-icons">
				<i class="fas fa-utensils"></i>
			</div>

			<!-- Header Section -->
			<div class="header-section">
				<div class="success-icon">
					<i class="fas fa-check"></i>
				</div>
				<h1 class="main-title">Order Confirmed!</h1>
				<p class="subtitle">Your delicious meal is on its way</p>
			</div>

			<!-- Content Section -->
			<div class="content-section">
				<div class="message-card">
					<div class="message-text">
						<i class="fas fa-heart text-danger mr-2"></i>
						<?= htmlspecialchars($msg) ?>
					</div>
					<p class="text-muted mb-0">We're preparing your order with love and care!</p>
				</div>

				<!-- Order Process Steps -->
				<div class="order-details">
					<div class="detail-item">
						<div class="detail-icon">
							<i class="fas fa-envelope"></i>
						</div>
						<div class="detail-title">Email Sent</div>
						<div class="detail-text">Check your inbox</div>
					</div>
					<div class="detail-item">
						<div class="detail-icon">
							<i class="fas fa-clock"></i>
						</div>
						<div class="detail-title">Preparing</div>
						<div class="detail-text">Fresh & delicious</div>
					</div>
					<div class="detail-item">
						<div class="detail-icon">
							<i class="fas fa-motorcycle"></i>
						</div>
						<div class="detail-title">On The Way</div>
						<div class="detail-text">Soon at your door</div>
					</div>
				</div>

				<a href="index.php" class="home-button">
					<i class="fas fa-home"></i>
					Back to Menu
				</a>

				<!-- Social Links -->
				<div class="social-links">
					<a href="#" class="social-link" title="Facebook">
						<i class="fab fa-facebook-f"></i>
					</a>
					<a href="#" class="social-link" title="Instagram">
						<i class="fab fa-instagram"></i>
					</a>
					<a href="#" class="social-link" title="Twitter">
						<i class="fab fa-twitter"></i>
					</a>
				</div>

				<div class="footer-note">
					<i class="fas fa-info-circle mr-2"></i>
					<strong>What's Next?</strong><br>
					<small>
						• Check your email for order confirmation<br>
						• We'll send you updates about your order status<br>
						• Estimated delivery time: 30-45 minutes
					</small>
				</div>
			</div>
		</div>
	</div>

	<!-- Bootstrap JS -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

	<!-- Add some interactive effects -->
	<script>
		// Add confetti effect on page load
		window.addEventListener('load', function() {
			// Simple animation for success icon
			const icon = document.querySelector('.success-icon');
			setTimeout(() => {
				icon.style.transform = 'scale(1.1)';
				setTimeout(() => {
					icon.style.transform = 'scale(1)';
				}, 200);
			}, 500);
		});

		// Add click effect to home button
		document.querySelector('.home-button').addEventListener('click', function(e) {
			this.style.transform = 'translateY(0)';
			setTimeout(() => {
				this.style.transform = 'translateY(-2px)';
			}, 100);
		});
	</script>
</body>

</html>