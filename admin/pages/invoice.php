<?php
require_once "../../config/db.php";

if (!isset($_GET['id'])) {
    die("Invalid invoice request.");
}

$sale_id = $_GET['id'];

// sales data fetch
$sql = "SELECT * FROM sales WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->execute([$sale_id]);
$sale = $stmt->fetch(PDO::FETCH_ASSOC);

if (!$sale) {
    die("Invoice not found.");
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Invoice #<?php echo $sale['id']; ?></title>
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
        <p><b>Invoice No:</b> INV-<?php echo $sale['id']; ?><br>
            <b>Date:</b> <?php echo $sale['sale_date']; ?>
        </p>

        <h3>Customer Info</h3>
        <p>
            <b>Name:</b> <?php echo $sale['user_name']; ?><br>
            <b>Phone:</b> <?php echo $sale['phone']; ?><br>
            <b>Address:</b> <?php echo $sale['address']; ?>
        </p>

        <h3>Order Summary</h3>
        <table>
            <tr>
                <th>Description</th>
                <th>Total</th>
                <th>Payable</th>
            </tr>
            <tr>
                <td>Order #<?php echo $sale['order_id']; ?></td>
                <td><?php echo number_format($sale['total_amount'], 2); ?></td>
                <td><?php echo number_format($sale['payable_amount'], 2); ?></td>
            </tr>
            <tr>
                <td colspan="2" align="right" class="total">Grand Total:</td>
                <td class="total"><?php echo number_format($sale['payable_amount'], 2); ?></td>
            </tr>
        </table>

        <br>
        <button onclick="window.print()">🖨️ Print Invoice</button>
    </div>
</body>

</html>