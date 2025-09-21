<?php
if (session_status() == PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_logged_in'])) {
	header("Location: ../login.php");
	exit;
}

require_once __DIR__ . '/../dbConfig.php';

// Categories
$cats = $DB_con->query("SELECT id, category_name FROM categories ORDER BY category_name ASC")->fetchAll(PDO::FETCH_ASSOC);

// Coupons with product names (if any)
$coupons = $DB_con->query("
    SELECT c.*, 
           GROUP_CONCAT(p.product_name SEPARATOR ', ') AS product_names
    FROM coupons c
    LEFT JOIN coupon_products cp ON cp.coupon_id = c.id
    LEFT JOIN products p ON p.id = cp.product_id
    GROUP BY c.id
    ORDER BY c.id DESC
    LIMIT 50
")->fetchAll(PDO::FETCH_ASSOC);
?>

<style>
	/* Custom Brand Colors */
	:root {
		--brand-primary: #3485A7;
		--brand-secondary: #08417A;
		--brand-light: #E8F4F8;
		--brand-dark: #062E4B;
	}

	/* Custom Card Styling */
	.brand-card {
		border: none;
		box-shadow: 0 4px 15px rgba(52, 133, 167, 0.1);
		border-radius: 12px;
		overflow: hidden;
	}

	.brand-card-header {
		background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
		color: white;
		font-weight: 600;
		padding: 1rem 1.5rem;
		border-bottom: none;
		font-size: 1.1rem;
	}

	/* Custom Form Styling */
	.brand-form {
		background: var(--brand-light);
		border: 2px solid #E3F2FD;
		border-radius: 10px;
		transition: all 0.3s ease;
	}

	.brand-form:hover {
		border-color: var(--brand-primary);
		box-shadow: 0 2px 10px rgba(52, 133, 167, 0.15);
	}

	.form-control:focus {
		border-color: var(--brand-primary);
		box-shadow: 0 0 0 0.2rem rgba(52, 133, 167, 0.25);
	}

	.form-check-input:checked {
		background-color: var(--brand-primary);
		border-color: var(--brand-primary);
	}

	/* Custom Button Styling */
	.btn-brand {
		background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
		border: none;
		color: white;
		font-weight: 500;
		padding: 0.6rem 1.5rem;
		border-radius: 8px;
		transition: all 0.3s ease;
	}

	.btn-brand:hover {
		background: linear-gradient(135deg, var(--brand-secondary), var(--brand-dark));
		transform: translateY(-1px);
		box-shadow: 0 4px 12px rgba(52, 133, 167, 0.3);
		color: white;
	}

	/* Custom Badge Colors */
	.badge-brand-primary {
		background-color: var(--brand-primary);
		color: white;
	}

	.badge-brand-secondary {
		background-color: var(--brand-secondary);
		color: white;
	}

	/* Table Styling */
	.table-brand thead th {
		background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
		color: white;
		font-weight: 500;
		border: none;
		padding: 1rem 0.75rem;
	}

	.table-brand tbody tr:hover {
		background-color: var(--brand-light);
	}

	/* Radio Button Group */
	.radio-group {
		background: white;
		padding: 1rem;
		border-radius: 8px;
		border: 2px solid #E3F2FD;
		margin-bottom: 1.5rem;
	}

	/* Custom Alert */
	.alert-brand {
		border: none;
		border-radius: 8px;
		box-shadow: 0 2px 10px rgba(52, 133, 167, 0.1);
	}

	/* Page Header */
	.page-header {
		background: linear-gradient(135deg, var(--brand-primary), var(--brand-secondary));
		color: white;
		padding: 2rem 0;
		border-radius: 15px;
		margin-bottom: 2rem;
		text-align: center;
	}

	/* Icon Styling */
	.icon-brand {
		color: var(--brand-primary);
		margin-right: 0.5rem;
	}

	/* Form Section Headers */
	.form-section-header {
		background: var(--brand-primary);
		color: white;
		padding: 0.5rem 1rem;
		border-radius: 6px;
		font-weight: 500;
		margin-bottom: 1rem;
		display: inline-block;
	}

	/* Action Buttons */
	.action-btn {
		margin-bottom: 0.25rem;
		min-width: 70px;
	}

	/* Loading State */
	.loading {
		opacity: 0.6;
		pointer-events: none;
	}
</style>

<div class="container-fluid px-4">
	<div class="page-header">
		<h2 class="mb-0"><i class="fas fa-ticket-alt mr-3"></i>Coupon Management System</h2>
		<p class="mb-0 mt-2 opacity-75">Create and manage discount coupons for your products</p>
	</div>

	<div class="row">
		<div class="col-lg-6 mb-4">
			<div class="card brand-card">
				<div class="card-header brand-card-header">
					<i class="fas fa-plus-circle mr-2"></i>Create New Coupon
				</div>
				<div class="card-body p-4">

					<div class="radio-group">
						<label class="form-label font-weight-bold mb-3">
							<i class="fas fa-crosshairs icon-brand"></i>Apply Coupon To:
						</label>
						<div class="row">
							<div class="col-md-6">
								<div class="form-check">
									<input type="radio" name="apply_to" class="form-check-input" id="optAll" value="all" checked>
									<label class="form-check-label font-weight-medium" for="optAll">
										<i class="fas fa-globe mr-2"></i>All Categories
									</label>
								</div>
							</div>
							<div class="col-md-6">
								<div class="form-check">
									<input type="radio" name="apply_to" class="form-check-input" id="optSelected" value="selected">
									<label class="form-check-label font-weight-medium" for="optSelected">
										<i class="fas fa-filter mr-2"></i>Selected Categories
									</label>
								</div>
							</div>
						</div>
					</div>

					<!--All Categories Form-->
					<form id="formAll" class="brand-form p-4">
						<div class="form-section-header">
							<i class="fas fa-globe mr-2"></i>All Products Coupon
						</div>

						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="font-weight-medium">
									<i class="fas fa-tag icon-brand"></i>Coupon Code
								</label>
								<input type="text" name="code" class="form-control" placeholder="e.g. SALE10" required>
							</div>
							<div class="form-group col-md-6">
								<label class="font-weight-medium">
									<i class="fas fa-percentage icon-brand"></i>Discount %
								</label>
								<input type="number" name="discount_percent" class="form-control" min="1" max="95" step="0.01" placeholder="10" required>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="font-weight-medium">
									<i class="fas fa-users icon-brand"></i>Usage Limit
								</label>
								<input type="number" name="usage_limit" id="usage_limit" class="form-control" min="1" placeholder="e.g 100">
							</div>
							<div class="form-group col-md-6">
								<label class="font-weight-medium">
									<i class="fas fa-toggle-on icon-brand"></i>Status
								</label>
								<select name="status" class="form-control">
									<option value="active" selected>Active</option>
									<option value="inactive">Inactive</option>
								</select>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="font-weight-medium">
									<i class="fas fa-calendar-plus icon-brand"></i>Start Date
								</label>
								<input type="date" name="start_date" class="form-control">
							</div>
							<div class="form-group col-md-6">
								<label class="font-weight-medium">
									<i class="fas fa-calendar-times icon-brand"></i>End Date
								</label>
								<input type="date" name="end_date" class="form-control">
							</div>
						</div>

						<div class="text-center mt-4">
							<button type="submit" class="btn btn-brand btn-lg">
								<i class="fas fa-save mr-2"></i>Create Coupon for All Products
							</button>
							<div class="mt-2">
								<small class="text-muted">
									<i class="fas fa-info-circle mr-1"></i>This will create a coupon scoped to All products
								</small>
							</div>
						</div>
					</form>

					<!-- Selected Category Form-->
					<form id="formSelected" class="brand-form p-4 mt-4 d-none">
						<div class="form-section-header">
							<i class="fas fa-bullseye mr-2"></i>Specific Product Coupon
						</div>

						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="font-weight-medium">
									<i class="fas fa-layer-group icon-brand"></i>Select Category
								</label>
								<select id="selCategory" class="form-control">
									<option value="">--Choose Category--</option>
									<?php foreach ($cats as $c): ?>
										<option value="<?= (int)$c['id'] ?>"><?= $c['category_name'] ?></option>
									<?php endforeach; ?>
								</select>
							</div>
							<div class="form-group col-md-6">
								<label class="font-weight-medium">
									<i class="fas fa-box icon-brand"></i>Select Product
								</label>
								<select id="selProduct" class="form-control" disabled>
									<option value="">---Choose Product--</option>
								</select>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-6">
								<label class="font-weight-medium">
									<i class="fas fa-tag icon-brand"></i>Coupon Code
								</label>
								<input type="text" name="sp_code" id="sp_code" class="form-control" placeholder="e.g. SAVE15" required>
							</div>
							<div class="form-group col-md-6">
								<label class="font-weight-medium">
									<i class="fas fa-percentage icon-brand"></i>Discount %
								</label>
								<input type="number" name="sp_discount" id="sp_discount" class="form-control" min="1" max="95" step="0.01" placeholder="15" required>
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-4">
								<label class="font-weight-medium">
									<i class="fas fa-users icon-brand"></i>Usage Limit
								</label>
								<input type="number" name="usages_limit" id="usages_limit" class="form-control" min="1" placeholder="e.g 100">
							</div>
							<div class="form-group col-md-4">
								<label class="font-weight-medium">
									<i class="fas fa-calendar-plus icon-brand"></i>Start Date
								</label>
								<input type="date" name="sp_start" id="sp_start" class="form-control">
							</div>
							<div class="form-group col-md-4">
								<label class="font-weight-medium">
									<i class="fas fa-calendar-times icon-brand"></i>End Date
								</label>
								<input type="date" name="sp_end" id="sp_end" class="form-control">
							</div>
						</div>

						<div class="form-row">
							<div class="form-group col-md-12">
								<label class="font-weight-medium">
									<i class="fas fa-toggle-on icon-brand"></i>Status
								</label>
								<select id="sp_status" class="form-control">
									<option value="active" selected>Active</option>
									<option value="inactive">Inactive</option>
								</select>
							</div>
						</div>

						<div class="text-center mt-4">
							<button type="button" id="btnCreateSelected" class="btn btn-brand btn-lg">
								<i class="fas fa-bullseye mr-2"></i>Create Coupon for Selected Product
							</button>
							<div class="mt-2">
								<small class="text-muted">
									<i class="fas fa-info-circle mr-1"></i>This coupon will be attached to the chosen product only.
								</small>
							</div>
						</div>
					</form>

					<div id="cpnMsg" class="mt-4"></div>
				</div>
			</div>
		</div>

		<div class="col-lg-6 mb-4">
			<div class="card brand-card">
				<div class="card-header brand-card-header">
					<i class="fas fa-history mr-2"></i>Recent Coupons
					<span class="badge badge-light ml-2"><?= count($coupons) ?></span>
				</div>
				<div class="card-body p-0">
					<div class="table-responsive">
						<table class="table table-brand table-hover mb-0">
							<thead>
								<tr>
									<th><i class="fas fa-tag mr-1"></i>Code</th>
									<th><i class="fas fa-percentage mr-1"></i>%</th>
									<th><i class="fas fa-crosshairs mr-1"></i>Scope</th>
									<th><i class="fas fa-toggle-on mr-1"></i>Status</th>
									<th><i class="fas fa-calendar mr-1"></i>Valid</th>
									<th><i class="fas fa-cogs mr-1"></i>Action</th>
								</tr>
							</thead>
							<tbody>
								<?php if (!$coupons): ?>
									<tr>
										<td colspan="6" class="text-center text-muted py-5">
											<i class="fas fa-ticket-alt fa-3x mb-3 opacity-25"></i><br>
											No Coupons Found!<br>
											<small>Create your first coupon above</small>
										</td>
									</tr>
									<?php else: foreach ($coupons as $cp): ?>
										<tr>
											<td>
												<span class="font-weight-bold text-uppercase">
													<?= htmlspecialchars($cp['code']) ?>
												</span>
											</td>
											<td>
												<span class="badge badge-brand-primary">
													<?= number_format((float)$cp['discount_percent'], 2) ?>%
												</span>
											</td>
											<td>
												<?php if ($cp['scope'] === 'product'): ?>
													<span class="badge badge-info mb-1">
														<i class="fas fa-box mr-1"></i>Product
													</span><br>
													<small class="text-muted">
														<?= htmlspecialchars($cp['product_names']) ?>
													</small>
												<?php else: ?>
													<span class="badge badge-<?= $cp['scope'] === 'all' ? 'brand-primary' : 'secondary' ?>">
														<i class="fas fa-<?= $cp['scope'] === 'all' ? 'globe' : 'layer-group' ?> mr-1"></i>
														<?= ucfirst($cp['scope']) ?>
													</span>
												<?php endif; ?>
											</td>
											<td>
												<span class="badge badge-<?= $cp['status'] === 'active' ? 'success' : 'secondary' ?>">
													<i class="fas fa-<?= $cp['status'] === 'active' ? 'check-circle' : 'pause-circle' ?> mr-1"></i>
													<?= ucfirst($cp['status']) ?>
												</span>
											</td>
											<td>
												<small class="text-muted">
													<?php
													$sv = $cp['start_date'] ? date('d M Y', strtotime($cp['start_date'])) : '_';
													$ev = $cp['end_date'] ? date('d M Y', strtotime($cp['end_date'])) : '_';
													echo $sv . '<br><i class="fas fa-arrow-down"></i><br>' . $ev;
													?>
												</small>
											</td>
											<td>
												<a href="?page=edit_coupon&id=<?= $cp['id'] ?>"
													class="btn btn-sm btn-warning action-btn mb-1"
													title="Edit Coupon">
													<i class="fas fa-edit"></i>
												</a><br>
												<a href="?page=delete_coupon&id=<?= $cp['id'] ?>"
													onclick="return confirm('Are you sure you want to delete this coupon?')"
													class="btn btn-sm btn-danger action-btn"
													title="Delete Coupon">
													<i class="fas fa-trash"></i>
												</a>
											</td>
										</tr>
								<?php endforeach;
								endif; ?>
							</tbody>
						</table>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>

<script>
	document.querySelectorAll('input[name="apply_to"]').forEach(r => {
		r.addEventListener('change', function() {
			document.getElementById('formAll').classList.toggle('d-none', this.value !== 'all');
			document.getElementById('formSelected').classList.toggle('d-none', this.value === 'all');
		});
	});

	// All Products form submit
	document.getElementById('formAll').addEventListener('submit', function(e) {
		e.preventDefault();

		// Add loading state
		const submitBtn = this.querySelector('button[type="submit"]');
		const originalText = submitBtn.innerHTML;
		submitBtn.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
		submitBtn.disabled = true;

		const fd = new FormData(this);
		fd.append('mode', 'all');

		fetch('ajax/save_coupon.php', {
			method: 'POST',
			body: fd,
			credentials: 'same-origin'
		}).then(r => r.json()).then(d => {
			showMsg(d);
			if (d.ok) this.reset();
		}).catch(() => showMsg({
			ok: false,
			msg: 'Unexpected Error!'
		})).finally(() => {
			submitBtn.innerHTML = originalText;
			submitBtn.disabled = false;
		});
	});

	// Selected Category Product Load
	document.getElementById('selCategory').addEventListener('change', function() {
		const cid = this.value;
		const sel = document.getElementById('selProduct');
		sel.innerHTML = '<option value=""><i class="fas fa-spinner fa-spin"></i> Loading...</option>';
		sel.disabled = true;

		fetch('ajax/get_products_by_category.php?category_id=' + encodeURIComponent(cid))
			.then(r => r.json()).then(d => {
				sel.innerHTML = '<option value="">Choose Product</option>';
				if (d && d.items && d.items.length) {
					d.items.forEach(it => {
						const opt = document.createElement('option');
						opt.value = it.id;
						opt.textContent = it.name;
						sel.appendChild(opt);
					});
					sel.disabled = false;
				} else sel.innerHTML = '<option value="">No products found!</option>';
			}).catch(() => sel.innerHTML = '<option value="">Error Loading</option>');
	});

	// Selected Products form submit
	document.getElementById('btnCreateSelected').addEventListener('click', function() {
		const cid = document.getElementById('selCategory').value;
		const pid = document.getElementById('selProduct').value;
		const code = document.getElementById('sp_code').value.trim();
		const disc = document.getElementById('sp_discount').value;
		const status = document.getElementById('sp_status').value;
		const sd = document.getElementById('sp_start').value;
		const ed = document.getElementById('sp_end').value;
		const ul = document.getElementById('usages_limit').value;

		if (!cid) return showMsg({
			ok: false,
			msg: 'Please choose a category'
		});
		if (!pid) return showMsg({
			ok: false,
			msg: 'Please choose a product'
		});
		if (!code) return showMsg({
			ok: false,
			msg: 'Please enter a coupon code'
		});
		if (!disc || parseFloat(disc) <= 0) return showMsg({
			ok: false,
			msg: 'Invalid discount percent'
		});

		// Add loading state
		const originalText = this.innerHTML;
		this.innerHTML = '<i class="fas fa-spinner fa-spin mr-2"></i>Creating...';
		this.disabled = true;

		const fd = new FormData();
		fd.append('mode', 'selected');
		fd.append('product_id', pid);
		fd.append('code', code);
		fd.append('discount_percent', disc);
		fd.append('status', status);
		fd.append('start_date', sd);
		fd.append('end_date', ed);
		fd.append('usages_limit', ul);

		fetch('ajax/save_coupon.php', {
				method: 'POST',
				body: fd,
				credentials: 'same-origin'
			})
			.then(r => r.json()).then(d => {
				showMsg(d);
				if (d.ok) {
					document.getElementById('sp_code').value = '';
					document.getElementById('sp_discount').value = '';
					document.getElementById('usages_limit').value = '';
				}
			}).catch(() => showMsg({
				ok: false,
				msg: 'Unexpected Error for selected coupon'
			})).finally(() => {
				this.innerHTML = originalText;
				this.disabled = false;
			});
	});

	function showMsg(d) {
		const el = document.getElementById('cpnMsg');
		if (!el) return;
		el.innerHTML = '';
		const div = document.createElement('div');
		div.className = 'alert alert-' + (d.ok ? 'success' : 'warning') + ' alert-dismissible fade show alert-brand';
		div.innerHTML = '<i class="fas fa-' + (d.ok ? 'check-circle' : 'exclamation-triangle') + ' mr-2"></i>' +
			(d.msg || (d.ok ? 'Success' : 'Failed')) +
			'<button type="button" class="close" data-dismiss="alert"><span>&times;</span></button>';
		el.appendChild(div);

		// Auto dismiss after 5 seconds
		setTimeout(() => {
			if (div.parentNode) {
				div.remove();
			}
		}, 5000);
	}
</script>