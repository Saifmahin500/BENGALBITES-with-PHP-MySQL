<?php
if (session_status() == PHP_SESSION_NONE) session_start();
if (empty($_SESSION['admin_logged_in'])) {
	echo json_encode(['ok' => false, 'msg' => 'Unauthorised']);
	exit;
}
require_once __DIR__ . '/../dbConfig.php';

?>

<div class="container-fluid">
	<div class="d-flex align-items-center justify-content-between mb-3">
		<h3 class="mb-0">Pending Orders</h3>
		<button id="refreshOrders" class="btnbtn-sm btn-outline-secondary">Refresh</button>
	</div>

	<div id="ordersTableWrap">

	</div>
</div>

<script type="text/javascript">
	document.addEventListener('DOMContentLoaded', function() {

		var badge = document.getElementById('orderBadge');
		if (badge) {
			badge.style.display = 'none';
			badge.textContent = '0';
		}

		fetchOrders();
	});

	function fetchOrders() {
		fetch('ajax/order_table.php', {
			credentials: 'same-origin'
		}).then(r => r.text()).then(html => {
			document.getElementById('ordersTableWrap').innerHTML = html;
		}).catch(() => {
			document.getElementById('ordersTableWrap').innerHTML = "<div class='alert alert-danger'>Failed to load order</div>";
		});
	}

	document.getElementById('refreshOrders').addEventListener('click', fetchOrders);

	document.addEventListener('change', function(e) {

		const sel = e.target.closest('.order-status');
		if (!sel) return;

		const gid = sel.getAttribute('data-gid');
		const val = sel.value;

		const body = new URLSearchParams();
		body.append('global_order_id', gid);
		body.append('status', val);

		fetch('ajax/order_status_update.php', {

			method: 'POST',
			headers: {
				'Content-Type': 'application/x-www-form-urlencoded'
			},
			credentials: 'same-origin',
			body: body.toString()
		}).then(r => r.json()).then(d => {
			if (!d || !d.ok) {
				alert(d && d.msg ? d.msg : 'Failed to update');
				return;
			}
			fetchOrders();
		}).catch(() => alert('Error updating status'));

	});
</script>