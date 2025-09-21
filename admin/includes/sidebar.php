<div class="sidebar">
	<div class="text-center mb-3">
		<?php
		if (!isset($_SESSION)) session_start();
		require_once __DIR__ . '/../dbConfig.php';
		$admin_id = $_SESSION['admin_id'] ?? null;

		// Default values for admin photo and name
		$adminPhoto = 'default.jpg';
		$adminName = 'Admin';

		// If admin is logged in, fetch admin details from DB
		if ($admin_id) {
			$stmt = $DB_con->prepare("SELECT * FROM admins WHERE id =?");
			$stmt->execute([$admin_id]);
			$admin = $stmt->fetch(PDO::FETCH_ASSOC);
			if ($admin) {
				$adminPhoto = !empty($admin['photo']) ? $admin['photo'] : 'default.jpg';
				$adminName = $admin['username'];
			}
		}
		?>
		<img src="../uploads/admins/<?= htmlspecialchars($adminPhoto) ?>" alt="Profile" class="rounded-circle" width="80" height="80">
		<h5 class="mt-2"><?= htmlspecialchars($adminName) ?></h5>
	</div>

	<!-- Sidebar title -->
	<h4><i class="fas fa-user-cog"></i> Admin Panel</h4>

	<!-- Dashboard link -->
	<a href="index.php?page=dashboard"><i class="fas fa-tachometer-alt"></i> Dashboard</a>

	<!-- All products link -->
	<a href="index.php?page=products"><i class="fas fa-box-open"></i> All Products</a>

	<!-- Categories link -->
	<a href="index.php?page=categories"><i class="fas fa-th-list"></i> All Categories</a>

	<!-- Coupons link -->
	<a href="index.php?page=coupons"><i class="fas fa-tags"></i> Coupons</a>

	

	<!-- Admin profile link -->
	<a href="index.php?page=sales_report"><i class="fas fa-chart-line"></i> Sales Report</a>

	<!-- Orders link -->
	<a href="index.php?page=orders" id="menuOrders">
		<i class="fa-solid fa-arrow-up-wide-short"></i> Orders
		<span id="orderBadge" class="badge badge-danger badge-pill" style="display: none; font-size: .70rem; line-height: 1; padding: .15rem .35rem;">0</span>
	</a>

	<!-- Inventory submenu with collapse -->
	<a href="#inventorySubmenu" data-toggle="collapse" aria-expanded="false" class="dropdown-toggle d-flex align-items-center">
		<i class="fas fa-warehouse mr-2"></i> Inventory
	</a>

	<!-- Inventory submenu items -->
	<div class="collapse" id="inventorySubmenu" style="margin-left: 20px; margin-top: 5px;">
		<a href="index.php?page=stock_in" class="d-block py-1">
			<i class="fas fa-arrow-down mr-1"></i> Stock In
		</a>
		<a href="index.php?page=stock_out" class="d-block py-1">
			<i class="fas fa-arrow-up mr-1"></i> Stock Out
		</a>
		<a href="index.php?page=stock_by_products" class="d-block py-1">
			<i class="fas fa-boxes mr-1"></i> Stock By Products
		</a>
		<a href="index.php?page=inventory_report" class="d-block py-1">
			<i class="fas fa-chart-bar mr-1"></i> Report
		</a>
	</div>

	<!-- User feedback -->
	<a href="index.php?page=feedback">
		<i class="fas fa-user"></i> User feedback
		<span id="fbcount" class="badge badge-pill badge-danger" style="margin-left: 6px;">0</span>
	</a>

	<!-- Admin profile link -->
	<a href="index.php?page=admin_profile"><i class="fas fa-user"></i> Change Profile</a>

	<!-- Link to view main website -->
	<a href="../index.php" style="color: white; text-decoration: none;">
		<i class="fa-solid fa-eye mr-2"></i> View website
	</a>

	<!-- Logout link -->
	<a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
</div>

<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js" integrity="sha512-v2CJ7UaYy4JwqLDIrZUI/4hqeoQieOmAZNXBeQyjo21dadnwR+8ZaIJVT8EE2iyI61OV8e6M8PP2/4hpQINQ/g==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-Fy6S3B9q64WdZWQUiU+q4/2Lc9npb8tCaSX9FK7E8HnRr0Jz8D6OP9dO5Vg3Q9ct" crossorigin="anonymous"></script>

<script type="text/javascript">
	// Polling for feedback count
	(function pollFedback() {
		$.ajax({
			url: 'ajax/send_reply.php',
			method: 'GET',
			dataType: 'json',
		}).done(function(d) {
			$('#fbcount').text((d && d.count) ? d.count : 0);
		}).always(function(d) {
			setTimeout(pollFedback, 10000)
		})
	})();
</script>

<style>
	/* Optional: smooth collapse pointer */
	.sidebar a.dropdown-toggle {
		cursor: pointer;
	}
</style>