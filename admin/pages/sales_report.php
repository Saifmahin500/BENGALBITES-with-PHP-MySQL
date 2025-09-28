<?php
require_once __DIR__ . "/../../config/dbconfig.php";

// ডাটাবেস কানেকশন তৈরি করুন
$database = new Database();
$pdo = $database->dbConnection(); // $pdo ভেরিয়েবলটি এখন ডাটাবেস কানেকশন ধারণ করবে

$start = $_GET['start_date'] ?? '';
$end   = $_GET['end_date'] ?? '';
$month = $_GET['month'] ?? '';
$year  = $_GET['year'] ?? '';

$params = [];
$where = " WHERE 1=1 ";

// date range takes priority
if ($start && $end) {
    $where .= " AND DATE(order_date) BETWEEN ? AND ? ";
    $params[] = $start;
    $params[] = $end;
} elseif ($month && $year) {
    $where .= " AND MONTH(order_date) = ? AND YEAR(order_date) = ? ";
    $params[] = $month;
    $params[] = $year;
}

// fetch rows from orders table
$sql = "SELECT global_order_id, user_name, total_amount, status, order_date 
        FROM orders
        $where
        GROUP BY global_order_id, user_name, total_amount, status, order_date
        ORDER BY order_date DESC";
$stmt = $pdo->prepare($sql);
$stmt->execute($params);
$orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

// total amount calculation from orders table
$totalSql = "SELECT COALESCE(SUM(total_amount), 0) AS total_amount FROM orders $where";
$totalStmt = $pdo->prepare($totalSql);
$totalStmt->execute($params);
$totalRow = $totalStmt->fetch(PDO::FETCH_ASSOC);
$totalAmount = $totalRow['total_amount'] ?? 0.00;

// CSV export
if (isset($_GET['export']) && $_GET['export'] === 'csv') {
    header('Content-Type: text/csv; charset=utf-8');
    header('Content-Disposition: attachment; filename=sales_report_' . date('Ymd') . '.csv');
    $out = fopen('php://output', 'w');
    fputcsv($out, ['Order Date', 'Customer Name', 'Order ID', 'Amount', 'Status']);
    foreach ($orders as $r) {
        fputcsv($out, [$r['order_date'], $r['user_name'], $r['global_order_id'], $r['total_amount'], $r['status']]);
    }
    fclose($out);
    exit;
}
?>

<!doctype html>
<html>

<head>
    <meta charset="utf-8">
    <title>Sales Report</title>
    <style>
        table {
            border-collapse: collapse;
            width: 100%;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 8px;
        }

        th {
            background: #f4f4f4;
        }

        .filters {
            margin-bottom: 12px;
        }
    </style>
</head>

<body>
    <h2>Sales Report</h2>

    <form method="get" class="filters" action="pages/sales_report.php">
        Start: <input type="date" name="start_date" value="<?= htmlspecialchars($start) ?>">
        End: <input type="date" name="end_date" value="<?= htmlspecialchars($end) ?>">
        Or Month:
        <select name="month">
            <option value="">--</option>
            <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= $m ?>" <?= ($month == $m) ? 'selected' : '' ?>><?= $m ?></option>
            <?php endfor; ?>
        </select>
        <input type="number" name="year" min="2000" max="2099" value="<?= htmlspecialchars($year ?: date('Y')) ?>">
        <button type="submit">Filter</button>
        <a href="?<?= http_build_query(array_merge($_GET, ['export' => 'csv'])) ?>">Export CSV</a>
    </form>

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
</body>

</html>