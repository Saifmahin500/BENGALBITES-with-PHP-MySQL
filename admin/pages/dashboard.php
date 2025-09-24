<?php
require_once __DIR__ . '/../../config/dbconfig.php';

$database = new Database();
$pdo = $database->dbConnection();

// 1. Total Orders
$stmt = $pdo->query("SELECT COUNT(*) as total_orders FROM orders");
$total_orders = $stmt->fetch(PDO::FETCH_ASSOC)['total_orders'];

// 2. Total Sales (Completed Orders)
$stmt = $pdo->query("SELECT SUM(total_amount) as total_sales FROM orders WHERE status='completed'");
$total_sales = $stmt->fetch(PDO::FETCH_ASSOC)['total_sales'] ?? 0;

// 3. Pending Orders
$stmt = $pdo->query("SELECT COUNT(*) as pending_orders FROM orders WHERE status='pending'");
$pending_orders = $stmt->fetch(PDO::FETCH_ASSOC)['pending_orders'];

// 4. Total Customers
$stmt = $pdo->query("SELECT COUNT(*) as total_customers FROM customers");
$total_customers = $stmt->fetch(PDO::FETCH_ASSOC)['total_customers'];

// 5. Monthly Sales Data (for Chart)
$stmt = $pdo->query("
    SELECT DATE_FORMAT(order_date, '%Y-%m') as month, SUM(total_amount) as monthly_sales
    FROM orders
    WHERE status='completed'
    GROUP BY month
    ORDER BY month
");
$months = [];
$sales = [];
while ($row = $stmt->fetch(PDO::FETCH_ASSOC)) {
    $months[] = $row['month'];
    $sales[] = $row['monthly_sales'];
}

// 6. Recent Orders (Last 5 Orders)
$stmt = $pdo->query("
    SELECT o.global_order_id, c.name as customer, o.total_amount, o.status, o.order_date
    FROM orders o
    JOIN customers c ON o.user_id = c.id
    ORDER BY o.order_date DESC
    LIMIT 5
");
$recent_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>




<!DOCTYPE html>
<html>

<head>
    <title>Dashboard</title>
</head>

<body>
    <h2>Dashboard</h2>
    <div class="row">
        <div class="col-md-3">
            <div class="card bg-primary text-white mb-3">
                <div class="card-body">
                    <h5>Total Orders</h5>
                    <h3><?php echo $total_orders; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-success text-white mb-3">
                <div class="card-body">
                    <h5>Total Sales</h5>
                    <h3><?php echo $total_sales; ?> ৳</h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-warning text-white mb-3">
                <div class="card-body">
                    <h5>Pending Orders</h5>
                    <h3><?php echo $pending_orders; ?></h3>
                </div>
            </div>
        </div>

        <div class="col-md-3">
            <div class="card bg-info text-white mb-3">
                <div class="card-body">
                    <h5>Total Customers</h5>
                    <h3><?php echo $total_customers; ?></h3>
                </div>
            </div>
        </div>
    </div>

    <div class="card mt-4">
        <div class="card-body">
            <h5>Monthly Sales Report</h5>
            <canvas id="salesChart"></canvas>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Monthly Sales',
                    data: <?php echo json_encode($sales); ?>,
                    borderColor: 'blue',
                    backgroundColor: 'rgba(0, 123, 255, 0.3)',
                    fill: true
                }]
            }
        });
    </script>


    <div class="card mt-4">
        <div class="card-body">
            <h5>Recent Orders</h5>
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Customer</th>
                        <th>Amount</th>
                        <th>Status</th>
                        <th>Date</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($recent_orders as $order): ?>
                        <tr>
                            <td><?php echo $order['global_order_id']; ?></td>
                            <td><?php echo $order['customer']; ?></td>
                            <td><?php echo $order['total_amount']; ?> ৳</td>
                            <td><?php echo ucfirst($order['status']); ?></td>
                            <td><?php echo $order['order_date']; ?></td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>


</body>

</html>