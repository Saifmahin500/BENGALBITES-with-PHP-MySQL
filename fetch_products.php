<?php
if (session_status() === PHP_SESSION_NONE) session_start();
require_once __DIR__ . '/admin/dbConfig.php';

$catIds = isset($_POST['categories']) ? $_POST['categories'] : [];
$catIds = is_array($catIds) ? array_filter($catIds) : [];

if ($catIds) {
	$in = implode(',', array_fill(0, count($catIds), '?'));
	$sql = "SELECT p.*, c.category_name, a.sizes, a.colors FROM products p LEFT JOIN categories c ON p.category_id = c.id LEFT JOIN attributes a ON a.product_id = p.id WHERE p.category_id IN ($in) ORDER BY p.product_name ASC";

	$stmt = $DB_con->prepare($sql);
	$stmt->execute($catIds);
} else {
	$sql = "SELECT p.*, c.category_name, a.sizes, a.colors FROM products p LEFT JOIN categories c ON p.category_id = c.id LEFT JOIN attributes a ON a.product_id = p.id ORDER BY p.product_name ASC";
	$stmt = $DB_con->query($sql);
}

$products = $stmt->fetchAll(PDO::FETCH_ASSOC);

function productThumb($row)
{
	$fsBase = __DIR__ . "/admin/uploads/";
	$urlBase = "admin/uploads/";

	if (!empty($row['product_image']) && file_exists($fsBase . $row['product_image'])) {
		return $urlBase . htmlspecialchars($row['product_image']);
	}

	if ($row['book_type'] == 'downloadable' && !empty($row['virtual_file'])) {
		$pdfIcon = 'pdf-icon.png';
		if (file_exists($fsBase . $pdfIcon)) {
			return $urlBase . $pdfIcon;
		}
	}

	return "assets/images/myImage.png";
}

ob_start();

if (!$products) {
	echo '<div class="col-12"><div class="alert alert-info">No Products Found!</div></div>';
} else {
	foreach ($products as $p) {
		$img = productThumb($p);

?>

<div class="col-sm-6 col-md-4 col-lg-3 mb-4">
	<div class="product-card shadow-lg rounded-lg h-100 border-0 overflow-hidden">
		<div class="product-img position-relative overflow-hidden">
			<img src="<?= $img ?>" alt="<?= $p['product_name'] ?>" class="product-image w-100">
			<div class="category-badge position-absolute">
				<?= $p['category_name'] ?? 'Product' ?>
			</div>
		</div>
		
		<div class="p-body p-3 d-flex flex-column justify-content-between">
			<!-- Decorative element -->
			<div class="decorative-line position-absolute"></div>
			
			<div class="product-info mt-2">
				<h6 class="product-title mb-2 font-weight-bold">
					<?= $p['product_name'] ?>
				</h6>
				
				<div class="price-section mb-3 p-2 rounded">
					<span class="product-price font-weight-bold"><?= (int)$p['selling_price'] ?> TK</span>
					<small class="d-block text-muted price-label">Best Price</small>
				</div>
			</div>
			
			<div class="action-section">
				<?php if (!empty($_SESSION['user_id'])): ?>
					<form method="$_POST" action="cart_add.php" class="m-0">
						<input type="hidden" name="product_id" value="<?= (int)$p['id'] ?>">
						<button type="submit" class="cart-btn btn btn-block font-weight-semibold d-flex align-items-center justify-content-center">
							<i class="fas fa-shopping-cart mr-2"></i>
							<span>Order Now</span>
						</button>
					</form>
				<?php else: ?>
					<button type="button" class="cart-btn btn btn-block font-weight-semibold d-flex align-items-center justify-content-center"
						data-toggle="modal" data-target="#loginModal">
						<i class="fas fa-user-lock mr-2"></i>
						<span>Login to order</span>
					</button>
				<?php endif; ?>
				
				<!--Login Modal-->
				<div class="modal fade" id="loginModal" tabindex="-1" aria-hidden="true">
					<div class="modal-dialog modal-dialog-centered">
						<form class="modal-content login-modal border-0 shadow-lg" method="post" action="<?= $BASE ?>/auth/login.php">
							<div class="modal-header login-header border-0">
								<h5 class="modal-title font-weight-bold">
									<i class="fas fa-sign-in-alt mr-2"></i>
									Login to your account
								</h5>
								<button type="button" class="close text-white login-close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body login-body p-4">
								<div class="form-group mb-3">
									<label class="font-weight-semibold login-label">Email Address:</label>
									<input type="email" name="email" class="form-control login-input border-0 shadow-sm" required autocomplete="email">
								</div>
								<div class="form-group mb-3">
									<label class="font-weight-semibold login-label">Password:</label>
									<input type="password" name="password" class="form-control login-input border-0 shadow-sm" required autocomplete="current-password">
								</div>
								<small class="text-center d-block">
									<a href="<?= $BASE ?>/auth/fpass.php" class="forgot-link">
										<i class="fas fa-key mr-1"></i>Forgot Password?
									</a>
								</small>
							</div>
							<div class="modal-footer login-footer border-0 d-flex justify-content-between">
								<button type="button" class="btn close-btn font-weight-semibold" data-dismiss="modal">
									Close
								</button>
								<button type="submit" class="btn login-submit-btn font-weight-bold">
									<i class="fas fa-sign-in-alt mr-2"></i>Login
								</button>
							</div>
						</form>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<style>
/* Product Card Styles */
.product-card {
	transition: all 0.3s ease;
	background: linear-gradient(135deg, #DBF0DD 0%, #ffffff 100%);
	cursor: pointer;
}

.product-card:hover {
	transform: translateY(-5px);
	box-shadow: 0 15px 35px rgba(23, 56, 49, 0.15);
}

/* Product Image Styles */
.product-img {
  height: 200px;
  width: 100%;              
  overflow: hidden;        
}

.product-image {
  width: 100%;              
  height: 100%;             
  object-fit: cover;        
  object-position: center;  
  transition: transform 0.3s ease;
}


.product-card:hover .product-image {
	transform: scale(1.05);
}

/* Category Badge */
.category-badge {
	top: 10px;
	right: 10px;
	background: rgba(23, 56, 49, 0.9);
	color: white;
	padding: 5px 12px;
	border-radius: 20px;
	font-size: 12px;
	font-weight: 600;
}

/* Product Body */
.p-body {
	height: calc(100% - 200px);
	background: white;
	position: relative;
}

/* Decorative Line */
.decorative-line {
	top: 0;
	left: 0;
	width: 100%;
	height: 3px;
	background: linear-gradient(90deg, #173831 0%, #DBF0DD 100%);
}

/* Product Title */
.product-title {
	color: #173831;
	line-height: 1.4;
	font-size: 16px;
	min-height: 40px;
	display: -webkit-box;
	-webkit-line-clamp: 2;
	-webkit-box-orient: vertical;
	overflow: hidden;
}

/* Price Section */
.price-section {
	background: linear-gradient(45deg, #DBF0DD, #f8fff9);
	border-left: 4px solid #173831;
}

.product-price {
	color: #173831;
	font-size: 18px;
}

.price-label {
	font-size: 12px;
}

/* Cart Button */
.cart-btn {
	border: 2px solid #173831;
	color: #173831;
	background: linear-gradient(135deg, transparent, #DBF0DD);
	transition: all 0.3s ease;
	padding: 12px 20px;
	font-size: 14px;
	border-radius: 25px;
	box-shadow: 0 2px 10px rgba(23, 56, 49, 0.1);
}

.cart-btn:hover {
	background: linear-gradient(135deg, #173831, #2a5f54);
	color: #fff;
	transform: translateY(-2px);
	box-shadow: 0 4px 15px rgba(23, 56, 49, 0.3);
}

/* Modal Styles */
.login-modal {
	border-radius: 15px;
	overflow: hidden;
}

.login-header {
	background: linear-gradient(135deg, #173831, #2a5f54);
	color: white;
}

.login-close {
	opacity: 0.8;
}

.login-body {
	background: linear-gradient(135deg, #DBF0DD, #ffffff);
}

.login-label {
	color: #173831;
}

.login-input {
	border-radius: 10px;
	padding: 12px 15px;
	background: white;
	border: 2px solid #DBF0DD !important;
}

.login-input:focus {
	border-color: #173831 !important;
	box-shadow: none !important;
}

.forgot-link {
	color: #173831;
	text-decoration: none;
}

.forgot-link:hover {
	text-decoration: underline;
	color: #173831;
}

.login-footer {
	background: white;
	padding: 20px;
}

.close-btn {
	color: #173831;
	background: transparent;
	border: 1px solid #DBF0DD;
	border-radius: 20px;
	padding: 10px 25px;
}

.close-btn:hover {
	background: #DBF0DD;
	color: #173831;
}

.login-submit-btn {
	background: linear-gradient(135deg, #173831, #2a5f54);
	color: white;
	border: none;
	border-radius: 20px;
	padding: 10px 30px;
	box-shadow: 0 3px 10px rgba(23, 56, 49, 0.3);
}

.login-submit-btn:hover {
	background: linear-gradient(135deg, #2a5f54, #173831);
	color: white;
}

/* Custom scrollbar for modal */
.modal-body::-webkit-scrollbar {
	width: 6px;
}

.modal-body::-webkit-scrollbar-track {
	background: #DBF0DD;
	border-radius: 10px;
}

.modal-body::-webkit-scrollbar-thumb {
	background: #173831;
	border-radius: 10px;
}

/* Responsive adjustments */
@media (max-width: 576px) {
	.product-img {
		height: 180px;
	}
	
	.p-body {
		height: calc(100% - 180px);
	}
	
	.product-title {
		font-size: 14px;
		min-height: 35px;
	}
	
	.cart-btn {
		font-size: 13px;
		padding: 10px 15px;
	}
}
</style>

<?php
}
}

echo ob_get_clean();

?>