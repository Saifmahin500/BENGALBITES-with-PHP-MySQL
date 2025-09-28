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
$stmt = $pdo->query("SELECT COUNT(*) as total_customers FROM orders");
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
    SELECT global_order_id, user_name, total_amount, status, order_date 
    FROM orders
    GROUP BY global_order_id, user_name, total_amount, status, order_date
    ORDER BY order_date DESC
    LIMIT 5
");
$recent_orders = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <!-- Bootstrap 4.6 CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        :root {
            --primary-color: #3485A7;
            --secondary-color:rgb(106, 193, 212);
            --light-green: #f8fffe;
        }

        body {
            background-color: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .navbar {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1e4239 100%);
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
        }

        .page-header {
           
            color: black;
            padding: 2rem 0;
            margin-bottom: 2rem;
        }

        .stats-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
            overflow: hidden;
            position: relative;
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.15);
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 4px;
            background: var(--primary-color);
        }

        .stats-card .card-body {
            padding: 2rem;
            background: white;
        }

        .stats-icon {
            width: 60px;
            height: 60px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            margin-bottom: 1rem;
        }

        .primary-bg {
            background: var(--primary-color);
        }

        .success-bg {
            background: #28a745;
        }

        .warning-bg {
            background: #ffc107;
        }

        .info-bg {
            background: #17a2b8;
        }

        .stat-number {
            font-size: 2.5rem;
            font-weight: bold;
            color: var(--primary-color);
            margin-bottom: 0.5rem;
        }

        .stat-label {
            color: #6c757d;
            font-weight: 500;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
        }

        .chart-card,
        .table-card {
            border: none;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.08);
            overflow: hidden;
        }

        .card-header {
            background: linear-gradient(135deg, var(--primary-color) 0%, #1e4239 100%);
            border: none;
            color: white;
            padding: 1.5rem 2rem;
        }

        .card-title {
            color: white;
            font-weight: 600;
            font-size: 1.25rem;
            margin-bottom: 0;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            /* background: var(--secondary-color); */
            color: black;
            font-weight: 700;
            border: none;
            text-transform: uppercase;
            font-size: 0.875rem;
            letter-spacing: 0.5px;
            padding: 1rem;
        }

        .table tbody td {
            padding: 1rem;
            border-color: #f8f9fa;
            vertical-align: middle;
        }

        .status-badge {
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-weight: 500;
            font-size: 0.875rem;
        }

        .status-completed {
            background: #d4edda;
            color: #155724;
        }

        .status-pending {
            background: #fff3cd;
            color: #856404;
        }

        .status-cancelled {
            background: #f8d7da;
            color: #721c24;
        }

        .chart-container {
            position: relative;
            height: 400px;
            padding: 2rem;
        }

        @media (max-width: 768px) {
            .stat-number {
                font-size: 2rem;
            }

            .stats-card .card-body {
                padding: 1.5rem;
            }

            .chart-container {
                height: 300px;
                padding: 1rem;
            }
        }
    </style>
</head>

<body>
    <!-- Navigation Bar -->
    <nav class="navbar navbar-expand-lg navbar-dark">
        <div class="container-fluid">
            <a class="navbar-brand font-weight-bold" href="#"><i class="fas fa-chart-line mr-2"></i>Admin Dashboard</a>
        </div>
    </nav>

    <!-- Page Header -->
    <div class="page-header">
        <div class="container-fluid">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h1 class="mb-0"><i class="fas fa-tachometer-alt mr-3"></i>Dashboard Overview</h1>
                    <p class="mb-0 mt-2 opacity-75">Welcome back! Here's what's happening with your business.</p>
                </div>
                <div class="col-md-6 text-md-right">
                    <small class="text-black-50">Last updated: <?php echo date('F j, Y - g:i A'); ?></small>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">
        <!-- Statistics Cards -->
        <div class="row mb-4">
            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <div class="stats-icon primary-bg text-white mx-auto">
                            <i class="fas fa-shopping-cart"></i>
                        </div>
                        <div class="stat-number"><?php echo number_format($total_orders); ?></div>
                        <div class="stat-label">Total Orders</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <div class="stats-icon success-bg text-white mx-auto">
                            <i class="fas fa-dollar-sign"></i>
                        </div>
                        <div class="stat-number"><?php echo number_format($total_sales); ?></div>
                        <div class="stat-label">Total Sales</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <div class="stats-icon warning-bg text-white mx-auto">
                            <i class="fas fa-clock"></i>
                        </div>
                        <div class="stat-number"><?php echo number_format($pending_orders); ?></div>
                        <div class="stat-label">Pending Orders</div>
                    </div>
                </div>
            </div>

            <div class="col-xl-3 col-md-6 mb-4">
                <div class="card stats-card">
                    <div class="card-body text-center">
                        <div class="stats-icon info-bg text-white mx-auto">
                            <i class="fas fa-users"></i>
                        </div>
                        <div class="stat-number"><?php echo number_format($total_customers); ?></div>
                        <div class="stat-label">Total Customers</div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Charts Row -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card chart-card">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-chart-area mr-2"></i>Monthly Sales Report</h5>
                    </div>
                    <div class="card-body">
                        <div class="chart-container">
                            <canvas id="salesChart"></canvas>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Recent Orders Table -->
        <div class="row mb-4">
            <div class="col-12">
                <div class="card table-card">
                    <div class="card-header">
                        <h5 class="card-title"><i class="fas fa-list mr-2"></i>Recent Orders</h5>
                    </div>
                    <div class="card-body p-0">
                        <div class="table-responsive">
                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th><i class="fas fa-hashtag mr-2"></i>Order ID</th>
                                        <th><i class="fas fa-user mr-2"></i>Customer</th>
                                        <th><i class="fas fa-money-bill mr-2"></i>Amount</th>
                                        <th><i class="fas fa-info-circle mr-2"></i>Status</th>
                                        <th><i class="fas fa-calendar mr-2"></i>Date</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($recent_orders as $order): ?>
                                        <tr>
                                            <td class="font-weight-bold text-primary">#<?php echo $order['global_order_id']; ?></td>
                                            <td>
                                                <div class="d-flex align-items-center">
                                                    <div class="avatar-sm bg-light rounded-circle d-flex align-items-center justify-content-center mr-2">
                                                        <i class="fas fa-user text-muted"></i>
                                                    </div>
                                                    <?php echo htmlspecialchars($order['user_name']); ?>
                                                </div>
                                            </td>
                                            <td class="font-weight-bold"><?php echo number_format($order['total_amount']); ?>TK</td>
                                            <td>
                                                <span class="status-badge status-<?php echo strtolower($order['status']); ?>">
                                                    <?php echo ucfirst($order['status']); ?>
                                                </span>
                                            </td>
                                            <td class="text-muted"><?php echo date('M j, Y', strtotime($order['order_date'])); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/jquery@3.5.1/dist/jquery.slim.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

    <!-- Chart.js Script -->
    <script>
        const ctx = document.getElementById('salesChart').getContext('2d');
        const salesChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: <?php echo json_encode($months); ?>,
                datasets: [{
                    label: 'Monthly Sales (৳)',
                    data: <?php echo json_encode($sales); ?>,
                    borderColor: '#173831',
                    backgroundColor: 'rgba(23, 56, 49, 0.1)',
                    fill: true,
                    tension: 0.4,
                    borderWidth: 3,
                    pointBackgroundColor: '#173831',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 2,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        display: true,
                        position: 'top',
                        labels: {
                            color: '#173831',
                            font: {
                                size: 14,
                                weight: 'bold'
                            }
                        }
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        grid: {
                            color: '#f0f0f0'
                        },
                        ticks: {
                            color: '#666',
                            callback: function(value) {
                                return value.toLocaleString() + ' ৳';
                            }
                        }
                    },
                    x: {
                        grid: {
                            color: '#f0f0f0'
                        },
                        ticks: {
                            color: '#666'
                        }
                    }
                },
                interaction: {
                    intersect: false,
                    mode: 'index'
                },
                hover: {
                    animationDuration: 200
                }
            }
        });
    </script>
</body>

</html>