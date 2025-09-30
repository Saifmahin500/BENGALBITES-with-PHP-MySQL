<?php
if (session_status() === PHP_SESSION_NONE) session_start();
if (!isset($_SESSION['admin_logged_in'])) {
    http_response_code(403);
    exit('Forbidden');
}

require_once __DIR__ . '/../dbConfig.php';

try {
    $sql = "
    SELECT o.global_order_id,
           GROUP_CONCAT(CONCAT(p.product_name, ' (', o.quantity,')') ORDER BY o.id SEPARATOR ', ') AS items,
           MIN(o.user_name) AS user_name,
           MIN(o.phone) AS phone,
           MIN(o.area) AS area,
           MIN(o.address) AS address,
           MIN(o.status) AS status,
           MIN(o.order_date) AS order_date,
           SUM(o.total_amount) AS total_amount,
           SUM(o.coupon_discount) AS coupon_discount,
           SUM(o.payable_amount) AS payable_amount
    FROM orders o
    JOIN products p ON p.id = o.product_id
    WHERE o.status IN ('pending')
    GROUP BY o.global_order_id
    ORDER BY order_date DESC";

    $st = $DB_con->query($sql);
    $rows = $st->fetchAll(PDO::FETCH_ASSOC);
} catch (Throwable $e) {
    echo "<div class='alert alert-danger'>DB Error loading orders</div>";
    exit;
}
?>

<?php if (!$rows): ?>
    <div class="alert alert-info">No pending orders</div>
<?php else: ?>
<div class="table-responsive">
    <table class="table table-bordered table-striped">
        <thead style="background:#3485A7; color:white;">
            <tr>
                <th>Order ID</th>
                <th>User</th>
                <th>Products (qty)</th>
                <th>Address</th>
                <th class="text-right">Total</th>
                <th class="text-right">Discount</th>
                <th class="text-right">Payable</th>
                <th>Status</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($rows as $r): ?>
            <tr>
                <td><strong><?= $r['global_order_id'] ?></strong><br><small><?= $r['order_date'] ?></small></td>
                <td><?= $r['user_name'] ?><br><small><?= $r['phone'] ?></small></td>
                <td><?= $r['items'] ?></td>
                <td><?= $r['address'] ?>, <?= $r['area'] ?></td>
                <td class="text-right"><?= number_format((float)$r['total_amount'],2) ?></td>
                <td class="text-right"><?= number_format((float)$r['coupon_discount'],2) ?></td>
                <td class="text-right"><?= number_format((float)$r['payable_amount'],2) ?></td>
                <td>
                    <select class="form-control form-control-sm order-status" data-gid="<?= $r['global_order_id'] ?>">
                        <option value="pending" <?= $r['status']=='pending'?'selected':'' ?>>Pending</option>
                        <option value="delivered" <?= $r['status']=='delivered'?'selected':'' ?>>Delivered</option>
                        <option value="completed" <?= $r['status']=='completed'?'selected':'' ?>>Completed</option>
                        <option value="cancelled" <?= $r['status']=='cancelled'?'selected':'' ?>>Cancelled</option>
                    </select>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<?php endif; ?>
