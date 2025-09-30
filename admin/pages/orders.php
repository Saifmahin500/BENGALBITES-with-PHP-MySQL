<?php
if (session_status() == PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_logged_in'])) {
	echo "Unauthorized";
	exit;
}
?>

<div class="container-fluid">
	<div class="d-flex align-items-center justify-content-between mb-3">
		<h3 class="mb-0">Pending Orders</h3>
		<button id="refreshOrders" class="btn btn-sm btn-outline-secondary">Refresh</button>
	</div>

	<div id="ordersTableWrap"></div>
</div>

<script>
	function fetchOrders() {
		fetch('ajax/order_table.php', {
				credentials: 'same-origin'
			})
			.then(r => r.text())
			.then(html => document.getElementById('ordersTableWrap').innerHTML = html)
			.catch(() => document.getElementById('ordersTableWrap').innerHTML = "<div class='alert alert-danger'>Failed to load orders</div>");
	}

	// Load initially
	document.addEventListener('DOMContentLoaded', fetchOrders);

	// Refresh button
	document.getElementById('refreshOrders').addEventListener('click', fetchOrders);

	// Change order status
	document.addEventListener('change', function(e) {
		const sel = e.target.closest('.order-status');
		if (!sel) return;

		const gid = sel.getAttribute('data-gid');
		const status = sel.value;

		const formData = new URLSearchParams();
		formData.append('global_order_id', gid);
		formData.append('status', status);

		fetch('ajax/update_order_status.php', {
				method: 'POST',
				headers: {
					'Content-Type': 'application/x-www-form-urlencoded'
				},
				body: formData.toString(),
				credentials: 'same-origin'
			})
			.then(r => r.text())
			.then(msg => {
				alert(msg);
				fetchOrders();
			})
			.catch(() => alert('Error updating status'));
	});
</script>