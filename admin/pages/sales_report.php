<?php
require_once __DIR__ . '/../../config/dbconfig.php';

// Database Connection
$database = new Database();
$conn = $database->dbConnection();

// Default query: সব sales দেখাবে (Shows all sales)
$query = "SELECT * FROM sales ORDER BY sale_date DESC";
$params = [];

// যদি filter apply হয় (If filter is applied)
if (!empty($_GET['from_date']) && !empty($_GET['to_date'])) {
    // Filter by Date Range
    $query = "SELECT * FROM sales WHERE DATE(sale_date) BETWEEN ? AND ? ORDER BY sale_date DESC";
    $params = [$_GET['from_date'], $_GET['to_date']];
} elseif (!empty($_GET['month'])) {
    // Filter by Month
    $query = "SELECT * FROM sales WHERE DATE_FORMAT(sale_date, '%Y-%m') = ? ORDER BY sale_date DESC";
    $params = [$_GET['month']];
}

$stmt = $conn->prepare($query);
$stmt->execute($params);
$sales = $stmt->fetchAll(PDO::FETCH_ASSOC);

// Initialize grand total before use in the loop
$grand_total = 0;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sales Report</title>
    <style>
        /* Simple styling for better presentation */
        body {
            font-family: Arial, sans-serif;
            padding: 20px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            margin-top: 20px;
        }

        th,
        td {
            border: 1px solid #ddd;
            padding: 10px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }

        .filter-form {
            display: inline-block;
            margin-right: 20px;
        }
    </style>
</head>

<body>
    <h1>Sales Report</h1>

    <div class="filter-controls">
        <form method="GET" class="filter-form">
            <label>From: <input type="date" name="from_date" value="<?= htmlspecialchars($_GET['from_date'] ?? '') ?>"></label>
            <label>To: <input type="date" name="to_date" value="<?= htmlspecialchars($_GET['to_date'] ?? '') ?>"></label>
            <button type="submit">Filter by Date</button>
        </form>

        <form method="GET" class="filter-form">
            <label>Month: <input type="month" name="month" value="<?= htmlspecialchars($_GET['month'] ?? '') ?>"></label>
            <button type="submit">Filter by Month</button>
        </form>
    </div>

    <br>

    <table>
        <thead>
            <tr>
                <th>Invoice No</th>
                <th>Customer</th>
                <th>Phone</th>
                <th>Date</th>
                <th>Total</th>
                <th>Payable</th>
                <th>Status</th>
                <th>Action</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($sales as $row) :
                // Calculate grand total inside the loop
                $grand_total += (float) $row['payable_amount'];
            ?>
                <tr>
                    <td>#INV-<?= htmlspecialchars($row['id']) ?></td>
                    <td><?= htmlspecialchars($row['user_name']) ?></td>
                    <td><?= htmlspecialchars($row['phone']) ?></td>
                    <td><?= htmlspecialchars($row['sale_date']) ?></td>
                    <td><?= number_format($row['total_amount'], 2) ?></td>
                    <td><?= number_format($row['payable_amount'], 2) ?></td>
                    <td><?= htmlspecialchars(ucfirst($row['status'])) ?></td>
                    <td>
                        <a href="invoice.php?id=<?= htmlspecialchars($row['id']) ?>" target="_blank">Invoice</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr>
                <td colspan="5" style="text-align: right;"><b>Grand Total:</b></td>
                <td colspan="3"><b><?= number_format($grand_total, 2) ?></b></td>
            </tr>
        </tfoot>
    </table>
</body>

</html>