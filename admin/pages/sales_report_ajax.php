<?php
require_once __DIR__ . "/../../config/dbconfig.php";

$database = new Database();
$pdo = $database->dbConnection();

$start = $_GET['start_date'] ?? '';
$end   = $_GET['end_date'] ?? '';
$month = $_GET['month'] ?? '';
$year  = $_GET['year'] ?? '';

$params = [];
$where = " WHERE 1=1 ";

if ($start && $end) {
    $where .= " AND DATE(order_date) BETWEEN ? AND ? ";
    $params[] = $start;
    $params[] = $end;
} elseif ($month && $year) {
    $where .= " AND MONTH(order_date) = ? AND YEAR(order_date) = ? ";
    $params[] = $month;
    $params[] = $year;
}

$sql = "SELECT global_order_id, user_name, total_amount, status, order_date 
        FROM orders
        $where
        GROUP BY global_order_id, user_name, total_amount, status, order_date
        ORDER BY order_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

$totalSql = "SELECT COALESCE(SUM(total_amount), 0) AS total_amount FROM orders $where";
$totalStmt = $pdo->prepare($totalSql);
$totalStmt->execute($params);
$totalRow = $totalStmt->fetch(PDO::FETCH_ASSOC);
$totalAmount = $totalRow['total_amount'] ?? 0.00;
?>

<table>
    <tr>
        <th>Date</th>
        <th>Customer</th>
        <th>Order ID</th>
        <th>Amount</th>
        <th>Status</th>
        <th>Invoice</th>
    </tr>
    <?php foreach ($orders as $s): ?>
        <tr>
            <td><?= $s['order_date'] ?></td>
            <td><?= htmlspecialchars($s['user_name']) ?></td>
            <td><?= $s['global_order_id'] ?></td>
            <td><?= number_format($s['total_amount'], 2) ?></td>
            <td><?= htmlspecialchars($s['status']) ?></td>
            <td><a href="pages/invoice.php?id=<?= $s['global_order_id'] ?>" target="_blank">View/Print</a></td>
        </tr>
    <?php endforeach; ?>
    <tr>
        <th colspan="5" style="text-align:right">Total</th>
        <th colspan="1"><?= number_format($totalAmount, 2) ?></th>
    </tr>
</table>