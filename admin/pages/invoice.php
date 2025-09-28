<?php
require_once __DIR__ . '/../../config/dbconfig.php';

// ডাটাবেস কানেকশন তৈরি করুন
$database = new Database();
$pdo = $database->dbConnection(); // $pdo ভেরিয়েবলটি এখন ডাটাবেস কানেকশন ধারণ করবে

// Check if sale_id is passed in the URL
if (!isset($_GET['id'])) {
    die("Invalid invoice request.");
}

$sale_id = $_GET['id'];

// Fetch data from orders table instead of sales table
$sql = "SELECT * FROM orders WHERE global_order_id = ?";
$stmt = $pdo->prepare($sql);  // Use $pdo here for database connection
$stmt->execute([$sale_id]);
$order = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$order) {
    die("Invoice not found.");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Invoice #<?php echo $order['global_order_id']; ?></title>
    <style>
        body {
            font-family: Arial;
        }

        .invoice-box {
            width: 700px;
            margin: auto;
            padding: 20px;
            border: 1px solid #eee;
        }

        table {
            width: 100%;
            border-collapse: collapse;
        }

        table td {
            padding: 8px;
        }

        table th {
            border-bottom: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        .total {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <div class="invoice-box">
        <h2>Invoice</h2>
        <p><b>Invoice No:</b> INV-<?php echo $order['global_order_id']; ?><br>
            <b>Date:</b> <?php echo $order['order_date']; ?>
        </p>

        <h3>Customer Info</h3>
        <p>
            <b>Name:</b> <?php echo $order['user_name']; ?><br>
            <b>Phone:</b> <?php echo $order['phone']; ?><br>
            <b>Address:</b> <?php echo $order['address']; ?>
        </p>

        <h3>Order Summary</h3>
        <table>
            <tr>
                <th>Description</th>
                <th>Total</th>
                <th>Payable</th>
            </tr>
            <tr>
                <td>Order #<?php echo $order['global_order_id']; ?></td>
                <td><?php echo number_format($order['total_amount'], 2); ?></td>
                <td><?php echo number_format($order['payable_amount'], 2); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="right" class="total">Grand Total:</td>
                <td class="total"><?php echo number_format($order['payable_amount'], 2); ?></td>
            </tr>
        </table>

        <br>
        <button onclick="window.print()">🖨️ Print Invoice</button>
    </div>
</body>

</html>