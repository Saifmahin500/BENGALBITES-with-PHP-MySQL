<style>
	/* Restaurant Footer Styles */
	.restaurant-footer {
		background: linear-gradient(135deg, #173831 0%, #2a5f54 100%);
		position: relative;
		overflow: hidden;
	}

	.restaurant-footer::before {
		content: '';
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		height: 4px;
		background: linear-gradient(90deg, #DBF0DD 0%, #173831 50%, #DBF0DD 100%);
	}

	.footer-section h5 {
		color: #DBF0DD;
		position: relative;
		padding-bottom: 10px;
		margin-bottom: 20px;
	}

	.footer-section h5::after {
		content: '';
		position: absolute;
		bottom: 0;
		left: 0;
		width: 50px;
		height: 2px;
		background: #DBF0DD;
		border-radius: 2px;
	}

	.restaurant-description {
		color: #ffffff;
		line-height: 1.6;
		font-size: 14px;
	}

	.quick-links {
		list-style: none;
		padding: 0;
	}

	.quick-links li {
		margin-bottom: 8px;
		position: relative;
		padding-left: 20px;
	}

	.quick-links li::before {
		content: '🍽️';
		position: absolute;
		left: 0;
		top: 0;
		font-size: 12px;
	}

	.quick-links a {
		color: #ffffff;
		text-decoration: none;
		transition: all 0.3s ease;
		font-size: 14px;
	}

	.quick-links a:hover {
		color: #DBF0DD;
		padding-left: 5px;
		text-decoration: none;
	}

	.contact-info {
		color: #ffffff;
	}

	.contact-item {
		display: flex;
		align-items: center;
		margin-bottom: 12px;
		font-size: 14px;
	}

	.contact-icon {
		width: 35px;
		height: 35px;
		background: rgba(219, 240, 221, 0.1);
		border-radius: 50%;
		display: flex;
		align-items: center;
		justify-content: center;
		margin-right: 12px;
		color: #DBF0DD;
		transition: all 0.3s ease;
	}

	.contact-item:hover .contact-icon {
		background: #DBF0DD;
		color: #173831;
		transform: scale(1.1);
	}

	.opening-hours {
		background: rgba(219, 240, 221, 0.1);
		padding: 15px;
		border-radius: 8px;
		margin-top: 20px;
	}

	.opening-hours h6 {
		color: #DBF0DD;
		margin-bottom: 10px;
		font-size: 14px;
	}

	.hours-item {
		display: flex;
		justify-content: space-between;
		margin-bottom: 5px;
		font-size: 13px;
		color: #ffffff;
	}

	.social-links {
		margin-top: 20px;
	}

	.social-icon {
		display: inline-block;
		width: 40px;
		height: 40px;
		background: rgba(219, 240, 221, 0.1);
		border-radius: 50%;
		text-align: center;
		line-height: 40px;
		color: #DBF0DD;
		margin-right: 10px;
		transition: all 0.3s ease;
		text-decoration: none;
	}

	.social-icon:hover {
		background: #DBF0DD;
		color: #173831;
		transform: translateY(-3px);
		text-decoration: none;
	}

	.footer-divider {
		height: 1px;
		background: linear-gradient(90deg, transparent 0%, #DBF0DD 50%, transparent 100%);
		margin: 30px 0 20px 0;
		border: none;
	}

	.copyright-section {
		text-align: center;
		color: #DBF0DD;
		font-size: 14px;
	}

	.brand-name {
		color: #DBF0DD;
		font-weight: bold;
	}

	/* Decorative Elements */
	.footer-decoration {
		position: absolute;
		opacity: 0.1;
		font-size: 150px;
		color: #DBF0DD;
		right: -50px;
		bottom: -50px;
		pointer-events: none;
	}

	/* Responsive Design */
	@media (max-width: 768px) {
		.footer-section {
			text-align: center;
			margin-bottom: 30px;
		}

		.quick-links li::before {
			display: none;
		}

		.quick-links li {
			padding-left: 0;
		}

		.contact-item {
			justify-content: center;
		}

		.hours-item {
			justify-content: center;
			text-align: center;
		}
	}
</style>

<footer class="restaurant-footer text-light pt-5 pb-4 mt-5">
	<div class="container">
		<div class="row">
			<!-- About Restaurant Column -->
			<div class="col-md-4 col-sm-12 mb-4 footer-section">
				<h5 class="text-uppercase">🍴 BENGALBITES</h5>
				<p class="restaurant-description">
					Experience authentic flavors and traditional recipes passed down through generations. We serve fresh, delicious meals made with love and the finest ingredients. Your taste buds will thank you!
				</p>
				<div class="opening-hours">
					<h6>🕐 Opening Hours</h6>
					<div class="hours-item">
						<span>Monday - Thursday</span>
						<span>11:00 AM - 10:00 PM</span>
					</div>
					<div class="hours-item">
						<span>Friday - Sunday</span>
						<span>11:00 AM - 11:00 PM</span>
					</div>
				</div>
			</div>

			<!-- Quick Links Column -->
			<div class="col-md-4 col-sm-12 mb-4 footer-section">
				<h5 class="text-uppercase">🔗 Quick Links</h5>
				<ul class="quick-links">
					<li><a href="index.php">Home</a></li>
					<li><a href="all_products.php">Our Menu</a></li>
					<li><a href="about.php">About Restaurant</a></li>
					<li><a href="contact.php">Contact Us</a></li>
					<li><a href="login.php">Customer Login</a></li>
				</ul>

				<div class="social-links">
					<a href="#" class="social-icon" title="Facebook">
						<i class="fab fa-facebook-f"></i>
					</a>
					<a href="#" class="social-icon" title="Instagram">
						<i class="fab fa-instagram"></i>
					</a>
					<a href="#" class="social-icon" title="Twitter">
						<i class="fab fa-twitter"></i>
					</a>
					<a href="#" class="social-icon" title="YouTube">
						<i class="fab fa-youtube"></i>
					</a>
				</div>
			</div>

			<!-- Contact Information Column -->
			<div class="col-md-4 col-sm-12 mb-4 footer-section">
				<h5 class="text-uppercase">📞 Contact Information</h5>
				<div class="contact-info">
					<div class="contact-item">
						<div class="contact-icon">
							<i class="fas fa-map-marker-alt"></i>
						</div>
						<div>
							<strong>Address:</strong><br>
							29, Purana Paltan<br>
							Noorjahan Sharif Plaza, Dhaka
						</div>
					</div>

					<div class="contact-item">
						<div class="contact-icon">
							<i class="fas fa-phone"></i>
						</div>
						<div>
							<strong>Phone:</strong><br>
							+88-01856-590532
						</div>
					</div>

					<div class="contact-item">
						<div class="contact-icon">
							<i class="fas fa-envelope"></i>
						</div>
						<div>
							<strong>Email:</strong><br>
							info@BENGALBITES.com
						</div>
					</div>
				</div>
			</div>
		</div>

		<hr class="footer-divider">

		<div class="copyright-section">
			<p class="mb-0">
				&copy; <?php echo date("Y"); ?> <span class="brand-name">BENGALBITES Restaurant</span>.
				All Rights Reserved. | Made with by SaifMahin
			</p>
		</div>
	</div>

	<!-- Decorative Element -->
	<div class="footer-decoration">
		🍽️
	</div>
</footer>

<!-- jQuery CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js" integrity="sha512-bLT0Qm9VnAYZDflyKcBaQ2gg0hSYNQrJ8RilYldYQ1FxQYoCLtUjuuRuZo+fjqhx/qtq/1itJ0C2ejDxltZVFg==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<!-- Bootstrap CDN -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap/4.6.2/js/bootstrap.bundle.min.js" integrity="sha512-igl8WEUuas9k5dtnhKqyyld6TzzRjvMqLC79jkgT3z02FvJyHAuUtyemm/P/jYSne1xwFI06ezQxEwweaiV7VA==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script>
	function loadProducts(catIds = []) {
		$.ajax({
			url: 'fetch_products.php',
			method: 'POST',
			data: {
				categories: catIds
			},
			success: function(html) {
				$('#productGrid').html(html);
			}
		});
	}

	$(function() {
		const checked = [];

		$('.cat-check:checked').each(function() {
			checked.push($(this).val());
		});

		loadProducts(checked);

		$(document).on('change', '.cat-check', function() {
			const ids = [];
			$('.cat-check:checked').each(function() {
				ids.push($(this).val());
			});

			loadProducts(ids);
		});

		$('#clearFilter').on('click', function() {
			$('.cat-check').prop('checked', false);
			loadProducts([]);
		});

		const qp = new URLSearchParams(window.location.search);
		if (qp.get('view') == 'all') {
			loadProducts([]);
		}
	});
</script>