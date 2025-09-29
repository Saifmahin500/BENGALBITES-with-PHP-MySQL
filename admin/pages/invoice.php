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
$sql = "SELECT o.global_order_id,
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
		JOIN products p ON p.id = o.product_id WHERE o.global_order_id = ?";
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
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Invoice #<?php echo $order['global_order_id']; ?></title>

    <!-- Bootstrap 4.6 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --brand-color: #3485A7;
        }

        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
        }

        .invoice-container {
            background: white;
            max-width: 800px;
            margin: 2rem auto;
            box-shadow: 0 0 20px rgba(0, 0, 0, 0.1);
        }

        .invoice-header {
            padding: 2rem;
            border-bottom: 3px solid var(--brand-color);
        }

        .company-name {
            font-size: 2rem;
            font-weight: bold;
            color: var(--brand-color);
            margin-bottom: 0;
        }

        .invoice-title {
            font-size: 1.5rem;
            color: #6c757d;
            margin-bottom: 0;
        }

        .invoice-body {
            padding: 2rem;
        }

        .invoice-info {
            background-color: #f8f9fa;
            padding: 1rem;
            border-left: 4px solid var(--brand-color);
            margin-bottom: 1.5rem;
        }

        .info-label {
            font-weight: 600;
            color: #495057;
            margin-right: 0.5rem;
        }

        .simple-table {
            border: 1px solid #dee2e6;
        }

        .simple-table th {
            background-color: var(--brand-color);
            color: white;
            padding: 1rem;
            border: none;
            font-weight: 600;
        }

        .simple-table td {
            padding: 1rem;
            border-bottom: 1px solid #dee2e6;
        }

        .simple-table .total-row {
            background-color: #f8f9fa;
            font-weight: 600;
        }

        .btn-print {
            background-color: var(--brand-color);
            border-color: var(--brand-color);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 5px;
        }

        .btn-print:hover {
            background-color: #2a6b85;
            border-color: #2a6b85;
            color: white;
        }

        .text-brand {
            color: var(--brand-color);
        }

        /* Print Styles */
        @media print {
            body {
                background: white;
            }

            .invoice-container {
                box-shadow: none;
                margin: 0;
                max-width: none;
            }

            .btn-print {
                display: none;
            }
        }
    </style>
</head>

<body>
    <div class="invoice-container">
        <!-- Invoice Header -->
        <div class="invoice-header">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="company-name">🍴BENGALBITES</h1>
                    <h2 class="invoice-title">Invoice</h2>
                </div>
                <div class="col-md-6 text-md-right">
                    <p class="mb-1"><strong>Invoice No:</strong> INV-<?php echo $order['global_order_id']; ?></p>
                    <p class="mb-0"><strong>Date:</strong> <?php echo $order['order_date']; ?></p>
                </div>
            </div>
        </div>

        <!-- Invoice Body -->
        <div class="invoice-body">
            <!-- Customer Information -->
            <div class="row">
                <div class="col-md-6">
                    <div class="invoice-info">
                        <h5 class="text-brand mb-3">Customer Information</h5>
                        <p class="mb-2">
                            <span class="info-label">Name:</span>
                            <?php echo htmlspecialchars($order['user_name']); ?>
                        </p>
                        <p class="mb-2">
                            <span class="info-label">Phone:</span>
                            <?php echo htmlspecialchars($order['phone']); ?>
                        </p>
                        <p class="mb-2">
                            <span class="info-label">Area:</span>
                            <?php echo htmlspecialchars($order['area']); ?>
                        </p>
                        <p class="mb-0">
                            <span class="info-label">Address:</span>
                            <?php echo htmlspecialchars($order['address']); ?>
                        </p>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="invoice-info">
                        <h5 class="text-brand mb-3">Order Details</h5>
                        <p class="mb-2">
                            <span class="info-label">Order ID:</span>
                            #<?php echo $order['global_order_id']; ?>
                        </p>
                        <p class="mb-2">
                            <span class="info-label">Date:</span>
                            <?php echo date('M d, Y', strtotime($order['order_date'])); ?>
                        </p>
                        <!-- <p class="mb-0">
                            <span class="info-label">Status:</span>
                            <?php echo ucfirst($order['status']); ?>
                        </p> -->
                    </div>
                </div>
            </div>

            <!-- Order Summary -->
            <h5 class="text-brand mb-3">Order Summary</h5>
            <div class="table-responsive">
                <table class="table simple-table mb-4">
                    <thead>
                        <tr>
                            <th>Description</th>
                            <th class="text-right">Total</th>
                            <th class="text-right">Discount</th>
                            <th class="text-right">Payable</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td>
                                <strong>Products:</strong><br>
                                <?php echo htmlspecialchars($order['items']); ?>
                            </td>
                            <td class="text-right"><?php echo number_format($order['total_amount'], 2); ?></td>
                            <td class="text-right"><?php echo number_format($order['coupon_discount'], 2); ?></td>
                            <td class="text-right"><?php echo number_format($order['payable_amount'], 2); ?></td>
                        </tr>
                        <tr class="total-row">
                            <td colspan="3" class="text-right"><strong>Grand Total:</strong></td>
                            <td class="text-right"><strong>৳ <?php echo number_format($order['payable_amount'], 2); ?></strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>

            <!-- Print Button -->
            <div class="text-center">
                <button onclick="window.print()" class="btn btn-print">
                    <i class="fas fa-print mr-2"></i>Print Invoice
                </button>
            </div>

            <!-- Footer -->
            <div class="text-center mt-4 pt-4" style="border-top: 1px solid #dee2e6;">
                <p class="text-muted mb-0">
                    <small>Thank you for your business with BengalBites!</small>
                </p>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>